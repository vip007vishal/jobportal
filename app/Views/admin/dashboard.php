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
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

    <style>
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

    <?php if ($userRole == 'admin'): ?>

        <?php include 'navbar.php'; ?>

        <?php
        $role = session()->get('role') ?? 'admin';
        $isAdmin = ($role === 'admin');
        ?>

        <div class="dashboard-wrapper">

            <div class="top-header">
                <div class="brand">
                    <h1>Admin Dashboard</h1>
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

            <!-- Analytics cards -->
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

            <!-- APPLICATIONS SECTION (full width) -->
            <div class="section-card">
                <h2>Applications</h2>
                <div class="search-bar" style="margin-bottom: 20px; padding-bottom: 16px; border-bottom: 1px solid var(--gray-200);">
                    <form method="get" class="form-row">
                        <input type="text" name="search" placeholder="Search by name, email or mobile..." value="<?= $_GET['search'] ?? '' ?>" style="flex: 2; min-width: 200px;">
                        <select name="status" style="flex: 1; min-width: 140px;">
                            <option value="">All Status</option>
                            <option value="Applied" <?= (isset($_GET['status']) && $_GET['status'] === 'Applied') ? 'selected' : '' ?>>Applied</option>
                            <option value="Waiting" <?= (isset($_GET['status']) && $_GET['status'] === 'Waiting') ? 'selected' : '' ?>>Waiting</option>
                            <option value="Hired" <?= (isset($_GET['status']) && $_GET['status'] === 'Hired') ? 'selected' : '' ?>>Hired</option>
                            <option value="Rejected" <?= (isset($_GET['status']) && $_GET['status'] === 'Rejected') ? 'selected' : '' ?>>Rejected</option>
                            <option value="Hold" <?= (isset($_GET['status']) && $_GET['status'] === 'Hold') ? 'selected' : '' ?>>Hold</option>
                        </select>
                        <button type="submit" class="btn">Search</button>
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
                                <?php if ($isAdmin): ?><th>Assigned HR / TL</th><?php endif; ?>
                                <th>Status</th>
                                <th>Resume</th>
                                <th>Update Status</th>
                                <th>Actions</th>
                                <th>Logs</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($applications as $application): ?>
                                <tr>
                                    <td><?= $application['id'] ?></td>
                                    <td><strong><?= esc($application['full_name']) ?></strong></td>
                                    <td><?= esc($application['email']) ?></td>
                                    <td><?= esc($application['mobile']) ?></td>
                                    <td><?= esc($application['role_name']) ?></td>
                                    <td>
                                        <strong title="Job Skills: <?= htmlspecialchars($application['required_skills'] ?? 'Empty') ?> | Candidate Skills: <?= htmlspecialchars($application['technical_skills'] ?? 'Empty') ?>">
                                            <?= $application['skill_match'] ?? 0 ?>%
                                        </strong>
                                    </td>
                                    <?php if ($isAdmin): ?>
                                        <td>
                                            <?php if (!empty($application['assigned_user_name'])): ?>
                                                <div style="position:relative;">
                                                    <span><?= esc($application['assigned_user_name']) ?></span>
                                                    <button type="button" class="btn btn-sm btn-warning openAssignModal" data-id="<?= $application['id'] ?>" style="margin-left:8px;">Reassign</button>
                                                </div>
                                            <?php else: ?>
                                                <button type="button" class="btn btn-sm btn-warning openAssignModal" data-id="<?= $application['id'] ?>">Assign HR / TL</button>
                                            <?php endif; ?>
                                        </td>
                                    <?php endif; ?>
                                    <td id="status-text-<?= $application['id'] ?>">
                                        <span class="status-badge <?= strtolower($application['status']) ?>"><?= $application['status'] ?></span>
                                    </td>
                                    <td>
                                        <a target="_blank" href="<?= base_url('uploads/resumes/' . $application['resume']) ?>" class="action-link">View</a>
                                    </td>
                                    <td>
                                        <form class="statusForm inline-form" data-id="<?= $application['id'] ?>">
                                            <select name="status">
                                                <option value="Applied">Applied</option>
                                                <option value="Waiting">Waiting</option>
                                                <option value="Hired">Hired</option>
                                                <option value="Rejected">Rejected</option>
                                                <option value="Hold">Hold</option>
                                            </select>
                                            <button type="submit" class="btn btn-sm">Update</button>
                                        </form>
                                    </td>
                                    <td>
                                        <a href="<?= base_url('admin/applicant/' . $application['id']) ?>" class="action-link">Details</a>
                                    </td>
                                    <td>
                                        <button type="button" class="btn-icon viewLogs" data-id="<?= $application['id'] ?>" title="View logs">&#128065;</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- ========== TWO-COLUMN SECTION ========== -->
            <div class="two-column-layout">
                <!-- LEFT COLUMN: Charts -->
                <div class="column-left">
                    <div class="chart-card">
                        <h2>Status Distribution</h2>
                        <canvas id="statusChart"></canvas>
                    </div>
                    <div class="section-card" style="margin-bottom:0;">
                        <h2>Add Job Role</h2>
                        <form method="post" action="<?= base_url('admin/add-role') ?>">
                            <div style="display:flex; flex-direction:column; gap:12px;">
                                <input type="text" name="role_name" placeholder="Role Name" required>
                                <textarea name="description" placeholder="Role Description" required></textarea>
                                <label style="font-weight:600; font-size:0.8rem;">Required Skills</label>
                                <div class="skills-checkbox-group">
                                    <?php if (!empty($allSkills)): ?>
                                        <?php foreach ($allSkills as $skill): ?>
                                            <label>
                                                <input type="checkbox" name="required_skills[]" value="<?= esc($skill['skill_name']) ?>">
                                                <?= esc($skill['skill_name']) ?>
                                            </label>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <p>No skills defined yet.</p>
                                    <?php endif; ?>
                                </div>
                                <select name="status">
                                    <option value="open">Open</option>
                                    <option value="closed">Closed</option>
                                </select>
                                <button type="submit" class="btn">Add Role</button>
                            </div>
                        </form>
                    </div>

                    <div class="section-card" style="margin-bottom:0px;">
                        <h2>Add HR / TL User</h2>
                        <form action="<?= base_url('admin/create-user') ?>" method="POST" style="display:flex; flex-direction:column; gap:12px;">
                            <input type="text" name="name" placeholder="Full Name" required>
                            <input type="email" name="email" placeholder="Email" required>
                            <input type="password" name="password" placeholder="Password" required>
                            <select name="role" required>
                                <option value="hr">HR</option>
                                <option value="tl">TL</option>
                            </select>
                            <button type="submit" class="btn">Create User</button>
                        </form>
                    </div>
                </div>

                <!-- RIGHT COLUMN: Admin forms -->
                <div class="column-right">
                    <div class="chart-card">
                        <h2>Applications Per Role</h2>
                        <canvas id="roleChart"></canvas>
                    </div>


                    <div class="section-card" style="margin-bottom:0;">
                        <h2>Technical Skills</h2>

                        <!-- ADD SKILL FORM (improved layout) -->
                        <form action="<?= base_url('admin/add-skill') ?>" method="POST" class="form-row" style="align-items: center; margin-bottom: 20px;">
                            <input type="text" name="skill_name" placeholder="Enter Skill" required style="flex: 1;">
                            <button type="submit" class="btn">Add Skill</button>
                        </form>

                        <!-- SKILLS LIST (unchanged styling, just using the same flex approach) -->
                        <div style="display:flex; flex-wrap:wrap; gap:10px;">
                            <?php if (!empty($allSkills)): ?>
                                <?php foreach ($allSkills as $skill): ?>
                                    <div style="background:#f1f5f9; padding:8px 12px; border-radius:8px; display:flex; align-items:center; gap:10px;">
                                        <span><?= esc($skill['skill_name']) ?></span>
                                        <a href="<?= base_url('admin/delete-skill/' . $skill['id']) ?>" onclick="return confirm('Delete this skill?')" style="color:red; text-decoration:none; font-weight:bold;">✕</a>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p>No skills added yet.</p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- ADMIN ONLY: Users Table -->
                    <div class="section-card">
                        <h2>Users</h2>
                        <div class="table-responsive">
                            <table>
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Users</th>
                                        <th>Role</th>
                                        <th>Mail ID</th>
                                        <th>Access</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($users)): ?>

                                        <?php foreach ($users as $user): ?>

                                            <?php if ($user['role'] != 'admin'): ?>

                                                <tr>

                                                    <td><?= esc($user['id']) ?></td>

                                                    <td>
                                                        <strong>
                                                            <?= esc($user['name']) ?>
                                                        </strong>
                                                    </td>

                                                    <td>
                                                        <?= esc(strtoupper($user['role'])) ?>
                                                    </td>

                                                    <td>
                                                        <?= esc($user['email']) ?>
                                                    </td>

                                                    <td>
                                                        <form action="<?= base_url('admin/update-access/' . $user['id']) ?>"
                                                            method="post">

                                                            <button class="btn" type="submit">

                                                                <?= $user['access'] ? 'Revoke Access' : 'Grant Access' ?>

                                                            </button>

                                                        </form>
                                                    </td>

                                                </tr>

                                            <?php endif; ?>

                                        <?php endforeach; ?>

                                    <?php else: ?>

                                        <tr>

                                            <td colspan="6">
                                                No Users found.
                                            </td>

                                        </tr>

                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

            </div>







            <!-- ADMIN ONLY: Job Roles Table -->
            <div class="section-card">
                <h2>Job Roles</h2>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Role</th>
                                <th>Description</th>
                                <th>Technical Skills</th>
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
                                        $skillsArray = array_map('trim', explode(',', $job['technical_skills']));
                                    }
                                    ?>
                                    <tr>
                                        <td><?= $job['id'] ?></td>
                                        <td><strong><?= esc($job['role_name']) ?></strong></td>
                                        <td><?= esc($job['description']) ?></td>
                                        <td><?= esc($job['technical_skills']) ?></td>
                                        <td>
                                            <?php if (isset($allSkills) && !empty($allSkills)): ?>
                                                <form method="post" action="<?= base_url('admin/update-role/' . $job['id']) ?>">
                                                    <div class="skills-checkbox-group">
                                                        <?php foreach ($allSkills as $skill): ?>
                                                            <label>
                                                                <input type="checkbox" name="required_skills[]" value="<?= esc($skill['skill_name']) ?>" <?= in_array($skill['skill_name'], $skillsArray) ? 'checked' : '' ?>>
                                                                <?= esc($skill['skill_name']) ?>
                                                            </label>
                                                        <?php endforeach; ?>
                                                    </div>
                                                    <button type="submit" class="btn btn-sm">Update Skills</button>
                                                </form>
                                            <?php else: ?>
                                                <form method="post" action="<?= base_url('admin/update-role/' . $job['id']) ?>">
                                                    <input type="text" name="required_skills_text" value="<?= implode(', ', $skillsArray) ?>" placeholder="PHP, JS, ..." style="width:150px;">
                                                    <button type="submit" class="btn btn-sm">Update Skills</button>
                                                </form>
                                            <?php endif; ?>
                                        </td>
                                        <td><span class="status-badge <?= ($job['status'] ?? '') == 'open' ? 'hired' : 'rejected' ?>"><?= ucfirst($job['status'] ?? '') ?></span></td>
                                        <td>
                                            <div class="inline-form">
                                                <form method="post" action="<?= base_url('admin/update-role/' . $job['id']) ?>" style="display:contents;">
                                                    <input type="text" name="role_name" value="<?= esc($job['role_name']) ?>" required>
                                                    <textarea name="description" required class="textarea-professional" style="min-height:60px;"><?= esc($job['description']) ?></textarea>
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

        <!-- LOGS MODAL -->
        <div id="logsModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:9999;">
            <div style="background:white; width:700px; max-width:95%; margin:50px auto; padding:20px; border-radius:8px;">
                <h3>Application Logs</h3>
                <div id="logsContainer"></div>
                <button onclick="$('#logsModal').hide()" class="btn" style="margin-top:15px;">Close</button>
            </div>
        </div>

        <!-- ASSIGN MODAL -->
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

        <div class="toast" id="toast"></div>


        <script>
            // Status distribution (pie) – unchanged
            const statusLabels = <?= json_encode(array_keys($statusCounts ?? [])) ?>;
            const statusData = <?= json_encode(array_values($statusCounts ?? [])) ?>;

            if (document.getElementById('statusChart')) {
                // Register the datalabels plugin (auto-register works, but we call it for safety)
                Chart.register(ChartDataLabels);

                new Chart(document.getElementById('statusChart').getContext('2d'), {
                    type: 'doughnut', // modern donut shape
                    data: {
                        labels: statusLabels.length ? statusLabels : ['No Data'],
                        datasets: [{
                            data: statusLabels.length ? statusData : [1],
                            backgroundColor: ['#6366f1', '#f59e0b', '#10b981', '#ef4444', '#8b5cf6'], // vibrant palette
                            borderColor: '#ffffff',
                            borderWidth: 3,
                            hoverBorderWidth: 5,
                            spacing: 4, // clean gap between slices
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '55%', // donut hole size
                        plugins: {
                            legend: {
                                position: 'right',
                                labels: {
                                    usePointStyle: true,
                                    pointStyleWidth: 10,
                                    padding: 20,
                                    font: {
                                        size: 12,
                                        family: "'Inter', system-ui, sans-serif"
                                    },
                                    color: '#334155',
                                    generateLabels: function(chart) {
                                        const data = chart.data;
                                        return data.labels.map((label, i) => ({
                                            text: `${label}: ${data.datasets[0].data[i]} (${Math.round((data.datasets[0].data[i] / data.datasets[0].data.reduce((a,b)=>a+b,0))*100)}%)`,
                                            fillStyle: data.datasets[0].backgroundColor[i],
                                            strokeStyle: '#ffffff',
                                            lineWidth: 2,
                                            hidden: false,
                                            index: i
                                        }));
                                    }
                                }
                            },
                            tooltip: {
                                backgroundColor: '#0f172a',
                                padding: 10,
                                cornerRadius: 6,
                                callbacks: {
                                    label: function(context) {
                                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        const percent = total > 0 ? Math.round((context.parsed / total) * 100) : 0;
                                        return ` ${context.label}: ${context.parsed} (${percent}%)`;
                                    }
                                }
                            },
                            datalabels: {
                                color: '#ffffff',
                                font: {
                                    weight: 'bold',
                                    size: 14,
                                    family: 'Inter, system-ui, sans-serif'
                                },
                                // white outline for better contrast
                                textStrokeColor: '#1e293b',
                                textStrokeWidth: 0,
                                formatter: (value, context) => {
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percent = total > 0 ? Math.round((value / total) * 100) : 0;
                                    return percent + '%';
                                },
                                display: (context) => {
                                    return context.dataset.data[context.dataIndex] > 0;
                                },
                                anchor: 'center',
                                clamp: true,
                                offset: 0,
                                // no background box
                                backgroundColor: null,
                                borderRadius: 0,
                                padding: 0
                            }
                        }
                    }
                });
            }
            // 📊 REDESIGNED: Applications Per Role (horizontal bar with gradient)
            const roleLabels = <?= json_encode(array_keys($roleCounts ?? [])) ?>;
            const roleData = <?= json_encode(array_values($roleCounts ?? [])) ?>;

            if (document.getElementById('roleChart')) {
                const ctx = document.getElementById('roleChart').getContext('2d');

                // Create gradient for bars
                const gradient = ctx.createLinearGradient(0, 0, 400, 0);
                gradient.addColorStop(0, '#1e3a8a'); // deep blue
                gradient.addColorStop(1, '#3b82f6'); // lighter blue

                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: roleLabels.length ? roleLabels : ['No Roles'],
                        datasets: [{
                            label: 'Applications',
                            data: roleLabels.length ? roleData : [0],
                            backgroundColor: gradient,
                            borderRadius: 6,
                            borderSkipped: false,
                            barPercentage: 0.6,
                            categoryPercentage: 0.8
                        }]
                    },
                    options: {
                        indexAxis: 'y', // horizontal bars
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: '#0f172a',
                                titleFont: {
                                    weight: 'bold'
                                },
                                bodyFont: {
                                    size: 13
                                },
                                padding: 10,
                                cornerRadius: 6,
                                displayColors: false
                            }
                        },
                        scales: {
                            x: {
                                beginAtZero: true,
                                grid: {
                                    color: '#e2e8f0',
                                    drawBorder: false
                                },
                                ticks: {
                                    precision: 0,
                                    font: {
                                        size: 11
                                    },
                                    color: '#64748b'
                                }
                            },
                            y: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    font: {
                                        size: 12,
                                        weight: '500'
                                    },
                                    color: '#334155'
                                }
                            }
                        },
                        // Value labels on bars
                        animation: {
                            onComplete: function() {
                                const chartInstance = this;
                                const ctx = chartInstance.ctx;
                                ctx.font = Chart.helpers.fontString(
                                    Chart.defaults.font.size,
                                    'bold',
                                    Chart.defaults.font.family
                                );
                                ctx.fillStyle = '#ffffff';
                                ctx.textAlign = 'left';
                                ctx.textBaseline = 'middle';
                                this.data.datasets.forEach(function(dataset, i) {
                                    const meta = chartInstance.getDatasetMeta(i);
                                    meta.data.forEach(function(bar, index) {
                                        const data = dataset.data[index];
                                        if (data > 0) {
                                            ctx.fillText(data, bar.x - 30, bar.y);
                                        }
                                    });
                                });
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

            // Assign HR/TL
            $(document).on('click', '.openAssignModal', function() {
                const appId = $(this).data('id');
                $('#assign_application_id').val(appId);
                $.get('<?= base_url('admin/get-assignable-users') ?>', function(users) {
                    let html = '';
                    if (!users || users.length === 0) {
                        html = '<div class="alert alert-warning">No HR/TL users available.</div>';
                    } else {
                        users.forEach(function(user) {
                            html += `<div class="border rounded p-2 mb-2">
                                <strong>${user.name}</strong> (${user.role})
                                <button class="btn btn-primary btn-sm float-end assign-user" data-user-id="${user.id}">Assign</button>
                            </div>`;
                        });
                    }
                    $('#assign_users_list').html(html);
                    $('#assignModal').modal('show');
                });
            });

            $(document).on('click', '.assign-user', function() {
                const userId = $(this).data('user-id');
                const appId = $('#assign_application_id').val();
                const btn = $(this);
                btn.prop('disabled', true).text('Assigning...');
                $.post('<?= base_url('admin/assign-application') ?>', {
                    application_id: appId,
                    user_id: userId
                }, function(res) {
                    if (res.success) {
                        location.reload();
                    } else {
                        showToast('Assignment failed: ' + (res.error || 'Unknown error'), true);
                        btn.prop('disabled', false).text('Assign');
                    }
                }).fail(function() {
                    showToast('Server error', true);
                    btn.prop('disabled', false).text('Assign');
                });
            });

            // Logs eye icon
            $(document).on('click', '.viewLogs', function() {
                const id = $(this).data('id');
                $.get('<?= base_url('admin/application-logs') ?>/' + id, function(logs) {
                    let html = '';
                    if (logs && logs.length) {
                        logs.forEach(function(log) {
                            html += `<div style="border:1px solid #ddd; padding:10px; margin-bottom:10px;">
                                <strong>${log.action}</strong><br>${log.description}<br><small>${log.created_at}</small>
                            </div>`;
                        });
                    } else {
                        html = '<div class="alert alert-info">No logs found.</div>';
                    }
                    $('#logsContainer').html(html);
                    $('#logsModal').show();
                });
            });

            function showToast(message, isError = false) {
                const toast = document.getElementById('toast');
                toast.textContent = message;
                toast.className = 'toast show' + (isError ? ' error-toast' : '');
                clearTimeout(toast.hideTimeout);
                toast.hideTimeout = setTimeout(() => toast.classList.remove('show'), 3000);
            }
        </script>


    <?php elseif ($access || ($canViewOwn == 0 && $canViewGlobal == 0 && $canUpdateStatus == 0)): ?>

        <div class="dashboard-wrapper" style="text-align: center; padding: 50px;">
            <h2>Access Denied</h2>
            <p>You do not have permission to view this page.</p>
        </div>

    <?php else: ?>

        <?php include 'navbar.php'; ?>

        <?php
        $role = session()->get('role') ?? 'admin';
        $isAdmin = ($role === 'admin');
        ?>

        <div class="dashboard-wrapper">

            <div class="top-header">
                <div class="brand">
                    <h1>Admin Dashboard</h1>
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

            <!-- Analytics cards -->
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

            <!-- APPLICATIONS SECTION (full width) -->
            <div class="section-card">
                <h2>Applications</h2>
                <div class="search-bar" style="margin-bottom: 20px; padding-bottom: 16px; border-bottom: 1px solid var(--gray-200);">
                    <form method="get" class="form-row">
                        <input type="text" name="search" placeholder="Search by name, email or mobile..." value="<?= $_GET['search'] ?? '' ?>" style="flex: 2; min-width: 200px;">
                        <select name="status" style="flex: 1; min-width: 140px;">
                            <option value="">All Status</option>
                            <option value="Applied" <?= (isset($_GET['status']) && $_GET['status'] === 'Applied') ? 'selected' : '' ?>>Applied</option>
                            <option value="Waiting" <?= (isset($_GET['status']) && $_GET['status'] === 'Waiting') ? 'selected' : '' ?>>Waiting</option>
                            <option value="Hired" <?= (isset($_GET['status']) && $_GET['status'] === 'Hired') ? 'selected' : '' ?>>Hired</option>
                            <option value="Rejected" <?= (isset($_GET['status']) && $_GET['status'] === 'Rejected') ? 'selected' : '' ?>>Rejected</option>
                            <option value="Hold" <?= (isset($_GET['status']) && $_GET['status'] === 'Hold') ? 'selected' : '' ?>>Hold</option>
                        </select>
                        <button type="submit" class="btn">Search</button>
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
                                <th>Status</th>
                                <th>Resume</th>
                                <th>Update Status</th>
                                <th>Actions</th>
                                <th>Logs</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($applications as $application): ?>
                                <tr>
                                    <td><?= $application['id'] ?></td>
                                    <td><strong><?= esc($application['full_name']) ?></strong></td>
                                    <td><?= esc($application['email']) ?></td>
                                    <td><?= esc($application['mobile']) ?></td>
                                    <td><?= esc($application['role_name']) ?></td>
                                    <td>
                                        <strong title="Job Skills: <?= htmlspecialchars($application['required_skills'] ?? 'Empty') ?> | Candidate Skills: <?= htmlspecialchars($application['technical_skills'] ?? 'Empty') ?>">
                                            <?= $application['skill_match'] ?? 0 ?>%
                                        </strong>
                                    </td>
                                    <td id="status-text-<?= $application['id'] ?>">
                                        <span class="status-badge <?= strtolower($application['status']) ?>"><?= $application['status'] ?></span>
                                    </td>
                                    <td>
                                        <a target="_blank" href="<?= base_url('uploads/resumes/' . $application['resume']) ?>" class="action-link">View</a>
                                    </td>
                                    <td>
                                        <form class="statusForm inline-form" data-id="<?= $application['id'] ?>">
                                            <select name="status">
                                                <option value="Applied">Applied</option>
                                                <option value="Waiting">Waiting</option>
                                                <option value="Hired">Hired</option>
                                                <option value="Rejected">Rejected</option>
                                                <option value="Hold">Hold</option>
                                            </select>
                                            <button type="submit" class="btn btn-sm">Update</button>
                                        </form>
                                    </td>
                                    <td>
                                        <a href="<?= base_url('admin/applicant/' . $application['id']) ?>" class="action-link">Details</a>
                                    </td>
                                    <td>
                                        <button type="button" class="btn-icon viewLogs" data-id="<?= $application['id'] ?>" title="View logs">&#128065;</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- ========== TWO-COLUMN SECTION ========== -->
            <div class="two-column-layout">
                <!-- LEFT COLUMN: Charts -->
                <div class="column-left">
                    <div class="chart-card">
                        <h2>Status Distribution</h2>
                        <canvas id="statusChart"></canvas>
                    </div>
                </div>

                <!-- RIGHT COLUMN: Admin forms -->
                <div class="column-right">
                    <div class="chart-card">
                        <h2>Applications Per Role</h2>
                        <canvas id="roleChart"></canvas>
                    </div>
                </div>
            </div>

            <?php if ($isAdmin): ?>
                <!-- ADMIN ONLY: Job Roles Table -->
                <div class="section-card">
                    <h2>Job Roles</h2>
                    <div class="table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Role</th>
                                    <th>Description</th>
                                    <th>Technical Skills</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($jobs)): ?>
                                    <?php foreach ($jobs as $job): ?>
                                        <?php
                                        $skillsArray = [];
                                        if (!empty($job['technical_skills'])) {
                                            $skillsArray = array_map('trim', explode(',', $job['technical_skills']));
                                        }
                                        ?>
                                        <tr>
                                            <td><?= $job['id'] ?></td>
                                            <td><strong><?= esc($job['role_name']) ?></strong></td>
                                            <td><?= esc($job['description']) ?></td>
                                            <td style="margin-left: 200px;"><?= esc($job['technical_skills']) ?></td>
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
            <?php endif; ?>

        </div>

        <!-- LOGS MODAL -->
        <div id="logsModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:9999;">
            <div style="background:white; width:700px; max-width:95%; margin:50px auto; padding:20px; border-radius:8px;">
                <h3>Application Logs</h3>
                <div id="logsContainer"></div>
                <button onclick="$('#logsModal').hide()" class="btn" style="margin-top:15px;">Close</button>
            </div>
        </div>


        <div class="toast" id="toast"></div>

        <script>
            // Status distribution (pie) – unchanged
            const statusLabels = <?= json_encode(array_keys($statusCounts ?? [])) ?>;
            const statusData = <?= json_encode(array_values($statusCounts ?? [])) ?>;

            if (document.getElementById('statusChart')) {
                // Register the datalabels plugin (auto-register works, but we call it for safety)
                Chart.register(ChartDataLabels);

                new Chart(document.getElementById('statusChart').getContext('2d'), {
                    type: 'doughnut', // modern donut shape
                    data: {
                        labels: statusLabels.length ? statusLabels : ['No Data'],
                        datasets: [{
                            data: statusLabels.length ? statusData : [1],
                            backgroundColor: ['#6366f1', '#f59e0b', '#10b981', '#ef4444', '#8b5cf6'], // vibrant palette
                            borderColor: '#ffffff',
                            borderWidth: 3,
                            hoverBorderWidth: 5,
                            spacing: 4, // clean gap between slices
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '55%', // donut hole size
                        plugins: {
                            legend: {
                                position: 'right',
                                labels: {
                                    usePointStyle: true,
                                    pointStyleWidth: 10,
                                    padding: 20,
                                    font: {
                                        size: 12,
                                        family: "'Inter', system-ui, sans-serif"
                                    },
                                    color: '#334155',
                                    generateLabels: function(chart) {
                                        const data = chart.data;
                                        return data.labels.map((label, i) => ({
                                            text: `${label}: ${data.datasets[0].data[i]} (${Math.round((data.datasets[0].data[i] / data.datasets[0].data.reduce((a,b)=>a+b,0))*100)}%)`,
                                            fillStyle: data.datasets[0].backgroundColor[i],
                                            strokeStyle: '#ffffff',
                                            lineWidth: 2,
                                            hidden: false,
                                            index: i
                                        }));
                                    }
                                }
                            },
                            tooltip: {
                                backgroundColor: '#0f172a',
                                padding: 10,
                                cornerRadius: 6,
                                callbacks: {
                                    label: function(context) {
                                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        const percent = total > 0 ? Math.round((context.parsed / total) * 100) : 0;
                                        return ` ${context.label}: ${context.parsed} (${percent}%)`;
                                    }
                                }
                            },
                            datalabels: {
                                color: '#ffffff',
                                font: {
                                    weight: 'bold',
                                    size: 14,
                                    family: 'Inter, system-ui, sans-serif'
                                },
                                // white outline for better contrast
                                textStrokeColor: '#1e293b',
                                textStrokeWidth: 0,
                                formatter: (value, context) => {
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percent = total > 0 ? Math.round((value / total) * 100) : 0;
                                    return percent + '%';
                                },
                                display: (context) => {
                                    return context.dataset.data[context.dataIndex] > 0;
                                },
                                anchor: 'center',
                                clamp: true,
                                offset: 0,
                                // no background box
                                backgroundColor: null,
                                borderRadius: 0,
                                padding: 0
                            }
                        }
                    }
                });
            }

            // 📊 REDESIGNED: Applications Per Role (horizontal bar with gradient)
            const roleLabels = <?= json_encode(array_keys($roleCounts ?? [])) ?>;
            const roleData = <?= json_encode(array_values($roleCounts ?? [])) ?>;

            if (document.getElementById('roleChart')) {
                const ctx = document.getElementById('roleChart').getContext('2d');

                // Create gradient for bars
                const gradient = ctx.createLinearGradient(0, 0, 400, 0);
                gradient.addColorStop(0, '#1e3a8a'); // deep blue
                gradient.addColorStop(1, '#3b82f6'); // lighter blue

                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: roleLabels.length ? roleLabels : ['No Roles'],
                        datasets: [{
                            label: 'Applications',
                            data: roleLabels.length ? roleData : [0],
                            backgroundColor: gradient,
                            borderRadius: 6,
                            borderSkipped: false,
                            barPercentage: 0.6,
                            categoryPercentage: 0.8
                        }]
                    },
                    options: {
                        indexAxis: 'y', // horizontal bars
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: '#0f172a',
                                titleFont: {
                                    weight: 'bold'
                                },
                                bodyFont: {
                                    size: 13
                                },
                                padding: 10,
                                cornerRadius: 6,
                                displayColors: false
                            }
                        },
                        scales: {
                            x: {
                                beginAtZero: true,
                                grid: {
                                    color: '#e2e8f0',
                                    drawBorder: false
                                },
                                ticks: {
                                    precision: 0,
                                    font: {
                                        size: 11
                                    },
                                    color: '#64748b'
                                }
                            },
                            y: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    font: {
                                        size: 12,
                                        weight: '500'
                                    },
                                    color: '#334155'
                                }
                            }
                        },
                        // Value labels on bars
                        animation: {
                            onComplete: function() {
                                const chartInstance = this;
                                const ctx = chartInstance.ctx;
                                ctx.font = Chart.helpers.fontString(
                                    Chart.defaults.font.size,
                                    'bold',
                                    Chart.defaults.font.family
                                );
                                ctx.fillStyle = '#ffffff';
                                ctx.textAlign = 'left';
                                ctx.textBaseline = 'middle';
                                this.data.datasets.forEach(function(dataset, i) {
                                    const meta = chartInstance.getDatasetMeta(i);
                                    meta.data.forEach(function(bar, index) {
                                        const data = dataset.data[index];
                                        if (data > 0) {
                                            ctx.fillText(data, bar.x - 30, bar.y);
                                        }
                                    });
                                });
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

            $(document).on('click', '.assign-user', function() {
                const userId = $(this).data('user-id');
                const appId = $('#assign_application_id').val();
                const btn = $(this);
                btn.prop('disabled', true).text('Assigning...');
                $.post('<?= base_url('admin/assign-application') ?>', {
                    application_id: appId,
                    user_id: userId
                }, function(res) {
                    if (res.success) {
                        location.reload();
                    } else {
                        showToast('Assignment failed: ' + (res.error || 'Unknown error'), true);
                        btn.prop('disabled', false).text('Assign');
                    }
                }).fail(function() {
                    showToast('Server error', true);
                    btn.prop('disabled', false).text('Assign');
                });
            });

            // Logs eye icon
            $(document).on('click', '.viewLogs', function() {
                const id = $(this).data('id');
                $.get('<?= base_url('admin/application-logs') ?>/' + id, function(logs) {
                    let html = '';
                    if (logs && logs.length) {
                        logs.forEach(function(log) {
                            html += `<div style="border:1px solid #ddd; padding:10px; margin-bottom:10px;">
                                <strong>${log.action}</strong><br>${log.description}<br><small>${log.created_at}</small>
                            </div>`;
                        });
                    } else {
                        html = '<div class="alert alert-info">No logs found.</div>';
                    }
                    $('#logsContainer').html(html);
                    $('#logsModal').show();
                });
            });

            function showToast(message, isError = false) {
                const toast = document.getElementById('toast');
                toast.textContent = message;
                toast.className = 'toast show' + (isError ? ' error-toast' : '');
                clearTimeout(toast.hideTimeout);
                toast.hideTimeout = setTimeout(() => toast.classList.remove('show'), 3000);
            }
        </script>



    <?php endif; ?>

</body>

</html>