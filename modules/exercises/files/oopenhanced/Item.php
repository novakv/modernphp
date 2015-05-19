<?php

namespace Ullman\PHPGevorderden;

class Item
{
    /*
    protected $id;

    protected $naam;

    protected $prijs;
    */
    public $id;

    public $naam;

    public $kleur;

    public $maat;

    public $prijs;

    public function __construct($id, $naam, $kleur, $maat, $prijs) {
        $this->id = $id;
        $this->naam = $naam;
        $this->kleur = $kleur;
        $this->maat = $maat;
        $this->prijs = $prijs;
    }

    public function getId() {
        return $this->id;
    }
    
    public function getNaam() {
        return $this->naam;
    }    
    
    public function getKleur() {
        return $this->kleur;
    }

    public function getMaat() {
        return $this->maat;
    }
 
    public function getPrijs() {
        return $this->prijs;
    }
}