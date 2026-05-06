<?php
session_start();

// Proses logout dari controller
require_once 'koneksi.php';
require_once 'controllers/MemberController.php';
$controller = new MemberController($dbh);
$controller->logout();
?>
