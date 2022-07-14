<?php $title = 'signup'; ?>


<?php ob_start(); ?>
<main>    
    <h1>S'enregistrer</h1>
    
    <div class="sign__error"></div>
    
    <form id="sign__form" action="/suivi_poids/sign" method="post">
        <div class="/suivi_poids/sign">
            <div class="">
                <label for="signEmail">Adresse email</label>
                <input type="email" name="email" id="signEmail">
            </div>
            <div class="">
                <label for="signPassword">Mot de passe</label>
                <input type="password" name="password" id="signPassword">
            </div>
        </div>
        <div class="">
            <div class="">
                <label for="signName">Prénom/pseudo</label>
                <input type="text" name="name" id="signName">
            </div>
            <div class="">
                <label for="signSexe">Sexe</label>
                <select name="sexe" id="signSexe">
                    <option value="man">Homme</option>
                    <option value="woman">Femme</option>
                </select>
            </div>
        </div>
        <div class="">
            <div class="">
                <label for="signSize">Taille</label>
                <input type="number" name="size" id="signSize">
            </div>
            <div class="">
                <label for="signWeight">Votre poids actuel</label>
                <input type="number" name="weight" id="signWeight">
            </div>
        </div>
        <input type="button" value="OK" onClick="checkInputs()">
    </form>

</main>

<script>
    const email = document.getElementById('signEmail');
    const password = document.getElementById('signPassword');
    const userName = document.getElementById('signName');
    const size = document.getElementById('signSize');
    const weight = document.getElementById('signWeight');
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