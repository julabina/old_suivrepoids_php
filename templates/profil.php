<?php $title = "profil"; ?>

<?php
    if(!isset($_SESSION['name']) || !isset($_SESSION['user']) || !isset($_SESSION['userId']) || !isset($_SESSION['size']) || (!isset($_SESSION['sexe']) || ($_SESSION['sexe'] !== "man" && $_SESSION['sexe'] !== "woman")) || !isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
        header('Location: /suivi_poids/login');
    }
?>

<?php ob_start(); ?>

<header>
    <div class="header">
        <a href="/suivi_poids/"><h1>TITRE DU SITE</h1></a>
        <div class="header__connected">
            <a class="header__connected__logoutBtn" href="/suivi_poids/logout">Se deconnecter</a>
        </div>
    </div>
</header>
<main class="profil">
    <h2>Bonjour <?= $userInfos->name; ?></h2>
    <!-- <nav class="profil__nav">
        <p class="profil__nav__subTitle">Que souhaitez vous faire ?</p>
        <a href="/suivi_poids/dashboard"><button class="profil__nav__btn">Voir votre tableau de bord</button></a>
        <button onClick="openModify()" class="profil__nav__btn">Modifier votre profil</button>
        <button onClick="openModifyPassword()" class="profil__nav__btn">Changer de mot de passe</button>
        <button onClick="openDeleteModal()" class="profil__nav__btn profil__nav__deleteBtn">Supprimer votre profil</button>
    </nav> -->

    <!-- <section class="profil__modify profil__modify--hidden">
        <h3>Modifier le profil</h3>
        <form action="">
            <div class="">
                <label for="">Prénom/Pseudo</label>
                <input type="text" name="" id="" value="<?= $userInfos->name; ?>">
            </div>
            <div class="">
                <label for="">Taille</label>
                <input type="number" name="" id="" value="<?= $userInfos->size ?>">
            </div>
            <div class="">
                <label for="">Date de naissance</label>
                <input type="text" name="" id="" value="<?= $userInfos->birthday; ?>">
            </div>
            <div class="">
                <label for="">Sexe</label>
                <select name="" id="">
                    <option value="man" <?php if($userInfos->sexe === "man") { echo "selected"; } ?>>Homme</option>
                    <option value="woman" <?php if($userInfos->sexe === "woman") { echo "selected"; } ?>>Femme</option>
                </select>
            </div>
        </form>
    </section> -->

    <section class="profil__modifyPassword">
        <h3>Mofier le mot de passe</h3>
        <form action="">
            <div class="">
                <label for="">Votre ancien mot de passe</label>
                <input type="password" name="" id="">
            </div>
            <div class="">
                <label for="">Votre nouveau mot de passe</label>
                <input type="password" name="" id="">
            </div>
            <div class="">
                <label for="">Confirmer le mot de passe</label>
                <input type="password" name="" id="">
            </div>
        </form>
    </section>

    <section class="profil__delete">
        <div class="profil__delete__modal"></div>
    </section>
</main>

<script>
    const openModify = () => {

    };
    
    const openModifyPassword = () => {

    };
    
    const openDeleteModal = () => {

    };
</script>

<?php $content = ob_get_clean(); ?>

<?php require('layout.php'); ?>