<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AssignmentMaster</title>


    <!-- JavaScript files for Bootstrap v5 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>


    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="<?= SCRIPTS . 'assets' . DIRECTORY_SEPARATOR . 'js' . DIRECTORY_SEPARATOR . 'ajax.js' ?>"></script>
    <script src="<?= SCRIPTS . 'assets' . DIRECTORY_SEPARATOR . 'js' . DIRECTORY_SEPARATOR . 'main.js' ?>"></script>
    <!-- CSS -->
    <link rel="stylesheet" href="<?= SCRIPTS . 'assets' . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR . 'bootstrap.css' ?>">
    <link rel="stylesheet" href="<?= SCRIPTS . 'assets' . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR . 'style.css' ?>">
</head>

<body>


    <?php include '../views/include/navbar.php' ?>

    <main class="mt-2">
        <?= $content ?>
    </main>


</body>

</html>