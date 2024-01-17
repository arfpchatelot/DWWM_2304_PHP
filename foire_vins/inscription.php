<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire d'inscription foire aux vins </title>
</head>
<style>
    form {
        width: 40%;
        margin-left: auto;
        margin-right: auto;
    }
</style>

<body>
    <?php
    session_start();
    require "./models/Connexion.php";

    if (isset($_POST['validation']) &&  $_POST['mdp'] == $_POST['verifmdp'] && intval($_POST["age"]) > 18) {


        $numeroavatar = 1;


        if (isset($_FILES["avatar"]) && $_FILES["avatar"]["name"] != "") {



            $name = $_FILES["avatar"]["name"]; //nom fichier chez le client
            $type = $_FILES["avatar"]["type"];
            $tab_split = explode('/', $type);
            $img_path = "./img/";
            $ext = $tab_split[1];
            $newname = "photo_avatar";
            $tab_ref = array("jpeg", "jpg", "gif", "png");
            if (in_array($ext, $tab_ref) == true) {
                $origin = $_FILES["avatar"]["tmp_name"];
                $destination = $img_path . $newname . "." . $ext;

                if (move_uploaded_file($origin, $destination) == true) {
                    echo "image transféré";
                    //récupérer les dimensions de l'image d'origine
                    $tabdim = getimagesize($destination);
                    $src_w = $tabdim[0];
                    $src_h = $tabdim[1];

                    $dest_w = 100;
                    $dest_h = round($dest_w * ($src_h / $src_w), 0);
                    //--------------------------
                    $connect = Connexion::getinstance();
                    $req = "SELECT max(id_avatar) FROM avatars";
                    $state = $connect->query($req);
                    $obj = $state->fetch(PDO::FETCH_ASSOC);
                    $num = $obj['max(id_avatar)'];
                    //-----------------------------
                    //definir la taille max d'une copie de l'image.
                    //créer une nouvelle image (vide) avec la ddl GD de PHP
                    // grace a un flux, on va créer une copie de l'image au dimension de la nouvelle image vide.
                    $cheminvignette = "vignette/avatar" . ($num + 1) . "." . $ext;
                    //$cheminDiapo = 'diaporama/bigPic.' . $ext;
                    $image = imagecreate($dest_w, $dest_h);

                    switch ($ext) {
                        case 'jpg':
                            $flux = imagecreatefromjpeg($destination);

                            break;

                        case 'jpeg':
                            $flux = imagecreatefromjpeg($destination);

                            break;

                        case 'gif':
                            $flux = imagecreatefromgif($destination);

                            break;


                        case 'png':
                            $flux = imagecreatefrompng($destination);

                            break;
                    }
                }
                if ($src_w > $dest_w) {

                    if (imagecopyresampled($image, $flux, 0, 0, 0, 0, $dest_w, $dest_h, $src_w, $src_h)) {
                        switch ($ext) {
                            case 'jpg':
                                $res = imagejpeg($image, $cheminvignette);
                                break;

                            case 'jpeg':
                                $res = imagejpeg($image, $cheminvignette);
                                break;
                            case 'gif':
                                $res = imagegif($image, $cheminvignette);
                                break;
                            case 'png':
                                $res = imagepng($image, $cheminvignette);
                                break;
                            default:
                                $res = "erreur";
                                break;
                        }
                        // enregistrer l'accès à l'image( chemin) et l'extension dans la table "avatars" de la BDD foire
                        //ajouter dans la variable  $numeroavatar  le numero de l'image chargée dans la table "avatars".

                        $req = "INSERT INTO avatars VALUES (id_avatar, 'http://localhost/TP_PHP/DWWM_2304_PHP/foire_vins/" . $cheminvignette . "', '" . $ext . " '  )";

                        $connect = Connexion::getinstance();

                        $nb_lignes = $connect->exec($req);
                        // intégration image réussie.  id_avatar = num +1 
                        if ($nb_lignes === 1) {
                            echo "Image intégrée dans la table ";
                            $numeroavatar = $num + 1;
                        }
                    }
                }
                // else {
                //     imagecopyresized($image, $flux, 0, 0, 0, 0, $dest_w, $dest_h, $src_w, $src_h);
                //     switch ($ext) {
                //         case 'jpg':
                //             $res = imagejpeg($image, $cheminDiapo);
                //             break;
                //         case 'jpeg':
                //             $res = imagejpeg($image, $cheminDiapo);
                //             break;
                //         case 'gif':
                //             $res = imagegif($image, $cheminDiapo);
                //             break;
                //         case 'png':
                //             $res = imagepng($image, $cheminDiapo);
                //             break;
                //     }
                //}






            }
        }




        $rq = "INSERT INTO candidats VALUES (id_user,:nom,:prenom,:email,:mdp,:departement,:age,:numavatar)";

        $monPDO = Connexion::getinstance();

        $state = $monPDO->prepare($rq);
        $state->bindParam(':nom', $_POST['nom'], PDO::PARAM_STR);
        $state->bindParam(':prenom', $_POST['prenom'], PDO::PARAM_STR);
        $state->bindParam(':email', $_POST['email'], PDO::PARAM_STR);

        $mdp = password_hash($_POST['mdp'], PASSWORD_ARGON2I);
        $state->bindParam(':mdp', $mdp, PDO::PARAM_STR);
        $state->bindParam(':departement', $_POST['departement'], PDO::PARAM_STR);
        $state->bindParam(':age', $_POST['age'], PDO::PARAM_INT);
        $state->bindParam(':numavatar', $numeroavatar, PDO::PARAM_INT);

        $state->execute();
        if ($state->rowCount() != 0) {
            echo "Bravo vous êtes inscrit !";
            $_SESSION['lastname_user'] = $_POST['nom'];
            $_SESSION['firstname_user'] = $_POST['prenom'];
            $_SESSION['mail_user'] = $_POST['email'];

            exit();
        } else {

            echo "<p>Problème d'inscription!</p>";
        }
    } else {
        echo "<p> vous devez avoir plus 18 ans </p>";
    }







    ?>
    <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST" enctype="multipart/form-data">

        <section>
            <label for="nom">Nom</label>
            <br>
            <input type="text" name="nom" id="nom" placeholder="votre nom" require="true">
        </section>
        <section>
            <label for="prenom">Prénom</label>
            <br>
            <input type="text" name="prenom" id="prenom" placeholder="votre prénom" require="true">
        </section>
        <section>
            <label for="email">email</label>
            <br>
            <input type="email" name="email" id="email" placeholder="identifiant" require="true">
        </section>
        <section>
            <label for="mdp">Mot de passe</label>
            <br>
            <input type="password" name="mdp" id="mdp" require="true">
            <br>
            <label for="verifmdp">Vérification du Mot de passe</label>
            <br>
            <input type="password" name="verifmdp" id="verifmdp" require="true">
        </section>
        <section>
            <label for="avatar">Charger votre avatar</label>
            <br>
            <input type="file" name="avatar" id="avatar" accept="img/jpg,img/png">
        </section>
        <section>
            <label for="departement">Département de votre domicile principale</label>
            <br>
            <select name="departement" id="departement" require="true">
                <option value="">Choisir un Département</option>
                <?php



                $monPDO = Connexion::getinstance();

                $rq = "SELECT id_dep,Name_dep FROM departements WHERE dep_actif=1";
                $state = $monPDO->prepare($rq);

                $state->execute();

                while ($ligne = $state->fetch(PDO::FETCH_ASSOC)) {
                    echo '<option value="' . $ligne['id_dep'] . '">' . $ligne['name_dep'] . ' </option>';
                }


                ?>

            </select>
        </section>
        <section>
            <label for="age">Votre age</label>
            <br>
            <input type="number" name="age" id="age" placeholder="18" step="1" min="16" max="110" require="true">
        </section>

        <input type="submit" value="valider" name="validation" id="validation">


    </form>


</body>

</html>