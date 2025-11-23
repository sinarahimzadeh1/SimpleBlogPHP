<?php
require_once 'functions/helpers.php';
require_once 'functions/PDO_Connection.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PHP tutorial</title>
    <link rel="stylesheet" href="<?= asset('assets/css/bootstrap.min.css') ?>" media="all" type="text/css">
    <link rel="stylesheet" href="<?= asset('assets/css/style.css') ?>" media="all" type="text/css">
</head>

<body>
    <section id="app">

        <?php require_once 'layouts/top-nav.php' ?>

        <section class="container my-5">
            <?php
            global $connection;
            $notFound = false;
            if (isset($_GET['id']) && $_GET['id'] !== '') {
                $query = "SELECT * FROM `categories` WHERE `id` = ?";
                $statement = $connection->prepare($query);
                $statement->execute([$_GET['id']]);
                $category = $statement->fetch();
    
                    if ($category !== false) {
                ?>
            <section class="row">
                <section class="col-12">
                    <h1><?= $category->name ?></h1>
                    <hr>
                </section>
            </section>
            <section class="row">
                <?php
                    $query = "SELECT `id`, `title`, `body`, `image` FROM `posts` WHERE `status` = 10 AND `cat_id` = ?";
                    $statement = $connection->prepare($query);
                    $statement->execute([$_GET['id']]);
                    $posts = $statement->fetchAll();
                    foreach ($posts as $post) {
                    ?>
                <section class="col-md-4">
                    <section class="mb-2 overflow-hidden" style="max-height: 15rem;"><img class="img-fluid" src=""
                            alt=""></section>
                    <h2 class="h5 text-truncate"><?= $post->title ?></h2>
                    <img src="<?= asset($post->image) ?>" width="250px" style="border-radius: 30px;">
                    <p><?= substr($post->body, 0, 35) . '...' ?></p>
                    <p><a class="btn btn-primary" href="<?= URL('detail.php?id=') . $post->id ?>" role="button">View details »</a></p>
                </section>
                <?php } ?>

            </section>

            <?php } else {
                    $notFound = True;
                } 
            } else {
                $notFound = True;
            }
            
            if ($notFound) {
            ?>

            <section class="row">
                <section class="col-12">
                    <h1>Category not found</h1>
                </section>
            </section>

            <?php } ?>

        </section>
    </section>

    </section>
    <script src="<?= asset('assets/js/jquery.min.js') ?>"></script>
    <script src="<?= asset('assets/js/bootstrap.min.js') ?>"></script>
</body>

</html>