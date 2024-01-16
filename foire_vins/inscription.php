<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire d'inscription </title>
</head>
<style>
    form {
        margin-left: 50px;
    }
</style>

<body>
    <?php
    session_start();
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
                //recuperer les dimension de l'image d'origine
                $tabdim = getimagesize($destination);
                $src_w = $tabdim[0];
                $src_h = $tabdim[1];

                $dest_w = 800;
                $dest_h = round($dest_w * ($src_h / $src_w), 0);
                $cheminvignette = "vignette/avatar." . $ext;
                $cheminDiapo = 'diaporama/bigPic.' . $ext;
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

                imagecopyresampled($image, $flux, 0, 0, 0, 0, $dest_w, $dest_h, $src_w, $src_h);
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
            } else {
                imagecopyresized($image, $flux, 0, 0, 0, 0, $dest_w, $dest_h, $src_w, $src_h);
                switch ($ext) {
                    case 'jpg':
                        $res = imagejpeg($image, $cheminDiapo);
                        break;
                    case 'jpeg':
                        $res = imagejpeg($image, $cheminDiapo);
                        break;
                    case 'gif':
                        $res = imagegif($image, $cheminDiapo);
                        break;
                    case 'png':
                        $res = imagepng($image, $cheminDiapo);
                        break;
                }
            }



            //definir la taille max d'une copie de l'image.
            //créer une nouvelle image (vide) ave la ddl GD de PHP
            // grace a un flux, on va créer une copie de l'image chargée sur limage vide.


        }
    }





    ?>
    <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST" enctype="multipart/form-data">

        <section>
            <label for="nom">Nom</label>
            <br>
            <input type="text" name="nom" id="nom" placeholder="votre nom">
        </section>
        <section>
            <label for="prenom">Prénom</label>
            <br>
            <input type="text" name="prenom" id="prenom" placeholder="votre prénom">
        </section>
        <section>
            <label for="email">email</label>
            <br>
            <input type="email" name="email" id="email" placeholder="identifiant">
        </section>
        <section>
            <label for="mdp">Mot de passe</label>
            <br>
            <input type="password" name="mdp" id="mdp">
            <br>
            <label for="verifmdp">Vérification du Mot de passe</label>
            <br>
            <input type="password" name="verifmdp" id="verifmdp">
        </section>
        <section>
            <label for="avatar">Charger votre avatar</label>
            <br>
            <input type="file" name="avatar" id="avatar" accept="img/jpg,img/png">
        </section>
        <section>
            <label for="departement">Département de votre domicile principale</label>
            <br>
            <select name="departement" id="departement">
                <option value="">Choisir un Département</option>
                <?php

                require "models/Connexion.php";

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
            <input type="number" name="age" id="age" placeholder="18" step="1" min="16" max="110">
        </section>

        <input type="submit" value="valider" name="validation" id="validation">


    </form>


</body>

</html>