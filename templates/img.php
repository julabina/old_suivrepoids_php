<?php $title = 'img'; ?>
<?php $contentHead = "" ?>

<?php ob_start(); ?>

<header>
    <div class="header">
        <a class="header__titleLink" href="/suivi_poids/"><h1>TITRE DU SITE</h1></a>
        <?php if(isset($_SESSION['name']) && isset($_SESSION['user']) && isset($_SESSION['userId']) && isset($_SESSION['size']) && (isset($_SESSION['sexe']) && ($_SESSION['sexe'] === "man" || $_SESSION['sexe'] === "woman")) && isset($_SESSION['auth']) && $_SESSION['auth'] === true): ?>
            <div class="header__connected">
                <a class='header__otherLink' href="/suivi_poids/imc">IMC</a>
                <a class="header__connected__toDashboard" href="/suivi_poids/dashboard">Tableau de bord</a>
                <a class="header__connected__logoutBtn" href="/suivi_poids/logout">Se deconnecter</a>
                <a href="/suivi_poids/profil"><div class="header__connected__userProfil">
                    <img src="../suivi_poids/assets/user.svg" alt="user icon">
                </div></a>
            </div>
        <?php else: ?>
            <div class="header__notConnectBtns">
                <a class='header__otherLink' href="/suivi_poids/imc">IMC</a>
                <a id="headerLogBtn" href="/suivi_poids/login">Se connecter</a>
                <a class="header__notConnectBtns__create" href="/suivi_poids/sign">Creer un compte</a>
            </div>
        <?php endif; ?> 
    </div>
</header>

