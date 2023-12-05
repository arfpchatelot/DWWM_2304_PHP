<?php
class Pret 
{


//attributs
public float $capital;
private float $tauxMensuel;
private int $nbMois;

//Constructeur 
public function __construct(float $_capital, float $_tauxAnnuel, $_nbannees)
{
    $this->capital=$_capital;
    $this->tauxMensuel=$_tauxAnnuel/12/100;
    $this->nbMois=$_nbannees*12;

}
// propriétés

public function getTauxMensuel(){

    return $this->tauxMensuel*100;
}
public function getnbMois()
{
 return $this->nbMois;

}
//

public function calculMensualite():float
{
    $quotient=( 1- POW((1+$this->tauxMensuel),-$this->nbMois));
$mensualite= ($this->capital*$this->tauxMensuel)/$quotient;
return round($mensualite,2);

}

public function tableauAmortissement():string
{
    $chaine = "<table><thead><tr><th>nombre de mois</th><th>part intérêt</th><th>part amortissement</th><th>capital restant dû</th><th>mensualité</th></tr></thead><tbody>";
    $numMois = 1;
    $capitalRestant = 0;
    $partInteret = 0;
    $partAmortissment = 0;
    $mensualite =  $this->calculMensualite();
    do {
        if ($numMois == 1)
        {
            $capitalRestant = $this->capital;
        }
        else 
        {
            $capitalRestant -= $partAmortissment;
        }
        $partInteret = $capitalRestant * $this->tauxMensuel;
        $partAmortissment = $mensualite - $partInteret;
        $chaine .= "<tr><td>" . $numMois . "</td><td>" . round($partInteret, 2) . "€ </td><td>" .  round($partAmortissment, 2) . "</td><td>" . round($capitalRestant, 2) . "€ </td><td>" . round($mensualite, 2) . "</td></tr>";
        $numMois ++;
    } while ($numMois <= $this->nbMois); 
        $chaine .= "</tbody></table>";
        return $chaine;
}


}