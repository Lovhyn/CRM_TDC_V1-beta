<?php
    class Pro {
//      Données membres -------------------------------------------------------
        private $idUserInChargeOf;
        private $idActivityArea;
        private $libPro;
        private $decisionMakerName;
        private $firstPhone;
        private $secondPhone;
        private $mail;
        private $firstAdress;
        private $secondAdress;
        private $cp;
        private $city;
        private $observation;
        private $status;
        private $firstContactDate;
//      Constructeur ----------------------------------------------------------
        public function __construct($idUserInChargeOf, $idActivityArea, $libPro, 
                                    $decisionMakerName, $firstPhone, $secondPhone, 
                                    $mail, $firstAdress, $secondAdress, $cp, $city,
                                    $observation, $status, $firstContactDate) {
            $this->setIdUserInChargeOf($idUserInChargeOf);
            $this->setIdActivityArea($idActivityArea);
            $this->setLibPro($libPro); 
            $this->setDecisionMakerName($decisionMakerName); 
            $this->setFirstPhone($firstPhone); 
            $this->setSecondPhone($secondPhone); 
            $this->setMail($mail); 
            $this->setFirstAdress($firstAdress); 
            $this->setSecondAdress($secondAdress); 
            $this->setCp($cp); 
            $this->setCity($city); 
            $this->setObservation($observation); 
            $this->setStatus($status);
            $this->setFirstContactDate($firstContactDate); 
        }
//      Getters ---------------------------------------------------------------
        public function getIdUserInChargeOf() {
            return $this->idUserInChargeOf;
        }
        public function getIdActivityArea() {
            return $this->idActivityArea;
        }
        public function getLibPro() {
            return $this->libPro;
        }
        public function getDecisionMakerName() {
            return $this->decisionMakerName;
        }
        public function getFirstPhone() {
            return $this->firstPhone;
        }
        public function getSecondPhone() {
            return $this->secondPhone;
        }
        public function getMail() {
            return $this->mail;
        }
        public function getFirstAdress() {
            return $this->firstAdress;
        }
        public function getSecondAdress() {
            return $this->secondAdress;
        }
        public function getCp() {
            return $this->cp;
        }
        public function getCity() {
            return $this->city;
        }
        public function getObservation() {
            return $this->observation;
        }
        public function getStatus() {
            return $this->status;
        }
        public function getFirstContactDate() {
            return $this->firstContactDate;
        }
//      Setters ---------------------------------------------------------------
        public function setIdUserInChargeOf($idUserInChargeOf) { 
            $this->idUserInChargeOf = $idUserInChargeOf;
        }
        public function setIdActivityArea($idActivityArea) {
            $this->idActivityArea = $idActivityArea;
        }
        public function setLibPro($libPro) {
            $this->libPro = $libPro;
        }
        public function setDecisionMakerName($decisionMakerName) {
            $this->decisionMakerName = $decisionMakerName;
        }
        public function setFirstPhone($firstPhone) {
            $this->firstPhone = $firstPhone;
        }
        public function setSecondPhone($secondPhone) {
            $this->secondPhone = $secondPhone;
        }
        public function setMail($mail) {
            $this->mail = $mail;
        }
        public function setFirstAdress($firstAdress) {
            $this->firstAdress = $firstAdress;
        }
        public function setSecondAdress($secondAdress) {
            $this->secondAdress = $secondAdress;
        }
        public function setCp($cp) {
            $this->cp = $cp;
        }
        public function setCity($city) {
            $this->city = $city;
        }
        public function setObservation($observation) {
            $this->observation = $observation;
        }
        public function setStatus($status) {
            $this->status = $status;
        }
        public function setFirstContactDate($firstContactDate) {
            $this->firstContactDate = $firstContactDate;
        }
    }
?>