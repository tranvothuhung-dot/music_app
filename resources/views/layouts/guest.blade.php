<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Music</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        body { 
            background-color: #f3f4f6; 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            display: flex; align-items: center; justify-content: center; 
            min-height: 100vh; margin: 0; padding: 20px;
        }
        .auth-card { 
            background: #fff; border-radius: 12px; 
            box-shadow: 0 4px 20px rgba(0,0,0,0.05); 
            padding: 40px; width: 100%; max-width: 400px; 
        }
        .auth-card.register-card { max-width: 500px; }
        .auth-icon { 
            width: 55px; height: 55px; background: #ff4081; color: #fff; 
            border-radius: 50%; display: flex; align-items: center; justify-content: center; 
            font-size: 26px; margin: 0 auto 15px; 
        }
        .auth-title { text-align: center; font-weight: 800; color: #1f2937; margin-bottom: 5px; font-size: 22px; }
        .auth-subtitle { text-align: center; color: #6b7280; font-size: 13px; margin-bottom: 25px; }
        
        .form-label { font-size: 13px; font-weight: 700; color: #4b5563; margin-bottom: 6px; }
        .form-control, .form-select { 
            border-radius: 8px; padding: 10px 15px; border: 1px solid #e5e7eb; 
            font-size: 14px; color: #1f2937; background-color: #fff;
        }
        .form-control:focus, .form-select:focus { 
            border-color: #ff4081; box-shadow: 0 0 0 3px rgba(255,64,129,0.1); 
        }
        .password-wrapper { position: relative; }
        .password-wrapper i { 
            position: absolute; right: 15px; top: 50%; transform: translateY(-50%); 
            color: #9ca3af; cursor: pointer; 
        }
        
        .btn-primary-custom { 
            background: #ff4081; border: none; border-radius: 25px; 
            padding: 12px; font-weight: bold; width: 100%; color: #fff; 
            transition: 0.3s; margin-top: 15px;
        }
        .btn-primary-custom:hover { background: #e83274; color: #fff; }
        
        .auth-links { text-align: center; margin-top: 20px; font-size: 13px; color: #4b5563; }
        .auth-links a { color: #ff4081; text-decoration: none; font-weight: 700; }
        .auth-links a:hover { text-decoration: underline; }
        
        .back-home { 
            display: block; text-align: center; margin-top: 20px; 
            color: #6b7280; text-decoration: none; font-size: 13px; font-weight: 600;
        }
        .back-home:hover { color: #374151; }
        
        .forgot-pass-link { 
            display: block; text-align: right; color: #ff4081; 
            font-size: 12px; font-weight: 600; text-decoration: none; margin-top: 8px;
        }
        .forgot-pass-link:hover { text-decoration: underline; }
        .text-danger { font-size: 12px; margin-top: 4px; display: block;}
    </style>
</head>
<body>
    {{ $slot }}

    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = "password";
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>