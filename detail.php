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
            <!-- Example row of columns -->
            <section class="row">
                <?php
                global $connection;
                $notFound = false;
                if (isset($_GET['id']) && $_GET['id'] !== '') {
                    $query = "SELECT `posts`.*, `categories`.`name` AS category_name FROM `posts`     LEFT JOIN `categories` ON `posts`.`cat_id` = `categories`.`id` WHERE `posts`. `status` = 10 AND `posts`.`id` = ?";
                    $statement = $connection->prepare($query);
                    $statement->execute([$_GET['id']]);
                    $post = $statement->fetch();
                    if ($post !== false) {
                        ?>
                        <section class="col-md-12">
                            <h1><?= $post->title ?></h1>
                            <h5 class="d-flex justify-content-between align-items-center">
                                <a href="<?= URL('category.php?id=') . $post->cat_id ?>"><?= $post->category_name ?></a>
                                <span class="date-time"><?= $post->created_at ?></span>
                            </h5>
                            <article class="card mb-4 shadow-sm p-3 bg-article p-3 rounded">
                                <div class="row g-3 align-items-center">
                                    <?php if (!empty($post->image)): ?>
                                        <div class="col-md-4">
                                            <img src="<?= asset($post->image) ?>" alt="<?= htmlspecialchars($post->title) ?>"
                                                class="img-fluid rounded img-thumbnail">
                                        </div>
                                    <?php endif; ?>
                                    <div class="<?= !empty($post->image) ? 'col-md-8' : 'col-12' ?>">
                                        <p class="mb-0"><?= nl2br(htmlspecialchars($post->body)) ?></p>
                                    </div>
                                </div>
                            </article>
                        <?php } else {
                        $notFound = True;
                    }
                } else {
                    $notFound = True;
                }
                if ($notFound) {
                    ?>
                        <section>post not found!</section>
                    <?php } ?>
                </section>
            </section>
        </section>

    </section>
    <script src="<?= asset('assets/js/jquery.min.js') ?>"></script>
    <script src="<?= asset('assets/js/bootstrap.min.js') ?>"></script>
</body>

</html>