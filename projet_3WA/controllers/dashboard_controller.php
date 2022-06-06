<?php
// Type Hinting
declare(strict_types=1);
// Traitement du form
$isAllowed = false;
// Faire un test si le user est présent dans la session
require 'Session.php';
Session::init();

if (Session::isAuth()) {
    // Appel du model User
    require 'UserModel.php';
    // Instanciation
    $userM = new UserModel();
    // Usage de la méthode d'insertion
    $users = $userM->findAll();
    // Test $users
    $isAllowed = $users ? true : false;
} else {
    // Si je ne suis pas connecté, alors je dois y aller
    header('location: index.php?page=login');
    exit;
}
// Alors il pourra visualiser la liste des users  (faut faire un requête hein pour les récup)

// Définition des infos de la page
$pageTitle = 'Back Office Page'; // title
$template = 'dashboard'; // vue

// 6 inclusion dans le template commun
include 'layout.phtml';
