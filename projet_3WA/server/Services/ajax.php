<?php
// Test du post, si vide
//var_dump($_POST);

// test si le post exist et n'est pas vide
// si les champs dans le post ne sont pas vide
try {
    if (!isset($_POST) || empty($_POST)) throw new LogicException("Pas de formulaire à traiter");

    // Déterminer quel form je dois traiter
    extract($_POST);

    // 4 - Étape du workflow Ajax - Déterminer quel form on doit traiter
    // 5 - Étape du workflow Ajax - Procéder à l'action vis-à-vis du Model (si besoin de requête SQL)
    switch ($action) {
        case 'insert':
            // 5 - Étape du workflow Ajax - Procéder à l'action
            // Test fields - et check if not contain 'trim'
            if (in_array('', $_POST)) throw new LogicException("Impossible de soumettre le form, un champ est vide");
            // Check email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) throw new LogicException("Email pourrit");

            // Connexion bdd
            require_once '../cnx.php'; // $pdo
            // User test
            $userQ = $pdo->prepare('SELECT id FROM user WHERE email = :mail');
            $userQ->execute([':mail' => $email]);
            $userQ = $userQ->fetch();
            // test si user exist
            if ($userQ) throw new LogicException("Un utilisateur exist déjà avec cet email");
            else {
                // Insertion du user
                $insert = $pdo->prepare(
                    'INSERT INTO user(name, email, password, created_at)
                    VALUES (:nom, :mail, :pwd, NOW())'
                );
                // Commit ma requête
                // usage du password_hash pour proteger le password (bcrypt)
                $id = $insert->execute([
                    ':nom'     => $nickName,
                    ':mail'    => $email,
                    ':pwd'     => password_hash($password, PASSWORD_DEFAULT)
                ]);
                // 6 - Étape du workflow Ajax - Renvoi du message de notification callBack - OK
                // Test result insert OK
                $status = $id === true ? ['notif' => "L'enregistrement s'est bien passé"] : ['error' => "Une erreur est survenue lors de l'insertion, merci de réessayer"];
            }

            // Version Pro de Jules: } else throw new LogicException("Impossible de soumettre le form, un champ est vide");
            break;

        case 'auth':
            // 5 - Étape du workflow Ajax - Procéder à l'action
            // Test fields - et check if not contain 'trim'
            if (in_array('', $_POST)) throw new LogicException("Impossible de soumettre le form, un champ est vide");

            // Check email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) throw new LogicException("Email pourrit");

            // Connexion bdd
            require '../cnx.php'; // $pdo

            // User test
            $userQ = $pdo->prepare('SELECT id, name, email, password FROM user WHERE email = :mail');
            $userQ->execute([':mail' => $email]);
            $userQ = $userQ->fetch();

            // test si user exist
            if (!$userQ) throw new LogicException("Email inconnu");

            // Test mdp
            if (!password_verify($password, $userQ['password'])) throw new LogicException("Password incorrect");

            // Insertion du user dans la session
            $status = [
                'notif' => "Vous êtes connecté(e)",
                'user'  => [
                    'id'        => $userQ['id'],
                    'name'      => $userQ['name'],
                    'email'     => $userQ['email']
                ]
            ];
            break;

        default:
            throw new LogicException("Fallait pas faire de la bidouille");
            break;
    }

    // Ne pas oublier d'afficher le résultat que vous souhaiter transmettre au callback js, pour générer l'affichage
    echo json_encode($status);
} catch (LogicException | PDOException $e) {
    // 6 bis - Étape du workflow Ajax - Renvoi du message d'error au callBack - KO
    // Je renvoi un tableau contenant la clé error, de manière à gérer le message à afficher
    // Et cela converti en json
    echo json_encode(['error' => $e->getMessage()]);
}

        case 'search':
            // 5 - Étape du workflow Ajax - Procéder à l'action
            // Test fields - et check if not contain 'trim'
            if (in_array('', $_POST)) throw new LogicException("Impossible de soumettre le form, un champ est vide");

            // Connexion bdd
            require '../cnx.php'; // $pdo

            // User test
            $userQ = $pdo->prepare('SELECT id, name FROM user WHERE name LIKE :search');
            $userQ->execute([':search' => '%' . $search . '%']);
            $users = $userQ->fetchAll();

            // test si user exist
            if (!$users) throw new LogicException("Aucun user ne correspond à votre recherche");

            // Insertion du user dans la session
            $status = [
                'users' => $users
            ];
            break;
