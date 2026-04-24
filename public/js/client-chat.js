function formatAiMessage(message) {
    if (!message) return '';
    let formattedText = message.replace(
        /\[([^\]]+)\]\(([^)]+)\)/g, 
        '<a href="$2" target="_blank">$1</a>'
    );
    formattedText = formattedText.replace(/\n/g, '<br>');
    formattedText = formattedText.replace(/\*\*([^*]+)\*\*/g, '<strong>$1</strong>');
    return formattedText;
}

function toggleChat() {
    const chatWindow = document.getElementById('chatWindow');
    if (chatWindow.style.display === 'none' || chatWindow.style.display === '') {
        chatWindow.style.display = 'flex';
        setTimeout(() => document.getElementById('chatInput').focus(), 100);
    } else {
        chatWindow.style.display = 'none';
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const chatInput = document.getElementById('chatInput');
    const sendButton = document.getElementById('btnChatSend');
    if (sendButton) { sendButton.addEventListener('click', sendMessage); }
    if (chatInput) { chatInput.addEventListener('keypress', function(e) { if (e.key === 'Enter') { sendMessage(); } }); }
});

async function sendMessage() {
    const input = document.getElementById('chatInput');
    const message = input.value.trim();
    const typingIndicator = document.getElementById('typingIndicator');
    
    if (!message) return;

    appendMessage(message, 'user');
    input.value = '';
    typingIndicator.style.display = 'block';
    scrollToBottom();

    try {
        const response = await fetch(window.appConfig.routes.chat, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ message: message })
        });

        const data = await response.json();
        typingIndicator.style.display = 'none';

        if (data.reply) { 
            const formattedReply = formatAiMessage(data.reply); 
            appendMessage(formattedReply, 'bot'); 
        }
        if (data.products && data.products.length > 0) { 
            renderProductCards(data.products); 
        }

    } catch (error) {
        typingIndicator.style.display = 'none';
        appendMessage('Xin lỗi, hệ thống đang gặp sự cố kết nối.', 'bot');
    }
}

function appendMessage(htmlContent, sender) {
    const chatBody = document.getElementById('chatBody');
    const div = document.createElement('div');
    div.classList.add('message', sender);
    if (sender === 'user') { div.textContent = htmlContent; } else { div.innerHTML = htmlContent; }
    chatBody.appendChild(div);
    scrollToBottom();
}

function renderProductCards(products) {
    const chatBody = document.getElementById('chatBody');
    const listDiv = document.createElement('div');
    listDiv.className = 'chat-product-list';

    products.forEach(product => {
        const originalPriceHtml = product.originalPrice ? `<span class="chat-product-original-price">${product.originalPrice}</span>` : '';
        const fallbackImage = 'https://via.placeholder.com/150?text=No+Image';
        const imageUrl = product.image ? product.image : fallbackImage;
        
        const cardHtml = `
            <div class="chat-product-card">
                <a href="${product.link}" target="_blank" style="text-decoration:none; color:inherit;">
                    <div class="chat-product-img-wrapper">
                        <img src="${imageUrl}" 
                             class="chat-product-img" 
                             alt="${product.name}"
                             onerror="this.onerror=null; this.src='${fallbackImage}';">
                    </div>
                    <div class="chat-product-info">
                        <div class="chat-product-name" title="${product.name}">${product.name}</div>
                        <div class="chat-product-price">
                            ${product.price}
                            ${originalPriceHtml}
                        </div>
                        <span class="chat-product-btn">Xem chi tiết</span>
                    </div>
                </a>
            </div>
        `;
        listDiv.innerHTML += cardHtml;
    });
    chatBody.appendChild(listDiv);
    scrollToBottom();
}

function scrollToBottom() { 
    const chatBody = document.getElementById('chatBody'); 
    chatBody.scrollTop = chatBody.scrollHeight; 
}