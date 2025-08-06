<?php
session_start();
include 'include/DatabaseConnection.php';
include 'include/functions.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: loginindex.php");
    exit;
}

$title = "Contact to Admin";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['user_id'];
    $message = ($_POST['message']);

    if (!empty($message)) {
        sendMessage($pdo, $userId, $message);
        $_SESSION['status'] = " Message sent successfully!";
    } else {
        $_SESSION['status'] = " Please fill in the box.";
    }

    header("Location: contactadmin.php");
    exit;
}

$allMessages = getMessages($pdo);
$statusMessage = $_SESSION['status'] ?? '';
unset($_SESSION['status']);

ob_start();
include 'template/contactadmin.html.php';
$output = ob_get_clean();

include 'template/layout.html.php';

