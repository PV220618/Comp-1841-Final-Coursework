<?php
session_start();

if ($_SESSION['role'] !== 'admin') {
    header("Location: ../loginindex.php");
    exit;
}



include '../include/DatabaseConnection.php';
include '../include/functions.php';

if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    deleteMessage($pdo, $id);
    $_SESSION['status'] = "Message deleted.";
    header("Location: messages.php");
    exit;
}

$title = "List massages";

ob_start();
$messages = getMessages($pdo);
include '../template/reply-message.html.php';
$output = ob_get_clean();

include '../template/layout.html.php';
?>