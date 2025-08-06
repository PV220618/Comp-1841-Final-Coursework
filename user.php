<?php
session_start();
require '../include/DatabaseConnection.php';
require '../include/functions.php';

$title = "Manage Users";

if (isset($_GET['delete'])) {
    $_SESSION['status'] = deleteUser($pdo, (int)$_GET['delete']);
    header("Location: user.php");
    exit;
}

$users = getAllUsers($pdo);

$statusMessage = $_SESSION['status'] ?? '';
unset($_SESSION['status']);

ob_start();
include '../template/user.html.php';
$output = ob_get_clean();

include '../template/layout.html.php';
