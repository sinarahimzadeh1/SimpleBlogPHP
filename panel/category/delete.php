<?php
require_once '../../functions/helpers.php';
require_once '../../functions/PDO_Connection.php';
require_once '../../functions/check_login.php';

if (isset($_GET['id']) && $_GET['id'] !== '') {
    global $connection;
    $query = "DELETE FROM `categories` WHERE `id` = ?";
    $statement = $connection->prepare($query);
    $statement->execute([$_GET['id']]);
}

redirect('panel/category');
