<?php $title = 'dashboard'; ?>

<?php
    if(!isset($_SESSION['name']) || !isset($_SESSION['user']) || !isset($_SESSION['userId']) || !isset($_SESSION['size']) || (!isset($_SESSION['sexe']) || ($_SESSION['sexe'] !== "man" && $_SESSION['sexe'] !== "woman")) || !isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
        header('Location: /suivi_poids/login');
    }
?>

<?php ob_start(); ?>

<header>
    <h1>Tableau de bord</h1>
    <h2><?= $userData->name; ?></h2>
</header>

<main>
    <section>
        <div>
            <div>
                <h4>Votre poids au ------</h4>
                <h3><?= $userData->weight; ?></h3>
            </div>
            <div>
                <h4>Votre IMC au ------</h4>
                <h3><?= floor($userData->imc); ?></h3>
            </div>
            <div>
                <h4>Votre IMG au ------</h4>
                <h3><?= $userData->img; ?></h3>
            </div>
        </div>
        <a href="/suivi_poids/objectifs"><div>
            <h4>Votre objectif</h4>
            <div>
                <?php if($userData->weight_goal === NULL && $userData->imc_goal === NULL && $userData->img_goal === NULL): ?>
                <h3>Vous pouvez définir un objectif ici !!</h3>
                <?php endif; ?>
                <!-- <p>Phrase en rapport a la reussite ou non</p> -->
            </div>
            <p>Cliquer pour définir un nouvel objectif !</p>
        </div></a>
    </section>
</main>

<?php $content = ob_get_clean(); ?>

<?php require('layout.php'); ?>