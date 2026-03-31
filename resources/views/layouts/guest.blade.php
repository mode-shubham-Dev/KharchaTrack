<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KharchaTrack</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    {{-- Override dashboard styles for auth pages --}}
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html,
        body {
            height: 100%;
            overflow: auto !important;
            background: #f8fafc !important;
            display: block !important;
            flex-direction: unset !important;
        }

        .auth-container {
            display: flex !important;
            min-height: 100vh;
            font-family: 'Inter', sans-serif;
        }

        .auth-left {
            width: 440px;
            min-width: 440px;
            min-height: 100vh;
            background-color: #1e1b4b;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 60px 48px;
            position: sticky;
            top: 0;
            height: 100vh;
        }

        .auth-right {
            flex: 1;
            background-color: #f8fafc;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 48px 40px;
        }

        .auth-form-card {
            width: 100%;
            max-width: 460px;
            background: white;
            border-radius: 16px;
            padding: 44px;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08);
            border: 1px solid #e2e8f0;
        }

        @media (max-width: 768px) {
            .auth-container {
                flex-direction: column;
            }

            .auth-left {
                width: 100%;
                min-width: unset;
                height: auto;
                position: relative;
                padding: 40px 24px;
            }

            .auth-right {
                padding: 32px 20px;
                align-items: flex-start;
            }

            .auth-form-card {
                padding: 28px 20px;
            }
        }
    </style>
</head>

<body>

    <div class="auth-container">

        {{-- ===== LEFT SIDE ===== --}}
        <div class="auth-left">

            <div style="margin-bottom: 48px;">
                <i class="fas fa-wallet" style="font-size:44px; color:#a78bfa; display:block; margin-bottom:16px;"></i>
                <h1 style="font-size:32px; font-weight:700; color:white; margin-bottom:10px;">KharchaTrack</h1>
                <p style="font-size:15px; color:#c4b5fd; line-height:1.5;">Smart Finance Tracking for Nepal</p>
            </div>

            <div style="display:flex; flex-direction:column; gap:18px; margin-bottom:48px;">
                <div style="display:flex; align-items:center; gap:12px; color:#e2e8f0; font-size:14px;">
                    <i class="fas fa-check-circle" style="color:#22c55e; font-size:18px; flex-shrink:0;"></i>
                    <span>Track income & expenses easily</span>
                </div>
                <div style="display:flex; align-items:center; gap:12px; color:#e2e8f0; font-size:14px;">
                    <i class="fas fa-check-circle" style="color:#22c55e; font-size:18px; flex-shrink:0;"></i>
                    <span>Beautiful charts & analytics</span>
                </div>
                <div style="display:flex; align-items:center; gap:12px; color:#e2e8f0; font-size:14px;">
                    <i class="fas fa-check-circle" style="color:#22c55e; font-size:18px; flex-shrink:0;"></i>
                    <span>Export transactions to CSV</span>
                </div>
                <div style="display:flex; align-items:center; gap:12px; color:#e2e8f0; font-size:14px;">
                    <i class="fas fa-check-circle" style="color:#22c55e; font-size:18px; flex-shrink:0;"></i>
                    <span>Secure & private data</span>
                </div>
            </div>

            <p style="font-size:13px; color:#4b5563; margin-top:auto;">
                Trusted by finance-conscious Nepalis 🇳🇵
            </p>

        </div>

        {{-- ===== RIGHT SIDE ===== --}}
        <div class="auth-right">
            <div class="auth-form-card">
                {{ $slot }}
            </div>
        </div>

    </div>

    <script src="{{ asset('assets/js/script.js') }}"></script>

</body>

</html>