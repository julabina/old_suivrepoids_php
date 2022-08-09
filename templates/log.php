<?php $title = 'login'; 
    ob_start(); ?>

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

<?php $contentHead = ob_get_clean() ?>

<?php SESSION_START(); ?>

<?php ob_start(); ?>

<main class="log">
    <a href="/suivi_poids/" class="backToHome">< retour</a>
    <?php if(isset($_SESSION['name']) && isset($_SESSION['user']) && isset($_SESSION['userId']) && isset($_SESSION['size']) && (isset($_SESSION['sexe']) && ($_SESSION['sexe'] === "man" || $_SESSION['sexe'] === "woman")) && isset($_SESSION['auth']) && $_SESSION['auth'] === true): ?>
        <div class="log__notConnected">
            <h1>Vous etes deja connecter !</h1>
            <div class="log__notConnected__linkCont">
                <a href="/suivi_poids/logout">Se deconnecter</a>
            </div>
        </div> 
    <?php else: ?>
        <h1>Se connecter</h1>
        
        <div class="log__error">
            <?php if(isset($_GET['err']) && $_GET['err'] === 'log'): ?>
                <p>- L'email ou le mot de passe est incorrecte.</p>
            <?php elseif(isset($_GET['err']) && $_GET['err'] === "format"): ?>
                <p>- Une erreur est survenue, rééssayer plus tard.</p>
                <p>- Si le probleme persiste contactez l'administrateur du site.</p>
            <?php elseif(isset($_GET['err']) && $_GET['err'] === "exp"): ?>
                <p>- Votre session a expiré.</p>
            <?php elseif(isset($_GET['err']) && $_GET['err'] === "delete"): ?>
                <p>- Votre compte a bien été supprimé.</p>
            <?php elseif(isset($_GET['err']) && $_GET['err'] === "send"): ?>
                <p>- L'email de récupération a bien été envoyé.</p>
            <?php elseif(isset($_GET['err']) && $_GET['err'] === "captcha"): ?>
                <p>- Veuillez cochez le Captcha.</p>
            <?php endif; ?>
        </div>
        
        <form class="log__form" id="log__form" action="/suivi_poids/login" method="post">
            <div class="log__form__email">
                <label for="logEmail">Email</label>
                <input type="email" name="email" id="logEmail">
            </div>
            <div class="log__form__password">
                <label for="logPassword">Mot de passe</label>
                <input type="password" name="password" id="logPassword">
                <a href="/suivi_poids/forgotten"><p>Mot de passe oublié ?</p></a>
            </div>
            <div class="log__form__captcha">
                <div class="g-recaptcha" data-sitekey="<?= $_ENV['G_CAPTCHA_CLIENT_KEY']; ?>" data-size="compact"></div>
            </div>
            <div class="log__form__btnCont">
                <input class="log__form__btnCont__submitBtn" type="button" value="Se connecter" onClick="checkLogInputs()">
            </div>
        </form>
    <?php endif; ?>
</main>

<script>
    const email = document.getElementById('logEmail');
    const password = document.getElementById('logPassword');
    const form = document.getElementById('log__form');
    const errorCont = document.querySelector('.log__error');
    const captcha = document.querySelector(".g-recaptcha");
    
    /**
     * check form before post
     */
    const checkLogInputs = () => {
        
        let error = "";

        if(email.value === "") {
            error += `<p>- L'email ne doit pas etre vide.</p>`
        } else if(!email.value.match(/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/i)) {
            error += `<p>- Le format de l'email n'est pas valide.</p>`
        }

        if(password.value === "") {
            error += `<p>- Le mot de passe ne doit pas etre vide.</p>`
        } else if(!password.value.match(/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/)) {
            error += `<p>- Le mot de passe doit etre d'une longueur de 8 caracteres et contenir au moins une majuscule un chiffre et une lettre.</p>`
        }

        const response = grecaptcha.getResponse();
        if(response.length == 0) 
        { 
            error += `<p>- Veuillez cocher la case "Je ne suis pas un robot".</p>`;
        }

        if(error !== '') {
            errorCont.innerHTML = error;
        } else {
            errorCont.innerHTML = "";
            form.submit();
        }
    };
</script>

<?php $content = ob_get_clean(); ?>

<?php require('layout.php'); ?>