<main class="bfp">

    <h2>Calculer votre indice de masse graisseuse (IMG).</h2>

    <?php if(isset($_SESSION['name']) && isset($_SESSION['user']) && isset($_SESSION['userId']) && isset($_SESSION['size']) && (isset($_SESSION['sexe']) && ($_SESSION['sexe'] === "man" || $_SESSION['sexe'] === "woman")) && isset($_SESSION['auth']) && $_SESSION['auth'] === true): ?>
        <section class="bfp__userSection">
            <p class="bfp__userSection__subTitle">Votre IMG est de</p>
            <h3><?= htmlspecialchars($imgInfos['img']); ?>%</h3>

            <p>Avec votre IMG, vous etes (selon Deurenberg)</p>
            <h4><?php 
                if($imgInfos['is_man'] === 0) {
                    if($imgInfos['age'] < 25) {
                        if($imgInfos['img'] < 22) {
                            echo "Trop maigre";
                        } elseif($imgInfos > 29) {
                            echo "En excedent de graisse";
                        } else {
                            echo "Normal";
                        }
                    } elseif($imgInfos['age'] < 30 && $imgInfos['age'] >= 25) {
                        if($imgInfos['img'] < 23) {
                            echo "Trop maigre";
                        } elseif($imgInfos > 30) {
                            echo "En excedent de graisse";
                        } else {
                            echo "Normal";
                        }
                    } elseif($imgInfos['age'] < 40 && $imgInfos['age'] >= 30) {
                        if($imgInfos['img'] < 24) {
                            echo "Trop maigre";
                        } elseif($imgInfos > 31) {
                            echo "En excedent de graisse";
                        } else {
                            echo "Normal";
                        }
                    } elseif($imgInfos['age'] < 45 && $imgInfos['age'] >= 40) {
                        if($imgInfos['img'] < 25) {
                            echo "Trop maigre";
                        } elseif($imgInfos > 33) {
                            echo "En excedent de graisse";
                        } else {
                            echo "Normal";
                        }
                    } elseif($imgInfos['age'] < 50 && $imgInfos['age'] >= 45) {
                        if($imgInfos['img'] < 27) {
                            echo "Trop maigre";
                        } elseif($imgInfos > 34) {
                            echo "En excedent de graisse";
                        } else {
                            echo "Normal";
                        }
                    } elseif($imgInfos['age'] < 60 && $imgInfos['age'] >= 50) {
                        if($imgInfos['img'] < 29) {
                            echo "Trop maigre";
                        } elseif($imgInfos > 36) {
                            echo "En excedent de graisse";
                        } else {
                            echo "Normal";
                        }
                    } elseif($imgInfos['age'] >= 60) {
                        if($imgInfos['img'] < 31) {
                            echo "Trop maigre";
                        } elseif($imgInfos > 38) {
                            echo "En excedent de graisse";
                        } else {
                            echo "Normal";
                        }
                    }
                } elseif($imgInfos['is_man'] === 1) {
                    if($imgInfos['age'] < 25) {
                        if($imgInfos['img'] < 8) {
                            echo "Trop maigre";
                        } elseif($imgInfos > 17) {
                            echo "En excedent de graisse";
                        } else {
                            echo "Normal";
                        }
                    } elseif($imgInfos['age'] < 30 && $imgInfos['age'] >= 25) {
                        if($imgInfos['img'] < 11) {
                            echo "Trop maigre";
                        } elseif($imgInfos > 18) {
                            echo "En excedent de graisse";
                        } else {
                            echo "Normal";
                        }
                    } elseif($imgInfos['age'] < 40 && $imgInfos['age'] >= 30) {
                        if($imgInfos['img'] < 12) {
                            echo "Trop maigre";
                        } elseif($imgInfos > 19) {
                            echo "En excedent de graisse";
                        } else {
                            echo "Normal";
                        }
                    } elseif($imgInfos['age'] < 45 && $imgInfos['age'] >= 40) {
                        if($imgInfos['img'] < 13) {
                            echo "Trop maigre";
                        } elseif($imgInfos > 21) {
                            echo "En excedent de graisse";
                        } else {
                            echo "Normal";
                        }
                    } elseif($imgInfos['age'] < 50 && $imgInfos['age'] >= 45) {
                        if($imgInfos['img'] < 15) {
                            echo "Trop maigre";
                        } elseif($imgInfos > 22) {
                            echo "En excedent de graisse";
                        } else {
                            echo "Normal";
                        }
                    } elseif($imgInfos['age'] < 60 && $imgInfos['age'] >= 50) {
                        if($imgInfos['img'] < 17) {
                            echo "Trop maigre";
                        } elseif($imgInfos > 24) {
                            echo "En excedent de graisse";
                        } else {
                            echo "Normal";
                        }
                    } elseif($imgInfos['age'] >= 60) {
                        if($imgInfos['img'] < 19) {
                            echo "Trop maigre";
                        } elseif($imgInfos > 26) {
                            echo "En excedent de graisse";
                        } else {
                            echo "Normal";
                        }
                    }
                }
            ?></h4>
        </section>
    <?php endif; ?>

    <section class="bfp__tools">
        <p>L'indice de masse grasse permet de définir la proportion de graisse dans le corps.</p>
        <p>Il se calcul en fonction du sexe et de l'age de l'individu, grace à la formule de Deurenberg.</p>
        <ul>
            <li><p>Chez l' homme : <span>IMG (en %) = (1.20 x IMC) + (0.23 x Age) - (10.8 x 1) - 5.4</span></p></li>
            <li><p>Chez la femme : <span>IMG (en %) = (1.20 x IMC) + (0.23 x Age) - (10.8 x 0) - 5.4</span></p></li>
        </ul>
        <p>Pour connaitre le votre, rien de plus simple, il vous suffit de remplir les champs ci dessous.</p>
        <div class="bfp__tools__error"></div>
        <form class="bfp__tools__form">
            <div class="bfp__tools__form__cont">
                <div class="bfp__tools__form__cont__field">
                    <label for="bfpSize">Taille en cm</label>
                    <input type="number" name="size" id="bfpSize" placeholder="175">
                </div>
                <div class="bfp__tools__form__cont__field">
                    <label for="bfpWeight">Poids en kg</label>
                    <input type="number" name="weight" id="bfpWeight" placeholder="80">
                </div>
            </div>
            <div class="bfp__tools__form__cont">
                <div class="bfp__tools__form__cont__field">
                    <label for="bfpAge">Age</label>
                    <input type="number" name="age" id="bfpAge" placeholder="30">
                </div>
                <div class="bfp__tools__form__cont__field">
                    <label for="bfpSexe">Sexe</label>
                    <select name="sexe" id="bfpSexe">
                        <option value="man" default>Homme</option>
                        <option value="woman">Femme</option>
                    </select>
                </div>
            </div>
            <div class="bfp__tools__form__btnCont">
                <input onClick="verifyForm()" type="button" value="Calculer">
            </div>
        </form>
        <div class="bfp__tools__results bfp__tools__results--hidden">
                <p class="bfp__tools__results__title"></p>
                <p class="bfp__tools__results__score"></p>
        </div>
        <div class="bfp__tools__interpretation">
            <h3>Interprétation de l'IMG</h3>
            <p class="bfp__tools__interpretation__about">Vous trouverez ci-dessous un tableau qui indique l'indice de masse graisseuse idéal suivant votre age et votre sexe.</p>
            <p class="bfp__tools__interpretation__about">Si votre résultat est en dessous vous etes trop maigre, et au contraire s'il est au dessus vous avez un excedent de graisse.</p>
            <h4>Si vous etes un homme</h4>
            <div class="bfp__tools__interpretation__array">
                <div class="bfp__tools__interpretation__array__row"><p class="bfp__tools__interpretation__array__row__value">Entre 18 et 24 ans, votre IMG idéal est compris entre 8% et 17%</p></div>
                <div class="bfp__tools__interpretation__array__row bfp__tools__interpretation__array__row--alt"><p class="bfp__tools__interpretation__array__row__value">Entre 25 et 29 ans, votre IMG idéal est compris entre 11% et 18%</p></div>
                <div class="bfp__tools__interpretation__array__row"><p class="bfp__tools__interpretation__array__row__value">Entre 30 et 39 ans, votre IMG idéal est compris entre 12% et 19%</p></div>
                <div class="bfp__tools__interpretation__array__row bfp__tools__interpretation__array__row--alt"><p class="bfp__tools__interpretation__array__row__value">Entre 40 et 44 ans, votre IMG idéal est compris entre 13% et 21%</p></div>
                <div class="bfp__tools__interpretation__array__row"><p class="bfp__tools__interpretation__array__row__value">Entre 45 et 49 ans, votre IMG idéal est compris entre 15% et 22%</p></div>
                <div class="bfp__tools__interpretation__array__row bfp__tools__interpretation__array__row--alt"><p class="bfp__tools__interpretation__array__row__value">Entre 50 et 59 ans, votre IMG idéal est compris entre 17% et 24%</p></div>
                <div class="bfp__tools__interpretation__array__row"><p class="bfp__tools__interpretation__array__row__value">A partir de 60 ans, votre IMG idéal est compris entre 19% et 26%</p></div>
            </div>
            <h4>Si vous etes une femme</h4>
            <div class="bfp__tools__interpretation__array">
                <div class="bfp__tools__interpretation__array__row"><p class="bfp__tools__interpretation__array__row__value">Entre 18 et 24 ans, votre IMG idéal est compris entre 22% et 29%</p></div>
                <div class="bfp__tools__interpretation__array__row bfp__tools__interpretation__array__row--alt"><p class="bfp__tools__interpretation__array__row__value">Entre 25 et 29 ans, votre IMG idéal est compris entre 23% et 30%</p></div>
                <div class="bfp__tools__interpretation__array__row"><p class="bfp__tools__interpretation__array__row__value">Entre 30 et 39 ans, votre IMG idéal est compris entre 24% et 31%</p></div>
                <div class="bfp__tools__interpretation__array__row bfp__tools__interpretation__array__row--alt"><p class="bfp__tools__interpretation__array__row__value">Entre 40 et 44 ans, votre IMG idéal est compris entre 25% et 33%</p></div>
                <div class="bfp__tools__interpretation__array__row"><p class="bfp__tools__interpretation__array__row__value">Entre 45 et 49 ans, votre IMG idéal est compris entre 27% et 34%</p></div>
                <div class="bfp__tools__interpretation__array__row bfp__tools__interpretation__array__row--alt"><p class="bfp__tools__interpretation__array__row__value">Entre 50 et 59 ans, votre IMG idéal est compris entre 29% et 36%</p></div>
                <div class="bfp__tools__interpretation__array__row"><p class="bfp__tools__interpretation__array__row__value">A partir de 60 ans, votre IMG idéal est compris entre 31% et 38%</p></div>
            </div>
            <p class='bfp__tools__disclaimer'>Ces valeurs sont à titre indicatif, et ne remplace pas l'avis d'un medecin.</p>
        </div>
    </section>

