<?php $title = 'login'; ?>
<?php $contentHead = "" ?>

<?php SESSION_START(); ?>

<?php ob_start(); ?>

<main class="forgotten">
    <a href="/suivi_poids/login" class="backToHome">< retour</a>
    <?php if(isset($_SESSION['name']) && isset($_SESSION['user']) && isset($_SESSION['userId']) && isset($_SESSION['size']) && (isset($_SESSION['sexe']) && ($_SESSION['sexe'] === "man" || $_SESSION['sexe'] === "woman")) && isset($_SESSION['auth']) && $_SESSION['auth'] === true): ?>
        <div class="log__notConnected">
            <h1>Vous etes deja connecter !</h1>
            <div class="log__notConnected__linkCont">
                <a href="/suivi_poids/logout">Se deconnecter</a>
            </div>
        </div> 
    <?php else: ?>
        <h1>Récupérer votre mot de passe</h1>
        <div class="forgotten__errorCont">
            <?php if(isset($_GET['err']) && $_GET['err'] === "notSend"): ?>
                <p>- Un problème est survenu, réessayez plus tard.</p>
            <?php elseif(isset($_GET['err']) && $_GET['err'] === "notExist"): ?>
                <p>- L'utilisateur n'existe pas.</p>
            <?php endif; ?>
        </div>
        <form action="/suivi_poids/resetpwd" method="post" class="forgotten__form">
            <div class="forgotten__form__row">
                <label for="forgotEmail">Votre adresse email</label>
                <input type="email" name="email" id="forgotEmail">
            </div>
            <div class="forgotten__form__btnCont">
                <input class="forgotten__form__btnCont__submitBtn" onClick="checkForgotForm()" type="button" value="Envoyer">
            </div>
        </form>
    <?php endif; ?>
</main>

<script>

    const checkForgotForm = () => {
        const forgotForm = document.querySelector('.forgotten__form');
        const forgotError = document.querySelector('.forgotten__errorCont');
        const forgotInput = document.getElementById('forgotEmail');
        let error = '';
        forgotError.innerHTML = "";
        
        if(forgotInput.value === "") {
            error += `<p>- L'email ne doit pas etre vide.</p>`
        } else if(!forgotInput.value.match(/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/i)) {
            error += `<p>- Le format de l'email n'est pas valide.</p>`
        }

        if(error !== "") {
            forgotError.innerHTML = error;
        } else {
            forgotForm.submit();
        }
    }
    
</script>

<?php $content = ob_get_clean(); ?>

<?php require('layout.php'); ?>