<?php
    class User {
//      Données membres -------------------------------------------------------
        private $userName;
        private $userSurname;
        private $userPassword;
        private $userMail;
        private $userPhone;
        private $userRights;
//      Constructeur ----------------------------------------------------------
        public function __construct(String $userName, String $userSurname, String $userPassword,
                                    String $userMail, String $userPhone, String $userRights) {
            $this->setUserName($userName);
            $this->setUserSurname($userSurname);
            $this->setUserPassword($userPassword);
            $this->setUserMail($userMail);
            $this->setUserPhone($userPhone);
            $this->setUserRights($userRights);
        }
//      Getters ---------------------------------------------------------------
        public function getUserName() {
            return $this->userName;
        }
        public function getUserSurname() {
            return $this->userSurname;
        }
        public function getUserPassWord() {
            return $this->userPassword;
        }
        public function getUserMail() {
            return $this->userMail;
        }
        public function getUserPhone() {
            return $this->userPhone;
        }
        public function getUserRights() {
            return $this->userRights;
        }
//      Setters ---------------------------------------------------------------
        public function setUserName($userName) { 
            $this->userName = $userName;
        }
        public function setUserSurname($userSurname) {
            $this->userSurname = $userSurname;
        }
        public function setUserPassword($userPassword) {
            $this->userPassword = $userPassword;
        }
        public function setUserMail($userMail) {
            $this->userMail = $userMail;
        }
        public function setUserPhone($userPhone) {
            $this->userPhone = $userPhone;
        }
        public function setUserRights($userRights) {
            $this->userRights = $userRights;
        }
    }
?>