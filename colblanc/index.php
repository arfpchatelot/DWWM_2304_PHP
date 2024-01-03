<!doctype html>
<html lang="Fr">

<head>
  <meta charset="utf-8">
  <title>Entrainement Centre de Readaptation</title>
  <link rel="stylesheet" media="screen" href="css/style.css">
  <link rel="stylesheet" media="print" href="css/style2.css">
</head>

<body>

  <div id="page">
    <div id="header">
      <img src="contenu/header.jpg" width="980" height="176" alt="colblanc entete">
    </div>

    <div id="menu">
      <ul>
        <li><a href="#">Entreprises</a>
          <ul>
            <li><a href="#" target="_self">Visualiser</a>
            </li>
            <li><a href="filtre.php">Rechercher</a>
            </li>
            <li><a href="#">Ajouter</a>
            </li>
          </ul>
        </li>
        <li><a href="#">Candidats</a>
          <ul>
            <li><a href="#" target="_self">Listing</a>
            </li>
            <li><a href="#">rechercher</a>
            </li>
            <li><a href="#">Ajouter</a>
            </li>
            <li><a href="#">CVthèque</a>
            </li>
          </ul>
        </li>
        <li><a href="#">Projets</a>

        </li>
        <li><a href="#">offres</a>
          <ul>

            <li><a href="#">Par secteur</a>

            </li>

            <li><a href="#">Par entreprises</a>

            </li>
          </ul>
        </li>
      </ul>
    </div>




    <main>
      <section>







        <h1 style=" text-align:center">formulaire de recherche d'emploi ou stage</h1>
        <form name="selection" action="<?php echo $_SERVER["PHP_SELF"] ?>" method="POST" enctype="multipart/form-data">
          <label for="dep">Choisir votre département :</label>
          <select name="dep" id="dep">
            <option value="">Selectionner un département</option>
            <?php
            include "models/Connexion.php";
            $connect = Connexion::getinstance();
            $rq = "SELECT id_dep, Name FROM departements WHERE dep_actif=1";
            $state = $connect->prepare($rq);
            $state->execute();
            while ($obj = $state->fetch()) {

              if (isset($_POST["dep"]) && !empty($_POST["dep"])  && $obj->id_dep == $_POST["dep"]) {
                echo '<option value="' . $obj->id_dep . '" selected="true" >' . $obj->name . '</option>';
              } else {
                echo '<option value="' . $obj->id_dep . '">' . $obj->name . '</option>';
              }
            }




            ?>
          </select>
          <br>
          <hr>
          <br>
          <fieldset>
            <legend>Sélectionner le type d'établissement</legend>
            <div>
              <input type="checkbox" name="choix[]" id="tpe" value="TPE">
              <label for="tpe"> TPE</label>
            </div>
            <div>
              <input type="checkbox" name="choix[]" id="pme" value="PME">
              <label for="pme">PME</label>
            </div>
            <div>
              <input type="checkbox" name="choix[]" id="ge" value="GE">
              <label for="ge">Grande Entreprise</label>
            </div>
            <div>
              <input type="checkbox" name="choix[]" id="ct" value="CT">
              <label for="ct">Collectivité Territoriale</label>
            </div>
            <div>
              <input type="checkbox" name="choix[]" id="assoc" value="ASSOC">
              <label for="assoc">Association</label>
            </div>
            <div>
              <input type="checkbox" name="choix[]" id="autres" value="AUTRES">
              <label for="autre">Autres...</label>
            </div>

          </fieldset>

          <?php

          //  var_export($_POST);
          ?>

          <input type="submit" value="Valider" name="validation" id="validation">
        </form>
        <aside>

        </aside>
      </section>


    </main>

    <?php

    // var_dump($_POST["choix"]);

    // var_dump($_POST);

    $connect = Connexion::getinstance();
    $rq = "SELECT nom_etab, type_etab, nom_resp, adresse, ville, cp, Telephone, email FROM institutions WHERE depart=:departement";
    $state = $connect->prepare($rq);
    $state->bindParam(":departement", $_POST["dep"], PDO::PARAM_STR);
    $state->execute();
    $data = [];
    $nbEntr = 0;
    while ($obj = $state->fetch()) {
      $nbEntr++;
      array_push($data, $obj);
    }
    var_dump($data);


    ?>

    <footer>
      Copyright
    </footer>
  </div>
</body>

</html>