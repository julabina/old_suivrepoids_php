<!DOCTYPE html>
<html lang="fr">
   <head>
      <meta charset="utf-8" />
      <title><?= $title; ?></title>
      <link href="/suivi_poids/css/style.css" rel="stylesheet" type="text/css" /> 
      <?= $contentHead; ?>
   </head>
   <body>
      <?= $content; ?>
      <footer class="footer">
         <div class="footer__main">
            <h3>Copyright © - 2022</h3>
            <div class="footer__main__listCont">
               <ul>
                  <a href="/suivi_poids/about"><li>A propos</li></a>
                  <a href="/suivi_poids/cgu"><li>CGU</li></a>
                  <a href="/suivi_poids/contact"><li>Contact</li></a>
               </ul>
            </div>
         </div>
      </footer>
   </body>
</html>