<?php $pageTitle = 'Job Roles';
include 'header.php'; ?>


<?php if (($userRole ?? session()->get('user_role')) === 'admin'): ?>

    <div class="two-column-layout">
        <div class="column-left">
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

                <div style="padding:12px; color:#475569;">You do not have permission to add job roles.</div>

            </div>
        </div>

        <div class="column-right">





        </div>

    </div>

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


<?php else: ?>

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
                        <th>Status</th>
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

                                <td><span class="status-badge <?= ($job['status'] ?? '') == 'open' ? 'hired' : 'rejected' ?>"><?= ucfirst($job['status'] ?? '') ?></span></td>

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

<?php include 'footer.php'; ?>