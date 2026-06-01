<?php $pageTitle = 'Applications';
include 'header.php'; ?>

<!-- Analytics cards (show on applications page as requested) -->
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

<?php
$role = $userRole ?? session()->get('user_role');
$isAdmin = ($role === 'admin');
$hasAccess = $isAdmin || ($canViewGlobal == 't') || ($canViewOwn == 't');
?>

<?php if ($hasAccess): ?>

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

    <!-- Applications table -->
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
                                <?php if ($canUpdateStatus == 't'): ?>
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
                                <?php else: ?>
                                    <span class="status-badge <?= strtolower($application['status']) ?>"><?= $application['status'] ?></span>
                                <?php endif; ?>
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

<?php else: ?>
    <div class="dashboard-wrapper" style="text-align: center; padding: 50px;">
        <h2>Access Denied</h2>
        <p>You do not have permission to view applications.</p>
    </div>
<?php endif; ?>

<?php include 'footer.php'; ?>