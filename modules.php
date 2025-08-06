<?php
session_start();

require '../include/DatabaseConnection.php';
require '../include/functions.php';

$title = "Manage Modules";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['module_name'])) {
    $_SESSION['status'] = addModule($pdo, $_POST['module_name']);
    header("Location: modules.php");
    exit;
}

if (isset($_GET['delete'])) {
    $_SESSION['status'] = deleteModule($pdo, (int)$_GET['delete']);
    header("Location: modules.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_id'], $_POST['edit_name'])) {
    $editId = (int)$_POST['edit_id'];
    $editName = trim($_POST['edit_name']);
    if (!empty($editName)) {
        if (updateModule($pdo, $editId, $editName)) {
            $_SESSION['status'] = "✅ Module updated.";
        } else {
            $_SESSION['status'] = "❗ Failed to update module.";
        }
    } else {
        $_SESSION['status'] = "❗ Please enter a module name.";
    }
    header("Location: modules.php");
    exit;
}


$modules = $pdo->query("SELECT * FROM modules ORDER BY module_name ASC")->fetchAll();
$statusMessage = $_SESSION['status'] ?? '';
unset($_SESSION['status']);

ob_start();
include '../template/modules.html.php';
$output = ob_get_clean();

include '../template/layout.html.php';
