<h2>👥 Manage Users</h2>

<?php if (!empty($statusMessage)): ?>
    <p style="color: green;"><?= htmlspecialchars($statusMessage) ?></p>
<?php endif; ?>

<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>Id</th>
            <th>Username</th>
            <th>Email</th>
            <th>Role</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 1; ?>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= $i++ ?></td>
                <td><?= htmlspecialchars($user['username']) ?></td>
                <td><?= htmlspecialchars($user['email'] ?? '') ?></td>
                <td><?= htmlspecialchars($user['role']) ?></td>
                <td>
                    <?php if ($user['id'] !== $_SESSION['user_id']): ?>
                        <a href="user.php?delete=<?= $user['id'] ?>" onclick="return confirm('Are you sure you want to delete this user?');"> Delete</a>
                    <?php else: ?>
                         (you)
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
