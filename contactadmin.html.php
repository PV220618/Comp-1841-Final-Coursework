<h2>Contact to Admin</h2>
<?php if (!empty($statusMessage)): ?>
    <div class="alert"><?= htmlspecialchars($statusMessage) ?></div>
<?php endif; ?>

<form method="post" class="mb-4">
        <div class="mb-3">
            <label for="message" class="form-label">Content:</label>
            <textarea name="message" id="message" rows="4" class="form-control" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Send</button>
    </form>


    <h4>Your Messages</h4>
    <ul class="list-group">
        <?php foreach ($allMessages as $msg): ?>
            <?php if ($msg['username'] === $_SESSION['username']): ?>
                <li class="list-group-item">
                    <strong>Message:</strong> <?= htmlspecialchars($msg['message']) ?><br>
                    <?php if (!empty($msg['reply'])): ?>
                        <strong>Admin Reply:</strong> <?= htmlspecialchars($msg['reply']) ?><br>
                    <?php endif; ?>
                    <small class="text-muted"><?= $msg['created_at'] ?></small>
                </li>
            <?php endif; ?>
        <?php endforeach; ?>
    </ul>

</body>
</html>