<?php
require_once("../Models/_BddConnexion.class.php");
class User_Mgr {
//  °°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°
    public static function getUsersList() {
        try {
//          Etablit une connexion à la base de données.
            $PDOconnexion = BddConnexion::getConnexion();
/*
            Prépare la requête SQL et l'enregistre dans une variable =>
            On souhaite ici récupérer : 
                - l'id de chaque utilisateur, l'id et le libellé de ses droits, 
                son nom, son prénom, son mail et son mot de passe (formaté MD5).
*/
            $sqlRequest = ' SELECT u.ID_utilisateur, u.tel, u.ID_droit, u.nom, u.prenom, 
                            u.mail, u.mot_de_passe, d.libelle_droit 
                            FROM utilisateur u 
                            INNER JOIN droits d ON d.ID_droit = u.ID_droit; ';
//          Connexion PDO + soumission de la requête.
            $repPDO = $PDOconnexion->query($sqlRequest);
//          On définit sous quelle forme nous souhaitons récupérer le résultat.
            $repPDO->setFetchMode(PDO::FETCH_ASSOC);
//          On récupère le résultat de la requête sous la forme d'un tableau associatif.
            $records = $repPDO->fetchAll();
//          Réinitialise le curseur.
            $repPDO->closeCursor();
//          Ferme la connexion à la bdd.
            BddConnexion::disconnect();
//          Puis on retourne ce tableau.
            return $records;
        } catch(Exception $e) {
            die('Erreur : Accès interdit ou connexion impossible.');
        }
    }
//  °°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°
    public static function createUser(String $userName, String $userSurname, String $userPassword, 
                                    String $userMail, String $userPhone, Int $userRights) {
        try {
//          Etablit une connexion à la base de données.
            $PDOconnexion = BddConnexion::getConnexion();
/*
            Prépare la requête SQL et l'enregistre dans une variable =>
            On souhaite ici insérer un nouvel utilisateur dans la base de données. 
*/
            $sqlRequest = ' INSERT INTO `utilisateur`
                            (`nom`, `prenom`, `mot_de_passe`, `mail`, `tel`, `ID_droit`) 
                            VALUES (:userName, :userSurname, :userPassword, :userMail, 
                                    :userPhone, :userRights);';
//          Connexion PDO + prépare l'envoi de la requête.
            $repPDO = $PDOconnexion->prepare($sqlRequest);
//          Exécute la requête en affectant les valeurs données en paramètres aux étiquettes.
            $repPDO->execute(array(':userName' => $userName, ':userSurname' => $userSurname,
                                    ':userPassword' => md5($userPassword), ':userMail' => $userMail, 
                                    ':userPhone' => self::phoneFormatToInternational($userPhone), ':userRights' => $userRights));
//          Réinitialise le curseur.
            $repPDO->closeCursor();
//          Ferme la connexion à la bdd.
            BddConnexion::disconnect();
        } catch(Exception $e) {
            die('Erreur : Accès interdit ou connexion impossible.');
        }
    }
//  °°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°
    public static function updateUser(String $userName, String $userSurname, String $userMail, 
                                    String $userPhone, Int $userRights, Int $userId) {
        try {
//          Etablit une connexion à la base de données.
            $PDOconnexion = BddConnexion::getConnexion();
/*
            Prépare la requête SQL et l'enregistre dans une variable =>
            On souhaite ici mettre à jour un utilisateur dans la base de données. 
*/
            $sqlRequest = ' UPDATE `utilisateur` 
                            SET `nom`=:userName, `prenom`=:userSurname,
                                `mail`=:userMail, `tel`=:userPhone, `ID_droit`=:userRights 
                            WHERE `ID_utilisateur` = :userID; ';
//          Connexion PDO + prépare l'envoi de la requête.
            $repPDO = $PDOconnexion->prepare($sqlRequest);
//          Exécute la requête en affectant les valeurs données en paramètres aux étiquettes.
            $repPDO->execute(array(':userName' => $userName, ':userSurname' => $userSurname,
                                    ':userMail' => $userMail, 
                                    ':userPhone' => self::phoneFormatToInternational($userPhone), ':userRights' => $userRights,
                                    ':userID' => $userId));
//          Réinitialise le curseur.
            $repPDO->closeCursor();
//          Ferme la connexion à la bdd.
            BddConnexion::disconnect();
        } catch(Exception $e) {
            die('Erreur : Accès interdit ou connexion impossible.');
        }
    }
//  °°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°
    public static function updateUserPassword(Int $userId, String $userPassword) {
        try {
//          Etablit une connexion à la base de données.
            $PDOconnexion = BddConnexion::getConnexion();
/*
            Prépare la requête SQL et l'enregistre dans une variable =>
            On souhaite ici mettre à jour le mdp d'un utilisateur dans la base de données. 
*/
            $sqlRequest = ' UPDATE `utilisateur` 
                            SET `mot_de_passe` = :userPassword 
                            WHERE `ID_utilisateur` = :userID; ';
//          Connexion PDO + prépare l'envoi de la requête.
            $repPDO = $PDOconnexion->prepare($sqlRequest);
//          Exécute la requête en affectant les valeurs données en paramètres aux étiquettes.
            $repPDO->execute(array(':userPassword' => md5($userPassword),
                                    ':userID' => $userId));
//          Réinitialise le curseur.
            $repPDO->closeCursor();
//          Ferme la connexion à la bdd.
            BddConnexion::disconnect();
        } catch(Exception $e) {
            die('Erreur : Accès interdit ou connexion impossible.');
        }
    }
//  °°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°
    public static function deleteUser(Int $userId) {
        try {
//          Etablit une connexion à la base de données.
            $PDOconnexion = BddConnexion::getConnexion();
/*
            Prépare la requête SQL et l'enregistre dans une variable =>
            On souhaite ici supprimer un utilisateur par son Identifiant. 
*/
            $sqlRequest = ' DELETE FROM `utilisateur` WHERE `ID_utilisateur` = :userID;';
//          Connexion PDO + prépare l'envoi de la requête.
            $repPDO = $PDOconnexion->prepare($sqlRequest);
//          Exécute la requête en affectant les valeurs données en paramètres aux étiquettes.
            $repPDO->execute(array(':userID' => $userId));
//          Réinitialise le curseur.
            $repPDO->closeCursor();
//          Ferme la connexion à la bdd.
            BddConnexion::disconnect();
        } catch(Exception $e) {
            die('Erreur : Accès interdit ou connexion impossible.');
        }
    }
//  °°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°
    public static function getUndeletableUsersList() {
        try {
//          Etablit une connexion à la base de données.
            $PDOconnexion = BddConnexion::getConnexion();
/*
            Prépare la requête SQL et l'enregistre dans une variable =>
            On souhaite ici récupérer : 
                - une liste non détaillée des utilisateurs qui ne sont pas
                en charge du suivi d'un professionnel.
*/
            $sqlRequest = ' SELECT u.ID_utilisateur, p.ID_utilisateur 
                            FROM utilisateur u 
                            INNER JOIN professionnel p ON u.ID_utilisateur = p.ID_utilisateur; ';
//          Connexion PDO + soumission de la requête.
            $repPDO = $PDOconnexion->query($sqlRequest);
//          On définit sous quelle forme nous souhaitons récupérer le résultat.
            $repPDO->setFetchMode(PDO::FETCH_ASSOC);
//          On récupère le résultat de la requête sous la forme d'un tableau associatif.
            $records = $repPDO->fetchAll();
//          Réinitialise le curseur.
            $repPDO->closeCursor();
//          Ferme la connexion à la bdd.
            BddConnexion::disconnect();
//          Puis on retourne ce tableau.
            return $records;
        } catch(Exception $e) {
            die('Erreur : Accès interdit ou connexion impossible.');
        }
    }
//  °°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°
    public static function phoneFormatToFrench(String $phoneNumber) {
//  Permet de convertir un numéro de téléphone d'un format "+33..." à "06...".
        $formattedPhoneNumber = substr_replace($phoneNumber, '0', 0, -9);
        return $formattedPhoneNumber;
    }
//  °°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°
    public static function phoneFormatToInternational(String $phoneNumber) {
//  Permet de convertir un numéro de téléphone d'un format "06..." à "+33...".
        $formattedPhoneNumber = substr_replace($phoneNumber, '+33', 0, -9);
        return $formattedPhoneNumber;
    }
}
?>