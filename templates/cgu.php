<?php 
    $title = "Cgu"; 
    $contentHead = "";
    SESSION_START();
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
                <a class="header__connected__toDashboard" href="/suivi_poids/dashboard">Tableau de bord</a>
                <a class="header__connected__logoutBtn" href="/suivi_poids/logout">Se deconnecter</a>
                <a href="/suivi_poids/profil"><div class="header__connected__userProfil">
                    <img src="../suivi_poids/assets/user.svg" alt="user icon">
                </div></a>
            </div>
            <?php else: ?>
                <div class="header__notConnectBtns">
                <a id="headerLogBtn" href="/suivi_poids/login">Se connecter</a>
                <a class="header__notConnectBtns__create" href="/suivi_poids/sign">Creer un compte</a>
            </div>
        <?php endif; ?>        
    </div>
</header>

<main class="cgu">
    <section class="cgu__section">
        <h2>Conditions Générales d'Utilisation</h2>
            <p class="cgu__section__started">En vigueur au 07/08/2022</p>

            <p>Les présentes conditions générales d'utilisation (dites « CGU ») ont pour objet l'encadrement juridique des modalités de mise à disposition du site et des services par _______________ et de définir les conditions d’accès et d’utilisation des services par « l'Utilisateur ».</p>
            <p class="cgu__section__space">Les présentes CGU sont accessibles sur le site à la rubrique «CGU».</p>

            <p>Toute inscription ou utilisation du site implique l'acceptation sans aucune réserve ni restriction des présentes CGU par l’utilisateur. Lors de l'inscription sur le site via le Formulaire d’inscription, chaque utilisateur accepte expressément les présentes CGU en cochant la case précédant le texte suivant : « J'ai lu et j'accepte les Conditions Générales d'Utilisation ».</p>     
            <p>En cas de non-acceptation des CGU stipulées dans le présent contrat, l'Utilisateur se doit de renoncer à l'accès des services proposés par le site.</p>     
            <p>TITRE_SITE.com se réserve le droit de modifier unilatéralement et à tout moment le contenu des présentes CGU.</p>   
        
        <h3>Article 1 : Les mentions légales</h3>

            <p>L'hébergeur du site TITRE_SITE.com est la société Digitalocean LLC, dont le siège social est situé au 101 Avenue of the Americas 10th Floor New York, NY 10013 United States.</p>
            <p>L'hébergeur detient toutes les informations concernant l'éditeur du site.</p>

        <h3>Article 2 : Accès au site</h3>

            <p>Le site TITRE_SITE.com permet à l'Utilisateur un accès gratuit aux services suivants :</p>
            <p>Le site internet propose les services suivants :</p>
            <p>- éditer et suivre sa courbe de poids.</p>
            <p>- éditer et suivre ses objectifs de perte de poids.</p>
            <p class="cgu__section__space">Le site est accessible gratuitement en tout lieu à tout Utilisateur ayant un accès à Internet. Tous les frais supportés par l'Utilisateur pour accéder au service (matériel informatique, logiciels, connexion Internet, etc.) sont à sa charge.</p>

            <p>L’Utilisateur non membre n'a pas accès aux services réservés. Pour cela, il doit s’inscrire en remplissant le formulaire. En acceptant de s’inscrire aux services réservés, l’Utilisateur membre s’engage à fournir des informations sincères et exactes concernant son état civil et ses coordonnées, notamment son adresse email.</p>
            <p>Pour accéder aux services, l’Utilisateur doit ensuite s'identifier à l'aide de son identifiant et de son mot de passe qui lui seront communiqués après son inscription.</p>
            <p>Tout Utilisateur membre régulièrement inscrit pourra également solliciter sa désinscription en se rendant à la page dédiée sur son espace personnel. Celle-ci sera effective dans un délai raisonnable.</p>
            <p>Tout événement dû à un cas de force majeure ayant pour conséquence un dysfonctionnement du site ou serveur et sous réserve de toute interruption ou modification en cas de maintenance, n'engage pas la responsabilité de TITRE_SITE.com. Dans ces cas, l’Utilisateur accepte ainsi ne pas tenir rigueur à l’éditeur de toute interruption ou suspension de service, même sans préavis.</p>
            <p>L'Utilisateur a la possibilité de contacter le site via le formulaire de <a href="/suivi_poids/contact">contact</a>.</p>

        <h3>Article 3 : Collecte des données</h3>

            <p>Le site assure à l'Utilisateur une collecte et un traitement d'informations personnelles dans le respect de la vie privée conformément à la loi n°78-17 du 6 janvier 1978 relative à l'informatique, aux fichiers et aux libertés. Le site est déclaré à la CNIL sous le numéro _______________.</p>
            <p>En vertu de la loi Informatique et Libertés, en date du 6 janvier 1978, l'Utilisateur dispose d'un droit d'accès, de rectification, de suppression et d'opposition de ses données personnelles. L'Utilisateur exerce ce droit :</p>
            <p>· via son espace personnel ;</p>

        <h3>Article 4 : Propriété intellectuelle</h3>

            <p class="cgu__section__space">Les marques, logos, signes ainsi que tous les contenus du site (textes, images, son...) font l'objet d'une protection par le Code de la propriété intellectuelle et plus particulièrement par le droit d'auteur.</p>
            
            <p>L'Utilisateur doit solliciter l'autorisation préalable du site pour toute reproduction, publication, copie des différents contenus. Il s'engage à une utilisation des contenus du site dans un cadre strictement privé, toute utilisation à des fins commerciales et publicitaires est strictement interdite.</p>
            <p>Toute représentation totale ou partielle de ce site par quelque procédé que ce soit, sans l’autorisation expresse de l’exploitant du site Internet constituerait une contrefaçon sanctionnée par l’article L 335-2 et suivants du Code de la propriété intellectuelle.</p>
            <p class="cgu__section__space">Il est rappelé conformément à l’article L122-5 du Code de propriété intellectuelle que l’Utilisateur qui reproduit, copie ou publie le contenu protégé doit citer l’auteur et sa source.</p>

            <p>CGU réalisées avec <a href="http://legalplace.fr/">legalplace</a></p>

        <h3>Article 5 : Responsabilité</h3>

            <p>Les sources des informations diffusées sur le site TITRE_SITE.com sont réputées fiables mais le site ne garantit pas qu’il soit exempt de défauts, d’erreurs ou d’omissions.</p>
            <p>Les informations communiquées sont présentées à titre indicatif et général sans valeur contractuelle.</p>
            <p>Malgré des mises à jour régulières, le site TITRE_SITE.com ne peut être tenu responsable de la modification des dispositions administratives et juridiques survenant après la publication. De même, le site ne peut être tenue responsable de l’utilisation et de l’interprétation de l’information contenue dans ce site.</p>
            <p>L'Utilisateur s'assure de garder son mot de passe secret. Toute divulgation du mot de passe, quelle que soit sa forme, est interdite. Il assume les risques liés à l'utilisation de son identifiant et mot de passe. Le site décline toute responsabilité.</p>
            <p>Le site TITRE_SITE.com ne peut être tenu pour responsable d’éventuels virus qui pourraient infecter l’ordinateur ou tout matériel informatique de l’Internaute, suite à une utilisation, à l’accès, ou au téléchargement provenant de ce site.</p>
            <p>La responsabilité du site ne peut être engagée en cas de force majeure ou du fait imprévisible et insurmontable d'un tiers.</p>

        <h3>Article 6 : Lien hypertextes</h3>

            <p>Des liens hypertextes peuvent être présents sur le site. L’Utilisateur est informé qu’en cliquant sur ces liens, il sortira du site TITRE_SITE.com. Ce dernier n’a pas de contrôle sur les pages web sur lesquelles aboutissent ces liens et ne saurait, en aucun cas, être responsable de leur contenu.</p>

        <h3>Article 7 : Cookies</h3>

            <p>L’Utilisateur est informé que lors de ses visites sur le site, un cookie peut s’installer automatiquement sur son logiciel de navigation.</p>
            <p>Les cookies sont de petits fichiers stockés temporairement sur le disque dur de l’ordinateur de l’Utilisateur par votre navigateur et qui sont nécessaires à l’utilisation du site TITRE_SITE.com. Les cookies ne contiennent pas d’information personnelle et ne peuvent pas être utilisés pour identifier quelqu’un. Un cookie contient un identifiant unique, généré aléatoirement et donc anonyme. Certains cookies expirent à la fin de la visite de l’Utilisateur, d’autres restent.</p>
            <p>L’information contenue dans les cookies est utilisée pour améliorer le site TITRE_SITE.com.</p>
            <p>En naviguant sur le site, L’Utilisateur les accepte.</p>
            <p>L’Utilisateur doit toutefois donner son consentement quant à l’utilisation de certains cookies.</p>
            <p>A défaut d’acceptation, l’Utilisateur est informé que certaines fonctionnalités ou pages risquent de lui être refusées.</p>
            <p>L’Utilisateur pourra désactiver ces cookies par l’intermédiaire des paramètres figurant au sein de son logiciel de navigation.</p>

        <h3>Article 8 : Droit applicable et juridiction compétente</h3>

            <p>La législation française s'applique au présent contrat. En cas d'absence de résolution amiable d'un litige né entre les parties, les tribunaux français seront seuls compétents pour en connaître.</p>
            <p>Pour toute question relative à l’application des présentes CGU, vous pouvez joindre l’éditeur aux coordonnées inscrites à l’ARTICLE 1.</p>
    </section>
</main>

<script>
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
    };
</script>

<?php $content = ob_get_clean(); ?>

<?php require('layout.php'); ?>