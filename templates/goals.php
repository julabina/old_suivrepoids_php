<?php $title = 'objectif'; ?>
<?php $contentHead = "" ?>

<?php
    $now = new DateTime();
    $currentTimestamp = $now->getTimestamp();
    if(!isset($_SESSION['name']) || !isset($_SESSION['user']) || !isset($_SESSION['userId']) || !isset($_SESSION['size']) || (!isset($_SESSION['sexe']) || ($_SESSION['sexe'] !== "man" && $_SESSION['sexe'] !== "woman")) || !isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
        return header('Location: /suivi_poids/login');
    }
    if(!isset($_SESSION['exp']) || $_SESSION['exp'] < $currentTimestamp) {
        return header('Location: /suivi_poids/logoutexp');
    }
?>

<?php ob_start(); ?>

<header>
    <div class="header">
        <a class="header__titleLink" href="/suivi_poids/"><h1>TITRE DU SITE</h1></a>
        <div class="header__connected">
            <a class="header__connected__toDashboard" href="/suivi_poids/dashboard">Tableau de bord</a>
            <a class="header__connected__logoutBtn" href="/suivi_poids/logout">Se deconnecter</a>
            <a href="/suivi_poids/profil"><div class="header__connected__userProfil">
                <img src="../suivi_poids/assets/user.svg" alt="user icon">
            </div></a>
        </div>
    </div>
</header>

<main class="obj">

    <section class="obj__current">
        <h2>Mon objectif actuel</h2>

        <div class="obj__current__cont">
            <?php foreach($goals as $goal): ?>
                <?php if($goal['current_goal']): ?>
                    <?php if($goal['weight_goal'] === null && $goal['imc_goal'] === null && $goal['img_goal'] === null): ?>
                        <h3>Aucun objectif défini</h3>
                    <?php elseif($goal['weight_goal'] !== null): ?>
                        <h3>Atteindre <?= htmlspecialchars($goal['weight_goal']); ?> kg</h3>
                    <?php elseif($goal['imc_goal'] !== null): ?>
                        <h3>Atteindre un IMC de <?= htmlspecialchars($goal['imc_goal']); ?></h3>
                    <?php elseif($goal['img_goal'] !== null): ?>
                        <h3>Atteindre un IMG de <?= htmlspecialchars($goal['img_goal']); ?>%</h3>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>

    </section>

    <section class="obj__change">
        <h2>Changer d'objectif</h2>
        <div class='obj__change__tabs'>
            <div onClick='changeTab(0)' class='obj__change__tabs__tab obj__change__tabs__tab--active'>
                <h4>POIDS</h4>
            </div>
            <div onClick='changeTab(1)' class='obj__change__tabs__tab'>
                <h4>IMC</h4>
            </div>
            <div onClick='changeTab(2)' class='obj__change__tabs__tab'>
                <h4>IMG</h4>
            </div>
        </div>
        <div class="obj__change__errCont">
            <?php if(isset($_GET['err']) && $_GET['err'] === "obj"): ?>
                <p>- Une erreur est survenu.</p>
            <?php endif; ?>
        </div>
        <!-- weight tab -->
        <div class='obj__change__tabsCont'>
            <div class="obj__change__tabsCont__errorCont obj__change__tabsCont__errorCont__weight"></div>
            <form id="objFormWeight" action="/suivi_poids/objectif" method="post">
                <input type="hidden" name="token" value="<?= htmlspecialchars($_SESSION['token']); ?>">
                <div class='obj__change__tabsCont__input'>
                    <label for="objChangeWeight">Entrer le poids que vous souhaitez atteindre</label>
                    <input type="number" name="objChangeWeight" id="changeWeight" placeholder="Votre poids actuel: <?= $goal['user_weight']; ?> kg">
                </div>
                <div class="obj__change__tabsCont__submitBtnCont">
                    <input class="obj__change__tabsCont__submitBtnCont__btn" onClick="verifyChangingWeight()" type="button" value="Valider">
                </div>
            </form>
        </div>
        <!-- imc tab -->
        <div class='obj__change__tabsCont obj__change__tabsCont--hidden'>
            <div class="obj__change__tabsCont__errorCont obj__change__tabsCont__errorCont__imc"></div>
            <form id="objFormImc" action="/suivi_poids/objectif" method="post">
                <input type="hidden" name="token" value="<?= htmlspecialchars($_SESSION['token']); ?>">
                <div class='obj__change__tabsCont__input'>
                    <label for="objChangeImc">Entrer l'IMC que vous souhaitez atteindre</label>
                    <input type="number" name="objChangeImc" id="changeImc" placeholder="Votre IMC actuel: <?= $goal['imc']; ?>">
                </div>
                <div class="obj__change__tabsCont__submitBtnCont">
                    <input class="obj__change__tabsCont__submitBtnCont__btn" onClick="verifyChangingImc()" type="button" value="Valider">
                </div>
            </form>
        </div>
        <!-- img tab -->
        <div class='obj__change__tabsCont obj__change__tabsCont--hidden'>
            <div class="obj__change__tabsCont__errorCont obj__change__tabsCont__errorCont__img"></div>
            <form id="objFormImg" action="/suivi_poids/objectif" method="post">
                <input type="hidden" name="token" value="<?= htmlspecialchars($_SESSION['token']); ?>">
                <div class='obj__change__tabsCont__input'>
                    <label for="objChangeImg">Entrer l'IMG que vous souhaitez atteindre</label>
                    <input type="number" name="objChangeImg" id="changeImg" placeholder="Votre IMG actuel: <?= $goal['img']; ?>%">
                </div>
                <div class="obj__change__tabsCont__submitBtnCont">
                    <input class="obj__change__tabsCont__submitBtnCont__btn" onClick="verifyChangingImg()" type="button" value="Valider">
                </div>
            </form>
        </div>
    </section>

    <section class="obj__old">   
        <h2>Mes anciens objectifs</h2>    
        <?php foreach($goals as $goal): ?>
            <?php if($goal['current_goal'] === 0): ?>
                <?php
                    $goalDate = strtotime($goal['created_at']);
                    $newDate = date('d-m-Y', $goalDate);
                ?>
                <?php if($goal['weight_goal'] !== null): ?>
                    <article class="obj__old__card">
                        <h3>Atteindre <?= htmlspecialchars($goal['weight_goal']); ?> kg</h3>
                        <p>le <?= htmlspecialchars($newDate); ?>.</p>
                    </article>
                <?php elseif($goal['imc_goal'] !== null): ?>
                    <article class="obj__old__card">
                        <h3>Atteindre un IMC de <?= htmlspecialchars($goal['imc_goal']); ?></h3>
                        <p>le <?= htmlspecialchars($newDate); ?>.</p>
                    </article>
                <?php elseif($goal['img_goal'] !== null): ?>
                    <article class="obj__old__card">
                        <h3>Atteindre un IMG de <?= htmlspecialchars($goal['img_goal']); ?>%</h3>
                        <p>le <?= htmlspecialchars($newDate); ?>.</p>
                    </article>
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
        } else if (inputWeight.value < 30 || inputWeight.value > 260) {
            error = '<p>- Le poids doit etre compris entre 30 et 260 kg.</p>';           
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
        } else if (inputImc.value < 10 || inputImc.value > 80) {
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
        } else if (inputImg.value < 1 || inputImg.value > 90) {
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