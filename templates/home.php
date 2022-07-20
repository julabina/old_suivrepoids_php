<?php $title = 'home'; ?>

<?php
    SESSION_START();
?>

<?php ob_start(); ?>

<main>
    <section class='home__basics'>
        
        <h1>TITRE DU SITE</h1>
        
        <?php if(isset($_SESSION['name']) && isset($_SESSION['user']) && isset($_SESSION['userId']) && isset($_SESSION['size']) && (isset($_SESSION['sexe']) && ($_SESSION['sexe'] === "man" || $_SESSION['sexe'] === "woman")) && isset($_SESSION['auth']) && $_SESSION['auth'] === true): ?>
            <a class="home__basics__logoutBtn" href="/suivi_poids/logout"><button>Se deconnecter</button></a>
            <h2>Bienvenue <?= $_SESSION['name']; ?></h2>

            <a class="home__basics__toDash" href="/suivi_poids/dashboard">Votre tableau de bord</a>
        <?php else: ?>
            <div class="home__basics__notConnectBtns">
                <a href="/suivi_poids/sign">Creer un compte</a>
                <a href="/suivi_poids/login">Se connecter</a>
            </div>
        <?php endif; ?>
           
        <div class='home__basics__calculBtns'>
            <a href="/suivi_poids/imc">Calculer votre IMC</a>
            <a href="/suivi_poids/img">Calculer votre IMG</a>
        </div>
    </section>

</main>

<?php $content = ob_get_clean(); ?>

<?php require('layout.php'); ?>