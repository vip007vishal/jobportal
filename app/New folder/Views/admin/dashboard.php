<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard — V7 Lancers</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        /* ========== PROFESSIONAL DESIGN ========== */
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

        .two-column-layout {
            display: flex;
            gap: 20px;
            margin-bottom: 24px;
            align-items: flex-start;
        }

        .left-column {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .right-column {
            flex: 1;
            min-width: 400px;
        }

        @media (max-width: 900px) {
            .two-column-layout {
                flex-direction: column;
            }

            .right-column {
                min-width: auto;
            }
        }

        .chart-card,
        .section-card {
            background: var(--white);
            border-radius: var(--radius);
            padding: 20px 24px;
            box-shadow: var(--shadow);
            border: 1px solid var(--gray-200);
        }

        .chart-card h2,
        .section-card h2 {
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

        .form-row input,
        .form-row select,
        .form-row textarea {
            padding: 9px 12px;
            border: 1px solid var(--gray-300);
            border-radius: var(--radius-sm);
            font-family: var(--font-sans);
            font-size: 0.85rem;
            color: var(--gray-800);
            background: #fff;
            outline: none;
            flex: 1;
            min-width: 160px;
            transition: border-color var(--transition), box-shadow var(--transition);
        }

        .form-row input:focus,
        .form-row select:focus,
        .form-row textarea:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 2px rgba(30, 58, 138, 0.1);
        }

        textarea {
            resize: vertical;
            min-height: 70px;
        }

        .textarea-professional {
            width: 100%;
            min-height: 120px;
            padding: 2px 6px;
            font-size: 0.9rem;
            line-height: 1.6;
            color: #334155;
            background: #fff;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            outline: none;
            resize: vertical;
            transition: border-color 0.15s ease, box-shadow 0.15s ease;
        }

        .textarea-professional:focus {
            border-color: #1e3a8a;
            box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.1);
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
            background: var(--primary-hover);
            box-shadow: var(--shadow);
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

        .inline-form select,
        .inline-form input {
            padding: 6px 8px;
            border-radius: var(--radius-sm);
            border: 1px solid var(--gray-300);
            font-size: 0.8rem;
            min-width: 100px;
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

        .progress {
            background-color: var(--gray-200);
            border-radius: 10px;
            height: 8px;
            width: 100px;
            overflow: hidden;
        }

        .progress-bar {
            background-color: var(--primary);
            height: 8px;
            border-radius: 10px;
        }

        .skills-checkbox-group {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 8px;
            margin-bottom: 8px;
        }

        .skills-checkbox-group label {
            background: var(--gray-100);
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
            border: 1px solid var(--gray-300);
        }

        .skills-checkbox-group input {
            margin: 0;
            transform: scale(0.9);
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

            .form-row {
                flex-direction: column;
                align-items: stretch;
            }

            .inline-form {
                flex-direction: column;
                align-items: flex-start;
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

    <div class="dashboard-wrapper">

        <div class="top-header">
            <div class="brand">
                <h1>Admin Dashboard</h1>
            </div>
        </div>

        <!-- ANALYTICS CARDS (safe defaults) -->
        <?php
        $totalApps = is_countable($applications ?? null) ? count($applications) : 0;
        $hiredCount = $statusCounts['Hired'] ?? 0;
        $rejectedCount = $statusCounts['Rejected'] ?? 0;
        $waitingCount = $statusCounts['Waiting'] ?? 0;
        $holdCount = $statusCounts['Hold'] ?? 0;
        $openJobs = 0;
        if (!empty($jobs)) {
            foreach ($jobs as $job) {
                if (($job['status'] ?? '') == 'open') $openJobs++;
            }
        }
        ?>
        <div class="cards-grid">
            <div class="stat-card">
                <div class="info">
                    <h3>Total</h3>
                    <div class="number"><?= $totalApps ?></div>
                </div>
            </div>
            <div class="stat-card">
                <div class="info">
                    <h3>Hired</h3>
                    <div class="number"><?= $hiredCount ?></div>
                </div>
            </div>
            <div class="stat-card">
                <div class="info">
                    <h3>Rejected</h3>
                    <div class="number"><?= $rejectedCount ?></div>
                </div>
            </div>
            <div class="stat-card">
                <div class="info">
                    <h3>Waiting</h3>
                    <div class="number"><?= $waitingCount ?></div>
                </div>
            </div>
            <div class="stat-card">
                <div class="info">
                    <h3>Hold</h3>
                    <div class="number"><?= $holdCount ?></div>
                </div>
            </div>
            <div class="stat-card">
                <div class="info">
                    <h3>Open Jobs</h3>
                    <div class="number"><?= $openJobs ?></div>
                </div>
            </div>
        </div>

        <!-- APPLICATIONS TABLE (with assigned HR/TL column & match) -->
        <!-- Applications Section -->

        <div class="section-card">

            <h2 style="margin-top: 0; margin-bottom: 16px;">
                Applications
            </h2>

            <div
                class="search-bar"
                style="margin-bottom: 20px; padding-bottom: 16px; border-bottom: 1px solid var(--gray-200);">

                <form method="get" class="form-row">

                    <input
                        type="text"
                        name="search"
                        placeholder="Search by name, email or mobile..."
                        value="<?= $_GET['search'] ?? '' ?>"
                        style="flex: 2; min-width: 200px;">

                    <select
                        name="status"
                        style="flex: 1; min-width: 140px;">

                        <option value="">
                            All Status
                        </option>

                        <option
                            value="Applied"
                            <?= (isset($_GET['status']) && $_GET['status'] === 'Applied') ? 'selected' : '' ?>>
                            Applied
                        </option>

                        <option
                            value="Waiting"
                            <?= (isset($_GET['status']) && $_GET['status'] === 'Waiting') ? 'selected' : '' ?>>
                            Waiting
                        </option>

                        <option
                            value="Hired"
                            <?= (isset($_GET['status']) && $_GET['status'] === 'Hired') ? 'selected' : '' ?>>
                            Hired
                        </option>

                        <option
                            value="Rejected"
                            <?= (isset($_GET['status']) && $_GET['status'] === 'Rejected') ? 'selected' : '' ?>>
                            Rejected
                        </option>

                        <option
                            value="Hold"
                            <?= (isset($_GET['status']) && $_GET['status'] === 'Hold') ? 'selected' : '' ?>>
                            Hold
                        </option>

                    </select>

                    <button
                        type="submit"
                        class="btn">
                        Search
                    </button>

                </form>

            </div>

            <div class="table-responsive">

                <table>

                    <thead>

                        <tr>

                            <th>ID</th>

                            <th>Name</th>

                            <th>Email</th>

                            <th>Mobile</th>

                            <th>Role</th>

                            <th>Skills Match</th>

                            <th>Assigned HR / TL</th>

                            <th>Status</th>

                            <th>Resume</th>

                            <th>Update Status</th>

                            <th>Actions</th>

                        </tr>

                    </thead>

                    <tbody>

                        <?php foreach ($applications as $application): ?>

                            <tr>

                                <td>
                                    <?= $application['id'] ?>
                                </td>

                                <td>
                                    <strong>
                                        <?= esc($application['full_name']) ?>
                                    </strong>
                                </td>

                                <td>
                                    <?= esc($application['email']) ?>
                                </td>

                                <td>
                                    <?= esc($application['mobile']) ?>
                                </td>

                                <td>
                                    <?= esc($application['role_name']) ?>
                                </td>

                                <td>

                                    <?php

                                    $requiredSkills = [];

                                    if (!empty($application['technical_skills'])) {

                                        $requiredSkills = array_map(
                                            'trim',
                                            explode(',', strtolower($application['technical_skills']))
                                        );
                                    }

                                    $candidateSkills = [];

                                    if (!empty($application['skills_summary'])) {

                                        $candidateSkills = array_map(
                                            'trim',
                                            explode(',', strtolower($application['skills_summary']))
                                        );
                                    }

                                    $matchedSkills = array_intersect(
                                        $requiredSkills,
                                        $candidateSkills
                                    );

                                    $matchPercentage = 0;

                                    if (count($requiredSkills) > 0) {

                                        $matchPercentage = round(
                                            (
                                                count($matchedSkills)
                                                /
                                                count($requiredSkills)
                                            ) * 100
                                        );
                                    }

                                    ?>

                                    <strong>

                                        <?= $matchPercentage ?>%

                                    </strong>

                                </td>

                                <td>

                                    <?php if (!empty($application['assigned_user_name'])): ?>

                                        <div
                                            class="assignWrapper"
                                            style="position:relative;">

                                            <span>

                                                <?= esc($application['assigned_user_name']) ?>

                                            </span>

                                            <div
                                                class="assignHover"
                                                style="display:none; position:absolute; top:22px; left:0; z-index:99;">

                                                <button
                                                    type="button"
                                                    class="btn btn-sm btn-warning openAssignModal"
                                                    data-id="<?= $application['id'] ?>">

                                                    Assign HR / TL

                                                </button>

                                            </div>

                                        </div>

                                    <?php else: ?>

                                        <button
                                            type="button"
                                            class="btn btn-sm btn-warning openAssignModal"
                                            data-id="<?= $application['id'] ?>">

                                            Assign HR / TL

                                        </button>

                                    <?php endif; ?>

                                </td>

                                <td id="status-text-<?= $application['id'] ?>">

                                    <span
                                        class="status-badge <?= strtolower($application['status']) ?>">

                                        <?= $application['status'] ?>

                                    </span>

                                </td>

                                <td>

                                    <a
                                        target="_blank"
                                        href="<?= base_url('uploads/resumes/' . $application['resume']) ?>"
                                        class="action-link">

                                        View

                                    </a>

                                </td>

                                <td>

                                    <form
                                        class="statusForm inline-form"
                                        data-id="<?= $application['id'] ?>">

                                        <select name="status">

                                            <option value="Applied">
                                                Applied
                                            </option>

                                            <option value="Waiting">
                                                Waiting
                                            </option>

                                            <option value="Hired">
                                                Hired
                                            </option>

                                            <option value="Rejected">
                                                Rejected
                                            </option>

                                            <option value="Hold">
                                                Hold
                                            </option>

                                        </select>

                                        <button
                                            type="submit"
                                            class="btn btn-sm">

                                            Update

                                        </button>

                                    </form>

                                </td>

                                <td>

                                    <div
                                        style="display:flex; gap:8px; flex-wrap:wrap;">

                                        <a
                                            href="<?= base_url('admin/applicant/' . $application['id']) ?>"
                                            class="action-link">

                                            Details

                                        </a>

                                        <button
                                            type="button"
                                            class="btn btn-sm viewLogs"
                                            data-id="<?= $application['id'] ?>">

                                            Logs

                                        </button>

                                    </div>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

        </div>

        <!-- LOGS MODAL -->

        <div
            id="logsModal"
            style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:9999;">

            <div
                style="background:white; width:700px; max-width:95%; margin:50px auto; padding:20px; border-radius:8px;">

                <h3>
                    Application Logs
                </h3>

                <div id="logsContainer"></div>

                <button
                    onclick="$('#logsModal').hide()"
                    class="btn"
                    style="margin-top:15px;">

                    Close

                </button>

            </div>

        </div>

        <!-- ASSIGN MODAL -->

        <div
            id="assignModal"
            style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:9999;">

            <div
                style="background:white; width:500px; max-width:95%; margin:50px auto; padding:20px; border-radius:8px;">

                <h3>
                    Assign HR / TL
                </h3>

                <input
                    type="hidden"
                    id="assign_application_id">

                <div id="assign_users_container"></div>

                <button
                    onclick="$('#assignModal').hide()"
                    class="btn"
                    style="margin-top:15px;">

                    Close

                </button>

            </div>

        </div>

        <script>
            $('.assignWrapper').hover(
                function() {

                    $(this)
                        .find('.assignHover')
                        .show();
                },

                function() {

                    $(this)
                        .find('.assignHover')
                        .hide();
                }
            );

            $(document).on(
                'click',
                '.openAssignModal',
                function() {

                    let applicationId = $(this).data('id');

                    $('#assign_application_id').val(applicationId);

                    $.get(
                        '<?= base_url('admin/get-assignable-users') ?>',
                        function(users) {

                            let html = '';

                            users.forEach(function(user) {

                                html += `
                        <div style="border:1px solid #ddd; padding:10px; margin-bottom:10px;">

                            <strong>
                                ${user.name}
                            </strong>

                            (${user.role})

                            <button
                                class="btn btn-sm assignUser"
                                data-user-id="${user.id}"
                                style="float:right;">

                                Assign

                            </button>

                        </div>
                    `;
                            });

                            $('#assign_users_container').html(html);

                            $('#assignModal').show();
                        }
                    );
                }
            );

            $(document).on(
                'click',
                '.assignUser',
                function() {

                    let userId = $(this).data('user-id');

                    let applicationId =
                        $('#assign_application_id').val();

                    $.post(
                        '<?= base_url('admin/assign-application') ?>', {
                            application_id: applicationId,
                            user_id: userId
                        },
                        function() {

                            location.reload();
                        }
                    );
                }
            );

            $(document).on(
                'click',
                '.viewLogs',
                function() {

                    let id = $(this).data('id');

                    $.get(
                        '<?= base_url('admin/application-logs') ?>/' + id,
                        function(logs) {

                            let html = '';

                            logs.forEach(function(log) {

                                html += `
                        <div style="border:1px solid #ddd; padding:10px; margin-bottom:10px;">

                            <strong>
                                ${log.action}
                            </strong>

                            <br>

                            ${log.description}

                            <br>

                            <small>
                                ${log.created_at}
                            </small>

                        </div>
                    `;
                            });

                            $('#logsContainer').html(html);

                            $('#logsModal').show();
                        }
                    );
                }
            );
        </script>

        <!-- TWO-COLUMN LAYOUT: Left = Charts + Add Role | Right = Job Roles -->
        <div class="two-column-layout">
            <!-- LEFT COLUMN -->
            <div class="left-column">
                <div class="chart-card">
                    <h2>Status Distribution</h2>
                    <canvas id="statusChart"></canvas>
                </div>
                <div class="chart-card">
                    <h2>Applications Per Role</h2>
                    <canvas id="roleChart"></canvas>
                </div>

                <!-- Add Job Role Form -->
                <div class="section-card">
                    <h2>Add Job Role</h2>
                    <form method="post" action="<?= base_url('admin/add-role') ?>">
                        <div class="form-row" style="flex-direction: column; gap: 12px;">
                            <input type="text" name="role_name" placeholder="Role Name" required>
                            <textarea name="description" placeholder="Role Description" class="textarea-professional" required></textarea>

                            <!-- Skills input: checkboxes if $allSkills exists, else text field -->
                            <label>
                                Required Skills
                            </label>

                            <div class="skills-checkbox-group">

                                <?php foreach ($allSkills as $skill): ?>

                                    <?php $skillName = $skill['skill_name']; ?>

                                    <label>

                                        <input
                                            type="checkbox"
                                            name="required_skills[]"
                                            value="<?= htmlspecialchars($skillName) ?>"
                                            <?= in_array($skillName, $skillsArray) ? 'checked' : '' ?>>

                                        <?= htmlspecialchars($skillName) ?>

                                    </label>

                                <?php endforeach; ?>

                            </div>

                        </div>

                        <select name="status">
                            <option value="open">Open</option>
                            <option value="closed">Closed</option>
                        </select>
                        <button type="submit" class="btn">Add Role</button>
                </div>
                </form>
            </div>
        </div>

        <!-- RIGHT COLUMN: Job Roles Table -->
        <div class="right-column">
            <div class="section-card">
                <h2>Job Roles</h2>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Role</th>
                                <th>Description</th>
                                <th>Required Skills</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($jobs)): ?>
                                <?php foreach ($jobs as $job): ?>
                                    <?php
                                    $skillsArray = [];
                                    if (!empty($job['technical_skills'])) {
                                        $skillsArray = array_map(
                                            'trim',
                                            explode(',', $job['technical_skills'])
                                        );
                                        if (!is_array($skillsArray)) $skillsArray = [];
                                    }
                                    $skillsString = implode(', ', $skillsArray);
                                    ?>
                                    <tr>
                                        <td><?= htmlspecialchars($job['id'] ?? '') ?></td>
                                        <td><strong><?= htmlspecialchars($job['role_name'] ?? '') ?></strong></td>
                                        <td><?= htmlspecialchars($job['description'] ?? '') ?></td>
                                        <td>
                                            <!-- Display existing skills and allow edit -->
                                            <?php if (isset($allSkills) && is_array($allSkills) && !empty($allSkills)): ?>
                                                <form method="post" action="<?= base_url('admin/update-role/' . $job['id']) ?>">
                                                    <div class="skills-checkbox-group">
                                                        <?php foreach ($allSkills as $skill): ?>
                                                            <label>
                                                                <input type="checkbox" name="required_skills[]" value="<?= htmlspecialchars($skill) ?>" <?= in_array($skill, $skillsArray) ? 'checked' : '' ?>>
                                                                <?= htmlspecialchars($skill) ?>
                                                            </label>
                                                        <?php endforeach; ?>
                                                    </div>
                                                    <button type="submit" class="btn btn-sm">Update Skills</button>
                                                </form>
                                            <?php else: ?>
                                                <form method="post" action="<?= base_url('admin/update-role/' . $job['id']) ?>">
                                                    <input type="text" name="required_skills_text" value="<?= htmlspecialchars($skillsString) ?>" placeholder="PHP, JS, ..." style="width: 150px;">
                                                    <button type="submit" class="btn btn-sm">Update Skills</button>
                                                </form>
                                            <?php endif; ?>
                                        </td>
                                        <td><span class="status-badge <?= (($job['status'] ?? '') == 'open') ? 'hired' : 'rejected' ?>"><?= htmlspecialchars(ucfirst($job['status'] ?? '')) ?></span></td>
                                        <td>
                                            <div class="inline-form">
                                                <form method="post" action="<?= base_url('admin/update-role/' . $job['id']) ?>" style="display:contents;">
                                                    <input type="text" name="role_name" value="<?= htmlspecialchars($job['role_name'] ?? '') ?>" required>
                                                    <textarea name="description" required class="textarea-professional" style="min-height:60px;"><?= htmlspecialchars($job['description'] ?? '') ?></textarea>
                                                    <select name="status">
                                                        <option value="open" <?= ($job['status'] ?? '') == 'open' ? 'selected' : '' ?>>Open</option>
                                                        <option value="closed" <?= ($job['status'] ?? '') == 'closed' ? 'selected' : '' ?>>Closed</option>
                                                    </select>
                                                    <button type="submit" class="btn btn-sm">Update Role</button>
                                                </form>
                                                <a href="<?= base_url('admin/delete-role/' . $job['id']) ?>" onclick="return confirm('Delete this role?')" class="action-link" style="color:#b91c1c;">Delete</a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6">No job roles found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- MODAL for Assign HR/TL -->
    <div class="modal fade" id="assignModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Assign HR / TL</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="assign_application_id">
                    <div id="assign_users_list"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-5">

        <div class="card-header">

            <h4>
                Add HR / TL User
            </h4>

        </div>

        <div class="card-body">

            <form
                action="<?= base_url('admin/create-user') ?>"
                method="POST">

                <div class="row">

                    <div class="col-md-3 mb-3">

                        <label>
                            Full Name
                        </label>

                        <input
                            type="text"
                            name="name"
                            class="form-control"
                            required>

                    </div>

                    <div class="col-md-3 mb-3">

                        <label>
                            Email
                        </label>

                        <input
                            type="email"
                            name="email"
                            class="form-control"
                            required>

                    </div>

                    <div class="col-md-3 mb-3">

                        <label>
                            Password
                        </label>

                        <input
                            type="password"
                            name="password"
                            class="form-control"
                            required>

                    </div>

                    <div class="col-md-3 mb-3">

                        <label>
                            Role
                        </label>

                        <select
                            name="role"
                            class="form-select"
                            required>

                            <option value="hr">
                                HR
                            </option>

                            <option value="tl">
                                TL
                            </option>

                        </select>

                    </div>

                </div>

                <button
                    type="submit"
                    class="btn btn-primary">

                    Create User

                </button>

            </form>

        </div>

    </div>

    <div class="toast" id="toast"></div>

    <script>
        // Chart data from backend (safe defaults)
        const statusLabels = <?= json_encode(array_keys($statusCounts ?? [])) ?>;
        const statusData = <?= json_encode(array_values($statusCounts ?? [])) ?>;
        const roleLabels = <?= json_encode(array_keys($roleCounts ?? [])) ?>;
        const roleData = <?= json_encode(array_values($roleCounts ?? [])) ?>;

        // Status Pie Chart
        if (document.getElementById('statusChart')) {
            new Chart(document.getElementById('statusChart').getContext('2d'), {
                type: 'pie',
                data: {
                    labels: statusLabels.length ? statusLabels : ['No Data'],
                    datasets: [{
                        data: statusLabels.length ? statusData : [1],
                        backgroundColor: ['#818cf8', '#fdba74', '#5eead4', '#fca5a5', '#94a3b8'],
                        borderWidth: 2,
                        borderColor: '#fff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                usePointStyle: true,
                                boxWidth: 10
                            }
                        }
                    }
                }
            });
        }

        // Role Bar Chart
        if (document.getElementById('roleChart')) {
            new Chart(document.getElementById('roleChart').getContext('2d'), {
                type: 'bar',
                data: {
                    labels: roleLabels.length ? roleLabels : ['No Roles'],
                    datasets: [{
                        label: 'Applications',
                        data: roleLabels.length ? roleData : [0],
                        backgroundColor: '#1e3a8a',
                        borderRadius: 4,
                        borderSkipped: false
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    }
                }
            });
        }

        // AJAX status update
        document.querySelectorAll('.statusForm').forEach(form => {
            form.addEventListener('submit', async function(e) {
                e.preventDefault();
                const id = this.dataset.id;
                const status = this.querySelector('select').value;
                try {
                    const resp = await fetch('<?= base_url('admin/update-status/') ?>' + id, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: 'status=' + encodeURIComponent(status)
                    });
                    if (resp.ok) {
                        document.getElementById('status-text-' + id).innerHTML = `<span class="status-badge ${status.toLowerCase()}">${status}</span>`;
                        showToast('Status updated to ' + status);
                    } else {
                        showToast('Error updating status', true);
                    }
                } catch (error) {
                    showToast('Error updating status', true);
                }
            });
        });

        // Assign HR/TL modal logic (jQuery)
        $(document).on('click', '.open-assign-modal, .assign-hover', function() {
            let applicationId = $(this).data('id');
            $('#assign_application_id').val(applicationId);
            $.get('<?= base_url('admin/get-assignable-users') ?>', function(users) {
                let html = '';
                if (users.length === 0) {
                    html = '<div class="alert alert-warning">No HR/TL users available.</div>';
                } else {
                    users.forEach(function(user) {
                        html += `<div class="border rounded p-2 mb-2">
                                    <strong>${escapeHtml(user.name)}</strong> (${user.role})
                                    <button class="btn btn-primary btn-sm float-end assign-user" data-user-id="${user.id}">Assign</button>
                                </div>`;
                    });
                }
                $('#assign_users_list').html(html);
            }).fail(function() {
                $('#assign_users_list').html('<div class="alert alert-danger">Could not load users.</div>');
            });
        });

        $(document).on('click', '.assign-user', function() {
            let userId = $(this).data('user-id');
            let applicationId = $('#assign_application_id').val();
            let btn = $(this);
            btn.prop('disabled', true).text('Assigning...');
            $.post('<?= base_url('admin/assign-application') ?>', {
                application_id: applicationId,
                user_id: userId
            }, function(response) {
                if (response.success) {
                    location.reload();
                } else {
                    showToast('Assignment failed: ' + (response.error || 'Unknown error'), true);
                    btn.prop('disabled', false).text('Assign');
                }
            }).fail(function() {
                showToast('Server error while assigning', true);
                btn.prop('disabled', false).text('Assign');
            });
        });

        function escapeHtml(str) {
            if (!str) return '';
            return str.replace(/[&<>]/g, function(m) {
                if (m === '&') return '&amp;';
                if (m === '<') return '&lt;';
                if (m === '>') return '&gt;';
                return m;
            });
        }

        function showToast(message, isError = false) {
            const toast = document.getElementById('toast');
            toast.textContent = message;
            toast.className = 'toast show' + (isError ? ' error-toast' : '');
            clearTimeout(toast.hideTimeout);
            toast.hideTimeout = setTimeout(() => toast.classList.remove('show'), 3000);
        }
    </script>
</body>

</html>