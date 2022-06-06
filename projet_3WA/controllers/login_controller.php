<?php
// Type Hinting
declare(strict_types=1);

// Avant que l'on submit (les champs ne peuvent être saisi)
$isValid = null;

// Traitement si post
if (isset($_POST) && !empty($_POST)) {
    // Appel de la session pour utiliser les notif et l'insertion d'un user
    require 'Session.php';
    Session::init();
    // Test $_POST exist
    // On part du principe que le post n'est pas vide et donc existant
    $isValid = true;
    // Extraction des données du form
    extract($_POST); // $email, $pwd
    // Test fields - et check if not contain 'trim'
    if ($isValid && !in_array('', $_POST)) {
        // Check email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $isValid = false;
            // It's KO email
            $_SESSION['notif'] = 'Email pourrit';
        } else {
            // Appel du model User
            require 'UserModel.php';
            // Instanciation
            $userM = new UserModel();
            // Usage de la méthode d'insertion
            $userQ = $userM->findByEmail($email);

            // test si user exist
            if (!$userQ) {
                // No
                $isValid = false;
                // It's Ko ids
                $_SESSION['notif'] = 'Email inconnu';
            } else {
                // Test mdp
                if (!password_verify($pwd, $userQ['pwd'])) {
                    // No
                    $isValid = false;
                    // It's Ko ids
                    $_SESSION['notif'] = 'Password incorrect';
                } else {
                    // Auth
                    $_SESSION['user'] = [
                        'id' => $userQ['id'],
                        'name' => $userQ['name'],
                        'email' => $userQ['email']
                    ];
                    // Notif
                    $_SESSION['notif'] = 'Connected as ' . $userQ['name'];
                    // Redirection home
                    header('Location: index.php');
                    exit;
                }
            }
        }
    } else {
        $isValid = false;
        // Notif
        $_SESSION['notif'] = 'Les champs sont vides';
    }
}

// Définition des infos de la page
$pageTitle = 'Login Page'; // title
$template = 'login'; // vue

// 6 inclusion dans le template commun
include 'layout.phtml';
