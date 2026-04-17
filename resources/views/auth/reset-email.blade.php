<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f3f4f6; padding: 30px; text-align: center; }
        .container { background-color: #ffffff; padding: 40px; border-radius: 12px; max-width: 500px; margin: 0 auto; box-shadow: 0 4px 20px rgba(0,0,0,0.05); }
        .logo { font-size: 26px; font-weight: 900; color: #ff4081; text-decoration: none; display: block; margin-bottom: 25px; }
        .btn { display: inline-block; padding: 14px 30px; background-color: #ff4081; color: #ffffff !important; text-decoration: none; border-radius: 25px; font-weight: bold; margin: 25px 0; }
        .footer { margin-top: 30px; font-size: 13px; color: #6b7280; border-top: 1px solid #eee; padding-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <a href="{{ url('/music') }}" style="text-decoration: none; display: block; text-align: center; margin-bottom: 30px;">
            <span style="display: inline-block; width: 38px; height: 38px; line-height: 38px; background-color: #ff4081; border-radius: 50%; vertical-align: middle; margin-right: 6px; text-align: center;">
                <span style="display: inline-block; width: 0; height: 0; border-top: 7px solid transparent; border-bottom: 7px solid transparent; border-left: 11px solid #ffffff; vertical-align: middle; margin-left: 3px;"></span>
            </span>
            <span style="color: #ff4081; font-size: 34px; font-weight: 800; vertical-align: middle; font-family: 'Segoe UI', Tahoma, Verdana, sans-serif; letter-spacing: -1px;">
                MusicApp
            </span>
        </a>

        <h2 style="color: #1f2937; margin-top: 0;">Chào bạn!</h2>
        
        <p style="color: #4b5563; line-height: 1.6; font-size: 15px;">
            Bạn nhận được email này vì chúng tôi nhận được yêu cầu đặt lại mật khẩu cho tài khoản của bạn.
        </p>

        <a href="{{ $url }}" class="btn">Đặt lại mật khẩu ngay</a>

        <p style="color: #4b5563; line-height: 1.6; font-size: 14px;">
            Liên kết này sẽ hết hạn trong 60 phút.<br>
            Nếu bạn không yêu cầu đặt lại mật khẩu, vui lòng bỏ qua email này.
        </p>

        <div class="footer">
            Trân trọng,<br><strong>Đội ngũ MusicApp</strong>
        </div>
    </div>
</body>
</html>