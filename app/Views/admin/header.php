<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'Admin Dashboard' ?> — V7 Lancers</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

    <style>
        /* (styles copied from original dashboard view - kept identical for compatibility) */
        :root {
            --primary: #1e3a8a;
            --primary-hover: #1e40af;
            --primary-light: #eff6ff;
            --success: #0f766e;
            --success-bg: #f0fdfa;
            --error: #b91c1c;
            --error-bg: #fef2f2;
            --gray-50: #f8fafc;
            --gray-100: #f1f5f9;
            --gray-200: #e2e8f0;
            --gray-300: #cbd5e1;
            --gray-400: #94a3b8;
            --gray-500: #64748b;
            --gray-600: #475569;
            --gray-700: #334155;
            --gray-800: #1e293b;
            --gray-900: #0f172a;
            --white: #ffffff;
            --shadow-sm: 0 1px 2px rgba(0, 0, 0, 0.04);
            --shadow: 0 1px 3px rgba(0, 0, 0, 0.06), 0 1px 2px rgba(0, 0, 0, 0.04);
            --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.05), 0 2px 4px rgba(0, 0, 0, 0.04);
            --radius-sm: 6px;
            --radius: 8px;
            --transition: 0.15s ease;
            --font-sans: 'Inter', system-ui, -apple-system, sans-serif;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: var(--font-sans);
            background: #f1f5f9;
            color: var(--gray-800);
            line-height: 1.5;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            -webkit-font-smoothing: antialiased;
        }

        .dashboard-wrapper {
            width: 100%;
            max-width: 1320px;
            margin: 0 auto;
            padding: 20px 24px 60px;
            flex: 1;
        }

        .top-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
            margin-bottom: 28px;
        }

        .top-header h1 {
            font-size: 1.4rem;
            font-weight: 650;
            color: var(--gray-900);
            letter-spacing: -0.3px;
        }

        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(170px, 1fr));
            gap: 16px;
            margin-bottom: 32px;
        }

        .stat-card {
            background: var(--white);
            border-radius: var(--radius);
            padding: 18px 16px;
            box-shadow: var(--shadow);
            border: 1px solid var(--gray-200);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .stat-card .info h3 {
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--gray-500);
            text-transform: uppercase;
            letter-spacing: 0.03em;
            margin-bottom: 3px;
        }

        .stat-card .info .number {
            font-size: 1.6rem;
            font-weight: 700;
            color: var(--gray-900);
            line-height: 1.2;
        }

        /* ----- GLOBAL FORM STYLING ----- */
        input,
        select,
        textarea {
            width: 100%;
            padding: 9px 12px;
            border: 1px solid var(--gray-300);
            border-radius: var(--radius-sm);
            font-family: var(--font-sans);
            font-size: 0.85rem;
            color: var(--gray-800);
            background: #fff;
            outline: none;
            transition: border-color var(--transition), box-shadow var(--transition);
        }

        input:focus,
        select:focus,
        textarea:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 2px rgba(30, 58, 138, 0.1);
        }

        textarea {
            resize: vertical;
            min-height: 70px;
        }

        select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            padding-right: 32px;
        }

        .section-card {
            background: var(--white);
            border-radius: var(--radius);
            padding: 20px 24px;
            box-shadow: var(--shadow);
            border: 1px solid var(--gray-200);
            margin-bottom: 28px;
        }

        .section-card h2 {
            font-size: 1rem;
            font-weight: 650;
            margin-bottom: 16px;
            border-bottom: 1px solid var(--gray-200);
            padding-bottom: 8px;
        }

        .two-column-layout {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 28px;
        }

        .column-left,
        .column-right {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .chart-card {
            background: var(--white);
            border-radius: var(--radius);
            padding: 20px 24px;
            box-shadow: var(--shadow);
            border: 1px solid var(--gray-200);
        }

        .chart-card h2 {
            font-size: 1rem;
            font-weight: 650;
            margin-bottom: 16px;
            border-bottom: 1px solid var(--gray-200);
            padding-bottom: 8px;
        }

        .chart-card canvas {
            max-height: 260px;
            width: 100% !important;
            height: auto !important;
        }

        .form-row {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            align-items: flex-end;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            padding: 9px 18px;
            font-weight: 600;
            font-size: 0.85rem;
            border-radius: 20px;
            cursor: pointer;
            border: none;
            transition: all var(--transition);
            background: var(--primary);
            color: #fff;
            white-space: nowrap;
            box-shadow: var(--shadow-sm);
        }

        .btn:hover {
            background: #001b6b;
            box-shadow: var(--shadow);
            color: #eff9fe;
        }

        .btn-sm {
            padding: 5px 12px;
            font-size: 0.8rem;
            border-radius: 16px;
        }

        .table-responsive {
            overflow-x: auto;
            margin-top: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.85rem;
            white-space: nowrap;
        }

        th {
            background: var(--gray-50);
            font-weight: 600;
            color: var(--gray-600);
            padding: 10px 8px;
            text-align: left;
            border-bottom: 2px solid var(--gray-200);
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        td {
            padding: 10px 8px;
            border-bottom: 1px solid var(--gray-100);
            color: var(--gray-700);
            vertical-align: middle;
        }

        tr:hover td {
            background: #fafbfc;
        }

        .inline-form {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            align-items: center;
        }

        .status-badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 16px;
            font-weight: 600;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.03em;
            background: #f1f5f9;
            color: #475569;
            border: 1px solid #e2e8f0;
        }

        .status-badge.applied {
            background: #eef2ff;
            color: #4338ca;
            border-color: #c7d2fe;
        }

        .status-badge.waiting {
            background: #fff7ed;
            color: #c2410c;
            border-color: #fed7aa;
        }

        .status-badge.hired {
            background: #ecfdf5;
            color: #0f766e;
            border-color: #a7f3d0;
        }

        .status-badge.rejected {
            background: #fef2f2;
            color: #b91c1c;
            border-color: #fecaca;
        }

        .status-badge.hold {
            background: #f8fafc;
            color: #475569;
            border-color: #cbd5e1;
        }

        .action-link {
            color: var(--primary);
            font-weight: 600;
            text-decoration: none;
            font-size: 0.8rem;
        }

        .action-link:hover {
            text-decoration: underline;
        }

        .btn-icon {
            background: none;
            border: none;
            font-size: 1.2rem;
            cursor: pointer;
            color: var(--gray-600);
            padding: 4px 8px;
            border-radius: 6px;
            transition: background 0.15s, color 0.15s;
        }

        .btn-icon:hover {
            background: var(--gray-100);
            color: var(--primary);
        }

        .skills-checkbox-group {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 4px;
            margin-bottom: 8px;
        }

        .skills-checkbox-group label {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 0.85rem;
            color: var(--gray-700);
            cursor: pointer;
            white-space: nowrap;
        }

        .skills-checkbox-group input[type="checkbox"] {
            width: 16px;
            height: 16px;
            margin: 0;
            accent-color: var(--primary);
        }

        .toast {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #0f172a;
            color: #fff;
            padding: 12px 20px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.85rem;
            box-shadow: var(--shadow-md);
            z-index: 9999;
            display: none;
            align-items: center;
            gap: 8px;
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(40px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .toast.show {
            display: flex;
        }

        .toast.error-toast {
            background: var(--error);
        }

        @media (max-width: 768px) {
            .two-column-layout {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 640px) {
            .dashboard-wrapper {
                padding: 15px 12px 40px;
            }

            .top-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .cards-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .section-card,
            .chart-card {
                padding: 16px 14px;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>

<body>

<?php include 'navbar.php'; ?>

<?php
$role = session()->get('role') ?? 'admin';
$isAdmin = ($role === 'admin');
?>

<div class="dashboard-wrapper">

    <div class="top-header">
        <div class="brand">
            <h1><?= $pageTitle ?? 'Admin Dashboard' ?></h1>
        </div>
    </div>

    <!-- Flash messages -->
        <?php if (session()->getFlashdata('success')): ?>
            <div style="background-color: var(--success-bg); border-left: 4px solid var(--success); padding: 12px; margin-bottom: 20px; border-radius: var(--radius);">
                <p style="color: var(--success); margin: 0;"><?= session()->getFlashdata('success') ?></p>
            </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div style="background-color: var(--error-bg); border-left: 4px solid var(--error); padding: 12px; margin-bottom: 20px; border-radius: var(--radius);">
                <p style="color: var(--error); margin: 0;"><?= session()->getFlashdata('error') ?></p>
            </div>
        <?php endif; ?>

