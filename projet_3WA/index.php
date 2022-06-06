<?php
// 1
// Chef d'orchestre
// On arrive ici quoi qu'il arrive en 1er
// Définition de la route à appeler

// Importe les routes de l'app
require 'routing.php';
/*
    3
    Tests
    isset -> check si le get est dispo
    array_key_exists -> check si on me demande bien une page
    in_array -> check si la page demandée exists dans nos routes
*/
// exemple de route index.php?totofaitduvelo
if (
    isset($_GET)
    && array_key_exists('page', $_GET)
    && array_key_exists($_GET['page'], $routes)
) {
    // 4 Redirection vers le controlleur souhaité
    header('Location: ' . $routes[$_GET['page']]);
    exit;
} else {
    // Page chargée par defaut
    header('Location: ' . $routes['home']);
    exit;
}
