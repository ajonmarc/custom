<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Access Denied</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            text-align: center;
            color: white;
            max-width: 600px;
        }

        .error-code {
            font-size: 150px;
            font-weight: bold;
            line-height: 1;
            margin-bottom: 20px;
            text-shadow: 4px 4px 8px rgba(0, 0, 0, 0.3);
            animation: fadeInDown 0.6s ease-out;
        }

        .lock-icon {
            font-size: 100px;
            margin-bottom: 30px;
            animation: shake 0.5s ease-in-out;
        }

        h1 {
            font-size: 36px;
            margin-bottom: 15px;
            animation: fadeIn 0.8s ease-out;
        }

        p {
            font-size: 18px;
            margin-bottom: 30px;
            opacity: 0.9;
            animation: fadeIn 1s ease-out;
        }

        .btn {
            display: inline-block;
            padding: 15px 40px;
            background: white;
            color: #667eea;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            animation: fadeInUp 1.2s ease-out;
        }

        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
        }

        .additional-links {
            margin-top: 30px;
            animation: fadeIn 1.4s ease-out;
        }

        .additional-links a {
            color: white;
            text-decoration: none;
            margin: 0 15px;
            opacity: 0.8;
            transition: opacity 0.3s ease;
        }

        .additional-links a:hover {
            opacity: 1;
            text-decoration: underline;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes shake {
            0%, 100% {
                transform: rotate(0deg);
            }
            25% {
                transform: rotate(-10deg);
            }
            75% {
                transform: rotate(10deg);
            }
        }

        @media (max-width: 768px) {
            .error-code {
                font-size: 100px;
            }

            h1 {
                font-size: 28px;
            }

            p {
                font-size: 16px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="lock-icon">🔒</div>
        <div class="error-code">403</div>
        <h1>Access Denied</h1>
        <p>{{ $exception->getMessage() ?: 'Sorry, you don\'t have permission to access this page.' }}</p>
        
        <a href="{{ url('/') }}" class="btn">Go Back Home</a>
        
        <div class="additional-links">
            <a href="{{ url()->previous() }}">← Go Back</a>
            @auth
                <a href="{{ route('dashboard') ?? url('/') }}">Dashboard</a>
            @else
                <a href="{{ route('login') ?? url('/login') }}">Login</a>
            @endauth
        </div>
    </div>
</body>
</html>