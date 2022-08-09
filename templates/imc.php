<?php $title = 'imc'; ?>
<?php $contentHead = "" ?>

<?php
    $now = new DateTime();
    $currentTimestamp = $now->getTimestamp();
    if(isset($_SESSION['name']) && isset($_SESSION['user']) && isset($_SESSION['userId']) && isset($_SESSION['size']) && (isset($_SESSION['sexe']) && ($_SESSION['sexe'] === "man" || $_SESSION['sexe'] === "woman")) && isset($_SESSION['auth']) && $_SESSION['auth'] === true) {
        if(!isset($_SESSION['exp']) || $_SESSION['exp'] < $currentTimestamp) {
            return header('Location: /suivi_poids/logout');
        }
    }
?>

<?php ob_start(); ?>

<header>
    <div class="hambMenu">
        <div onClick="toggleMobileMenu()" class="hambMenu__hambBtn">
            <img src="../suivi_poids/assets/hamburger.svg" alt="hamburger menu icon">
        </div>
        <div onClick="toggleMobileMenu()" class="hambMenu__closeBtn hambMenu__closeBtn--hidden">
            <img src="../suivi_poids/assets/closeHamb.svg" alt="close icon">
        </div>
    </div>
    <div class="header header--mobile">
        <a class="header__titleLink" href="/suivi_poids/"><h1>TITRE DU SITE</h1></a>
        <?php if(isset($_SESSION['name']) && isset($_SESSION['user']) && isset($_SESSION['userId']) && isset($_SESSION['size']) && (isset($_SESSION['sexe']) && ($_SESSION['sexe'] === "man" || $_SESSION['sexe'] === "woman")) && isset($_SESSION['auth']) && $_SESSION['auth'] === true): ?>
            <div class="header__connected">
                <a class='header__otherLink' href="/suivi_poids/img">IMG</a>
                <a class="header__connected__toDashboard" href="/suivi_poids/dashboard">Tableau de bord</a>
                <a class="header__connected__logoutBtn" href="/suivi_poids/logout">Se deconnecter</a>
                <a href="/suivi_poids/profil"><div class="header__connected__userProfil">
                    <img src="../suivi_poids/assets/user.svg" alt="user icon">
                </div></a>
            </div>
            <?php else: ?>
                <div class="header__notConnectBtns">
                <a class='header__otherLink' href="/suivi_poids/img">IMG</a>
                <a id="headerLogBtn" href="/suivi_poids/login">Se connecter</a>
                <a class="header__notConnectBtns__create" href="/suivi_poids/sign">Creer un compte</a>
            </div>
        <?php endif; ?>        
    </div>
</header>

