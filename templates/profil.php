<?php $title = "profil"; ?>
<?php $contentHead = "" ?>

<?php
   $now = new DateTime();
   $currentTimestamp = $now->getTimestamp();
   if(!isset($_SESSION['name']) || !isset($_SESSION['user']) || !isset($_SESSION['userId']) || !isset($_SESSION['size']) || (!isset($_SESSION['sexe']) || ($_SESSION['sexe'] !== "man" && $_SESSION['sexe'] !== "woman")) || !isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
       return header('Location: /suivi_poids/login');
   }
   if(!isset($_SESSION['exp']) || $_SESSION['exp'] < $currentTimestamp) {
       return header('Location: /suivi_poids/logoutexp');
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
        <div class="header__connected">
            <a class="header__connected__logoutBtn" href="/suivi_poids/logout">Se deconnecter</a>
        </div>
    </div>
</header>

<main class="profil">
    <h2>Bonjour <?= htmlspecialchars($userInfos->name); ?></h2>
    
    <nav class="profil__nav">
        <p class="profil__nav__subTitle">Que souhaitez vous faire ?</p>
        <div class="profil__nav__errorCont">
            <?php if(isset($_GET['success']) && $_GET['success'] === 'true'): ?>
                <p id="successMsg">- Profil bien modifié.</p>
            <?php elseif(isset($_GET['success']) && $_GET['success'] === 'false'): ?>
                <p>- Une erreur est survenu.</p>
            <?php endif; ?>
        </div>
        <a href="/suivi_poids/dashboard"><button class="profil__nav__btn">Voir votre tableau de bord</button></a>
        <button onClick="openModify()" class="profil__nav__btn">Modifier votre profil</button>
        <button onClick="openModifyPassword()" class="profil__nav__btn">Changer de mot de passe</button>
        <button onClick="toggleDeleteModal()" class="profil__nav__btn profil__nav__deleteBtn">Supprimer votre profil</button>
    </nav>
    
    <section class="profil__modify profil__modify--hidden">
        <h3>Modifier le profil</h3>
        <div class="profil__modify__errorCont"></div>
        <form class="profil__modify__form" action="/suivi_poids/modifyProfil" method='post'>
            <input type="hidden" name="token" value="<?= htmlspecialchars($_SESSION['token']); ?>">
            <div class="profil__modify__form__row">
                <label for="modifyName">Prénom/Pseudo</label>
                <input class="profil__modify__form__row__input" type="text" name="name" id="modifyName" value="<?= htmlspecialchars($userInfos->name); ?>">
            </div>
            <div class="profil__modify__form__row">
                <label for="modifySize">Taille</label>
                <input class="profil__modify__form__row__input" type="number" name="size" id="modifySize" value="<?= htmlspecialchars($userInfos->size); ?>">
            </div>
            <div class="profil__modify__form__row">
                <label for="modifyBirthday">Date de naissance</label>
                <input class="profil__modify__form__row__input" type="text" name="birthday" id="modifyBirthday" value="<?= htmlspecialchars($userInfos->birthday); ?>">
            </div>
            <div class="profil__modify__form__row">
                <label for="modifySexe">Sexe</label>
                <select name="sexe" id="modifySexe">
                    <option value="man" <?php if($userInfos->sexe === "man") { echo "selected"; } ?>>Homme</option>
                    <option value="woman" <?php if($userInfos->sexe === "woman") { echo "selected"; } ?>>Femme</option>
                </select>
            </div>
            <div class="profil__modify__form__btnCont">
                <input onClick="backToNav()" class="profil__modify__form__btnCont__btn" type="button" value="Annuler">
                <input onClick="verifyModify()" class="profil__modify__form__btnCont__btn" type="button" value="Modifier">
            </div>
        </form>
    </section>
    
    <section class="profil__modifyPassword profil__modifyPassword--hidden">
        <h3>Modifier le mot de passe</h3>
        <div class="profil__modifyPassword__errorCont">
            <p id="passwordError"></p>
        </div>
        <form class="profil__modifyPassword__form" action="/suivi_poids/modifyPassword" method="post">
            <input type="hidden" name="token" value="<?= htmlspecialchars($_SESSION['token']); ?>">
            <div class="profil__modifyPassword__form__row">
                <label for="passwordOld">Votre ancien mot de passe</label>
                <input class="profil__modifyPassword__form__row__input" type="password" name="oldPassword" id="passwordOld">
            </div>
            <div class="profil__modifyPassword__form__row">
                <label for="passwordNew">Votre nouveau mot de passe</label>
                <input class="profil__modifyPassword__form__row__input" type="password" name="newPassword" id="passwordNew">
            </div>
            <div class="profil__modifyPassword__form__row">
                <label for="passwordNewConfirm">Confirmer le mot de passe</label>
                <input class="profil__modifyPassword__form__row__input" type="password" id="passwordNewConfirm">
            </div>
            <div class="profil__modifyPassword__form__btnCont">
                <input onClick="backToNav()" class="profil__modifyPassword__form__btnCont__btn" type="button" value="Annuler">
                <input onClick="verifyPassword()" class="profil__modifyPassword__form__btnCont__btn" type="button" value="Modifier">
            </div>
        </form>
    </section>

    <section class="profil__delete profil__delete--hidden">
        <div class="profil__delete__modal">
            <h2>Supprimer votre compte</h2>
            <p>cette action est définitive !</p>
            <form class='profil__delete__modal__btnCont' method="post" action="/suivi_poids/delete">
                <input type="hidden" name="token" value="<?= htmlspecialchars($_SESSION['token']); ?>">
                <button type="submit" class='profil__delete__modal__btnCont__btn profil__delete__modal__btnCont__btn--deleteBtn'>Supprimer</button>
                <input type='button' onClick="toggleDeleteModal()" class='profil__delete__modal__btnCont__btn' value="Annuler" />
            </form>
        </div>
    </section>
</main>

<script>
    const nav = document.querySelector('.profil__nav');
    const sectionModify = document.querySelector('.profil__modify');
    const sectionModifyPassword = document.querySelector('.profil__modifyPassword');

    const openModify = () => {
        nav.classList.add('profil__nav--hidden');
        sectionModify.classList.remove('profil__modify--hidden');
    };
    
    const openModifyPassword = () => {
        nav.classList.add('profil__nav--hidden');
        sectionModifyPassword.classList.remove('profil__modifyPassword--hidden');
    };
    
    const toggleDeleteModal = () => {
        const modal = document.querySelector('.profil__delete');
        
        if(modal.classList.contains('profil__delete--hidden')) {
            modal.classList.remove('profil__delete--hidden');
        } else {
            modal.classList.add('profil__delete--hidden');
        }
    };
    
    const backToNav = () => {
        sectionModify.classList.add('profil__modify--hidden');
        sectionModifyPassword.classList.add('profil__modifyPassword--hidden');
        nav.classList.remove('profil__nav--hidden');
    };

    const verifyPassword = () => {
        const passwordForm = document.querySelector(".profil__modifyPassword__form");
        const passwordInputs = document.querySelectorAll('.profil__modifyPassword__form__row__input');
        const errorCont = document.getElementById('passwordError');
        
        errorCont.textContent = "";
        
        if(passwordInputs[0].value === "" || passwordInputs[1].value === "" || passwordInputs[2].value === "") {
            return errorCont.textContent = "- Tous les champs sont requis."
        } else if(!passwordInputs[0].value.match(/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/) || !passwordInputs[1].value.match(/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/) || !passwordInputs[2].value.match(/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/)) {
            return errorCont.textContent = "- Le mot de passe doit etre d'une longueur de 8 caracteres et contenir au moins une majuscule, un chiffre et une lettre.";
        } else if(passwordInputs[0].value === passwordInputs[1].value) {
            return errorCont.textContent = "- Le nouveau mot de passe ne doit pas etre identique à l'ancien.";
        } else if(passwordInputs[1].value !== passwordInputs[2].value) {
            return errorCont.textContent = "- Le mot de passe de confirmation doit etre identique au nouveau mot de passe.";
        } else {
            passwordForm.submit();
        }
    };
    
    const verifyModify = () => {
        const modifyForm = document.querySelector('.profil__modify__form');
        const inputs = document.querySelectorAll('.profil__modify__form__row__input');
        const select = document.getElementById('modifySexe');
        const errorCont = document.querySelector('.profil__modify__errorCont');

        let error = "";

        if(inputs[0].value === "") {
            error += `<p>- Le nom ne doit pas etre vide.</p>`
        } else if (inputs[0].value.length < 2 || inputs[0].value.length > 25) {
            error += `<p>- Le nom ne doit avoir une taille comprise entre 2 et 25 caracteres.</p>`
        } else if (!inputs[0].value.match(/^[a-zA-Zé èà]*$/)) {
            error += `<p>- Le nom doit contenir que des lettres.</p>`
        }

        if(inputs[1].value === '') {
            error += `<p>- La taille ne doit pas etre vide.</p>`
        } else if(inputs[1].value < 90 || inputs[1].value > 260) {
            error += `<p>- La taille doit etre d'une longueur comprise entre 90 et 260 cm.</p>`
        } else if(!inputs[1].value.match(/^[0-9]*$/)) {
            error += `<p>- La taille doit contenir que des chiffres.</p>`
        }

        if(inputs[2].value === "") {
            error += `<p>- La date de naissance ne doit pas etre vide.</p>`
        } else if(!inputs[2].value.match(/^([0-2][0-9]|(3)[0-1])(\/)(((0)[0-9])|((1)[0-2]))(\/)(?:19\d{2}|20[01][0-9]|2022)$/i)) {
            error += `<p>- La date de naissance doit etre au format jj/mm/aaaa et etre entre 1900 et 2022.</p>`
        }

        if(error !== "") {
            return errorCont.innerHTML = error;
        } 
        
        if(inputs[0].value !== "<?= htmlspecialchars($userInfos->name); ?>" || inputs[1].value !== "<?= htmlspecialchars($userInfos->size); ?>" || inputs[2].value !== "<?= htmlspecialchars($userInfos->birthday); ?>" || select.value !== "<?= htmlspecialchars($userInfos->sexe); ?>") {
            modifyForm.submit();
        } else {
            return errorCont.innerHTML = `<p>- Aucun champs n'a été modifier.</p>`;
        }
    };

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