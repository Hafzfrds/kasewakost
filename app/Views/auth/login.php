<!DOCTYPE html>
<html>
<head>
    <title>Login Sistem Kost</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            display: flex;
            background: linear-gradient(to right, #2a5fa8, #6db8e8);
        }

        /* Left Panel - Login Form */
        .left-panel {
            width: 45%;
            background: transparent;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 60px 60px;
        }

        .left-panel h2 {
            color: #ffffff;
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .left-panel p {
            color: #cde4f7;
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 50px;
        }

        .form-group {
            width: 100%;
            max-width: 460px;
            margin-bottom: 28px;
        }

        .form-group label {
            display: block;
            color: #ffffff;
            font-size: 1.15rem;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .form-group input {
            width: 100%;
            padding: 18px 22px;
            background: rgba(255, 255, 255, 0.85);
            border: none;
            border-radius: 8px;
            font-size: 1.1rem;
            font-family: 'Poppins', sans-serif;
            color: #333;
            outline: none;
            transition: background 0.2s, box-shadow 0.2s;
        }

        .form-group input:focus {
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(255,255,255,0.3);
        }

        .btn-enter {
            width: 100%;
            max-width: 460px;
            padding: 18px;
            background: #7ecef0;
            color: #1a5a8a;
            border: none;
            border-radius: 8px;
            font-size: 1.2rem;
            font-weight: 700;
            font-family: 'Poppins', sans-serif;
            cursor: pointer;
            margin-top: 14px;
            letter-spacing: 1px;
            transition: background 0.2s, transform 0.1s;
        }

        .btn-enter:hover {
            background: #5bbce8;
            transform: translateY(-2px);
        }

        .btn-enter:active {
            transform: translateY(0);
        }

        .error-msg {
            color: #ffe0e0;
            background: rgba(200, 50, 50, 0.25);
            padding: 14px 20px;
            border-radius: 8px;
            font-size: 1rem;
            margin-bottom: 20px;
            width: 100%;
            max-width: 460px;
            text-align: center;
        }

        /* Right Panel - Branding */
        .right-panel {
            width: 55%;
            background: transparent;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 60px 50px;
            position: relative;
            overflow: hidden;
        }

        .right-panel::before {
            content: '';
            position: absolute;
            top: -80px;
            right: -80px;
            width: 280px;
            height: 280px;
            background: rgba(255,255,255,0.06);
            border-radius: 50%;
        }

        .right-panel::after {
            content: '';
            position: absolute;
            bottom: -60px;
            left: -60px;
            width: 200px;
            height: 200px;
            background: rgba(255,255,255,0.06);
            border-radius: 50%;
        }

        .brand-title {
            font-size: 5.5rem;
            font-weight: 800;
            color: #ffffff;
            letter-spacing: -2px;
            line-height: 1;
            margin-bottom: 6px;
        }

        .brand-subtitle {
            font-size: 2rem;
            font-weight: 700;
            color: #ffffff;
            letter-spacing: 8px;
            text-transform: uppercase;
            margin-bottom: 50px;
        }

        /* Door Icon SVG */
        .door-icon {
            width: 260px;
            height: 290px;
            margin-bottom: 50px;
        }

        .brand-tagline {
            font-size: 1.35rem;
            font-weight: 700;
            color: #ffffff;
            text-align: center;
            letter-spacing: 0.3px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            body {
                flex-direction: column;
            }
            .left-panel, .right-panel {
                width: 100%;
                padding: 40px 30px;
            }
            .right-panel {
                padding-top: 40px;
                padding-bottom: 50px;
            }
            .brand-title {
                font-size: 2.5rem;
            }
        }
    </style>
</head>
<body>

<!-- Left Panel: Login Form -->
<div class="left-panel">
    <h2>Welcome</h2>
    <p>welcome to system</p>

    <?php if(session()->getFlashdata('error')) : ?>
    <div class="error-msg"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <form action="/login/process" method="post" style="width:100%;display:flex;flex-direction:column;align-items:center;">

        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required autocomplete="username">
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required autocomplete="current-password">
        </div>

        <button type="submit" class="btn-enter">Enter</button>

    </form>
</div>

<!-- Right Panel: Branding -->
<div class="right-panel">
    <div class="brand-title">welcome</div>
    <div class="brand-subtitle">Kasewakost</div>

    <!-- Door SVG Icon -->
    <svg class="door-icon" viewBox="0 0 180 200" fill="none" xmlns="http://www.w3.org/2000/svg">
        <!-- Door frame (open) -->
        <rect x="10" y="10" width="90" height="170" rx="4" stroke="white" stroke-width="8" fill="none"/>
        <!-- Door panel (open/ajar, perspective) -->
        <path d="M100 20 L160 35 L160 175 L100 180 Z" stroke="white" stroke-width="8" fill="none" stroke-linejoin="round"/>
        <!-- Door knob -->
        <circle cx="148" cy="108" r="7" fill="white"/>
    </svg>

    <div class="brand-tagline">kenyamanan kamu tanggung jawab kami</div>
</div>

</body>
</html>