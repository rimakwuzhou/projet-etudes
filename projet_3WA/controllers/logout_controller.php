<?php

require 'Session.php';
Session::init();
Session::destroy();

// Redirection vers la page d'accueil
header('location: index.php');
exit;
