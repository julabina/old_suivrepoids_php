<?php 
    $title = "A propos"; 
    $contentHead = "";
?>

<?php ob_start(); ?>

<?php $content = ob_get_clean(); ?>

<?php require('layout.php'); ?>