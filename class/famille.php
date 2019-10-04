<?php

/**
 * Description of famille
 *
 * @author Web-Star
 */
class famille {
    //attribut
    protected $id;
    protected $libelle;
    //methode
    //getters
    public function getId() {
        if($this->id){
            return $this->id;
        }else{
            0;
        }
    }
    public function getLibelle() {
        if($this->libelle){
            return $this->libelle;
    }else{
            "";
}
