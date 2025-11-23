<?php
require_once '../../functions/helpers.php';
require_once '../../functions/PDO_Connection.php';
require_once '../../functions/check_login.php';

global $connection;
if (isset($_GET['id']) && $_GET['id'] !== '') {

    $query = "SELECT * FROM `posts` WHERE `id` = ?;";
    $statement = $connection->prepare($query);
    $statement->execute([$_GET['id']]);

    $posts = $statement->fetch();

    if ($posts !== false) {
        $status = ($posts->status == 10) ? 0 : 10;
        $query = "UPDATE `posts` SET `status` = ? WHERE `id` = ?";
        $statement = $connection->prepare($query);
        $statement->execute([$status, $_GET['id']]);
    }
}

redirect('panel/post');
