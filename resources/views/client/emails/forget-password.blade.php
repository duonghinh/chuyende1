<!DOCTYPE html>
<html>
<head>
    <title>Đặt lại mật khẩu</title>
</head>
<body>
    <h1>Yêu cầu đặt lại mật khẩu</h1>
    <p>Xin chào,</p>
    <p>Bạn nhận được email này vì chúng tôi nhận được yêu cầu đặt lại mật khẩu cho tài khoản của bạn.</p>
    <p>Vui lòng click vào link bên dưới để đặt lại mật khẩu:</p>
    
    <a href="{{ route('password.reset', ['token' => $token, 'email' => $email]) }}" 
       style="background-color: #0d6efd; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block;">
        Đặt lại mật khẩu
    </a>
    
    <p>Nếu bạn không yêu cầu thay đổi mật khẩu, vui lòng bỏ qua email này.</p>
    <p>Trân trọng,<br>Đội ngũ Sweet Bakery</p>
</body>
</html>