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

    $baseURL = dirname(dirname(__DIR__));

    if ($posts !== false) {
        
        if (file_exists($baseURL . $posts->image)) {
            unlink ($baseURL . $posts->image);
        }

        $query = "DELETE FROM `posts` WHERE `id` = ?;";
        $statement = $connection->prepare($query);
        $statement->execute([$_GET['id']]);
    
    } else {
        redirect('panel/post');
    }
}

redirect('panel/post');