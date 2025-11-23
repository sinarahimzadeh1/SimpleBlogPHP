<?php
require_once 'functions/helpers.php';
require_once 'functions/PDO_Connection.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PHP Blog</title>
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
                $query = "SELECT `id`, `title`, `body`, `image` FROM `posts` WHERE `status` = 10";
                $statement = $connection->prepare($query);
                $statement->execute();
                $posts = $statement->fetchAll();
                foreach ($posts as $post) {
                    ?>
                    <section class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm">
                            <?php if (!empty($post->image)): ?>
                                <a href="<?= URL('detail.php?id=') . $post->id ?>"><img
                                        src="<?= asset($post->image) ?>" class="card-img-top img-fluid"
                                        alt="<?= htmlspecialchars($post->title) ?>"></a>
                            <?php endif; ?>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title text-truncate"><?= htmlspecialchars($post->title) ?></h5>
                                <p class="card-text text-truncate"><?= substr(strip_tags($post->body), 0, 60) . '...' ?></p>
                                <a href="<?= URL('detail.php?id=') . $post->id ?>" class="btn btn-primary mt-auto">View
                                    details »</a>
                            </div>
                        </div>
                    </section>
                <?php } ?>

            </section>
        </section>

    </section>
    <script src="<?= asset('assets/js/jquery.min.js') ?>"></script>
    <script src="<?= asset('assets/js/bootstrap.min.js') ?>"></script>
</body>

</html>