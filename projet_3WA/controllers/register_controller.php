<?php
// Type Hinting
declare(strict_types=1);

// Avant que l'on submit (les champs ne peuvent être saisi)
$isValid = null;

// Traitement si post
if (isset($_POST) && !empty($_POST)) {
    // Test $_POST exist
    // var_dump($_POST);
    // On part du principe que le post n'est pas vide et donc existant
    $isValid = true;
    // Extraction des données du form
    extract($_POST); //$name, $email, $password

    // Test fields - et check if not contain 'trim'
    if ($isValid && !in_array('', $_POST)) {
        // Check email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $isValid = false;
            // It's KO email
            $notif = "Email pourrit";
        } else {
            // Appel du model User
            require 'UserModel.php';
            // Instanciation
            $userM = new UserModel();
            // Usage de la méthode d'insertion
            $userQ = $userM->findByEmail($email);

            // test si user exist
            if ($userQ) {
                // No
                $isValid = false;
                // It's Ko ids
                $notif = "Identifiants déjà existant";
            } else {
                // Insertion du user
                // INSERT INTO user(firstname, lastname, email, pwd, created_at)
                //    VALUES (:prenom, :nom, :email, :pwd, NOW())
                require 'UserModel.php';
                // Instanciation
                $userM = new UserModel();
                // Usage de la méthode d'insertion
                $userM->create($name, $email, $pwd);

                // It's all right
                $notif = "Yeah y're registered";
            }
        }
    } else {
        $isValid = false;
        // It's KO empty
        $notif = "Les champs sont vides";
    }
}

// Définition des infos de la page
$pageTitle = 'Register Page'; // title
$template = 'register'; // vue

// 6 inclusion dans le template commun
include 'layout.phtml';
