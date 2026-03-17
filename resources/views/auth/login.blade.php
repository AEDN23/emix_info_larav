<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | EMIX INFO</title>
    <link rel="shortcut icon" href="{{ asset('public/storage/foto/icon.png') }}?v=1" type="image/png">
    <link rel="icon" href="{{ asset('public/storage/foto/icon.png') }}?v=1" type="image/png">
    <link href="{{ asset('public/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/css/css2.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('public/css/all.min.css') }}">
    <style>
        :root {
            --primary: #4f46e5;
            --primary-hover: #4338ca;
            --dark: #0f172a;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            overflow: hidden;
        }

        .login-container {
            width: 100%;
            max-width: 450px;
            padding: 20px;
            perspective: 1000px;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.4);
            border-radius: 24px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1);
            padding: 48px;
            animation: cardAppear 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes cardAppear {
            from {
                opacity: 0;
                transform: translateY(40px) scale(0.95);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .brand-logo {
            width: 64px;
            height: 64px;
            background: var(--primary);
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 28px;
            margin: 0 auto 24px;
            box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.3);
        }

        .login-title {
            color: var(--dark);
            font-weight: 800;
            font-size: 24px;
            text-align: center;
            margin-bottom: 8px;
        }

        .login-subtitle {
            color: #64748b;
            text-align: center;
            font-size: 14px;
            margin-bottom: 32px;
        }

        .form-label {
            font-weight: 600;
            color: #334155;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        .input-group {
            background: #f1f5f9;
            border-radius: 12px;
            padding: 4px;
            border: 2px solid transparent;
            transition: all 0.2s;
        }

        .input-group:focus-within {
            background: white;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
        }

        .input-group-text {
            background: transparent;
            border: none;
            color: #94a3b8;
            padding-left: 16px;
        }

        .form-control {
            background: transparent;
            border: none;
            padding: 12px 16px;
            font-size: 15px;
            font-weight: 500;
        }

        .form-control:focus {
            background: transparent;
            box-shadow: none;
        }

        .btn-login {
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 14px;
            font-weight: 700;
            font-size: 16px;
            width: 100%;
            margin-top: 24px;
            transition: all 0.3s;
            box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.2);
        }

        .btn-login:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.3);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .alert {
            border-radius: 12px;
            font-size: 14px;
            border: none;
        }

        .footer-text {
            text-align: center;
            margin-top: 32px;
            color: #94a3b8;
            font-size: 12px;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-card">
            <!-- <div class="brand-logo">
                <i class="fas fa-layer-group"></i>
            </div> -->
            <img src="{{ asset('public/storage/foto/1.png') }}" alt="Logo" class="img-fluid mb-4"
                style="max-width: 100px; display: block; margin: 0 auto;">
            <h1 class="login-title">Selamat Datang</h1>
            <p class="login-subtitle">Silakan masuk untuk mengelola Emix Info</p>

            @if($errors->any() || session('error'))
                <div class="alert alert-danger mb-4">
                    <ul class="mb-0 list-unstyled">
                        @if(session('error'))
                            <li><i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}</li>
                        @endif
                        @foreach($errors->all() as $error)
                            <li><i class="fas fa-exclamation-circle me-2"></i>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="form-label">Username</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                        <input type="text" name="username" class="form-control" placeholder="user"
                            value="{{ old('username', 'user') }}" required autofocus>
                    </div>
                </div>

                <div class="mb-2">
                    <label class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" name="password" class="form-control" placeholder="password"
                            value="password" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-login">
                    Masuk ke Sistem <i class="fas fa-arrow-right ms-2"></i>
                </button>
            </form>

            <div class="footer-text">
                &copy; {{ date('Y') }} PT. Elastomix Indonesia.
            </div>
        </div>
    </div>
</body>

</html>