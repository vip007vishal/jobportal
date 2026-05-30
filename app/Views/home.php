<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Portal — Apply & Admin</title>
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
            --shadow-lg: 0 10px 15px rgba(0, 0, 0, 0.06), 0 4px 6px rgba(0, 0, 0, 0.04);
            --radius-sm: 6px;
            --radius: 8px;
            --radius-lg: 12px;
            --radius-xl: 16px;
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
            -webkit-font-smoothing: antialiased;
        }

        .main-wrapper {
            max-width: 900px;
            margin: 0 auto;
            padding: 30px 20px 60px;
        }

        /* Hero */
        .hero {
            text-align: center;
            padding: 60px 20px 40px;
            background: #030d21;
            border-bottom: 1px solid var(--gray-200);
            margin-bottom: 30px;
        }

        .hero h1 {
            font-size: 2.5rem;
            font-weight: 650;
            color: #aebde2;
            letter-spacing: -0.5px;
        }

        .hero h1 span {
            color: var(--primary);
        }

        .hero p {
            font-size: 1.1rem;
            color: var(--gray-500);
            max-width: 600px;
            margin: 20px auto 30px;
        }

        .hero .btn-group {
            display: flex;
            justify-content: center;
            gap: 15px;
            flex-wrap: wrap;
        }

        /* Features */
        .features-row {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            max-width: 900px;
            margin: 0 auto 40px;
            padding: 0 20px;
        }

        .feature-card {
            background: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: var(--radius);
            padding: 24px 20px;
            flex: 1 1 200px;
            text-align: center;
            box-shadow: var(--shadow-sm);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .feature-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow);
        }

        .feature-card h3 {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--gray-800);
            margin-bottom: 8px;
        }

        .feature-card p {
            font-size: 0.9rem;
            color: var(--gray-500);
            line-height: 1.5;
        }

        /* Flash messages */
        .flash-msg {
            padding: 12px 18px;
            border-radius: var(--radius);
            margin-bottom: 20px;
            font-weight: 500;
            font-size: 0.9rem;
        }

        .flash-msg.success {
            background: var(--success-bg);
            color: #115e59;
            border: 1px solid #a7f3d0;
        }

        .flash-msg.error {
            background: var(--error-bg);
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        /* Cards */
        .card {
            background: var(--white);
            border-radius: var(--radius);
            padding: 24px;
            box-shadow: var(--shadow);
            border: 1px solid var(--gray-200);
            margin-bottom: 24px;
        }

        .card h2 {
            font-size: 1.15rem;
            font-weight: 650;
            color: var(--gray-800);
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Form elements */
        .form-row {
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
            margin-bottom: 6px;
        }

        .form-group {
            flex: 1;
            min-width: 200px;
            margin-bottom: 14px;
        }

        .form-group.full-width {
            flex: 1 1 100%;
        }

        .form-group label {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--gray-600);
            margin-bottom: 4px;
            display: block;
        }

        .form-group label .required-star {
            color: var(--error);
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid var(--gray-300);
            border-radius: var(--radius-sm);
            font-family: var(--font-sans);
            font-size: 0.9rem;
            color: var(--gray-800);
            background: #fff;
            outline: none;
            transition: border-color var(--transition);
        }

        input:focus,
        select:focus,
        textarea:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 2px rgba(30, 58, 138, 0.1);
        }

        textarea {
            min-height: 80px;
            resize: vertical;
        }

        select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            padding-right: 32px;
        }

        input[type="file"] {
            padding: 6px 6px;
        }

        input[type="file"]::file-selector-button {
            background: var(--primary-light);
            color: var(--primary);
            border: 1px solid var(--primary);
            border-radius: 4px;
            padding: 6px 14px;
            margin-right: 10px;
            cursor: pointer;
            font-weight: 600;
            font-size: 0.85rem;
        }

        /* Radio & checkbox */
        .radio-group,
        .checkbox-group,
        .skills-checkbox-group {
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
            padding-top: 6px;
        }

        .radio-group label,
        .checkbox-group label,
        .skills-checkbox-group label {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 0.9rem;
            color: var(--gray-700);
            cursor: pointer;
        }

        input[type="radio"],
        input[type="checkbox"] {
            accent-color: var(--primary);
            width: 16px;
            height: 16px;
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 10px 20px;
            font-weight: 600;
            font-size: 0.9rem;
            border-radius: 20px;
            cursor: pointer;
            border: none;
            transition: all var(--transition);
            background: var(--primary);
            color: #fff;
            box-shadow: var(--shadow-sm);
        }

        .btn:hover {
            background: var(--primary-hover);
            box-shadow: var(--shadow);
        }

        .btn-outline {
            background: transparent;
            color: var(--primary);
            border: 1.5px solid var(--primary);
            box-shadow: none;
        }

        .btn-outline:hover {
            background: var(--primary-light);
        }

        .btn-ghost {
            background: var(--gray-100);
            color: var(--gray-700);
            box-shadow: none;
        }

        .btn-ghost:hover {
            background: var(--gray-200);
            color: var(--gray-900);
        }

        .btn-success {
            background: var(--success);
        }

        .btn-success:hover {
            background: #0d9488;
        }

        .btn-lg {
            padding: 12px 26px;
            font-size: 1rem;
            border-radius: 24px;
        }

        .buttons-row {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            margin-top: 18px;
            justify-content: flex-end;
        }

        .buttons-row.start {
            justify-content: flex-start;
        }

        .buttons-row.between {
            justify-content: space-between;
        }

        /* Step indicator */
        .step-indicator {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 24px;
        }

        .step-dot .circle {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.9rem;
            background: var(--gray-200);
            color: var(--gray-600);
            transition: all 0.3s;
        }

        .step-dot .circle.active {
            background: var(--primary);
            color: #fff;
            box-shadow: 0 0 0 6px rgba(30, 58, 138, 0.1);
        }

        .step-dot .circle.completed {
            background: var(--success);
            color: #fff;
        }

        .step-line {
            width: 50px;
            height: 2px;
            background: var(--gray-200);
            margin: 0 8px;
            border-radius: 2px;
        }

        .step-line.done {
            background: var(--success);
        }

        .step-label-row {
            display: flex;
            justify-content: center;
            gap: 0;
            margin-top: 6px;
            font-size: 0.75rem;
            color: var(--gray-500);
        }

        .step-label-row span {
            width: 36px;
            text-align: center;
            margin: 0 42px;
        }

        /* Steps */
        .step {
            display: none;
            animation: fadeIn 0.3s ease;
        }

        .step.active {
            display: block;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateX(20px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .step h3 {
            font-size: 1rem;
            font-weight: 650;
            color: var(--gray-800);
            margin-bottom: 16px;
            padding-bottom: 10px;
            border-bottom: 1px solid var(--gray-200);
        }

        .declaration-box {
            display: flex;
            align-items: center;
            gap: 8px;
            background: var(--gray-50);
            border: 1px solid var(--gray-200);
            border-radius: var(--radius-sm);
            padding: 10px 14px;
            cursor: pointer;
            font-size: 0.9rem;
            color: var(--gray-700);
        }

        .divider-text {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 24px 0;
            color: var(--gray-400);
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .divider-text::before,
        .divider-text::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--gray-200);
        }

        .cta-banner {
            text-align: center;
            padding: 20px;
            background: var(--white);
            border-radius: var(--radius);
            border: 1px solid var(--gray-200);
        }

        /* Modal styles */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            backdrop-filter: blur(4px);
            padding: 20px;
            overflow-y: auto;
        }

        .modal-overlay.active {
            display: flex;
        }

        .modal-content {
            background: var(--white);
            border-radius: var(--radius-lg);
            width: 100%;
            max-width: 750px;
            max-height: 90vh;
            overflow-y: auto;
            padding: 28px;
            box-shadow: var(--shadow-lg);
            position: relative;
            animation: modalFadeIn 0.2s ease;
        }

        /* Smaller admin modal */
        .modal-content.admin-modal {
            max-width: 400px;
        }

        @keyframes modalFadeIn {
            from {
                opacity: 0;
                transform: scale(0.95) translateY(-10px);
            }

            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        .modal-close {
            position: absolute;
            top: 12px;
            right: 16px;
            background: none;
            border: none;
            font-size: 1.6rem;
            cursor: pointer;
            color: var(--gray-500);
            line-height: 1;
            z-index: 2;
        }

        @media (max-width: 640px) {
            .hero h1 {
                font-size: 2rem;
            }

            .card {
                padding: 18px 14px;
            }

            .form-row {
                flex-direction: column;
                gap: 0;
            }

            .step-line {
                width: 30px;
            }

            .modal-content {
                max-width: 100%;
                max-height: 100vh;
                border-radius: 0;
                margin: 0;
                padding: 20px 15px;
            }
        }
    </style>
</head>

<body>

    <!-- Hero -->
    <div class="hero">
        <h1>Welcome to <span>V7 Lancers</span></h1>
        <p>Your trusted recruitment management portal. Apply to top openings, track your status, and let opportunities find you.</p>
        <div class="btn-group">
            <button class="btn btn-primary btn-lg" onclick="openApplicationModal()">Apply Now</button>
            <a href="<?= base_url('admin') ?>" class="btn btn-outline btn-lg">Employee Login</a>
        </div>
    </div>

    <!-- Features -->
    <div class="features-row">
        <div class="feature-card">
            <h3>Quick Apply</h3>
            <p>Fill a simple 3‑step form and submit your application in minutes.</p>
        </div>
        <div class="feature-card">
            <h3>Real‑time Tracking</h3>
            <p>Stay updated with your application status and admin feedback.</p>
        </div>
        <div class="feature-card">
            <h3>Data Security</h3>
            <p>Your personal information is encrypted and never shared without consent.</p>
        </div>
        <div class="feature-card">
            <h3>Multiple Roles</h3>
            <p>Browse a variety of open positions across different domains.</p>
        </div>
    </div>

    <div class="main-wrapper">

        <?php if (session()->getFlashdata('success')): ?>
            <div class="flash-msg success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="flash-msg error"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <!-- Application Form Modal -->
        <div class="modal-overlay" id="applicationModal">
            <div class="modal-content">
                <button class="modal-close" onclick="closeApplicationModal()">&times;</button>
                <h2 style="margin-bottom:20px;">Job Application Form</h2>

                <!-- Step indicator (1-2-3) -->
                <div class="step-indicator" id="stepIndicator">
                    <div class="step-dot"><span class="circle active" id="circ1">1</span></div>
                    <div class="step-line" id="line1"></div>
                    <div class="step-dot"><span class="circle" id="circ2">2</span></div>
                    <div class="step-line" id="line2"></div>
                    <div class="step-dot"><span class="circle" id="circ3">3</span></div>
                </div>
                <div class="step-label-row">
                    <span>Personal</span>
                    <span style="margin:0 30px;">Academic</span>
                    <span>Experience</span>
                </div>

                <form id="jobApplicationForm" method="post" action="<?= base_url('apply') ?>" enctype="multipart/form-data" novalidate>
                    <!-- Step 1 -->
                    <div class="step active" data-step="0">
                        <h3>Step 1 — Personal Information</h3>
                        <div class="form-row">
                            <div class="form-group">
                                <label>Full Name <span class="required-star">*</span></label>
                                <input type="text" name="full_name" placeholder="e.g. Vishal Krish">
                            </div>
                            <div class="form-group">
                                <label>Email <span class="required-star">*</span></label>
                                <input type="email" name="email" placeholder="e.g. vishal@example.com">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label>Mobile Number <span class="required-star">*</span></label>
                                <input type="text" name="mobile" placeholder="e.g. 9876543210">
                            </div>
                            <div class="form-group">
                                <label>Date of Birth <span class="required-star">*</span></label>
                                <input type="date" name="dob">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Gender <span class="required-star">*</span></label>
                            <div class="radio-group">
                                <label><input type="radio" name="gender" value="Male"> Male</label>
                                <label><input type="radio" name="gender" value="Female"> Female</label>
                                <label><input type="radio" name="gender" value="Other"> Other</label>
                            </div>
                        </div>
                        <div class="form-group full-width">
                            <label>Address <span class="required-star">*</span></label>
                            <textarea name="address" placeholder="Enter your full address"></textarea>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label>Nationality <span class="required-star">*</span></label>
                                <select name="nationality">
                                    <option value="">Select Nationality</option>
                                    <option value="Indian">Indian</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Willing To Relocate? <span class="required-star">*</span></label>
                                <div class="radio-group">
                                    <label><input type="radio" name="relocate" value="Yes"> Yes</label>
                                    <label><input type="radio" name="relocate" value="No"> No</label>
                                </div>
                            </div>
                        </div>
                        <div class="buttons-row">
                            <button type="button" class="btn" onclick="nextStep()">Next →</button>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div class="step" data-step="1">
                        <h3>Step 2 — Academic Information</h3>
                        <div class="form-row">
                            <div class="form-group">
                                <label>Qualification <span class="required-star">*</span></label>
                                <select name="qualification">
                                    <option value="">Select Qualification</option>
                                    <option value="BE">BE</option>
                                    <option value="ME">ME</option>
                                    <option value="BTech">BTech</option>
                                    <option value="MTech">MTech</option>
                                    <option value="BCA">BCA</option>
                                    <option value="BSc">BSc</option>
                                    <option value="MCA">MCA</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Institution Name <span class="required-star">*</span></label>
                                <input type="text" name="institution" placeholder="e.g. University of INDIA">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label>Graduation Year <span class="required-star">*</span></label>
                                <input type="number" name="graduation_year" placeholder="e.g. 2026" min="1950" max="2100">
                            </div>
                            <div class="form-group">
                                <label>CGPA / Percentage <span class="required-star">*</span></label>
                                <input type="text" name="cgpa" placeholder="e.g. 8.5 or 85%">
                            </div>
                        </div>
                        <label>Technical Skills</label>
                        <div class="skills-checkbox-group">
                            <?php foreach ($allSkills as $skill): ?>
                                <label>
                                    <input
                                        type="checkbox"
                                        name="technical_skills[]"
                                        value="<?= esc($skill['skill_name']) ?>">
                                    <?= esc($skill['skill_name']) ?>
                                </label>
                            <?php endforeach; ?>
                        </div>
                        <div class="form-group full-width">
                            <label>Certifications</label>
                            <textarea name="certifications" placeholder="List any relevant certifications..."></textarea>
                        </div>
                        <div class="buttons-row between">
                            <button type="button" class="btn btn-ghost" onclick="previousStep()">← Previous</button>
                            <button type="button" class="btn" onclick="nextStep()">Next →</button>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="step" data-step="2">
                        <h3>Step 3 — Experience & Resume</h3>
                        <div class="form-row">
                            <div class="form-group">
                                <label>Job Role <span class="required-star">*</span></label>
                                <select name="role_id">
                                    <option value="">Select Job Role</option>
                                    <?php foreach ($jobs as $job): ?>
                                        <option value="<?= $job['id'] ?>"><?= $job['role_name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Work Experience <span class="required-star">*</span></label>
                                <select name="work_experience">
                                    <option value="">Work Experience</option>
                                    <option value="Fresher">Fresher</option>
                                    <option value="1-2 Years">1-2 Years</option>
                                    <option value="3+ Years">3+ Years</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Employment Status <span class="required-star">*</span></label>
                            <div class="radio-group">
                                <label><input type="radio" name="employment_status" value="Employed"> Employed</label>
                                <label><input type="radio" name="employment_status" value="Unemployed"> Unemployed</label>
                                <label><input type="radio" name="employment_status" value="Student"> Student</label>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label>Previous Organization</label>
                                <input type="text" name="previous_organization" placeholder="e.g. ABC Corp">
                            </div>
                            <div class="form-group">
                                <label>Job Title</label>
                                <input type="text" name="job_title" placeholder="e.g. Software Engineer">
                            </div>
                        </div>
                        <div class="form-group full-width">
                            <label>Skills Summary</label>
                            <textarea name="skills_summary" placeholder="Briefly describe your key skills and strengths..."></textarea>
                        </div>
                        <div class="form-group full-width">
                            <label>Upload Resume <span class="required-star">*</span></label>
                            <input type="file" name="resume" accept=".pdf,.doc,.docx">
                            <small style="color:var(--gray-500);margin-top:3px;">Accepted formats: PDF, DOC, DOCX</small>
                        </div>
                        <label class="declaration-box" for="declarationCheck">
                            <input type="checkbox" name="declaration_accept" value="1" id="declarationCheck">
                            <span>I confirm that all the details provided above are accurate and complete.</span>
                        </label>
                        <div class="buttons-row between">
                            <button type="button" class="btn btn-ghost" onclick="previousStep()">← Previous</button>
                            <button type="submit" class="btn btn-success btn-lg">Submit Application</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- CTA Banner (stays inline) -->
        <div class="cta-banner" id="ctaBanner">
            <p style="font-weight:600;color:var(--gray-700);margin-bottom:12px;">Ready to take the next step in your career?</p>
            <button class="btn btn-success btn-lg" onclick="openApplicationModal()">Apply For a Job</button>
        </div>
    </div>

    <script>
        let currentStep = 0;
        const totalSteps = 3;
        const steps = document.querySelectorAll('#jobApplicationForm .step');
        const circles = ['circ1', 'circ2', 'circ3'].map(id => document.getElementById(id));
        const lines = ['line1', 'line2'].map(id => document.getElementById(id));

        function updateStepIndicator(step) {
            circles.forEach((circle, i) => {
                circle.classList.remove('active', 'completed');
                circle.textContent = i + 1;
                if (i < step) {
                    circle.classList.add('completed');
                    circle.textContent = '✓';
                } else if (i === step) {
                    circle.classList.add('active');
                }
            });
            lines.forEach((line, i) => {
                line.classList.toggle('done', i < step);
            });
        }

        function showStep(index) {
            steps.forEach(s => s.classList.remove('active'));
            steps[index].classList.add('active');
            currentStep = index;
            updateStepIndicator(index);
            // Scroll to top of modal content if needed
            const modalContent = document.querySelector('#applicationModal .modal-content');
            if (modalContent) {
                modalContent.scrollTop = 0;
            }
        }

        function nextStep() {
            if (currentStep < totalSteps - 1) showStep(currentStep + 1);
        }

        function previousStep() {
            if (currentStep > 0) showStep(currentStep - 1);
        }

        // Application Modal
        function openApplicationModal() {
            document.getElementById('applicationModal').classList.add('active');
            showStep(0); // reset to step 1 each time opened
            document.body.style.overflow = 'hidden'; // prevent background scroll
        }

        function closeApplicationModal() {
            document.getElementById('applicationModal').classList.remove('active');
            document.body.style.overflow = '';
        }

        // Close modals when clicking outside the content
        document.getElementById('applicationModal').addEventListener('click', function(e) {
            if (e.target === this) closeApplicationModal();
        });

        // Validation
        document.getElementById('jobApplicationForm').addEventListener('submit', function(e) {
            const required = ['full_name', 'email', 'mobile', 'dob', 'address', 'nationality',
                'qualification', 'institution', 'graduation_year', 'cgpa',
                'role_id', 'work_experience', 'resume'
            ];
            for (let name of required) {
                const field = document.getElementsByName(name)[0];
                if (!field || field.value.trim() === '') {
                    alert(name.replaceAll('_', ' ') + ' is required');
                    e.preventDefault();
                    if (['full_name', 'email', 'mobile', 'dob', 'address', 'nationality'].includes(name)) showStep(0);
                    else if (['qualification', 'institution', 'graduation_year', 'cgpa'].includes(name)) showStep(1);
                    else showStep(2);
                    return;
                }
            }
            if (!document.querySelector('input[name="gender"]:checked')) {
                alert('Please select gender');
                e.preventDefault();
                showStep(0);
                return;
            }
            if (!document.querySelector('input[name="relocate"]:checked')) {
                alert('Please select relocate option');
                e.preventDefault();
                showStep(0);
                return;
            }
            if (!document.querySelector('input[name="employment_status"]:checked')) {
                alert('Please select employment status');
                e.preventDefault();
                showStep(2);
                return;
            }
            if (!document.querySelector('input[name="declaration_accept"]:checked')) {
                alert('Please accept declaration');
                e.preventDefault();
                showStep(2);
                return;
            }
        });

        updateStepIndicator(0);
    </script>
</body>

</html>