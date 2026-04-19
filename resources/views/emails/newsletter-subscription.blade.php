<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chào mừng bạn đến với MusicApp Newsletter</title>
    <style>
        * { margin: 0; padding: 0; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; color: #333; background-color: #f5f5f5; line-height: 1.6; }
        .email-wrapper { max-width: 600px; margin: 0 auto; background-color: #fff; }
        .header { background: linear-gradient(135deg, #ff4081 0%, #f06292 100%); padding: 0; text-align: center; }
        .logo { padding: 30px 20px 20px; font-size: 32px; font-weight: 800; color: #fff; letter-spacing: -1px; }
        .header-banner { width: 100%; height: auto; display: block; max-height: 250px; object-fit: cover; }
        .content { padding: 40px 30px; text-align: center; }
        .content h2 { font-size: 28px; color: #ff4081; margin-bottom: 15px; font-weight: 700; }
        .content p { font-size: 16px; color: #555; margin-bottom: 20px; }
        .highlight { color: #ff4081; font-weight: 600; }
        .features { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin: 30px 0; text-align: left; }
        .feature-box { background: #f9f9f9; padding: 20px; border-radius: 8px; border-left: 4px solid #ff4081; }
        .feature-box i-icon { font-size: 24px; color: #ff4081; margin-bottom: 10px; display: block; }
        .feature-box h4 { color: #333; font-size: 16px; margin-bottom: 8px; }
        .feature-box p { font-size: 14px; color: #777; }
        .cta-section { margin: 35px 0; }
        .cta-btn { display: inline-block; padding: 15px 40px; background: linear-gradient(135deg, #ff4081 0%, #f06292 100%); color: #fff; text-decoration: none; border-radius: 50px; font-weight: 700; font-size: 16px; box-shadow: 0 4px 15px rgba(255, 64, 129, 0.3); transition: transform 0.3s; }
        .cta-btn:hover { transform: translateY(-2px); }
        .divider { border: none; border-top: 2px solid #f0f0f0; margin: 30px 0; }
        .social-section { padding: 30px; background: #f9f9f9; text-align: center; }
        .social-section h3 { color: #333; font-size: 16px; margin-bottom: 20px; }
        .social-links { display: flex; justify-content: center; gap: 20px; }
        .social-links a { display: inline-flex; align-items: center; justify-content: center; width: 45px; height: 45px; background: #ff4081; color: #fff; border-radius: 50%; text-decoration: none; font-size: 20px; transition: 0.3s; }
        .social-links a:hover { background: #f06292; transform: scale(1.1); }
        .footer { background: #333; color: #fff; padding: 30px 20px; text-align: center; font-size: 12px; }
        .footer p { margin: 8px 0; }
        .footer a { color: #ff4081; text-decoration: none; }
        .footer-divider { border-top: 1px solid #555; margin: 15px 0; padding-top: 15px; }
        .unsubscribe { font-size: 11px; color: #999; margin-top: 15px; }
        @media (max-width: 600px) {
            .content { padding: 25px 15px; }
            .features { grid-template-columns: 1fr; }
            .content h2 { font-size: 24px; }
            .cta-btn { padding: 12px 30px; font-size: 14px; }
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <!-- Header -->
        <div class="header">
            <div class="logo">🎵 MusicApp</div>
        </div>

        <!-- Main Content -->
        <div class="content">
            <h2>🎉 Chào mừng bạn!</h2>
            <p>Cảm ơn bạn đã <span class="highlight">đăng ký nhận tin</span> từ MusicApp.</p>
            <p>Bây giờ bạn sẽ được cập nhật những thông tin mới nhất về âm nhạc, album hot, nghệ sĩ trending và nhiều hơn thế.</p>

            <!-- Features Grid -->
            <div class="features">
                <div class="feature-box">
                    <div>🎵</div>
                    <h4>Bài Hát Mới</h4>
                    <p>Nghe những bài hát mới phát hành mỗi tuần.</p>
                </div>
                <div class="feature-box">
                    <div>📊</div>
                    <h4>Bảng Xếp Hạng</h4>
                    <p>Khám phá những bài hát trending hiện nay.</p>
                </div>
                <div class="feature-box">
                    <div>👨‍🎤</div>
                    <h4>Nghệ Sĩ Hot</h4>
                    <p>Theo dõi những nghệ sĩ yêu thích của bạn.</p>
                </div>
                <div class="feature-box">
                    <div>💿</div>
                    <h4>Album Độc Quyền</h4>
                    <p>Truy cập album đặc biệt từ các nghệ sĩ.</p>
                </div>
            </div>

            <hr class="divider">

            <!-- CTA Section -->
            <div class="cta-section">
                <p style="margin-bottom: 20px; font-size: 18px; color: #ff4081; font-weight: 700;">Bắt đầu nghe nhạc ngay</p>
                <a href="{{ url('/') }}" class="cta-btn">Vào MusicApp</a>
            </div>

            <p style="font-size: 14px; color: #999; margin-top: 25px;">Bạn sẽ nhận được bản tin hàng tuần với những nội dung hay nhất.</p>
        </div>


        <!-- Footer -->
        <div class="footer">
            <p><strong>MusicApp</strong> - Thế Giới Âm Nhạc Trong Tầm Tay</p>
            <p>Nghe nhạc chất lượng cao, khám phá xu hướng mới nhất.</p>
            <div class="footer-divider"></div>
            <p>© {{ date('Y') }} MusicApp. All rights reserved.</p>
            <div class="unsubscribe">
                <p>Bạn nhận được email này vì đã đăng ký nhận tin từ MusicApp.</p>
                <p><a href="#">Bỏ theo dõi</a> | <a href="#">Quản lý cài đặt</a></p>
            </div>
        </div>
    </div>
</body>
</html>
