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
    <div class="header">
        <h1>TITRE DU SITE</h1>
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
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Rerum voluptatem voluptatibus debitis cupiditate consectetur repudiandae, ullam asperiores provident ex facilis magni, ad accusantium. Quidem consequatur tenetur veniam! Beatae, laudantium saepe?</p>
                <div class="home__faq__cont__main__btnCont">
                    <?php if(isset($_SESSION['name']) && isset($_SESSION['user']) && isset($_SESSION['userId']) && isset($_SESSION['size']) && (isset($_SESSION['sexe']) && ($_SESSION['sexe'] === "man" || $_SESSION['sexe'] === "woman")) && isset($_SESSION['auth']) && $_SESSION['auth'] === true): ?> 
                        <a class='home__faq__cont__main__btnCont__link' href="/suivi_poids/dashboard"><p>Commencer</p></a>
                    <?php else: ?>
                        <a class='home__faq__cont__main__btnCont__link' href="/suivi_poids/sign"><p>Commencer</p></a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="home__faq__cont__step">
                <div class="home__faq__cont__step__img">    
                    <img src="../suivi_poids/assets/weight.svg" alt="weight icon">
                </div>
                <h3>petit titre</h3>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nostrum eum sunt excepturi!</p>
            </div>
            <div class="home__faq__cont__step">
                <div class="home__faq__cont__step__img">    
                    <img src="../suivi_poids/assets/graph.svg" alt="graph icon">
                </div>
                <h3>petit titre</h3>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nostrum eum sunt excepturi!</p>
            </div>
            <div class="home__faq__cont__step">
                <div class="home__faq__cont__step__img">    
                    <img src="../suivi_poids/assets/money.svg" alt="money icon">
                </div>
                <h3>petit titre</h3>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nostrum eum sunt excepturi!</p>
            </div>
        </div>
    </section>

    <section class='home__bmiBfp'>
        <h2>Calculer votre IMC et votre IMG</h2>
        <div class='home__bmiBfp__calculLink'>
            <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Totam natus debitis corrupti optio nesciunt eveniet ab, temporibus perspiciatis alias deserunt accusantium similique? Quaerat autem inventore consequuntur exercitationem placeat. Possimus pariatur tempore laborum commodi cum unde. Velit ducimus sunt nemo dolore. Nemo numquam vitae praesentium eligendi accusantium eveniet voluptatem ipsa officiis.</p>
            <a href="/suivi_poids/imc">Calculer votre IMC</a>
        </div>
        <div class='home__bmiBfp__calculLink'>
            <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Totam natus debitis corrupti optio nesciunt eveniet ab, temporibus perspiciatis alias deserunt accusantium similique? Quaerat autem inventore consequuntur exercitationem placeat. Possimus pariatur tempore laborum commodi cum unde. Velit ducimus sunt nemo dolore. Nemo numquam vitae praesentium eligendi accusantium eveniet voluptatem ipsa officiis.</p>
            <a href="/suivi_poids/img">Calculer votre IMG</a>
        </div>
    </section>

</main>

<?php $content = ob_get_clean(); ?>

<?php require('layout.php'); ?>