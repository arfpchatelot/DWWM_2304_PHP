<!DOCTYPE html>
<html lang="FR-fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>calcul de l'impôt</title>
</head>
<style>
    label {
        display: inline-block;
        width: 200px;
    }

    #validation {
        margin: 10px auto 10px 250px;
    }

    #rst {

        color: #999;
    }
</style>

<body>
    <?php
    require "model/Contribuable.php";

    $result = 0;

    if (isset($_GET["validation"])) {
        if (!empty($_GET["nom"]) && !empty($_GET["revenu"])) {
            $monContribuable = new Contribuable($_GET["nom"], $_GET["revenu"]);
            $result = $monContribuable->calculImpot();
        } else {
            echo "Veuillez remplir toutes les zones de saisies";
        }
    } else {
        echo "Veuillez remplir le formulaire (nom et revenu)";
    }



    ?>

    <form action="index.php" method="GET" enctype="multipart/form-data">
        <label for="nom">Nom : </label>
        <input type="text" name="nom" id="nom" value="<?php echo isset($_GET["nom"]) ?  $_GET["nom"] : "" ?>">
        <br>
        <label for="revenu">Revenu annuel : </label>
        <input type="number" step="0.01" name="revenu" id="revenu" value="<?php echo isset($_GET["revenu"]) ? $_GET["revenu"] : 0 ?>">
        <br>
        <!-- <button type="submit">Valider</button> -->
        <input type="submit" value="Valider" name="validation" id="validation">
        <br>
        <label for="rst">Calcul impôt sur le revenu : </label>
        <input type="text" value="<?= $result ?> " readonly="true" id="rst">

    </form>

</body>

</html>