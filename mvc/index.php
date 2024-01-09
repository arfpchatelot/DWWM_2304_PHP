<?php

require_once('src/controllers/homepage.php');
require_once('src/controllers/post.php');
require_once('src/controllers/add_comment.php');

if (isset($_GET['action']) && $_GET['action'] !== '') {
    if ($_GET['action'] == 'post') {
        if (isset($_GET['id']) && $_GET['id'] > 0) {
            $identifier = $_GET['id'];

            post($identifier);
        }
    } else if ($_GET["action"] == 'addcomment') {
        echo  "test";
        if (isset($_GET['id']) && $_GET['id'] > 0) {

            addComment($_GET['id'], $_POST);
        } else {
            die('Erreur : aucun identifiant de billet envoyé');
        }
    } else {
        echo "Erreur 404 : la page que vous recherchez n'existe pas.";
    }
} else {
    homepage();
}
