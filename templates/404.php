<?php 
    $title = "404"; 
    $contentHead = "";
?>

<?php ob_start(); ?>

<main class="notFound">
    <h1>La page demandée n'a pas été trouvée !</h1>
    <div class="notFound__btn">
        <a href="/suivi_poids/"><button>Retourner à l'accueil</button></a>
    </div>
</main>

<?php $content = ob_get_clean(); ?>

<?php require('layout.php');