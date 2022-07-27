<?php $title = 'login'; ?>
<?php $contentHead = "" ?>

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
        
        <div class="log__error"></div>
        
        <form class="log__form" id="log__form" action="/suivi_poids/login" method="post">
            <div class="log__form__email">
                <label for="logEmail">Email</label>
                <input type="email" name="email" id="logEmail">
            </div>
            <div class="log__form__password">
                <label for="logPassword">Mot de passe</label>
                <input type="password" name="password" id="logPassword">
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