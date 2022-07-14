<?php $title = 'home'; ?>

<?php
    SESSION_START();
?>

<?php ob_start(); ?>

<main>
    <h1>TITRE DU SITE</h1>

    <?php if(isset($_SESSION['name']) && isset($_SESSION['user']) && isset($_SESSION['userId']) && isset($_SESSION['size']) && (isset($_SESSION['sexe']) && ($_SESSION['sexe'] === "man" || $_SESSION['sexe'] === "woman")) && isset($_SESSION['auth']) && $_SESSION['auth'] === true): ?>
        <a href="/suivi_poids/dashboard">Votre tableau de bord</a>
    <?php endif; ?>

    <a href="/suivi_poids/imc">Calculer votre IMC</a>
    <a href="/suivi_poids/img">Calculer votre IMG</a>

</main>

<?php $content = ob_get_clean(); ?>

<?php require('layout.php'); ?>