<?php $title = 'dashboard'; ?>

<?php
    if(!isset($_SESSION['name']) || !isset($_SESSION['user']) || !isset($_SESSION['userId']) || !isset($_SESSION['size']) || (!isset($_SESSION['sexe']) || ($_SESSION['sexe'] !== "man" && $_SESSION['sexe'] !== "woman")) || !isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
        header('Location: /suivi_poids/login');
    }
?>

<?php ob_start(); ?>

<header class="dashHeader">
    <h1>Tableau de bord</h1>
</header>

<main class="dash">
    <section class="dash__infos">
        <div class="dash__infos__cont">
            <div class="dash__infos__cont__infoBox">
                <h4>Votre poids au <?= $userData->recordDate; ?></h4>
                <h3><?= $userData->weight; ?></h3>
            </div>
            <div class="dash__infos__cont__infoBox">
                <h4>Votre IMC</h4>
                <h3><?= floor($userData->imc); ?></h3>
            </div>
            <div class="dash__infos__cont__infoBox">
                <h4>Votre IMG</h4>
                <h3><?= $userData->img; ?>%</h3>
            </div>
        </div>
        <a class="dash__link" href="/suivi_poids/objectifs"><div class="dash__obj">
            <div class="dash__obj__content">
                <?php if($userData->weight_goal === NULL && $userData->imc_goal === NULL && $userData->img_goal === NULL): ?>
                    <h3>Vous pouvez définir un objectif ici !!</h3>
                <?php elseif($userData->weight_goal !== null): ?>
                    <h4>Votre objectif actuel</h4>
                    <h3>Atteindre le poids de <?= $userData->weight_goal; ?> kg</h3>
                <?php elseif($userData->imc_goal !== null): ?>
                    <h4>Votre objectif actuel</h4>
                    <h3><?= $userData->imc_goal; ?></h3>
                <?php elseif($userData->img_goal !== null): ?>
                    <h4>Votre objectif actuel</h4>
                    <h3><?= $userData->img_goal; ?>%</h3>
                <?php endif; ?>
                <!-- <p>Phrase en rapport a la reussite ou non</p> -->
            </div>
            <p>Cliquer pour définir un nouvel objectif !</p>
        </div></a>
    </section>
</main>

<?php $content = ob_get_clean(); ?>

<?php require('layout.php'); ?>