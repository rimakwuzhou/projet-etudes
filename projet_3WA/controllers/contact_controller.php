<?php

// Tratement du form post
if (
    isset($_POST)
    && !empty($_POST)
) {
    var_dump($_POST);
    die;
}



// Définition des infos de la page
$pageTitle = 'Contact Page'; // title
$template = 'contact'; // vue contact.phtml

// 6 inclusion dans le template commun
include 'layout.phtml';
