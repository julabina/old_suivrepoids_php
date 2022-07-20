<?php $title = 'img'; ?>

<?php ob_start(); ?>

<main>
    <h1>TITRE IMG</h1>

    <?php if(isset($_SESSION['name']) && isset($_SESSION['user']) && isset($_SESSION['userId']) && isset($_SESSION['size']) && (isset($_SESSION['sexe']) && ($_SESSION['sexe'] === "man" || $_SESSION['sexe'] === "woman")) && isset($_SESSION['auth']) && $_SESSION['auth'] === true): ?>
        <h2>Votre img est de <?= $imgInfos['img']; ?>%.</h2>

        <p>Avec votre IMG, vous etes (selon Deurenberg)</p>
        <h3><?php 
            if($imgInfos['is_man'] === 0) {
                if($imgInfos['img'] < 25) {
                    echo "Trop maigre";
                } elseif($imgInfos['img'] < 30 && $imgInfos['img'] > 24) {
                    echo "Normal";
                } elseif($imgInfos['img'] > 29) {
                    echo "Trop de graisse";
                }
            } elseif($imgInfos['is_man'] === 1) {
                if($imgInfos['img'] < 15) {
                    echo "Trop maigre";
                } elseif($imgInfos['img'] < 20 && $imgInfos['img'] > 14) {
                    echo "Normal";
                } elseif($imgInfos['img'] > 19) {
                    echo "Trop de graisse";
                }
            }
            ?></h3>
    <?php endif; ?>

</main>

<?php $content = ob_get_clean(); ?>

<?php require('layout.php'); ?>