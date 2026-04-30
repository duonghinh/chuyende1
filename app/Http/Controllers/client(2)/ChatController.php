<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ChatController extends Controller
{
    public function sendMessage(Request $request)
    {
        $userMessage = $request->input('message');

        if (!$userMessage) {
            return response()->json(['reply' => 'Bạn chưa nhập câu hỏi nào cả.']);
        }

        try {
            // --- Chuẩn bị dữ liệu và từ khóa ---
            $msg = Str::lower($userMessage);
            $isSale = Str::contains($msg, ['sale', 'giảm giá', 'khuyến mãi', 'rẻ']);
            $isBest = Str::contains($msg, ['nhất', 'tốt', 'mạnh', 'top', 'khủng']);
            
            $relevantProducts = collect();
            $contextNote = "";
            $isFallback = false; 
            $structuredProducts = [];

            // --- 1. LOGIC TÌM KIẾM TRONG KHO ---
            $stopWords = ['tôi', 'muốn', 'mua', 'cần', 'tìm', 'có', 'không', 'với', 'là', 'của', 'cho', 'giá', 'rẻ', 'tốt', 'nhất', 'shop', 'bên', 'mình', 'em', 'ơi', 'tư', 'vấn', 'biết', 'về', 'thông', 'tin', 'hiệu', 'năng', 'cấu', 'hình'];
            $keywords = array_filter(explode(' ', $msg), function($w) use ($stopWords) {
                return !in_array($w, $stopWords) && strlen($w) > 1;
            });

            $query = Product::with(['category', 'brand'])->where('status', 1);
            
            if ($isSale) {
                $query->whereNotNull('sale_price')->whereColumn('sale_price', '<', 'price');
            }

            $allProducts = $query->get();

            $scoredProducts = $allProducts->map(function ($product) use ($keywords) {
                $score = 0;
                // Tìm cả trong description để bắt từ khóa kỹ thuật (vd: "i7", "rtx", "ssd")
                $searchString = Str::lower($product->name . ' ' . strip_tags($product->description) . ' ' . ($product->category->name ?? '') . ' ' . ($product->brand->name ?? ''));
                foreach ($keywords as $word) {
                    if (str_contains($searchString, $word)) $score++;
                }
                $product->search_score = $score;
                return $product;
            });

            $relevantProducts = $scoredProducts->where('search_score', '>', 0)->sortByDesc('search_score')->take(5);

            // --- 2. XỬ LÝ FALLBACK ---
            if ($relevantProducts->isEmpty()) {
                $isFallback = true;
                $relevantProducts = Product::where('status', 1)->latest()->take(3)->get();
                $contextNote = "DANH SÁCH GỢI Ý (Không tìm thấy sản phẩm khớp chính xác):";
            } else {
                if ($isBest) {
                    $relevantProducts = $relevantProducts->sortByDesc('price')->take(5);
                }
                $contextNote = "DANH SÁCH SẢN PHẨM KHỚP YÊU CẦU:";
            }

            // --- 3. TẠO CONTEXT (QUAN TRỌNG: Thêm mô tả kỹ thuật & LINK) ---
            $productContext = ">>> " . $contextNote . "\n";
            foreach ($relevantProducts as $product) {
                $link = route('client.product.detail', $product->slug);
                $categoryName = $product->category->name ?? 'Khác';
                
                // Xử lý giá
                $isProductOnSale = $product->sale_price && $product->sale_price < $product->price;
                if ($isProductOnSale) {
                    $displayPrice = number_format($product->sale_price) . "đ";
                    $originalPrice = number_format($product->price) . "đ";
                    $priceText = "{$displayPrice} (Gốc: {$originalPrice}) [ĐANG SALE]";
                } else {
                    $displayPrice = number_format($product->price) . "đ";
                    $originalPrice = null;
                    $priceText = $displayPrice;
                }

                // --- XỬ LÝ MÔ TẢ ---
                $cleanDesc = strip_tags($product->description); 
                $cleanDesc = preg_replace('/\s+/', ' ', $cleanDesc);
                $shortDesc = Str::limit($cleanDesc, 250);

                // --- XỬ LÝ ẢNH (FIX LỖI ẢNH) ---
                $imageUrl = 'https://via.placeholder.com/150?text=No+Image'; // Mặc định nếu không có ảnh

                if (!empty($product->thumbnail)) {
                    // Nếu là link ảnh online (http...)
                    if (Str::startsWith($product->thumbnail, 'http')) {
                        $imageUrl = $product->thumbnail;
                    } else {
                        // Nếu là ảnh upload: Xóa chữ 'public/' thừa nếu có trong DB để asset() chạy đúng
                        $cleanPath = Str::replaceFirst('public/', '', $product->thumbnail);
                        // Tạo đường dẫn đầy đủ: http://domain/storage/path/to/image.jpg
                        $imageUrl = asset('storage/' . $cleanPath);
                    }
                } elseif (!empty($product->image_url)) {
                    $imageUrl = $product->image_url;
                }

                // Dữ liệu trả về Frontend
                $structuredProducts[] = [
                    'name' => $product->name,
                    'price' => $displayPrice,
                    'originalPrice' => $originalPrice,
                    'link' => $link,
                    'isSale' => $isProductOnSale,
                    'category' => $categoryName,
                    'image' => $imageUrl // <-- Đã cập nhật ảnh chuẩn
                ];

                // Context gửi cho AI phân tích
                $productContext .= "- Tên: {$product->name}\n";
                $productContext .= "  Giá: {$priceText}\n";
                $productContext .= "  Link: {$link}\n"; 
                $productContext .= "  Thông số/Mô tả: {$shortDesc}\n";
                $productContext .= "---\n";
            }
            $productContext .= ">>> HẾT DANH SÁCH\n";

            // --- 4. PROMPT ---
            $apiKey = env('GEMINI_API_KEY');
            $baseInstruction = "Bạn là 'Sweet Bakery Assistant', trợ lý tư vấn bánh ngọt của Sweet Bakery. Phong cách: thân thiện, ngắn gọn, dễ hiểu.";
            
            $promptLogic = $isFallback 
                ? "Hiện KHÔNG CÓ đúng sản phẩm khách tìm. Hãy giải thích ngắn gọn về loại bánh hoặc nhu cầu mà khách mong muốn, sau đó giới thiệu các sản phẩm gợi ý bên dưới."
                : "Dựa vào danh sách sản phẩm bên dưới để tư vấn. Nếu khách hỏi về khẩu vị, kích cỡ, dịp sử dụng hoặc bảo quản, hãy phân tích dựa trên phần 'Thông số/Mô tả'.";

            $prompt = $baseInstruction . "\n\n" .
                      "YÊU CẦU QUAN TRỌNG:\n" .
                      "1. KHÔNG tự bịa ra sản phẩm không có trong danh sách.\n" .
                      "2. KHI NHẮC ĐẾN SẢN PHẨM, HÃY CHÈN LINK MUA HÀNG dưới dạng Markdown: [Tên sản phẩm](Link sản phẩm).\n" .
                      "3. Khi gợi ý bánh, hãy nói rõ lý do chọn theo khẩu vị, dịp sử dụng hoặc số người dùng.\n" .
                      "4. Bạn có thể mời khách bấm vào link trong đoạn chat hoặc xem thẻ sản phẩm bên dưới đều được.\n\n" .
                      "TÌNH HUỐNG: " . $promptLogic . "\n\n" .
                      "CÂU HỎI KHÁCH: \"$userMessage\"\n" .
                      "DỮ LIỆU SẢN PHẨM:\n" . $productContext;

            // --- 5. GỌI API ---
            $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash-preview-09-2025:generateContent?key={$apiKey}";

            $response = Http::withoutVerifying()
                ->withHeaders(['Content-Type' => 'application/json'])
                ->post($url, ['contents' => [['parts' => [['text' => $prompt]]]]]);

            if ($response->successful()) {
                $replyText = $response->json()['candidates'][0]['content']['parts'][0]['text'];
                return response()->json([
                    'reply' => $replyText,
                    'products' => $structuredProducts, 
                ]);
            } else {
                Log::error('Gemini API Error: ' . $response->body());
                return response()->json(['reply' => 'Hệ thống đang bận chút xíu, bạn đợi lát nhé. (Lỗi kết nối AI)']);
            }

        } catch (\Exception $e) {
            Log::error('Chat Error: ' . $e->getMessage());
            return response()->json(['reply' => 'Lỗi hệ thống. Vui lòng thử lại sau.']);
        }
    }
}