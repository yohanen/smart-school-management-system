<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Yohanen Dinagde University</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('uploads/login-bg.jpg');
            background-size: cover;
            background-position: center;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-container {
            background: #ffffff;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 400px;
            margin: 20px;
        }

        .logo-container {
            text-align: center;
            margin-bottom: 2rem;
        }

        .logo-container img {
            max-width: 150px;
            height: auto;
        }

        .form-group {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px 12px 45px;
            border: 2px solid #e1e1e1;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: #f8f9fa;
            color: #333;
            box-sizing: border-box;
        }

        .form-control:focus {
            border-color: #4a90e2;
            box-shadow: 0 0 10px rgba(74, 144, 226, 0.2);
            outline: none;
            background: #ffffff;
        }

        .form-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #ffffff;
            font-size: 20px;
            z-index: 2;
        }

        .form-group::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            width: 45px;
            height: 100%;
            background: #4a90e2;
            border-radius: 8px 0 0 8px;
            z-index: 1;
        }

        .login-btn {
            width: 100%;
            padding: 12px;
            background: #4a90e2;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .login-btn:hover {
            background: #357abd;
            transform: translateY(-2px);
        }

        .captcha-container {
            margin: 1.5rem 0;
            text-align: center;
        }

        .captcha-container img {
            border-radius: 5px;
            margin-right: 10px;
            border: 1px solid #e1e1e1;
        }

        .captcha-input {
            width: 100%;
            margin-top: 10px;
            padding: 12px 15px;
        }

        select.form-control {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%234a90e2' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 15px center;
            background-size: 15px;
            padding-right: 40px;
        }

        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #4a90e2;
            cursor: pointer;
            font-size: 18px;
            z-index: 2;
        }

        .error-msg {
            color: #dc3545;
            font-size: 14px;
            margin-top: 5px;
            text-align: center;
            background: #fff;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #dc3545;
        }

        @media (max-width: 480px) {
            .login-container {
                margin: 15px;
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo-container">
            <img src="<?php echo base_url('uploads/logo.png'); ?>" alt="University Logo">
        </div>
        
        <?php echo form_open(base_url() . 'index.php?login/validate_login', array('class' => 'form-login')); ?>
            <div class="form-group">
                <i class="fas fa-user-shield form-icon"></i>
                <select name="login_type" class="form-control" required>
                    <option value="">Select User Type</option>
                    <option value="admin">Admin</option>
                    <option value="teacher">Teacher</option>
                    <option value="student">Student</option>
                    <option value="parent">Parent</option>
                </select>
            </div>
            
            <div class="form-group">
                <i class="fas fa-user form-icon"></i>
                <input type="text" name="email" placeholder="User ID" class="form-control" required>
            </div>
            
            <div class="form-group">
                <i class="fas fa-lock form-icon"></i>
                <input type="password" name="password" placeholder="Password" class="form-control" required>
                <i class="fas fa-eye password-toggle" onclick="togglePassword(this)"></i>
            </div>

            <div class="captcha-container">
                <img src="<?php echo $captcha_image; ?>" alt="CAPTCHA">
                <input type="text" name="captcha" placeholder="Enter Captcha" class="form-control captcha-input" required>
            </div>

            <?php if(isset($login_error)): ?>
                <div class="error-msg"><?php echo $login_error; ?></div>
            <?php endif; ?>

            <button type="submit" class="login-btn">Login</button>
        <?php echo form_close(); ?>
    </div>

    <script>
        function togglePassword(element) {
            const passwordInput = element.previousElementSibling;
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                element.classList.remove("fa-eye");
                element.classList.add("fa-eye-slash");
            } else {
                passwordInput.type = "password";
                element.classList.remove("fa-eye-slash");
                element.classList.add("fa-eye");
            }
        }
    </script>
</body>
</html> 