<main class="bmi">

    <h2>Calculer votre indice de masse corporel (IMC).</h2>

    <?php if(isset($_SESSION['name']) && isset($_SESSION['user']) && isset($_SESSION['userId']) && isset($_SESSION['size']) && (isset($_SESSION['sexe']) && ($_SESSION['sexe'] === "man" || $_SESSION['sexe'] === "woman")) && isset($_SESSION['auth']) && $_SESSION['auth'] === true): ?>
        <section class="bmi__userSection"> 
            <p class="bmi__userSection__subTitle">Votre IMC est de</p>
            <h3><?= htmlspecialchars(floor($imcInfos['imc'])); ?></h3>

            <p>Avec votre IMC, vous etes (selon l'OMS) en </p>
            <h4><?php 
                if($imcInfos['imc'] < 16.5) {
                    echo "Maigreur extreme";
                } elseif($imcInfos['imc'] >= 16.5 && $imcInfos['imc'] < 18.5) {
                    echo "Maigreur";
                } elseif($imcInfos['imc'] >= 18.5 && $imcInfos['imc'] < 25) {
                    echo "Corpulence normale";
                } elseif($imcInfos['imc'] >= 25 && $imcInfos['imc'] < 30) {
                    echo "Surpoids";
                } elseif($imcInfos['imc'] >= 30 && $imcInfos['imc'] < 35) {
                    echo "Obésité modérée";
                } elseif($imcInfos['imc'] >= 35 && $imcInfos['imc'] < 40) {
                    echo "Obésité sévère";
                } elseif($imcInfos['imc'] >= 40) {
                    echo "Obésité morbide";
                }
            ?></h4>

            <p>Selon votre taille votre poids idéal se situe entre <?php 
                $size = $imcInfos['size'] / 100;
                echo htmlspecialchars(ceil(($size * $size) * 18.5));
                ?>kg et <?php
                echo htmlspecialchars(floor(($size * $size) * 25));  
            ?>kg.</p>
        </section>
    <?php endif; ?>

    <section class="bmi__tools">
        <p>L'indice de masse corporelle permet de rapidement évaluer votre corpulence avec votre poids et votre taille indépendamment de votre sexe.</p>
        <p>Il se calcul simplement en divisant le poids par le carré de la taille (en metre).Un IMC normal (selon l'OMS) se situe entre 18,5 et 25.</p>
        <p>Pour connaitre le votre, rien de plus simple, il vous suffit de remplir les champs ci dessous.</p>
        <div class="bmi__tools__error"></div>
        <form class="bmi__tools__form">
            <div class="bmi__tools__form__cont">
                <div class="bmi__tools__form__cont__field">
                    <label for="bmiSize">Taille en cm</label>
                    <input type="number" name="size" id="bmiSize" placeholder="175">
                </div>
                <div class="bmi__tools__form__cont__field">
                    <label for="bmiWeight">Poids en kg</label>
                    <input type="number" name="weight" id="bmiWeight" placeholder="80">
                </div>
            </div>
            <div class="bmi__tools__form__btnCont">
                <input onClick="verifyForm()" type="button" value="Calculer">
            </div>
        </form>
        <div class="bmi__tools__results bmi__tools__results--hidden">
                <p class="bmi__tools__results__title"></p>
                <p class="bmi__tools__results__score"></p>
        </div>
        <div class="bmi__tools__interpretation">
            <h3>Interprétation de l'IMC (selon l'OMS)</h3>
            <div class="bmi__tools__interpretation__array">
                <div class="bmi__tools__interpretation__array__row"><p class="bmi__tools__interpretation__array__row__score">En dessous de 16,5</p><p class="bmi__tools__interpretation__array__row__status">Maigreur extreme</p></div>
                <div class="bmi__tools__interpretation__array__row bmi__tools__interpretation__array__row--alt"><p class="bmi__tools__interpretation__array__row__score">Entre 16,5 et 18.4</p><p class="bmi__tools__interpretation__array__row__status">Maigreur</p></div>
                <div class="bmi__tools__interpretation__array__row"><p class="bmi__tools__interpretation__array__row__score">Entre 18.5 et 24.9</p><p class="bmi__tools__interpretation__array__row__status">Corpulence normal</p></div>
                <div class="bmi__tools__interpretation__array__row bmi__tools__interpretation__array__row--alt"><p class="bmi__tools__interpretation__array__row__score">Entre 25 et 29.9</p><p class="bmi__tools__interpretation__array__row__status">Surpoids</p></div>
                <div class="bmi__tools__interpretation__array__row"><p class="bmi__tools__interpretation__array__row__score">Entre 30 et 34.9</p><p class="bmi__tools__interpretation__array__row__status">Obésité modérée</p></div>
                <div class="bmi__tools__interpretation__array__row bmi__tools__interpretation__array__row--alt"><p class="bmi__tools__interpretation__array__row__score">Entre 35 et 39.9</p><p class="bmi__tools__interpretation__array__row__status">Obésité sévère</p></div>
                <div class="bmi__tools__interpretation__array__row"><p class="bmi__tools__interpretation__array__row__score">Au dessus de 40</p><p class="bmi__tools__interpretation__array__row__status">Obésité morbide</p></div>
            </div>
        </div>
    </section>
</main>

<script>
    const weight = document.getElementById('bmiWeight');
    const size = document.getElementById('bmiSize');

    const verifyForm = () => {
        const errorCont = document.querySelector(".bmi__tools__error");
        const error = document.createElement('p');
        
        errorCont.innerHTML = "";
        let err = false;
        
        if(weight.value === "" || size.value === "") {
            const errorMsg = '- Tous les champs sont requis.';
            errorCont.appendChild(error);
            return error.textContent = errorMsg;
        } else if (!weight.value.match(/^[0-9]*$/) || !size.value.match(/^[0-9]*$/)) {
            const errorMsg = '- Tous les champs doivent etre des nombres.';
            errorCont.appendChild(error);
            return error.textContent = errorMsg;
        } 
        if(weight.value < 30 || weight.value > 250) {
            const errorWeightCont = document.createElement('p');
            const weightError = '- Le poids doit etre compris entre 30 et 250 kg';
            errorCont.appendChild(errorWeightCont);
            errorWeightCont.textContent = weightError;
            err = true;
        }
        if(size.value < 90 || size.value > 260) {
            const errorSizeCont = document.createElement('p');
            const sizeError = '- La taille doit etre comprise entre 90 et 260 cm';
            errorCont.appendChild(errorSizeCont);
            errorSizeCont.textContent = sizeError;
            err = true;
        }
        if(!err) {
            calculBmi();
        }
    };

    const calculBmi = () => {
        const resultDiv = document.querySelector(".bmi__tools__results");
        const resultCont = document.querySelector(".bmi__tools__results__score");

        newSize = size.value / 100;
        result = weight.value / (newSize*newSize);

        resultDiv.classList.remove("bmi__tools__results--hidden");
        resultCont.textContent = Math.floor(result);
    };

    const toggleMobileMenu = () => {
        const hambBtn = document.querySelector(".hambMenu__hambBtn");
        const closeBtn = document.querySelector(".hambMenu__closeBtn");
        const header = document.querySelector('.header');

        if(hambBtn.classList.contains('hambMenu__hambBtn--hidden')) {
            hambBtn.classList.remove('hambMenu__hambBtn--hidden');
            closeBtn.classList.add('hambMenu__closeBtn--hidden');
            header.classList.add('header--mobile');
        } else {
            hambBtn.classList.add('hambMenu__hambBtn--hidden');
            closeBtn.classList.remove('hambMenu__closeBtn--hidden');
            header.classList.remove('header--mobile');
        }
    }
</script>

<?php $content = ob_get_clean(); ?>

<?php require('layout.php'); ?>