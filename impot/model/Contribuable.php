<?php
class Contribuable
{

    //attributs
    private string $nom = "";
    private float $revenu = 0;


    public const TAUX1 = 0.09;
    public const TAUX2 = 0.14;
    public const PLAFOND = 15000;
    //Constructeur

    public function __construct(string $_nom, float $_revenu)
    {
        $this->nom = $_nom;
        $this->revenu = $_revenu;
    }
    //propriétés

    public function getRevenu(): float
    {

        return $this->revenu;
    }

    public function setRevenu(float $_nouvRevenu): void
    {
        $this->revenu = $_nouvRevenu;
    }
    public function getNom(): string
    {
        return $this->nom;
    }

    //méthode
    public function calculImpot():float
    
    {   $impot=0;

        if($this->revenu <= self::PLAFOND)
        {
            $impot = self::TAUX1 * $this->revenu;
        }
        else
        {
            $impot = (self::PLAFOND * self::TAUX1) + ($this->revenu - self::PLAFOND)*self::TAUX2;
        }

        return round($impot, 2);

    }


}
