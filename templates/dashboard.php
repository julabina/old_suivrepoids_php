<?php $title = 'dashboard'; ?>

<?php ob_start(); ?>

<header>
    <h1>Tableau de bord</h1>
    <h2><?= $userData->name; ?></h2>
</header>

<?php $content = ob_get_clean(); ?>

<?php require('layout.php'); ?>