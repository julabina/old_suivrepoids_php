<?php $title = 'home'; ?>

<?php
    SESSION_START();
?>

<?php ob_start(); ?>

<header>
    <div class="header">
        <h1>TITRE DU SITE</h1>
        <?php if(isset($_SESSION['name']) && isset($_SESSION['user']) && isset($_SESSION['userId']) && isset($_SESSION['size']) && (isset($_SESSION['sexe']) && ($_SESSION['sexe'] === "man" || $_SESSION['sexe'] === "woman")) && isset($_SESSION['auth']) && $_SESSION['auth'] === true): ?>
            <a class="header__logoutBtn" href="/suivi_poids/logout">Se deconnecter</a>
        <?php else: ?>
            <div class="header__notConnectBtns">
                <a id="headerLogBtn" href="/suivi_poids/login">Se connecter</a>
                <a href="/suivi_poids/sign">Creer un compte</a>
            </div>
        <?php endif; ?>
    </div>
</header>

<main>
    <section class='home__basics'>
        <?php if(isset($_SESSION['name']) && isset($_SESSION['user']) && isset($_SESSION['userId']) && isset($_SESSION['size']) && (isset($_SESSION['sexe']) && ($_SESSION['sexe'] === "man" || $_SESSION['sexe'] === "woman")) && isset($_SESSION['auth']) && $_SESSION['auth'] === true): ?>
            <h1>Bienvenue <?= $_SESSION['name']; ?></h1>
            <a class="home__basics__toDash" href="/suivi_poids/dashboard">Votre tableau de bord</a>
        <?php else: ?>
            <h2 class="home__basics__para">Une phrase d'accroche pertinante</h2>
            <div class="home__basics__notConnectBtns">
                <a href="/suivi_poids/sign">Creer un compte</a>
                <a href="/suivi_poids/login">Se connecter</a>
            </div>
        <?php endif; ?>
        <div class="home__basics__scrollBtn">
            <img src="../suivi_poids/assets/arrow.svg" alt="arrow down">
        </div>
    </section>
    <section>
        <div class='home__basics__calculBtns'>
            <a href="/suivi_poids/imc">Calculer votre IMC</a>
            <a href="/suivi_poids/img">Calculer votre IMG</a>
        </div>
        <h2>TITRE</h2>
        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Totam natus debitis corrupti optio nesciunt eveniet ab, temporibus perspiciatis alias deserunt accusantium similique? Quaerat autem inventore consequuntur exercitationem placeat. Possimus pariatur tempore laborum commodi cum unde. Velit ducimus sunt nemo dolore. Nemo numquam vitae praesentium eligendi accusantium eveniet voluptatem ipsa officiis.</p>
    </section>

</main>

<?php $content = ob_get_clean(); ?>

<?php require('layout.php'); ?>