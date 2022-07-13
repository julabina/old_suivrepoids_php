<?php $title = 'objectif'; ?>

<?php
    if(!isset($_SESSION['name']) || !isset($_SESSION['user']) || !isset($_SESSION['userId']) || !isset($_SESSION['size']) || (!isset($_SESSION['sexe']) || ($_SESSION['sexe'] !== "man" && $_SESSION['sexe'] !== "woman")) || !isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
        header('Location: /suivi_poids/login');
    }
?>

<?php ob_start(); ?>

<h1>Mes objectifs</h1>

<h2>objectif courant</h2>

<?php foreach($objectifs as $objectif): ?>
    <?php if($objectif['current'] === 0): ?>
        <div>
            <h3>ON AFFICHE LES OBJECTIFS PRECEDENTS</h3>
        </div>
    <?php endif; ?>
<?php endforeach; ?>    

<?php $content = ob_get_clean(); ?>

<?php require('layout.php'); ?>