<?php
$pageTitle = 'Users';
include 'header.php';
?>

<style>
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.6);
        backdrop-filter: blur(4px);
    }

    .modal-content {
        background-color: #fff;
        margin: 10% auto;
        padding: 25px 30px;
        border-radius: 12px;
        width: 500px;
        max-width: 90%;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        position: relative;
        text-align: left;
        overflow-wrap: break-word;
        word-wrap: break-word;
        word-break: break-word;
    }

    .close {
        color: #888;
        position: absolute;
        right: 15px;
        top: 10px;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
        line-height: 1;
    }

    .close:hover,
    .close:focus {
        color: #000;
    }

    .modal-content h2 {
        margin-top: 0;
        margin-bottom: 20px;
        font-size: 1.4em;
    }

    /* Fixed label & checkbox styles */
    .modal-content label {
        display: flex;
        align-items: center;
        gap: 12px;
        margin: 0 0 12px 0;
        padding: 0;
        font-size: 1rem;
        cursor: pointer;
        white-space: normal;
        overflow-wrap: break-word;
        word-break: break-word;
        width: 100%;
    }

    .modal-content input[type="checkbox"] {
        flex-shrink: 0;
        margin: 0;
        padding: 0;
        width: 18px;
        height: 18px;
        cursor: pointer;
    }

    .modal-content button[type="submit"] {
        margin-top: 15px;
        width: 100%;
        padding: 10px;
        background-color: #4f46e5;
        color: white;
        border: none;
        border-radius: 6px;
        font-size: 1rem;
        cursor: pointer;
    }

    .modal-content button[type="submit"]:hover {
        background-color: #4338ca;
    }

    .settings-btn {
        background: none;
        border: none;
        padding: 0;
        font-size: 1.5rem;
        color: #4b5563;
        cursor: pointer;
        line-height: 1;
        vertical-align: middle;
    }

    .settings-btn:hover {
        color: #1f2937;
        transform: scale(1.1);
        transition: all 0.2s;
    }
</style>

<!-- Settings Modal -->
<div id="settingsModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Update User Settings</h2>
        <form action="<?= base_url('admin/update-settings') ?>" method="post">
            <input type="hidden" name="user_id" id="settingsUserId">

            <label>
                <input type="checkbox" name="view_own" id="viewOwn">
                View Own
            </label>

            <label>
                <input type="checkbox" name="view_global" id="viewGlobal">
                View Global
            </label>

            <label>
                <input type="checkbox" name="update_status" id="updateStatus">
                Update Status
            </label>

            <button type="submit">Save</button>
        </form>
    </div>
</div>

<!-- Main content -->
<div class="two-column-layout">
    <div class="column-left">
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

    <div class="column-right">
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
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($users)): ?>
                            <?php foreach ($users as $user): ?>
                                <?php if ($user['role'] != 'admin'): ?>
                                    <tr>
                                        <td><?= esc($user['id']) ?></td>
                                        <td><strong><?= esc($user['name']) ?></strong></td>
                                        <td><?= esc(strtoupper($user['role'])) ?></td>
                                        <td><?= esc($user['email']) ?></td>
                                        <td>
                                            <form action="<?= base_url('admin/update-access/' . $user['id']) ?>" method="post">
                                                <button class="btn" type="submit">
                                                    <?= $user['access'] ? 'Revoke Access' : 'Grant Access' ?>
                                                </button>
                                            </form>
                                        </td>
                                        <td>
                                            <button
                                                class="settings-btn"
                                                data-id="<?= $user['id'] ?>"
                                                data-view-own="<?= $user['view_own'] ?>"
                                                data-view-global="<?= $user['view_global'] ?>"
                                                data-update-status="<?= $user['update_status'] ?>">
                                                ⚙️
                                            </button>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6">No Users found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var modal = document.getElementById('settingsModal');
        var closeBtn = document.querySelector('.modal .close');

        function openSettings(button) {
            var userId = button.getAttribute('data-id');
            var viewOwn = button.getAttribute('data-view-own') === '1';
            var viewGlobal = button.getAttribute('data-view-global') === '1';
            var updateStatus = button.getAttribute('data-update-status') === '1';

            document.getElementById('settingsUserId').value = userId;
            document.getElementById('viewOwn').checked = viewOwn;
            document.getElementById('viewGlobal').checked = viewGlobal;
            document.getElementById('updateStatus').checked = updateStatus;

            modal.style.display = 'block';
        }

        closeBtn.addEventListener('click', function() {
            modal.style.display = 'none';
        });

        window.addEventListener('click', function(event) {
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        });

        document.querySelectorAll('.settings-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                openSettings(this);
            });
        });
    });
</script>

<?php include 'footer.php'; ?>