<?php
require_once '../../functions/helpers.php';
require_once '../../functions/PDO_Connection.php';
require_once '../../functions/check_login.php';

if (!isset($_GET['id'])) {
    redirect('panel/post');
}

global $connection;
$query = "SELECT * FROM `posts` WHERE `id` = ?";
$statement = $connection->prepare($query);
$statement->execute([$_GET['id']]);
$post = $statement->fetch();

if ($post === false) {
    redirect('panel/post');
}


if (
    isset($_POST['title']) && $_POST['title'] !== ''
    && isset($_POST['cat_id']) && $_POST['cat_id'] !== ''
    && isset($_POST['body']) && $_POST['body'] !== ''
) {
    // Checking to exists category
    $query = "SELECT * FROM `categories`";
    $statement = $connection->prepare($query);
    $statement->execute();
    $category = $statement->fetch();

    // if user wants to upload new image
    if (isset($_FILES['image']) && $_FILES['image']['name'] !== '') {

        // Determine the extensions that can be used
        $allowedExtensions = ['png', 'jpg', 'jpeg', 'gif'];

        // Rreturn only image extenrion 
        $imageExtensions = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        if (!in_array($imageExtensions, $allowedExtensions)) {
            redirect('panel/post');
        }

        // set base
        $baseURL = dirname(dirname(__DIR__));

        // Deleting last image and replace new
        if (file_exists($baseURL . $post->image)) {
            unlink($baseURL . $post->image);
        }

        // Image address
        $image = '/assets/images/posts/' . date('Y_m_d_H_i_s') . '.' . $imageExtensions;

        // Moving uploaded image with temp name to designated address
        $image_upload = move_uploaded_file($_FILES['image']['tmp_name'], $baseURL . $image);

        // Checking that the category exists and the photo is uploaded correctly
        if ($category !== false && $image_upload !== false) {
            $UpdatePostQuery = "UPDATE `posts` SET `title` = ?, `body` = ?, `cat_id` = ?, `image` = ?, `updated_at` = NOW() WHERE `id` = ?;";
            $UpdatePostQueryStatement = $connection->prepare($UpdatePostQuery);
            $UpdatePostQueryStatement->execute([$_POST['title'], $_POST['body'], $_POST['cat_id'], $image, $_GET['id']]);
        }
    } else {

        // Checking that the category exists 
        if ($category !== false) {
            $UpdatePostQuery = "UPDATE `posts` SET `title` = ?, `body` = ?, `cat_id` = ?, `updated_at` = NOW() WHERE `id` = ?;";
            $UpdatePostQueryStatement = $connection->prepare($UpdatePostQuery);
            $UpdatePostQueryStatement->execute([$_POST['title'], $_POST['body'], $_POST['cat_id'], $_GET['id']]);
        }
    }
    redirect('panel/post');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PHP panel</title>
    <link rel="stylesheet" href="<?= asset('assets/css/bootstrap.min.css') ?>" media="all" type="text/css">
    <link rel="stylesheet" href="<?= asset('assets/css/style.css') ?>" media="all" type="text/css">
</head>

<body>
    <section id="app">

        <!-- Navbar -->
        <?php require_once '../layouts/top-nav.php' ?>

        <section class="container-fluid">
            <section class="row">
                <section class="col-md-2 p-0">

                    <!-- Sidebar -->
                    <?php require_once '../layouts/sidebar.php' ?>

                </section>
                <section class="col-md-10 pt-3">

                    <form action="<?= asset('panel/post/edit.php?id=') . $_GET['id'] ?>" method="post" enctype="multipart/form-data">
                        <section class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" name="title" id="title" placeholder="title ..." value="<?= $post->title ?>">
                        </section>
                        <section class="form-group">
                            <label for="image">Image</label>
                            <input type="file" class="form-control" name="image" id="image">
                            <img src="<?= asset($post->image) ?> " width="130px">
                        </section>
                        <section class="form-group">
                            <label for="cat_id">Category</label>
                            <select class="form-control" name="cat_id" id="cat_id">
                                <?php
                                $query = "SELECT * FROM `categories`";
                                $statement = $connection->prepare($query);
                                $statement->execute();
                                $categories = $statement->fetchAll();
                                foreach ($categories as $category) {
                                ?>
                                    <option value="<?= $category->id ?>" <?php if ($category->id == $post->cat_id) echo "selected" ?>> <?= $category->name ?> </option>
                                <?php } ?>
                            </select>
                        </section>
                        <section class="form-group">
                            <label for="body">Body</label>
                            <textarea class="form-control" name="body" id="body" rows="5" placeholder="body ..."><?= $post->body ?></textarea>
                        </section>
                        <section class="form-group">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </section>
                    </form>

                </section>
            </section>
        </section>

    </section>

    <script src="<?= asset('assets/js/jquery.min.js') ?>"></script>
    <script src="<?= asset('assets/js/bootstrap.min.js') ?>"></script>
</body>

</html>