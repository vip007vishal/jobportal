<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin / HR / TL Login — V7 Lancers</title>
    <style>
        :root {
            --primary: #1e3a8a;
            --primary-hover: #1e40af;
            --primary-light: #eff6ff;
            --gray-50: #f8fafc;
            --gray-100: #f1f5f9;
            --gray-200: #e2e8f0;
            --gray-400: #94a3b8;
            --gray-600: #475569;
            --gray-800: #1e293b;
            --white: #ffffff;
            --shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            --radius: 14px;
            --transition: 0.2s ease;
            --font-sans: 'Inter', system-ui, -apple-system, sans-serif;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: var(--font-sans);
            background: linear-gradient(180deg, #f8fafc 0%, #e2e8f0 100%);
            color: var(--gray-800);
        }

        .page-shell {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 24px;
        }

        .card {
            width: 100%;
            max-width: 480px;
            background: var(--white);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            padding: 30px;
            border: 1px solid var(--gray-200);
        }

        h1 {
            font-size: 1.9rem;
            margin-bottom: 12px;
            color: var(--gray-900);
        }

        p {
            margin-bottom: 24px;
            color: var(--gray-600);
            line-height: 1.6;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--gray-700);
        }

        input {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid var(--gray-300);
            border-radius: 10px;
            font-size: 0.95rem;
            background: var(--gray-50);
            color: var(--gray-900);
        }

        button,
        .secondary-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            padding: 14px 18px;
            font-size: 0.95rem;
            border-radius: 10px;
            border: none;
            text-decoration: none;
            transition: transform var(--transition), box-shadow var(--transition), background var(--transition);
        }

        button {
            background: var(--primary);
            color: #fff;
            cursor: pointer;
            box-shadow: 0 10px 20px rgba(30, 58, 138, 0.18);
        }

        button:hover {
            background: var(--primary-hover);
            transform: translateY(-1px);
        }

        .secondary-link {
            margin-top: 14px;
            background: #f8fafc;
            color: var(--gray-700);
            border: 1px solid var(--gray-200);
        }

        .secondary-link:hover {
            background: var(--gray-100);
            transform: translateY(-1px);
        }

        .flash-msg {
            margin-bottom: 20px;
            padding: 12px 14px;
            border-radius: 10px;
            font-size: 0.95rem;
        }

        .flash-msg.success {
            background: #ecfdf5;
            color: #065f46;
            border: 1px solid #d1fae5;
        }

        .flash-msg.error {
            background: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }
    </style>
</head>

<body>
    <div class="page-shell">
        <div class="card">
            <h1>Admin / HR / TL Login</h1>
            <p>Use this page to sign in and manage applications, roles, or users.</p>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="flash-msg success"><?= session()->getFlashdata('success') ?></div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')): ?>
                <div class="flash-msg error"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>

            <form method="post" action="<?= base_url('admin/login') ?>">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                </div>
                <button type="submit">Login</button>
            </form>

            <a href="<?= base_url('apply') ?>" class="secondary-link">Go to Job Apply Page</a>
        </div>
    </div>
</body>

</html>
