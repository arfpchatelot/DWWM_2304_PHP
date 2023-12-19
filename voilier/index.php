<!DOCTYPE html>
<html lang="FR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>accès membre voiliers</title>
</head>

<body>
    <?php
    session_start();
    require "model/Connexion.php";

    function loginVoilier(string $_login, string $_mdp): bool
    {
        $loginOk = false;
        $requete = "SELECT * FROM utilisateurs WHERE mail_user =:mail";

        $connect = Connexion::getInstance();


        $state = $connect->prepare($requete);
        $state->bindParam(":mail", $_login, PDO::PARAM_STR);

        $state->execute();

        $nbLigne = $state->rowCount();

        if ($nbLigne > 0) {
            $ligne = $state->fetch();


            if (password_verify($_mdp, $ligne["pass_user"]) == true) {


                $_SESSION["nom_utilisateur"] = $ligne["lastname_user"];
                $loginOK = true;
            } else {
                echo "Mot de passe erroné!";
                $loginOK = false;
            }
        } else {
            $loginOk = false;
            echo "Identifiant erroné!";
        }

        return $loginOK;
    }

    if (isset($_POST['login'], $_POST['mdp']) && !empty($_POST['login']) && !empty($_POST['mdp'])) {
        $valid = loginVoilier($_POST['login'], $_POST['mdp']);
        if ($valid) {
            echo "<script>window.location.href='liste.php'</script>";
        } else {
            echo "Authentification échouée!";
        }
    } else {
        echo "Veuillez remplir toutes les zones du formulaire!";
        var_export($_POST);
    }




    ?>








    <form action="index.php" method="POST" enctype="multipart/form-data">
        <fieldset>
            <legend>ACCES MEMBRES</legend>
            <label>Email</label>
            <input type="email" name="login" id="login">
            <label> Mot de passe</label>
            <input type="password" name="mdp" id="mdp" maxlength="30">
            <input type="submit" value="Valider" name="validation" id="validation">
        </fieldset>

    </form>

</body>

</html>