<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo $viewData['title']; ?></title>
    <?php foreach ($viewData['styles'] as $style): ?>
    <link rel="stylesheet" href="<?php echo $style; ?>">
    <?php endforeach; ?>
</head>
<body>
