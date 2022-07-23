<?php $title = 'imc'; ?>

<?php ob_start(); ?>

<header>
    <div class="header">
        <a class="header__titleLink" href="/suivi_poids/"><h1>TITRE DU SITE</h1></a>
        <a class="header__toDashboard" href="/suivi_poids/dashboard">Tableau de bord</a>
    </div>
</header>

<main class="bmi">

    <h2>Calculer votre indice de masse corporel (IMC).</h2>

    <?php if(isset($_SESSION['name']) && isset($_SESSION['user']) && isset($_SESSION['userId']) && isset($_SESSION['size']) && (isset($_SESSION['sexe']) && ($_SESSION['sexe'] === "man" || $_SESSION['sexe'] === "woman")) && isset($_SESSION['auth']) && $_SESSION['auth'] === true): ?>
        <section class="bmi__userSection"> 
            <p class="bmi__userSection__subTitle">Votre IMC est de</p>
            <h3><?= floor($imcInfos['imc']); ?></h3>

            <p>Avec votre IMC, vous etes (selon l'OMS) en </p>
            <h4><?php 
                if($imcInfos['imc'] < 16.5) {
                    echo "Maigreur extreme";
                } elseif($imcInfos['imc'] >= 16.5 && $imcInfos['imc'] < 18.5) {
                    echo "Maigreur";
                } elseif($imcInfos['imc'] >= 18.5 && $imcInfos['imc'] < 25) {
                    echo "Corpulence normale";
                } elseif($imcInfos['imc'] >= 25 && $imcInfos['imc'] < 30) {
                    echo "Surpoids";
                } elseif($imcInfos['imc'] >= 30 && $imcInfos['imc'] < 35) {
                    echo "Obésité modérée";
                } elseif($imcInfos['imc'] >= 35 && $imcInfos['imc'] < 40) {
                    echo "Obésité sévère";
                } elseif($imcInfos['imc'] >= 40) {
                    echo "Obésité morbide";
                }
            ?></h4>

            <p>Selon votre taille votre poids idéal se situe entre <?php 
                $size = $imcInfos['size'] / 100;
                echo ceil(($size * $size) * 18.5);
                ?>kg et <?php
                echo floor(($size * $size) * 25);  
            ?>kg.</p>
        </section>
    <?php endif; ?>
</main>

<?php $content = ob_get_clean(); ?>

<?php require('layout.php'); ?>