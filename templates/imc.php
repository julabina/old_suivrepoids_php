<?php $title = 'imc'; ?>

<?php
    SESSION_START();
?>

<?php ob_start(); ?>

<main>
    <h1>TITRE IMC</h1>

    <?php if(isset($_SESSION['name']) && isset($_SESSION['user']) && isset($_SESSION['userId']) && isset($_SESSION['size']) && (isset($_SESSION['sexe']) && ($_SESSION['sexe'] === "man" || $_SESSION['sexe'] === "woman")) && isset($_SESSION['auth']) && $_SESSION['auth'] === true): ?>
        <p>test</p>
    <?php endif; ?>

</main>

<?php $content = ob_get_clean(); ?>

<?php require('layout.php'); ?>