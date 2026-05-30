<?php $pageTitle = 'Analytics'; include 'header.php'; ?>

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

<div class="two-column-layout">
    <div class="column-left">
        <div class="chart-card">
            <h2>Status Distribution</h2>
            <canvas id="statusChart"></canvas>
        </div>
    </div>
    <div class="column-right">
        <div class="chart-card">
            <h2>Applications Per Role</h2>
            <canvas id="roleChart"></canvas>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
