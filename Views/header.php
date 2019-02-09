<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo $viewData['title']; ?></title>
    <?php foreach ($viewData['styles'] as $style): ?>
    <link rel="stylesheet" href="<?php echo $style; ?>">
    <?php endforeach; ?>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
    <script src="<?php echo BASE_URL.'/node_modules/jquery/dist/jquery.min.js'; ?>"></script>
    <script src="<?php echo BASE_URL.'/assets/js/script.js'; ?>"></script>
</head>
<body>
