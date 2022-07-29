<?php $title = 'dashboard'; ?>
<?php ob_start(); ?>

    <script src="https://www.gstatic.com/charts/loader.js"></script>
    <script>

        google.charts.load('current', {
            packages: ['corechart']
        });
    
        const drawChart = () => {
            const dataChart = new google.visualization.DataTable();
            dataChart.addColumn('date', 'lastWeight');
            dataChart.addColumn('number', 'Poids');
            dataChart.addColumn({type: 'string', role: 'tooltip'});                      
            dataChart.addRows([
                <?php foreach($userWeightList as $row): ?>
                    [ new Date(<?= date('Y, m, d', strtotime($row->recordDate)); ?>),  <?= $row->weight; ?>, '<?= $row->weight; ?>kg le <?= date('d/m/Y', strtotime($row->recordDate)); ?>'],
                <?php endforeach; ?>                    
            ]);
                
            const chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
                
            const options = {
                title: 'Vos derniers poids ajoutés',
                hAxis: {
                    title: 'Temps',  
                    titleTextStyle: {color: '#333'},
                    format: 'dd/MM/yy',
                    gridlines: {count: 10} 
                },
                vAxis: {
                    minValue: 0,
                    gridlines: {color: 'none'}
                },
                colors: ['#0C2E8A'],
                pointSize: 5,
                pointShape: 'square',
                backgroundColor: '#FDFDFD',
                /* legend: 'none', */
            };
            
            // Instantiate and draw the chart.
            chart.draw(dataChart, options);
        }
        
        google.charts.setOnLoadCallback(drawChart);
        </script>

<?php $contentHead = ob_get_clean(); ?>

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
        <div class="header__connected">
            <a class="header__connected__logoutBtn" href="/suivi_poids/logout">Se deconnecter</a>
            <a href="/suivi_poids/profil"><div class="header__connected__userProfil">
                <img src="../suivi_poids/assets/user.svg" alt="user icon">
            </div></a>
        </div>
    </div>
</header>

<main class="dash">
    <?php
    echo "////////////////////////////////////////////////////////////////////////////////////////////////";echo "<br />";
    echo "////////////////////////////////////////////////////////////////////////////////////////////////";echo "<br />";
    echo "////////////////////// MOIS POUR CHART PAS LE BON ////////////////////////";echo "<br />";
    echo "////////////////////////////////////////////////////////////////////////////////////////////////";echo "<br />";
    echo "////////////////////////////////////////////////////////////////////////////////////////////////";echo "<br />";
    echo "<pre>";
    print_r($userWeightList);
    echo "</pre>";
    ?>
    <section class="dash__infos">
        <h2>Tableau de bord</h2>
        <div class="dash__infos__errorCont">
        <?php if(isset($_GET['err']) && $_GET['err'] === "addW"): ?>
                <p>- Une erreur est survenu, impossible d'ajouter un nouveau poids.</p>
            <?php endif; ?>
        </div>
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
    <section class='dash__graph'>
        <div class="dash__graph__mainCont">
            <div class="dash__graph__mainCont__tabs">
                <div onClick="handleGraph('line')" class="dash__graph__mainCont__tabs__tab dash__graph__mainCont__tabs__tab--active"><p>Graphique</p></div>
                <div onClick="handleGraph('list')" class="dash__graph__mainCont__tabs__tab"><p>Liste</p></div>
            </div>
            <div class="dash__graph__mainCont__graphNav">
                <select name="" id="">
                    <option value=""></option>
                </select>
            </div>
            <div class="dash__graph__mainCont__graph" id="chart_div">
            </div>
            <div class="dash__graph__mainCont__graph dash__graph__mainCont__graph--bot dash__graph__mainCont__graph--hidden">
                <?php foreach($userWeightList as $weight): ?>
                    <div class="dash__graph__mainCont__graph__row">
                        <div class=""><p><?= date('d/m/Y',strtotime($weight->recordDate)); ?></p></div>
                        <div class=""><p><?= $weight->weight; ?></p></div>
                        <div class=""><p><?= $weight->bmi; ?></p></div>
                        <div class=""><p><?= $weight->bfp; ?></p></div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</main>

<!-- modal add weight begin -->
<section class="dashAddWeight dashAddWeight--hidden">
    <div class="dashAddWeight__modal">
        <p onClick="handleModal()" class="dashAddWeight__modal__close">X</p>
        <form class="dashAddWeight__modal__form" action="/suivi_poids/addWeight" method="post">
            <input type="hidden" name="token" value="<?= $_SESSION['token']; ?>">
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
        } else if(addWeight.value < 30) {
            modalError = '- Le poids doit etre superieur à 30 kg.';
        } else if(addWeight.value > 260) {
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

    const handleGraph = (graph) => {
        const tabs = document.querySelectorAll('.dash__graph__mainCont__tabs__tab');
        const graphs = document.querySelectorAll('.dash__graph__mainCont__graph');

        if(graph === "list") {
            tabs[1].classList.add('dash__graph__mainCont__tabs__tab--active');
            tabs[0].classList.remove('dash__graph__mainCont__tabs__tab--active');
            graphs[0].classList.add('dash__graph__mainCont__graph--hidden');
            graphs[1].classList.remove('dash__graph__mainCont__graph--hidden');
        }else if(graph === "line") {
            tabs[0].classList.add('dash__graph__mainCont__tabs__tab--active');
            tabs[1].classList.remove('dash__graph__mainCont__tabs__tab--active');
            graphs[1].classList.add('dash__graph__mainCont__graph--hidden');
            graphs[0].classList.remove('dash__graph__mainCont__graph--hidden');
        } 
    };

</script>

<?php $content = ob_get_clean(); ?>

<?php require('layout.php'); ?>