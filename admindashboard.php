<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../loginindex.php");
    exit;
}

$title = "Admin Dashboard";

ob_start();
?>

<h2>Welcome to Admin Dashboard</h2>

<div>
    <a href="messages.php" >
        <h3> Messages</h3>
        <p>View and reply to student messages.</p>
    </a>

    <a href="modules.php" >
        <h3> Modules</h3>
        <p>Manage modules used in questions.</p>
    </a>

    <a href="user.php" >
        <h3> Users</h3>
        <p>View, add, or remove users.</p>
    </a>
</div>

<?php
$output = ob_get_clean();
include '../template/layout.html.php';