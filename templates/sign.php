<?php $title = 'signup'; ?>

<?php

    $error = "";

    if(isset($_POST['name'])) {
        $name = htmlspecialchars($_POST['name']);
        echo $name;
        if(empty($name)) {
            $error = 'Nom vide';
        }
    }

    if(isset($_POST['name']) && ($error === "")) {
        echo '1';
    } else {
        echo 'erreur';

    }
?>

<?php ob_start(); ?>

<h1>S'enregistrer</h1>

<?php
		if ($error !== "") {

            echo $error;
        }
		?>

<form action="/suivi_poids/sign" method="post">
    <div class="">
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
            <label for="signSize">Taille</label>
            <input type="number" name="size" id="signSize">
        </div>
        <div class="">
            <label for="signSexe">Sexe</label>
            <select name="sexe" id="signSexe">
                <option value="men">Homme</option>
                <option value="women">Femme</option>
            </select>
        </div>
    </div>
    <button type="submit">OK</button>
</form>

<?php $content = ob_get_clean(); ?>

<?php require('layout.php'); ?>