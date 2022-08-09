<?php 
    $title = "Contact"; 
    $contentHead = "";
?>

<?php
    SESSION_START();

    $now = new DateTime();
    $currentTimestamp = $now->getTimestamp();
    if(isset($_SESSION['name']) && isset($_SESSION['user']) && isset($_SESSION['userId']) && isset($_SESSION['size']) && (isset($_SESSION['sexe']) && ($_SESSION['sexe'] === "man" || $_SESSION['sexe'] === "woman")) && isset($_SESSION['auth']) && $_SESSION['auth'] === true) {
        if(!isset($_SESSION['exp']) || $_SESSION['exp'] < $currentTimestamp) {
            return header('Location: /suivi_poids/logoutexp');
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
        <a class="header__titleLink" href="/suivi_poids/"><h1>TITRE DU SITE</h1></a>
        <?php if(isset($_SESSION['name']) && isset($_SESSION['user']) && isset($_SESSION['userId']) && isset($_SESSION['size']) && (isset($_SESSION['sexe']) && ($_SESSION['sexe'] === "man" || $_SESSION['sexe'] === "woman")) && isset($_SESSION['auth']) && $_SESSION['auth'] === true): ?>
            <div class="header__connected">
                <a class="header__connected__toDashboard" href="/suivi_poids/dashboard">Tableau de bord</a>
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

<main class="contact">
    <h2>Contactez nous</h2>
    <section class="contact__section">
        <div class="contact__section__errorCont">
            <?php if(isset($_GET['send']) && $_GET['send'] === 'true'): ?>
                <p>- Message bien envoyé.</p>
            <?php elseif(isset($_GET['send']) && $_GET['send'] === 'false'): ?>
                <p>- Message non envoyé.</p>
            <?php endif; ?>
        </div>
        <form action="/suivi_poids/contact" method="post" class="contact__section__form">
            <div class="contact__section__form__top">
                <div class="contact__section__form__top__email">
                    <label for="contactEmail">Votre email</label>
                    <input class="contact__section__form__inputs" type="email" name="email" id="contactEmail">
                </div>
                <div class="contact__section__form__top__name">
                    <label for="contactName">Votre nom</label>
                    <input class="contact__section__form__inputs" type="text" name="name" id="contactName">
                </div>
            </div>
            <div class="contact__section__form__subject">
                <label for="contactSubject">Le sujet</label>
                <input class="contact__section__form__inputs" type="text" name="subject" id="contactSubject">
            </div>
            <div class="contact__section__form__text">
                <label for="contactMsg">Votre message</label>
                <textarea class="contact__section__form__text__message" name="message" id="contactMsg"></textarea>
            </div>
            <div class="contact__section__form__btnCont">
                <input class="contact__section__form__btnCont__btn" type="button" value="Envoyer" onClick="verifyForm()">
            </div>
        </form>
    </section>
</main>

<script>

    /**
     * check form before post
     */
    const verifyForm = () => {

        const contactForm = document.querySelector(".contact__section__form");
        const contactInputs = document.querySelectorAll(".contact__section__form__inputs");
        const contactTextArea = document.querySelector('.contact__section__form__text__message');
        const errorCont = document.querySelector('.contact__section__errorCont');

        let error = "";
        errorCont.innerHTML = "";

        if(contactInputs[0].value === "") {
            error += `<p>- L'email ne doit pas etre vide.</p>`
        } else if(!contactInputs[0].value.match(/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/i)) {
            error += `<p>- Le format de l'email n'est pas valide.</p>`
        }

        if(contactInputs[1].value === "") {
            error += `<p>- Le nom ne doit pas etre vide.</p>`
        } else if (contactInputs[1].value.length < 3 || contactInputs[1].value.length > 24) {
            error += `<p>- Le nom doit avoir une taille comprise entre 3 et 24 caracteres.</p>`
        } else if (!contactInputs[1].value.match(/^[a-zA-Zé èà]*$/)) {
            error += `<p>- Le nom doit contenir que des lettres.</p>`
        }

        if(contactInputs[2].value === "") {
            error += `<p>- Le sujet ne doit pas etre vide.</p>`
        } else if (contactInputs[2].value.length < 5 || contactInputs[2].value.length > 50) {
            error += `<p>- Le sujet doit avoir une taille comprise entre 5 et 50 caracteres.</p>`
        } else if(!contactInputs[2].value.match(/^[a-zA-Zé èà0-9 ?!:@,+'.-]+$/)) {
            error += `<p>- Les caractères spéciaux ne sont pas autorisés pour le sujet.</p>`
        }

        if(contactTextArea.value === "") {
            error += `<p>- Le message ne doit pas etre vide.</p>`
        } else if (contactTextArea.value.length < 10 || contactTextArea.value.length > 200) {
            error += `<p>- Le message doit avoir une taille comprise entre 10 et 200 caracteres.</p>`
        } else if(!contactTextArea.value.match(/^[a-zA-Zé èà0-9 ?!:@,+'.-]+$/)) {
            error += `<p>- Les caractères spéciaux ne sont pas autorisés pour le message.</p>`
        }

        if(error !== "") {
            errorCont.innerHTML = error;
        } else {
            contactForm.submit();
        }

    };

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
    };

</script>

<?php $content = ob_get_clean(); ?>

<?php require('layout.php'); ?>