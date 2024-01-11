<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire d'inscription </title>
</head>

<body>
    <?php
    session_start();


    ?>
    <form action="<?= $_SERVER["PHP_SELF"] ?>" method="POST" enctype="multipart/form-data">

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