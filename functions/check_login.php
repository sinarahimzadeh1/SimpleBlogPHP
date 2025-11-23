<?php
require_once 'helpers.php';

session_start();

if (!isset($_SESSION['user'])) {
	redirect('auth/login.php');
}

?>