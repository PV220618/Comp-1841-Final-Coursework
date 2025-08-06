<h2>📚 Manage Modules</h2>

<?php if ($statusMessage): ?>
    <div>
        <?= htmlspecialchars($statusMessage) ?>
    </div>
<?php endif; ?>

<form method="post" class="mb-4">
    <label for="module_name">Add new module:</label><br>
    <input type="text" name="module_name" id="module_name" required>
    <button type="submit">Add</button>
</form>

<h3>Module List</h3>
<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>Id</th>
            <th>Module Name</th> 
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
         <?php $i = 1; ?>
        <?php foreach ($modules as $module): ?>
            <tr>
                <td><?= $i++ ?></td>
                <td>
                    <?php if (isset($_GET['edit']) && $_GET['edit'] == $module['id']): ?>
                        <form method="post" style="display: flex; gap: 5px;">
                            <input type="hidden" name="edit_id" value="<?= $module['id'] ?>">
                            <input type="text" name="edit_name" value="<?= htmlspecialchars($module['module_name']) ?>" required>
                            <button type="submit">Save</button>
                            <a href="modules.php">Cancel</a>
                        </form>
                    <?php else: ?>
                        <?= htmlspecialchars($module['module_name']) ?>
                    <?php endif; ?>
                </td>
                <td>
                    <a href="modules.php?edit=<?= $module['id'] ?>">✏️ Edit</a> |
                    <a href="modules.php?delete=<?= $module['id'] ?>" onclick="return confirm('Are you sure?')"> Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
