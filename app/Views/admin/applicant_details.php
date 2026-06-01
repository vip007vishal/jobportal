<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applicant Profile — <?= esc($application['full_name']) ?></title>

    <style>
        /* ========== PROFESSIONAL, LESS COLORFUL DESIGN ========== */
        :root {
            --primary: #1e3a8a;
            /* deep navy */
            --primary-hover: #1e40af;
            --primary-light: #eff6ff;
            --success: #0f766e;
            /* teal */
            --success-bg: #f0fdfa;
            --success-text: #115e59;
            --error: #b91c1c;
            --error-bg: #fef2f2;
            --warning: #b45309;
            --warning-bg: #fffbeb;
            --warning-text: #92400e;
            --info: #1e40af;
            --info-bg: #eff6ff;
            --info-text: #1e40af;
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
            --shadow-lg: 0 10px 15px rgba(0, 0, 0, 0.06), 0 4px 6px rgba(0, 0, 0, 0.04);
            --radius-sm: 6px;
            --radius: 8px;
            --radius-lg: 12px;
            --radius-xl: 16px;
            --transition: 0.15s ease;
            --font-sans: 'Inter', system-ui, -apple-system, sans-serif;
            --font-mono: 'JetBrains Mono', 'Fira Code', 'Consolas', monospace;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: var(--font-sans);
            background: #f1f5f9;
            /* solid neutral gray */
            color: var(--gray-800);
            line-height: 1.5;
            min-height: 100vh;
            -webkit-font-smoothing: antialiased;
        }

        /* Remove decorative blobs – cleaner look */
        body::before,
        body::after {
            display: none;
        }

        .main-wrapper {
            max-width: 1000px;
            margin: 0 auto;
            padding: 24px 20px 50px;
        }

        /* ── Top bar ── */
        .top-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 14px;
            margin-bottom: 24px;
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 18px;
            font-weight: 600;
            font-size: 0.85rem;
            text-decoration: none;
            color: var(--gray-700);
            background: var(--white);
            border: 1px solid var(--gray-300);
            border-radius: 20px;
            transition: all var(--transition);
            box-shadow: var(--shadow-sm);
        }

        .btn-back:hover {
            background: var(--gray-100);
            border-color: var(--gray-400);
            box-shadow: var(--shadow);
            transform: translateX(-2px);
        }

        .btn-back .arrow {
            font-size: 1.1rem;
            transition: transform var(--transition);
        }

        .btn-back:hover .arrow {
            transform: translateX(-2px);
        }

        .print-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 18px;
            font-weight: 600;
            font-size: 0.85rem;
            color: var(--gray-700);
            background: var(--white);
            border: 1px solid var(--gray-300);
            border-radius: 20px;
            cursor: pointer;
            transition: all var(--transition);
            box-shadow: var(--shadow-sm);
            font-family: var(--font-sans);
        }

        .print-btn:hover {
            background: var(--gray-100);
            border-color: var(--gray-400);
            box-shadow: var(--shadow);
        }

        /* ── Profile header ── */
        .profile-header {
            background: var(--white);
            border-radius: var(--radius);
            padding: 24px 28px;
            box-shadow: var(--shadow);
            border: 1px solid var(--gray-200);
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 20px;
        }

        .profile-header .avatar-group {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .avatar {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: var(--primary);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            font-weight: 700;
            text-transform: uppercase;
            flex-shrink: 0;
            box-shadow: var(--shadow);
        }

        .profile-header .info h1 {
            font-size: 1.4rem;
            font-weight: 650;
            color: var(--gray-900);
            letter-spacing: -0.3px;
            line-height: 1.2;
        }

        .profile-header .info .role-tag {
            display: inline-block;
            margin-top: 4px;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--primary);
            background: var(--primary-light);
            padding: 3px 10px;
            border-radius: 16px;
        }

        /* Status badge – muted colors */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 16px;
            border-radius: 20px;
            font-weight: 700;
            font-size: 0.8rem;
            letter-spacing: 0.03em;
            text-transform: uppercase;
            white-space: nowrap;
            box-shadow: var(--shadow-sm);
            border: 1px solid transparent;
        }

        .status-badge.pending {
            background: #fff7ed;
            color: #c2410c;
            border-color: #fed7aa;
        }

        .status-badge.shortlisted {
            background: #eff6ff;
            color: #1e40af;
            border-color: #bfdbfe;
        }

        .status-badge.rejected {
            background: #fef2f2;
            color: #b91c1c;
            border-color: #fecaca;
        }

        .status-badge.accepted,
        .status-badge.approved,
        .status-badge.selected {
            background: #f0fdfa;
            color: #0f766e;
            border-color: #99f6e4;
        }

        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .status-dot.pending {
            background: #c2410c;
            animation: pulse-dot 1.5s infinite;
        }

        .status-dot.shortlisted {
            background: #1e40af;
        }

        .status-dot.rejected {
            background: #b91c1c;
        }

        .status-dot.accepted,
        .status-dot.approved,
        .status-dot.selected {
            background: #0f766e;
        }

        @keyframes pulse-dot {

            0%,
            100% {
                box-shadow: 0 0 0 0 rgba(194, 65, 12, 0.4);
            }

            50% {
                box-shadow: 0 0 0 8px rgba(194, 65, 12, 0);
            }
        }

        /* ── Cards grid ── */
        .cards-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .cards-grid .card-full {
            grid-column: 1 / -1;
        }

        @media (max-width: 720px) {
            .cards-grid {
                grid-template-columns: 1fr;
            }

            .cards-grid .card-full {
                grid-column: 1;
            }
        }

        /* ── Card ── */
        .card {
            background: var(--white);
            border-radius: var(--radius);
            padding: 20px 24px;
            box-shadow: var(--shadow);
            border: 1px solid var(--gray-200);
        }

        .card h2 {
            font-size: 0.95rem;
            font-weight: 650;
            color: var(--gray-800);
            margin-bottom: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
            border-bottom: 1px solid var(--gray-200);
            padding-bottom: 8px;
        }

        .card h2 .section-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 28px;
            height: 28px;
            border-radius: 6px;
            font-size: 14px;
            flex-shrink: 0;
            background: var(--gray-100);
            color: var(--gray-600);
        }

        .icon-personal {
            background: #f1f5f9;
            color: #475569;
        }

        .icon-academic {
            background: #f1f5f9;
            color: #475569;
        }

        .icon-experience {
            background: #f1f5f9;
            color: #475569;
        }

        .icon-status {
            background: #f1f5f9;
            color: #475569;
        }

        .icon-resume {
            background: #f1f5f9;
            color: #475569;
        }

        /* ── Info rows ── */
        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 8px 0;
            border-bottom: 1px solid var(--gray-100);
            gap: 12px;
            flex-wrap: wrap;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-row .label {
            font-weight: 600;
            font-size: 0.8rem;
            color: var(--gray-500);
            text-transform: uppercase;
            letter-spacing: 0.03em;
            flex-shrink: 0;
            min-width: 80px;
        }

        .info-row .value {
            font-weight: 500;
            font-size: 0.875rem;
            color: var(--gray-800);
            text-align: right;
            word-break: break-word;
        }

        .info-row .value.highlight {
            font-weight: 700;
            color: var(--primary);
            background: var(--primary-light);
            padding: 2px 10px;
            border-radius: 12px;
            display: inline-block;
        }

        .info-row .value.skills-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
            justify-content: flex-end;
        }

        .skill-tag {
            display: inline-block;
            background: var(--gray-100);
            color: var(--gray-700);
            padding: 3px 10px;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
            border: 1px solid var(--gray-200);
        }

        .skill-tag.primary-skill {
            background: var(--primary-light);
            color: var(--primary);
            border-color: #bfdbfe;
        }

        .empty-value {
            color: var(--gray-400);
            font-style: italic;
            font-weight: 400;
        }

        /* ── Resume section ── */
        .resume-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            align-items: center;
        }

        .btn-resume {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 9px 18px;
            font-weight: 600;
            font-size: 0.85rem;
            text-decoration: none;
            border-radius: 20px;
            transition: all var(--transition);
            cursor: pointer;
            font-family: var(--font-sans);
            border: none;
        }

        .btn-view {
            background: var(--primary);
            color: #fff;
            box-shadow: var(--shadow-sm);
        }

        .btn-view:hover {
            background: var(--primary-hover);
            box-shadow: var(--shadow);
        }

        .btn-download {
            background: var(--white);
            color: var(--primary);
            border: 1.5px solid var(--primary);
        }

        .btn-download:hover {
            background: var(--primary-light);
        }

        .resume-filename {
            font-family: var(--font-mono);
            font-size: 0.8rem;
            color: var(--gray-500);
            background: var(--gray-100);
            padding: 5px 10px;
            border-radius: 6px;
            border: 1px solid var(--gray-200);
        }

        /* ── Footer meta ── */
        .meta-footer {
            text-align: center;
            margin-top: 28px;
            font-size: 0.8rem;
            color: var(--gray-400);
        }

        .meta-footer span {
            font-weight: 600;
            color: var(--gray-500);
        }

        /* ── Print ── */
        @media print {
            body {
                background: #fff;
                color: #000;
            }

            .btn-back,
            .print-btn,
            .btn-resume,
            .resume-actions {
                display: none;
            }

            .card {
                box-shadow: none;
                border: 1px solid #ccc;
                break-inside: avoid;
            }

            .profile-header {
                box-shadow: none;
                border: 1px solid #ccc;
            }

            .status-badge {
                box-shadow: none;
                border: 1px solid #000;
            }

            .main-wrapper {
                max-width: 100%;
                padding: 0;
            }

            .cards-grid {
                grid-template-columns: 1fr 1fr;
                gap: 10px;
            }
        }

        /* ── Responsive ── */
        @media (max-width: 640px) {
            .profile-header {
                flex-direction: column;
                align-items: flex-start;
                padding: 18px 16px;
            }

            .profile-header .info h1 {
                font-size: 1.2rem;
            }

            .avatar {
                width: 44px;
                height: 44px;
                font-size: 1.1rem;
            }

            .card {
                padding: 16px 14px;
            }

            .info-row .label {
                min-width: 65px;
                font-size: 0.7rem;
            }

            .info-row .value {
                font-size: 0.8rem;
                text-align: left;
            }

            .info-row {
                flex-direction: column;
                gap: 2px;
            }

            .info-row .value.skills-tags {
                justify-content: flex-start;
            }

            .top-bar {
                flex-direction: column;
                align-items: flex-start;
            }

            .status-badge {
                font-size: 0.7rem;
                padding: 5px 12px;
            }
        }
    </style>
