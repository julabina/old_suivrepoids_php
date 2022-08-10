<?php $title = 'home'; ?>
<?php $contentHead = "" ?>

<?php
    SESSION_START();

    $now = new DateTime();
    $currentTimestamp = $now->getTimestamp();
    if(isset($_SESSION['name']) && isset($_SESSION['user']) && isset($_SESSION['userId']) && isset($_SESSION['size']) && (isset($_SESSION['sexe']) && ($_SESSION['sexe'] === "man" || $_SESSION['sexe'] === "woman")) && isset($_SESSION['auth']) && $_SESSION['auth'] === true) {
        if(!isset($_SESSION['exp']) || $_SESSION['exp'] < $currentTimestamp) {
            return header('Location: /suivi_poids/logout');
        }
    }
?>

<?php ob_start(); ?>

<header>
    <div class="hambMenu">
        <div onClick="toggleMobileMenu()" class="hambMenu__hambBtn">
            <img src="../suivi_poids/assets/hamburger.svg" alt="hamburger menu icon">
        </div>
        <div onClick="toggleMobileMenu()" class="hambMenu__closeBtn hambMenu__closeBtn--hidden">
            <img src="../suivi_poids/assets/closeHamb.svg" alt="close icon">
        </div>
    </div>
    <div class="header header--mobile">
        <div class="header__titleCont">
            <img src="../suivi_poids/assets/weight-icon.jpg" alt="weight balance icon">
            <h1>TITRE DU SITE</h1>
        </div>
        <?php if(isset($_SESSION['name']) && isset($_SESSION['user']) && isset($_SESSION['userId']) && isset($_SESSION['size']) && (isset($_SESSION['sexe']) && ($_SESSION['sexe'] === "man" || $_SESSION['sexe'] === "woman")) && isset($_SESSION['auth']) && $_SESSION['auth'] === true): ?>
            <div class="header__connected">
                <a class="header__connected__logoutBtn" href="/suivi_poids/logout">Se deconnecter</a>
                <a href="/suivi_poids/profil"><div class="header__connected__userProfil">
                    <img src="../suivi_poids/assets/user.svg" alt="user icon">
                </div></a>
            </div>
        <?php else: ?>
            <div class="header__notConnectBtns">
                <a id="headerLogBtn" href="/suivi_poids/login">Se connecter</a>
                <a class="header__notConnectBtns__create" href="/suivi_poids/sign">Creer un compte</a>
            </div>
        <?php endif; ?>
    </div>
</header>

<main>
    <section class='home__basics'>
        <?php if(isset($_SESSION['name']) && isset($_SESSION['user']) && isset($_SESSION['userId']) && isset($_SESSION['size']) && (isset($_SESSION['sexe']) && ($_SESSION['sexe'] === "man" || $_SESSION['sexe'] === "woman")) && isset($_SESSION['auth']) && $_SESSION['auth'] === true): ?>
            <h1>Bienvenue <?= htmlspecialchars($_SESSION['name']); ?></h1>
            <a class="home__basics__toDash" href="/suivi_poids/dashboard">Votre tableau de bord</a>
        <?php else: ?>
            <h2 class="home__basics__para">Une phrase d'accroche pertinante</h2>
            <div class="home__basics__notConnectBtns">
                <a href="/suivi_poids/login">Se connecter</a>
                <a href="/suivi_poids/sign">Creer un compte</a>
            </div>
        <?php endif; ?>
        <a class="home__basics__scrollLink" href="#faq"><div class="home__basics__scrollBtn">
            <img src="../suivi_poids/assets/arrow.svg" alt="arrow down">
        </div></a>
    </section>

    <section id="faq" class="home__faq">
        <div class="home__faq__cont">
            <div class="home__faq__cont__main">
                <h2>Comment ca marche ?</h2>
                <p>TITRE DU SITE vous permet d'enregistrer régulièrement votre poids et de générer l'IMC et l'IMG automatiquement, vous pouvez suivre votre progression et réaliser vos objectifs.</p>
                <div class="home__faq__cont__main__btnCont">
                    <?php if(isset($_SESSION['name']) && isset($_SESSION['user']) && isset($_SESSION['userId']) && isset($_SESSION['size']) && (isset($_SESSION['sexe']) && ($_SESSION['sexe'] === "man" || $_SESSION['sexe'] === "woman")) && isset($_SESSION['auth']) && $_SESSION['auth'] === true): ?> 
                        <a class='home__faq__cont__main__btnCont__link' href="/suivi_poids/dashboard"><p>Commencer</p></a>
                    <?php else: ?>
                        <a class='home__faq__cont__main__btnCont__link' href="/suivi_poids/sign"><p>Commencer</p></a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="home__faq__cont__steps">
                <div class="home__faq__cont__steps__step">
                    <div class="home__faq__cont__steps__step__img">    
                        <img src="../suivi_poids/assets/weight.svg" alt="weight icon">
                    </div>
                    <h3>Atteindre votre objectif</h3>
                    <p>Choisissez un objectif, puis observer votre évolution.</p>
                </div>
                <div class="home__faq__cont__steps__step">
                    <div class="home__faq__cont__steps__step__img">    
                        <img src="../suivi_poids/assets/graph.svg" alt="graph icon">
                    </div>
                    <h3>Suivre votre poids</h3>
                    <p>Entrez votre poids et suivez la progression de celui-ci.</p>
                </div>
                <div class="home__faq__cont__steps__step">
                    <div class="home__faq__cont__steps__step__img">    
                        <img src="../suivi_poids/assets/money.svg" alt="money icon">
                    </div>
                    <h3>100% Gratuit</h3>
                    <p>TITRE DU SITE est entièrement gratuit et le restera.</p>
                </div>
            </div>
        </div>
    </section>

    <section class='home__bmiBfp'>
        <h2>Calculer votre IMC et votre IMG</h2>
        <div class='home__bmiBfp__calculLink'>
            <div class="home__bmiBfp__calculLink__para">
                <p>L'indice de masse corporelle permet de rapidement évaluer votre corpulence avec votre poids et votre taille indépendamment de votre sexe.</p>
                <p>Pour connaitre le votre, rien de plus simple, il vous suffit de cliquer sur 'Calculer votre IMC'.</p>
            </div>
            <a href="/suivi_poids/imc">Calculer votre IMC</a>
        </div>
        <div class='home__bmiBfp__calculLink'>
            <div class="home__bmiBfp__calculLink__para">
                <p>L'indice de masse grasse permet de définir la proportion de graisse dans le corps.</p>
                <p>Pour connaitre le votre, rien de plus simple, il vous suffit de cliquer sur 'Calculer votre IMG'.</p>
            </div>
            <a href="/suivi_poids/img">Calculer votre IMG</a>
        </div>
    </section>

</main>

<script>

    /**
     * toggle the mobile hamburger menu
     */
    const toggleMobileMenu = () => {
        const hambBtn = document.querySelector(".hambMenu__hambBtn");
        const closeBtn = document.querySelector(".hambMenu__closeBtn");
        const header = document.querySelector('.header');

        if(hambBtn.classList.contains('hambMenu__hambBtn--hidden')) {
            hambBtn.classList.remove('hambMenu__hambBtn--hidden');
            closeBtn.classList.add('hambMenu__closeBtn--hidden');
            header.classList.add('header--mobile');
        } else {
            hambBtn.classList.add('hambMenu__hambBtn--hidden');
            closeBtn.classList.remove('hambMenu__closeBtn--hidden');
            header.classList.remove('header--mobile');
        }
    }

</script>

<?php $content = ob_get_clean(); ?>

<?php require('layout.php'); ?>