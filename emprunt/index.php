<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>affichage prêt</title>
</head>
<body>
    <?php
include "./models/Pret.php";
$monPret=new Pret(10000,3,3);

echo "mensualité constante :".$monPret->calculMensualite()."€";
echo "<caption>Tableau d'amortissement prêt</caption>" . $monPret->tableauAmortissement();

    ?>
</body>
</html>