</head>

<body>

    <?php include 'navbar.php'; ?>

    <div class="main-wrapper">

        <!-- ── TOP NAVIGATION ── -->
        <div class="top-bar">
            <a href="<?= base_url('admin/dashboard') ?>" class="btn-back">
                <span class="arrow">&#8592;</span> Back to Dashboard
            </a>
            <button class="print-btn" onclick="window.print()" title="Print this profile">
                &#128424; Print Profile
            </button>
        </div>

        <!-- ── PROFILE HEADER ── -->
        <div class="profile-header">
            <div class="avatar-group">
                <div class="avatar">
                    <?= strtoupper(substr($application['full_name'], 0, 2)) ?>
                </div>
                <div class="info">
                    <h1><?= esc($application['full_name']) ?></h1>
                    <span class="role-tag">
                        &#128188; <?= esc($application['role_name'] ?? 'Applicant') ?>
                    </span>
                </div>
            </div>
            <?php
            $status = strtolower($application['status'] ?? 'pending');
            $statusClass = 'pending';
            if (in_array($status, ['shortlisted', 'interviewed', 'reviewed'])) {
                $statusClass = 'shortlisted';
            } elseif (in_array($status, ['rejected', 'declined', 'withdrawn'])) {
                $statusClass = 'rejected';
            } elseif (in_array($status, ['accepted', 'approved', 'selected', 'hired', 'offered'])) {
                $statusClass = 'accepted';
            }
            ?>
            <span class="status-badge <?= $statusClass ?>">
                <span class="status-dot <?= $statusClass ?>"></span>
                <?= esc(ucfirst($application['status'] ?? 'Pending')) ?>
            </span>
        </div>

        <!-- ── DETAIL CARDS ── -->
        <div class="cards-grid">

            <!-- PERSONAL INFO -->
            <div class="card">
                <h2>
                    <span class="section-icon icon-personal">&#128100;</span>
                    Personal Information
                </h2>
                <div class="info-row">
                    <span class="label">Full Name</span>
                    <span class="value highlight"><?= esc($application['full_name']) ?></span>
                </div>
                <div class="info-row">
                    <span class="label">Email</span>
                    <span class="value">
                        <?php if (!empty($application['email'])): ?>
                            <a href="mailto:<?= esc($application['email']) ?>" style="color:var(--primary);text-decoration:none;font-weight:600;">
                                <?= esc($application['email']) ?>
                            </a>
                        <?php else: ?>
                            <span class="text-muted">Hidden</span>
                        <?php endif; ?>
                    </span>
                </div>
                <div class="info-row">
                    <span class="label">Mobile</span>
                    <span class="value">
                        <?php if (!empty($application['mobile'])): ?>
                            <a href="tel:<?= esc($application['mobile']) ?>" style="color:var(--gray-800);text-decoration:none;">
                                <?= esc($application['mobile']) ?>
                            </a>
                        <?php else: ?>
                            <span class="text-muted">-</span>
                        <?php endif; ?>
                    </span>
                </div>
                <div class="info-row">
                    <span class="label">Date of Birth</span>
                    <span class="value"><?= esc($application['dob'] ?? 'Hidden') ?></span>
                </div>
                <div class="info-row">
                    <span class="label">Gender</span>
                    <span class="value"><?= esc($application['gender'] ?? 'Unknown') ?></span>
                </div>
                <div class="info-row">
                    <span class="label">Nationality</span>
                    <span class="value"><?= esc($application['nationality'] ?? 'Hidden') ?></span>
                </div>
                <div class="info-row">
                    <span class="label">Relocate</span>
                    <span class="value">
                        <?php if (strtolower($application['relocate'] ?? '') === 'yes'): ?>
                            <span style="color:var(--success);font-weight:700;">&#10003; Yes</span>
                        <?php elseif (strtolower($application['relocate'] ?? '') === 'no'): ?>
                            <span style="color:var(--error);font-weight:700;">&#10007; No</span>
                        <?php else: ?>
                            <?= esc($application['relocate'] ?? '-') ?>
                        <?php endif; ?>
                    </span>
                </div>
                <div class="info-row">
                    <span class="label">Address</span>
                    <span class="value"><?= !empty($application['address']) ? nl2br(esc($application['address'])) : 'Hidden' ?></span>
                </div>
            </div>

            <!-- ACADEMIC INFO -->
            <div class="card">
                <h2>
                    <span class="section-icon icon-academic">&#127891;</span>
                    Academic Information
                </h2>
                <div class="info-row">
                    <span class="label">Qualification</span>
                    <span class="value highlight"><?= esc($application['qualification']) ?></span>
                </div>
                <div class="info-row">
                    <span class="label">Institution</span>
                    <span class="value"><?= esc($application['institution']) ?></span>
                </div>
                <div class="info-row">
                    <span class="label">Grad. Year</span>
                    <span class="value"><?= esc($application['graduation_year']) ?></span>
                </div>
                <div class="info-row">
                    <span class="label">CGPA / %</span>
                    <span class="value" style="font-weight:700;color:var(--primary);">
                        <?= esc($application['cgpa']) ?>
                    </span>
                </div>
                <div class="info-row">
                    <span class="label">Skills</span>
                    <span class="value skills-tags">
                        <?php
                        $skills = $application['technical_skills'] ?? '';
                        if (!empty($skills)):
                            $skillsArray = is_array($skills) ? $skills : explode(',', $skills);
                            foreach ($skillsArray as $skill):
                                $skill = trim($skill);
                                if (!empty($skill)):
                        ?>
                                    <span class="skill-tag primary-skill"><?= esc($skill) ?></span>
                            <?php
                                endif;
                            endforeach;
                        else:
                            ?>
                            <span class="empty-value">Not specified</span>
                        <?php endif; ?>
                    </span>
                </div>
                <div class="info-row">
                    <span class="label">Certifications</span>
                    <span class="value">
                        <?= !empty($application['certifications']) ? nl2br(esc($application['certifications'])) : '<span class="empty-value">None listed</span>' ?>
                    </span>
                </div>
            </div>

            <!-- EXPERIENCE INFO -->
            <div class="card">
                <h2>
                    <span class="section-icon icon-experience">&#128188;</span>
                    Experience &amp; Role
                </h2>
                <div class="info-row">
                    <span class="label">Applied Role</span>
                    <span class="value highlight"><?= esc($application['role_name'] ?? '—') ?></span>
                </div>
                <div class="info-row">
                    <span class="label">Experience</span>
                    <span class="value">
                        <?php if (strtolower($application['work_experience'] ?? '') === 'fresher'): ?>
                            <span style="background:#e0f2fe;color:#0c4a6e;padding:3px 12px;border-radius:15px;font-weight:700;font-size:0.8rem;">🌱 Fresher</span>
                        <?php else: ?>
                            <?= esc($application['work_experience']) ?>
                        <?php endif; ?>
                    </span>
                </div>
                <div class="info-row">
                    <span class="label">Emp. Status</span>
                    <span class="value"><?= esc($application['employment_status']) ?></span>
                </div>
                <div class="info-row">
                    <span class="label">Prev. Org</span>
                    <span class="value">
                        <?= !empty($application['previous_organization']) ? esc($application['previous_organization']) : '<span class="empty-value">—</span>' ?>
                    </span>
                </div>
                <div class="info-row">
                    <span class="label">Job Title</span>
                    <span class="value">
                        <?= !empty($application['job_title']) ? esc($application['job_title']) : '<span class="empty-value">—</span>' ?>
                    </span>
                </div>
                <div class="info-row">
                    <span class="label">Skills Summary</span>
                    <span class="value">
                        <?= !empty($application['skills_summary']) ? esc($application['skills_summary']) : '<span class="empty-value">Not provided</span>' ?>
                    </span>
                </div>
            </div>

            <!-- APPLICATION STATUS -->
            <div class="card">
                <h2>
                    <span class="section-icon icon-status">&#128203;</span>
                    Application Status
                </h2>
                <div class="info-row">
                    <span class="label">Current Status</span>
                    <span class="value">
                        <span class="status-badge <?= $statusClass ?>" style="font-size:0.75rem;padding:5px 14px;">
                            <span class="status-dot <?= $statusClass ?>"></span>
                            <?= esc(ucfirst($application['status'] ?? 'Pending')) ?>
                        </span>
                    </span>
                </div>
                <div class="info-row">
                    <span class="label">Application ID</span>
                    <span class="value" style="font-family:var(--font-mono);font-size:0.8rem;color:var(--gray-500);">
                        #<?= esc($application['id'] ?? '—') ?>
                    </span>
                </div>
                <?php if (!empty($application['created_at'] ?? '')): ?>
                    <div class="info-row">
                        <span class="label">Submitted On</span>
                        <span class="value"><?= esc($application['created_at']) ?></span>
                    </div>
                <?php endif; ?>
                <?php if (!empty($application['updated_at'] ?? '')): ?>
                    <div class="info-row">
                        <span class="label">Last Updated</span>
                        <span class="value"><?= esc($application['updated_at']) ?></span>
                    </div>
                <?php endif; ?>
            </div>

            <!-- RESUME CARD (full width) -->
            <div class="card card-full">
                <h2>
                    <span class="section-icon icon-resume">&#128196;</span>
                    Resume Document
                </h2>
                <div class="resume-actions">
                    <?php if (!empty($application['resume'])): ?>
                        <span class="resume-filename">
                            &#128206; <?= esc($application['resume']) ?>
                        </span>
                        <a
                            class="btn-resume btn-view"
                            target="_blank"
                            href="<?= base_url('uploads/resumes/' . $application['resume']) ?>">
                            &#128065; View Resume
                        </a>
                        <a
                            class="btn-resume btn-download"
                            download
                            href="<?= base_url('uploads/resumes/' . $application['resume']) ?>">
                            &#128229; Download
                        </a>
                    <?php else: ?>
                        <span class="empty-value" style="font-size:0.85rem;">No resume uploaded</span>
                    <?php endif; ?>
                </div>
            </div>

        </div>

        <!-- ── FOOTER ── -->
        <div class="meta-footer">
            <p>Applicant profile &bull; <span>ID: #<?= esc($application['id'] ?? '—') ?></span> &bull; Generated on <?= date('M d, Y') ?></p>
        </div>

    </div>

</body>

</html>
