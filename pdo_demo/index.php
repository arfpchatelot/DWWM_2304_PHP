<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    require "models/Connexion.php";
$nouv="Zorhino";

    $mail="t.tournesol@gmail.com";

    $maconnection = Connexion::getinstance();
  //  $rq = " SELECT lastname_user ,firstname_user,mail_user FROM utilisateurs";
 // $rq=" SELECT * FROM utilisateurs WHERE mail_user=:monmail";

       $rq2="UPDATE utilisateurs SET pass_user=? WHERE mail_user=?";



    $state = $maconnection->prepare($rq2);
  //  $state->bindParam(":mail", $mail, PDO::PARAM_STR );

   // $state->bindParam(":nouvpass", $nouv, PDO::PARAM_STR );

    $state->execute( [ $nouv,$mail] );

    echo $state->rowCount();
   // $tab = [];

   // $tabResultat=$state->FETCHALL();

  //  var_export($tabResultat);
   //$test=  $tabResultat[1]["lastname_user"];

   //echo $test;
     
   // $ligne = $state->fetch();

        // var_dump($ligne);
    


    ?>
</body>

</html>