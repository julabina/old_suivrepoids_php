<?php $title = 'signup'; ?>


<?php ob_start(); ?>

<main class="sign">   
    <a href="/suivi_poids/" class="sign__back">< retour</a> 
    <h1>S'enregistrer</h1>
    
    <div class="sign__error"></div>
    
    <form class="sign__form" id="sign__form" action="/suivi_poids/sign" method="post">
        <div class="sign__form__logs">
            <div class="sign__form__logs__email">
                <label for="signEmail">Adresse email</label>
                <input type="email" name="email" id="signEmail">
            </div>
            <div class="sign__form__logs__password">
                <label for="signPassword">Mot de passe</label>
                <input type="password" name="password" id="signPassword">
            </div>
        </div>
        <div class="sign__form__name">
            <div class="sign__form__name__firstname">
                <label for="signName">Prénom/pseudo</label>
                <input type="text" name="name" id="signName">
            </div>
            <div class="sign__form__name__birthday">
                <label for="signBirthday">Date de naissance (jj/mm/aaaa)</label>
                <input type="text" name="birthday" id="signBirthday">
            </div>
        </div>
        <div class="sign__form__stats">
            <div class="sign__form__stats__sexe">
                <label for="signSexe">Sexe</label>
                <select name="sexe" id="signSexe">
                    <option value="man">Homme</option>
                    <option value="woman">Femme</option>
                </select>
            </div>
            <div class="sign__form__stats__size">
                <label for="signSize">Taille</label>
                <input type="number" name="size" id="signSize">
            </div>
            <div class="sign__form__stats__weight">
                <label for="signWeight">Votre poids actuel</label>
                <input type="number" name="weight" id="signWeight">
            </div>
        </div>
        <div class="sign__form__checkCont">
            <input type="checkbox" name="checkCgu" id="signCheckCgu">
            <label for="signCheckCgu">J'ai lu et j'accepte les <a href="/suivi_poids/cgu/">Conditions Générales d'Utilisation</a>.</label>
        </div>
        <div class="sign__form__btnCont">
            <input class="sign__form__btnCont__submitBtn" type="button" value="Créer un compte" onClick="checkInputs()">
        </div>
    </form>

</main>

<script>
    const email = document.getElementById('signEmail');
    const password = document.getElementById('signPassword');
    const userName = document.getElementById('signName');
    const userBirthday = document.getElementById('signBirthday');
    const size = document.getElementById('signSize');
    const weight = document.getElementById('signWeight');
    const cgu = document.getElementById('signCheckCgu');
    const form = document.getElementById('sign__form');
    const errorCont = document.querySelector('.sign__error');

    const checkInputs = () => {
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

        if(userName.value === "") {
            error += `<p>- Le nom ne doit pas etre vide.</p>`
        } else if (userName.value.length < 3 || userName.value.length > 24) {
            error += `<p>- Le nom ne doit avoir une taille comprise entre 2 et 25 caracteres.</p>`
        } else if (!userName.value.match(/^[a-zA-Zé èà]*$/)) {
            error += `<p>- Le nom doit contenir que des lettres.</p>`
        }
        
        if(userBirthday.value === "") {
            error += `<p>- La date de naissance ne doit pas etre vide.</p>`
        } else if(!userBirthday.value.match(/^([0-2][0-9]|(3)[0-1])(\/)(((0)[0-9])|((1)[0-2]))(\/)(?:19\d{2}|20[01][0-9]|2022)$/i)) {
            error += `<p>- La date de naissance doit etre au format jj/mm/aaaa et etre entre 1900 et 2022.</p>`
        }
        
        if(size.value === '') {
            error += `<p>- La taille ne doit pas etre vide.</p>`
        } else if(size.value < 91 || size.value > 259) {
            error += `<p>- La taille doit etre d'une longueur comprise entre 90 et 260 cm.</p>`
        } else if(!size.value.match(/^[0-9]*$/)) {
            error += `<p>- La taille doit contenir que des chiffres.</p>`
        }
        
        if(weight.value === '') {
            error += `<p>- Le poids ne doit pas etre vide.</p>`
        } else if(weight.value < 31 || weight.value > 249) {
            error += `<p>- Le poids doit etre  compris entre 90 et 260 kg.</p>`
        } else if(!weight.value.match(/^[0-9]*$/)) {
            error += `<p>- Le poids doit contenir que des chiffres.</p>`
        }
        
        if(!cgu.checked) {
            error += `<p>- Vous devez accepter les conditions générales d'utilisation.</p>`
        } 

        if(error !== '') {
            errorCont.innerHTML = error;
        } else {
            errorCont.innerHTML = "";
            /* form.submit(); */
        }
    };
</script>

<?php $content = ob_get_clean(); ?>

<?php require('layout.php'); ?>