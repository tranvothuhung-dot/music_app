<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chào mừng bạn đến với MusicApp Newsletter</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f4f6fb;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
            color: #27303f;
        }

        .email-wrapper {
            width: 100%;
            background-color: #f4f6fb;
            padding: 32px 0;
        }

        .email-container {
            width: 92%;
            max-width: 640px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 18px;
            box-shadow: 0 24px 80px rgba(39, 48, 63, 0.12);
            overflow: hidden;
        }

        .email-header {
            background: linear-gradient(135deg, #0f172a 0%, #2563eb 100%);
            color: #ffffff;
            padding: 32px 28px;
            text-align: center;
        }

        .email-header h1 {
            margin: 0;
            font-size: 28px;
            letter-spacing: -0.02em;
            line-height: 1.2;
        }

        .email-header p {
            margin-top: 10px;
            margin-bottom: 0;
            font-size: 15px;
            opacity: 0.88;
        }

        .email-body {
            padding: 32px 28px;
        }

        .email-body h2 {
            margin-top: 0;
            font-size: 22px;
            color: #111927;
        }

        .email-body p {
            margin: 0 0 18px;
            line-height: 1.75;
            font-size: 15px;
            color: #4b5563;
        }

        .email-body .button {
            display: inline-block;
            padding: 14px 26px;
            background-color: #2563eb;
            color: #ffffff;
            text-decoration: none;
            border-radius: 12px;
            font-weight: 600;
            margin-top: 10px;
        }

        .email-divider {
            border-top: 1px solid #e2e8f0;
            margin: 0 28px;
        }

        .email-footer {
            padding: 24px 28px 30px;
            color: #6b7280;
            font-size: 13px;
            line-height: 1.7;
        }

        .email-footer strong {
            color: #111827;
        }

        .footer-note {
            margin-top: 18px;
            color: #9ca3af;
            font-size: 12px;
        }

        @media screen and (max-width: 520px) {
            .email-container {
                border-radius: 0;
            }

            .email-header,
            .email-body,
            .email-footer {
                padding-left: 24px;
                padding-right: 24px;
            }

            .email-header h1 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="email-container">
            <div class="email-header">
                <h1>Chào mừng đến với MusicApp</h1>
                <p>Bạn đã đăng ký nhận tin thành công. Hãy cùng khám phá những bản nhạc mới nhất.</p>
            </div>

            <div class="email-body">
                <h2>Xin chào!</h2>
                <p>Cảm ơn bạn đã đăng ký nhận tin từ MusicApp. Chúng tôi rất vui khi được đồng hành cùng bạn trong hành trình âm nhạc.</p>
                <p>Trong những email tiếp theo, bạn sẽ nhận được:</p>
                <ul style="padding-left: 18px; color: #4b5563;">
                    <li>Thông tin về album mới và bài hát hot nhất</li>
                    <li>Cập nhật về nghệ sĩ và sự kiện đặc sắc</li>
                    <li>Ưu đãi và khuyến mãi độc quyền dành riêng cho bạn</li>
                </ul>
                <p>Hãy nhấn nút bên dưới để trở lại MusicApp và tiếp tục khám phá.</p>
                <a href="{{ url('/') }}" class="button">Truy cập MusicApp</a>
            </div>

            <div class="email-divider"></div>

            <div class="email-footer">
                <p><strong>MusicApp</strong></p>
                <p>MusicApp luôn cố gắng mang đến cho bạn trải nghiệm âm nhạc tốt nhất, cập nhật nhanh nhất và thiết kế tinh tế.</p>
                <p class="footer-note">Bạn nhận được email này vì đã đăng ký nhận tin từ MusicApp. Nếu bạn không yêu cầu, hãy bỏ qua email này.</p>
            </div>
        </div>
    </div>
</body>
</html>
