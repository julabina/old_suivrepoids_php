<?php $title = 'dashboard'; ?>

<?php
    if(!isset($_SESSION['name']) || !isset($_SESSION['user']) || !isset($_SESSION['userId']) || !isset($_SESSION['size']) || (!isset($_SESSION['sexe']) || ($_SESSION['sexe'] !== "man" && $_SESSION['sexe'] !== "woman")) || !isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
        header('Location: /suivi_poids/login');
    }
?>

<?php ob_start(); ?>

<script>
    const successfulObj = () => {
        const objCard = document.querySelector('.dash__obj');
        objCard.classList.add('dash__obj--success');
    };
</script>

<header class="dashHeader">
    <div class="header">
        <a href="/suivi_poids/"><h1>TITRE DU SITE</h1></a>
    </div>
</header>

<main class="dash">
    <section class="dash__infos">
        <h2>Tableau de bord</h2>
        <div class="dash__infos__cont">
            <div onClick="handleModal()" class="dash__infos__cont__infoBox">
                <h4>Votre poids au <?= $userData->recordDate; ?></h4>
                <h3><?= $userData->weight; ?></h3>
                <p>cliquer pour ajouter un nouveau poids.</p>
            </div>
            <a href="/suivi_poids/imc"><div class="dash__infos__cont__infoBox">
                <h4>Votre IMC</h4>
                <h3><?= floor($userData->imc); ?></h3>
                <p></p>
            </div></a>
            <a href="/suivi_poids/img"><div class="dash__infos__cont__infoBox">
                <h4>Votre IMG</h4>
                <h3><?= $userData->img; ?>%</h3>
                <p></p>
            </div></a>
        </div>
        <a href="/suivi_poids/objectifs"><div class="dash__obj">
            <div class="dash__obj__content">
                <?php if($userData->weight_goal === NULL && $userData->imc_goal === NULL && $userData->img_goal === NULL): ?>
                    <h3>Vous pouvez définir un objectif ici !!</h3>
                <!-- if goal is weight -->
                <?php elseif($userData->weight_goal !== null): ?>
                    <?php if($userData->weight <= $userData->weight_goal): ?>
                        <?= "<script> successfulObj(); </script>"; ?>
                        <h4>Objectif Atteint, Félicitation !</h4>
                    <?php else: ?>
                        <h4>Votre objectif actuel</h4>
                    <?php endif; ?>
                    <h3>Atteindre le poids de <?= $userData->weight_goal; ?> kg</h3>
                <!-- if goal is imc -->
                <?php elseif($userData->imc_goal !== null): ?>
                    <?php if($userData->imc <= $userData->imc_goal): ?>
                        <?= "<script> successfulObj(); </script>"; ?>
                        <h4>Objectif Atteint, Félicitation !</h4>
                    <?php else: ?>
                        <h4>Votre objectif actuel</h4>
                    <?php endif; ?>
                    <h3>Atteindre un IMC de <?= $userData->imc_goal; ?></h3>
                <!-- if goal is img -->
                <?php elseif($userData->img_goal !== null): ?>
                    <?php if($userData->img <= $userData->img_goal): ?>
                        <?= "<script> successfulObj(); </script>"; ?>
                        <h4>Objectif Atteint, Félicitation !</h4>
                    <?php else: ?>
                        <h4>Votre objectif actuel</h4>
                    <?php endif; ?>
                    <h3>Atteindre un IMG de <?= $userData->img_goal; ?>%</h3>
                <?php endif; ?>
                <!-- <p>Phrase en rapport a la reussite ou non</p> -->
            </div>
            <p>Cliquer pour définir un nouvel objectif !</p>
        </div></a>
    </section>
</main>

<!-- modal add weight begin -->
<section class="dashAddWeight dashAddWeight--hidden">
    <div class="dashAddWeight__modal">
        <p onClick="handleModal()" class="dashAddWeight__modal__close">X</p>
        <form class="dashAddWeight__modal__form" action="/suivi_poids/addWeight" method="post">
            <label for="addWeightInput">Ajouter un nouveau poids</label>
            <p class="dashAddWeight__modal__form__error"></p>
            <input type="number" name="addWeight" id="addWeightInput">
            <input onClick="verifyAddWeight()" class="dashAddWeight__modal__form__submitBtn" type="button" value="Ajouter">
        </form>
    </div>
</section>
<!-- modal add weight end -->

<script>  
    const modal = document.querySelector(".dashAddWeight");

    const verifyAddWeight = () => {   
        const addWeight = document.getElementById("addWeightInput");
        const modalErrorCont = document.querySelector(".dashAddWeight__modal__form__error");
        const modalForm = document.querySelector(".dashAddWeight__modal__form");
        let modalError = "";
        modalErrorCont.textContent = "";
    
        if(addWeight.value === '') {
            modalError = '- Le poids ne doit pas etre vide.';
        } else if(addWeight.value < 31) {
            modalError = '- Le poids doit etre superieur à 30 kg.';
        } else if(addWeight.value > 249) {
            modalError = '- Le poids doit etre inférieur à 260 kg.';
        } else if(!addWeight.value.match(/^[0-9]*$/)) {
            modalError = '- Le poids ne doit contenir que des chiffres.';
        }
    
        if(modalError !== "") {
            return modalErrorCont.textContent = modalError;
        }

        modalForm.submit();
        handleModal();
    };

    const handleModal = () => {
        if(modal.classList.contains('dashAddWeight--hidden')) {
            modal.classList.remove("dashAddWeight--hidden");
        } else {
            modal.classList.add("dashAddWeight--hidden");
        }
    };

</script>

<?php $content = ob_get_clean(); ?>

<?php require('layout.php'); ?>