</main>

<script>
    const weight = document.getElementById('bfpWeight');
    const size = document.getElementById('bfpSize');
    const age = document.getElementById('bfpAge');
    const sexe = document.getElementById('bfpSexe');

    const verifyForm = () => {
        const errorCont = document.querySelector(".bfp__tools__error");
        const error = document.createElement('p');

        errorCont.innerHTML = "";
        let err = false;

        if(weight.value === "" || size.value === "" || age.value === "") {
            const errorMsg = '- Tous les champs sont requis.';
            errorCont.appendChild(error);
            return error.textContent = errorMsg;
        } else if (!weight.value.match(/^[0-9]*$/) || !size.value.match(/^[0-9]*$/) || !age.value.match(/^[0-9]*$/)) {
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
        if(age.value < 18 || age.value > 100) {
            const errorAgeCont = document.createElement('p');
            const ageError = "- L'age doit etre compris entre 18 et 100";
            errorCont.appendChild(errorAgeCont);
            errorAgeCont.textContent = ageError;
            err = true;
        }
        if(!err) {
            calculBfp();
        }
    };
        
    const calculBfp = () => {
        const resultDiv = document.querySelector(".bfp__tools__results");
        const resultCont = document.querySelector(".bfp__tools__results__score");
    
        newSize = size.value / 100;
        imc = Math.floor(weight.value / (newSize*newSize));

        resultDiv.classList.remove("bfp__tools__results--hidden");
        if(sexe.value === "man") {
            result = (1.2*imc)+(0.23*age.value)-(10.8*1)-5.4;
        } else if(sexe.value === "woman") {
            result = (1.2*imc)+(0.23*age.value)-(10.8*0)-5.4;
        }
        resultCont.textContent = Math.floor(result) + "%";
    };
</script>

<?php $content = ob_get_clean(); ?>

<?php require('layout.php'); ?>