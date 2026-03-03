<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Grade Chart Data</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #2563eb;
            --secondary: #10b981;
            --bg-gradient: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
            --text-main: #1f2937;
            --text-muted: #6b7280;
            --card-bg: #ffffff;
            --input-border: #d1d5db;
            --shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background: var(--bg-gradient);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .alert-container {
            width: 100%;
            max-width: 450px;
            margin-bottom: 20px;
            animation: fadeInDown 0.5s ease-out;
        }

        .alert {
            background-color: #fee2e2;
            border: 1px solid #fecaca;
            color: #991b1b;
            padding: 12px 16px;
            border-radius: 8px;
            position: relative;
            font-size: 0.9rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .alert .close-btn {
            background: none;
            border: none;
            color: #991b1b;
            cursor: pointer;
            font-size: 1.2rem;
            font-weight: bold;
            line-height: 1;
        }

        .login-card {
            background: var(--card-bg);
            width: 100%;
            max-width: 450px;
            padding: 40px;
            border-radius: 16px;
            box-shadow: var(--shadow);
            text-align: center;
            animation: scaleIn 0.4s ease-out;
        }

        .logo-section {
            margin-bottom: 30px;
        }

        .logo-placeholder {
            width: 120px;
            height: auto;
            margin: 0 auto 15px;
            display: block;
        }

        h1 {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--text-main);
            letter-spacing: 0.05em;
            text-transform: uppercase;
            margin-bottom: 30px;
        }

        .form-group {
            text-align: left;
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--text-main);
            margin-bottom: 8px;
        }

        input {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid var(--input-border);
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.2s;
            outline: none;
        }

        input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .help-text {
            font-size: 0.8125rem;
            color: var(--text-muted);
            margin-bottom: 20px;
            text-align: left;
        }

        .actions {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .btn {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-primary {
            background-color: var(--secondary);
            color: white;
        }

        .btn-primary:hover {
            background-color: #059669;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);
        }

        .btn-outline {
            background-color: var(--primary);
            color: white;
        }

        .btn-outline:hover {
            background-color: #1d4ed8;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .error-text {
            color: #dc2626;
            font-size: 0.75rem;
            margin-top: 4px;
        }
    </style>
</head>

<body>

    @if(session('error') || $errors->any())
        <div class="alert-container">
            <div class="alert">
                <span>Silakan login terlebih dahulu!</span>
                <button class="close-btn" onclick="this.parentElement.parentElement.remove()">&times;</button>
            </div>
        </div>
    @endif

    <main class="login-card">
        <div class="logo-section">
            {{-- Using generated logo path if possible, or placeholder --}}
            <img src="/emix_logo.png" alt="EMIX Logo" class="logo-placeholder"
                onerror="this.src='https://via.placeholder.com/120x60?text=EMIX'">
            <h1>Grade Chart Data</h1>
        </div>

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" value="user" placeholder="username" required autofocus>
                @error('username')
                    <p class="error-text">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" value="password" required>
                @error('password')
                    <p class="error-text">{{ $message }}</p>
                @enderror
            </div>

            <p class="help-text">Masuk langsung Jika login sebagai user</p>

        </form>
    </main>

</body>

</html>