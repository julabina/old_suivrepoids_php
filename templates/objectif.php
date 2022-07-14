<?php $title = 'objectif'; ?>

<?php
    if(!isset($_SESSION['name']) || !isset($_SESSION['user']) || !isset($_SESSION['userId']) || !isset($_SESSION['size']) || (!isset($_SESSION['sexe']) || ($_SESSION['sexe'] !== "man" && $_SESSION['sexe'] !== "woman")) || !isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
        header('Location: /suivi_poids/login');
    }
?>

<?php ob_start(); ?>
<main>

    <h1>Mes objectifs</h1>
    
    <section>
        <h2>objectif courant</h2>

        <div>
            <div>
                <?php foreach($objectifs as $objectif): ?>
                    <?php if($objectif['current']): ?>
                        <?php if($objectif['weight_goal'] === null && $objectif['imc_goal'] === null && $objectif['img_goal'] === null): ?>
                            <h3>Aucun objectifs défini</h3>
                        <?php elseif($objectif['weight_goal'] !== null): ?>
                            <h3><?= $objectif['weight_goal']; ?></h3>
                        <?php elseif($objectif['imc_goal'] !== null): ?>
                            <h3><?= $objectif['imc_goal']; ?></h3>
                        <?php elseif($objectif['img_goal'] !== null): ?>
                            <h3><?= $objectif['img_goal']; ?></h3>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>

    </section>

    <section class="obj__change">
        <h2>Changer d'objectif</h2>
        <div class='obj__change__tabs'>
            <div onClick='changeTab(0)' class='obj__change__tabs__tab obj__change__tabs__tab--active'>
                <h4>Poids</h4>
            </div>
            <div onClick='changeTab(1)' class='obj__change__tabs__tab'>
                <h4>IMC</h4>
            </div>
            <div onClick='changeTab(2)' class='obj__change__tabs__tab'>
                <h4>IMG</h4>
            </div>
        </div>
        <!-- weight tab -->
        <div class='obj__change__tabsCont'>
            <div class="obj__change__tabsCont__errorCont obj__change__tabsCont__errorCont__weight"></div>
            <form id="objFormWeight" action="/suivi_poids/objectif" method="post">
                <h3></h3>
                <div>
                    <label for="objChangeWeight">poids</label>
                    <input type="number" name="objChangeWeight" id="changeWeight">
                </div>
                <input onClick="verifyChangingWeight()" type="button" value="ok">
            </form>
        </div>
        <!-- imc tab -->
        <div class='obj__change__tabsCont obj__change__tabsCont--hidden'>
            <div class="obj__change__tabsCont__errorCont obj__change__tabsCont__errorCont__imc"></div>
            <form id="objFormImc" action="/suivi_poids/objectif" method="post">
                <h3></h3>
                <div>
                    <label for="objChangeImc">imc</label>
                    <input type="number" name="objChangeImc" id="changeImc">
                </div>
                <input onClick="verifyChangingImc()" type="button" value="ok">
            </form>
        </div>
        <!-- img tab -->
        <div class='obj__change__tabsCont obj__change__tabsCont--hidden'>
            <div class="obj__change__tabsCont__errorCont obj__change__tabsCont__errorCont__img"></div>
            <form id="objFormImg" action="/suivi_poids/objectif" method="post">
                <h3></h3>
                <div>
                    <label for="objChangeImg">img</label>
                    <input type="number" name="objChangeImg" id="changeImg">
                </div>
                <input onClick="verifyChangingImg()" type="button" value="ok">
            </form>
        </div>
    </section>

    <section>       
        <?php foreach($objectifs as $objectif): ?>
            <?php if($objectif['current'] === 0): ?>
                <?php if($objectif['weight_goal'] !== null): ?>
                    <div>
                        <h3><?= $objectif['weight_goal']; ?> kg</h3>
                    </div>
                <?php elseif($objectif['imc_goal'] !== null): ?>
                    <div>
                        <h3><?= $objectif['imc_goal']; ?></h3>
                    </div>
                <?php elseif($objectif['img_goal'] !== null): ?>
                    <div>
                        <h3><?= $objectif['img_goal']; ?> %</h3>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        <?php endforeach; ?>    
    </section>

</main>

<script>
    const tabs = document.querySelectorAll('.obj__change__tabs__tab');
    const tabsCont = document.querySelectorAll('.obj__change__tabsCont'); 
    const errorWeight = document.querySelector('.obj__change__tabsCont__errorCont__weight');
    const errorImc = document.querySelector('.obj__change__tabsCont__errorCont__imc');
    const errorImg = document.querySelector('.obj__change__tabsCont__errorCont__img');
    const inputWeight = document.getElementById('changeWeight');
    const inputImc = document.getElementById('changeImc');
    const inputImg = document.getElementById('changeImg');
    const formWeight = document.getElementById('objFormWeight');
    const formImc = document.getElementById('objFormImc');
    const formImg = document.getElementById('objFormImg');
    
    const resetClass = () => {
        for(let i = 0; i < tabs.length; i++) {
            if(tabs[i].classList.contains('obj__change__tabs__tab--active')) {
                tabs[i].classList.remove('obj__change__tabs__tab--active');
            }
            if(tabsCont[i].classList.contains('obj__change__tabsCont--hidden')) {
                tabsCont[i].classList.remove('obj__change__tabsCont--hidden');
            }
        }
    };

    const changeTab = (tab) => {
        resetClass();
        tabs[tab].classList.add('obj__change__tabs__tab--active');
        for(let i = 0; i < tabsCont.length; i++) {
            if(tab !== i) {
                tabsCont[i].classList.add('obj__change__tabsCont--hidden');
            }
        }
    };

    const verifyChangingWeight = () => {
        let error = "";

        if(inputWeight.value === "") {
            error = '<p>- Le champ ne doit pas etre vide ou doit contenir que des chiffres.</p>';
        } else if (inputWeight.value < 31 || inputWeight.value > 249) {
            error = '<p>- Le poids doit etre compris entre 30 et 250 kg.</p>';           
        } 

        errorWeight.innerHTML = error;

        if(error === "") {
            formWeight.submit();
        }

    };
    
    const verifyChangingImc = () => {
        let error = "";
        
        if(inputImc.value === "") {
            error = '<p>- Le champ ne doit pas etre vide ou doit contenir que des chiffres.</p>';
        } else if (inputImc.value < 11 || inputImc.value > 79) {
            error = '<p>- L\'imc doit etre compris entre 10 et 80.</p>';           
        }

        errorImc.innerHTML = error;

        if(error === "") {
            formImc.submit();
        }

    };
    
    const verifyChangingImg = () => {
        let error = "";
        
        if(inputImg.value === "") {
            error = '<p>- Le champ ne doit pas etre vide ou doit contenir que des chiffres.</p>';
        } else if (inputImg.value < 1 || inputImg.value > 89) {
            error = '<p>- L\'img doit etre compris entre 1 et 90 %.</p>';           
        } 
    
        errorImg.innerHTML = error;

        if(error === "") {
            formImg.submit();
        }

    };
</script>

<?php $content = ob_get_clean(); ?>

<?php require('layout.php'); ?>