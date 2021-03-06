<?php
require_once("../Models/_BddConnexion.class.php");
class Pro_Mgr {
//  °°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°
    public static function getFullProspectsList() {
        try {
//          Etablit une connexion à la base de données.
            $PDOconnexion = BddConnexion::getConnexion();
/*
            Prépare la requête SQL et l'enregistre dans une variable =>
            On souhaite ici récupérer : 
                - la liste de tous les prospects parmi les professionnels enregistrés.
*/
            $sqlRequest = " SELECT 
                            p.libelle_entreprise, p.nom_decideur, 
                            CONCAT(p.cp, ', ', p.ville) as lieu, p.tel, p.tel_2, p.mail, 
                            p.adresse, p.adresse_2, p.cp, p.ville,
                            CONCAT(SUBSTRING(u.nom, 1, 1), '.', u.prenom) as suivi, 
                            u.nom, u.prenom,
                            s.libelle_secteur, p.observation, p.prospect_ou_client,
                            p.ID_professionnel, p.ID_utilisateur, p.ID_secteur,
                            MAX(f.date_derniere_pdc) as `date_derniere_pdc`
                            FROM professionnel p
                            INNER JOIN suivre f ON f.ID_professionnel = p.ID_professionnel
                            INNER JOIN utilisateur u ON u.ID_utilisateur = p.ID_utilisateur
                            INNER JOIN secteur_activite s ON s.ID_secteur = p.ID_secteur
                            WHERE p.prospect_ou_client = 0 
                            GROUP BY p.ID_professionnel 
                            ORDER BY f.date_derniere_pdc DESC; ";
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
    public static function getFilteredProspectsList(String $paramUserId, String $paramStartDate, String $paramEndDate) {
        try {
//          Etablit une connexion à la base de données.
            $PDOconnexion = BddConnexion::getConnexion();
/*
            Prépare la requête SQL et l'enregistre dans une variable =>
            On souhaite ici récupérer : 
                - une liste filtrée de prospects.
*/
        if ($paramUserId != '0') {
            $sqlRequest = " SELECT 
                            p.libelle_entreprise, p.nom_decideur, 
                            CONCAT(p.cp, ', ', p.ville) as lieu, p.tel, p.tel_2, p.mail, 
                            p.adresse, p.adresse_2, p.cp, p.ville,
                            CONCAT(SUBSTRING(u.nom, 1, 1), '.', u.prenom) as suivi, 
                            u.nom, u.prenom,
                            s.libelle_secteur, p.observation, p.prospect_ou_client,
                            p.ID_professionnel, p.ID_utilisateur, p.ID_secteur,
                            MAX(f.date_derniere_pdc) as `date_derniere_pdc`
                            FROM professionnel p
                            INNER JOIN suivre f ON f.ID_professionnel = p.ID_professionnel
                            INNER JOIN utilisateur u ON u.ID_utilisateur = p.ID_utilisateur
                            INNER JOIN secteur_activite s ON s.ID_secteur = p.ID_secteur
                            WHERE p.prospect_ou_client = 0
                            AND p.ID_utilisateur = :paramUserId
                            AND f.date_derniere_pdc >= :paramStartDate 
                            AND f.date_derniere_pdc <= :paramEndDate 
                            GROUP BY p.ID_professionnel 
                            ORDER BY f.date_derniere_pdc DESC ;";
//          Connexion PDO + soumission de la requête.
            $repPDO = $PDOconnexion->prepare($sqlRequest);
//          Exécute la requête en affectant les valeurs données en paramètres aux étiquettes.
            $repPDO->execute(array(':paramUserId' => (int) $paramUserId,
                                    ':paramStartDate' => (string) $paramStartDate,
                                    ':paramEndDate' => (string) $paramEndDate));
        } else {
            $sqlRequest = " SELECT 
                            p.libelle_entreprise, p.nom_decideur, 
                            CONCAT(p.cp, ', ', p.ville) as lieu, p.tel, p.tel_2, p.mail, 
                            p.adresse, p.adresse_2, p.cp, p.ville,
                            CONCAT(SUBSTRING(u.nom, 1, 1), '.', u.prenom) as suivi, 
                            u.nom, u.prenom,
                            s.libelle_secteur, p.observation, p.prospect_ou_client,
                            p.ID_professionnel, p.ID_utilisateur, p.ID_secteur,
                            MAX(f.date_derniere_pdc) as `date_derniere_pdc`
                            FROM professionnel p
                            INNER JOIN suivre f ON f.ID_professionnel = p.ID_professionnel
                            INNER JOIN utilisateur u ON u.ID_utilisateur = p.ID_utilisateur
                            INNER JOIN secteur_activite s ON s.ID_secteur = p.ID_secteur
                            WHERE p.prospect_ou_client = 0
                            AND f.date_derniere_pdc >= :paramStartDate 
                            AND f.date_derniere_pdc <= :paramEndDate 
                            GROUP BY p.ID_professionnel 
                            ORDER BY f.date_derniere_pdc DESC ;";
//          Connexion PDO + soumission de la requête.
            $repPDO = $PDOconnexion->prepare($sqlRequest);
//          Exécute la requête en affectant les valeurs données en paramètres aux étiquettes.
            $repPDO->execute(array(':paramStartDate' => (string) $paramStartDate,
                                    ':paramEndDate' => (string) $paramEndDate));
        }
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
            die('Erreur TEST : Accès interdit ou connexion impossible.');
        }
    }
//  °°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°
public static function getFilteredCustomersList(String $paramUserId, String $paramStartDate, String $paramEndDate) {
    try {
//          Etablit une connexion à la base de données.
        $PDOconnexion = BddConnexion::getConnexion();
/*
        Prépare la requête SQL et l'enregistre dans une variable =>
        On souhaite ici récupérer : 
            - une liste filtrée de prospects.
*/
    if ($paramUserId != '0') {
        $sqlRequest = " SELECT 
                        p.libelle_entreprise, p.nom_decideur, 
                        CONCAT(p.cp, ', ', p.ville) as lieu, p.tel, p.tel_2, p.mail, 
                        p.adresse, p.adresse_2, p.cp, p.ville,
                        CONCAT(SUBSTRING(u.nom, 1, 1), '.', u.prenom) as suivi, 
                        u.nom, u.prenom,
                        s.libelle_secteur, p.observation, p.prospect_ou_client,
                        p.ID_professionnel, p.ID_utilisateur, p.ID_secteur,
                        MAX(f.date_derniere_pdc) as `date_derniere_pdc`
                        FROM professionnel p
                        INNER JOIN suivre f ON f.ID_professionnel = p.ID_professionnel
                        INNER JOIN utilisateur u ON u.ID_utilisateur = p.ID_utilisateur
                        INNER JOIN secteur_activite s ON s.ID_secteur = p.ID_secteur
                        WHERE p.prospect_ou_client = 1
                        AND p.ID_utilisateur = :paramUserId
                        AND f.date_derniere_pdc >= :paramStartDate 
                        AND f.date_derniere_pdc <= :paramEndDate 
                        GROUP BY p.ID_professionnel 
                        ORDER BY f.date_derniere_pdc DESC ;";
//          Connexion PDO + soumission de la requête.
        $repPDO = $PDOconnexion->prepare($sqlRequest);
//          Exécute la requête en affectant les valeurs données en paramètres aux étiquettes.
        $repPDO->execute(array(':paramUserId' => (int) $paramUserId,
                                ':paramStartDate' => (string) $paramStartDate,
                                ':paramEndDate' => (string) $paramEndDate));
    } else {
        $sqlRequest = " SELECT 
                        p.libelle_entreprise, p.nom_decideur, 
                        CONCAT(p.cp, ', ', p.ville) as lieu, p.tel, p.tel_2, p.mail, 
                        p.adresse, p.adresse_2, p.cp, p.ville,
                        CONCAT(SUBSTRING(u.nom, 1, 1), '.', u.prenom) as suivi, 
                        u.nom, u.prenom,
                        s.libelle_secteur, p.observation, p.prospect_ou_client,
                        p.ID_professionnel, p.ID_utilisateur, p.ID_secteur,
                        MAX(f.date_derniere_pdc) as `date_derniere_pdc`
                        FROM professionnel p
                        INNER JOIN suivre f ON f.ID_professionnel = p.ID_professionnel
                        INNER JOIN utilisateur u ON u.ID_utilisateur = p.ID_utilisateur
                        INNER JOIN secteur_activite s ON s.ID_secteur = p.ID_secteur
                        WHERE p.prospect_ou_client = 1
                        AND f.date_derniere_pdc >= :paramStartDate 
                        AND f.date_derniere_pdc <= :paramEndDate 
                        GROUP BY p.ID_professionnel 
                        ORDER BY f.date_derniere_pdc DESC ;";
//          Connexion PDO + soumission de la requête.
        $repPDO = $PDOconnexion->prepare($sqlRequest);
//          Exécute la requête en affectant les valeurs données en paramètres aux étiquettes.
        $repPDO->execute(array(':paramStartDate' => (string) $paramStartDate,
                                ':paramEndDate' => (string) $paramEndDate));
    }
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
        die('Erreur TEST : Accès interdit ou connexion impossible.');
    }
}
//  °°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°
    public static function getFullCustomersList() {
        try {
//          Etablit une connexion à la base de données.
            $PDOconnexion = BddConnexion::getConnexion();
/*
            Prépare la requête SQL et l'enregistre dans une variable =>
            On souhaite ici récupérer : 
                - la liste de tous les clients parmi les professionnels enregistrés.
*/
            $sqlRequest = " SELECT 
                            p.`libelle_entreprise`, p.`nom_decideur`, 
                            CONCAT(p.`cp`, ', ', p.`ville`) as `lieu`, p.`tel`, p.`tel_2`, p.`mail`, 
                            p.`adresse`, p.`adresse_2`, p.`cp`, p.`ville`,
                            CONCAT(SUBSTRING(u.`nom`, 1, 1), '.', u.`prenom`) as `suivi`, 
                            u.`nom`, u.`prenom`,
                            s.`libelle_secteur`, p.`observation`, p.`prospect_ou_client`,
                            p.`ID_professionnel`, p.`ID_utilisateur`, p.`ID_secteur`,
                            MAX(f.`date_derniere_pdc`) as `date_derniere_pdc`
                            FROM professionnel p
                            INNER JOIN suivre f ON f.`ID_professionnel` = p.`ID_professionnel`
                            INNER JOIN utilisateur u ON u.`ID_utilisateur` = p.`ID_utilisateur`
                            INNER JOIN secteur_activite s ON s.`ID_secteur` = p.`ID_secteur`
                            WHERE p.`prospect_ou_client` = 1 
                            GROUP BY p.`ID_professionnel` 
                            ORDER BY f.`date_derniere_pdc` DESC; ";
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
    public static function getProPhonesList(int $paramProId) {
        try {
//          Etablit une connexion à la base de données.
            $PDOconnexion = BddConnexion::getConnexion();
/*
            Prépare la requête SQL et l'enregistre dans une variable =>
            On souhaite ici récupérer : 
                - la liste des numéros de téléphones enregistrés dans la fiche d'un professionnel.
*/
            $sqlRequest = " SELECT 
                            tel, tel_2
                            FROM professionnel p
                            WHERE ID_professionnel = :idProfessionnel ;";
//          Connexion PDO + prépare l'envoi de la requête.
            $repPDO = $PDOconnexion->prepare($sqlRequest);
//          Exécute la requête en affectant les valeurs données en paramètres aux étiquettes.
            $repPDO->execute(array(':idProfessionnel' => $paramProId));
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
    public static function getProMail(int $paramProId) {
        try {
//          Etablit une connexion à la base de données.
            $PDOconnexion = BddConnexion::getConnexion();
/*
            Prépare la requête SQL et l'enregistre dans une variable =>
            On souhaite ici récupérer : 
                - l'adresse mail enregistrée dans la fiche d'un professionnel.
*/
            $sqlRequest = " SELECT 
                            mail
                            FROM professionnel p
                            WHERE ID_professionnel = :idProfessionnel ;";
//          Connexion PDO + prépare l'envoi de la requête.
            $repPDO = $PDOconnexion->prepare($sqlRequest);
//          Exécute la requête en affectant les valeurs données en paramètres aux étiquettes.
            $repPDO->execute(array(':idProfessionnel' => $paramProId));
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
    public static function getDecisionMakerName(int $paramProId) {
        try {
//          Etablit une connexion à la base de données.
            $PDOconnexion = BddConnexion::getConnexion();
/*
            Prépare la requête SQL et l'enregistre dans une variable =>
            On souhaite ici récupérer : 
                - le nom du décideur d'une entreprise.
*/
            $sqlRequest = " SELECT 
                            nom_decideur
                            FROM professionnel p
                            WHERE ID_professionnel = :idProfessionnel ;";
//          Connexion PDO + prépare l'envoi de la requête.
            $repPDO = $PDOconnexion->prepare($sqlRequest);
//          Exécute la requête en affectant les valeurs données en paramètres aux étiquettes.
            $repPDO->execute(array(':idProfessionnel' => $paramProId));
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
    public static function updateProspect(String $updName, String $updDecisionMaker, 
                                        String $updMainPhone, String $updSecondaryPhone,
                                        String $updMail, String $updMainAdress, String $updSecondaryAdress,
                                        String $updCp, String $updCity, String $updObservation, Int $proId,
                                        Int $updUserId) {
        try {
//          Etablit une connexion à la base de données.
            $PDOconnexion = BddConnexion::getConnexion();
/*
            Prépare la requête SQL et l'enregistre dans une variable =>
            On souhaite ici mettre à jour un prospect dans la base de données. 
*/
            $sqlRequest = ' UPDATE `professionnel` 
                            SET 
                            `libelle_entreprise`=:newProName,
                            `nom_decideur`=:newDecisionMaker,
                            `tel`=:newMainPhone,
                            `tel_2`=:newSecondaryPhone,
                            `mail`=:newMail,
                            `adresse`=:newMainAdress,
                            `adresse_2`=:newSecondaryAdress,
                            `cp`=:newCp,
                            `ville`=:newCity,
                            `observation`=:newObservation, 
                            `ID_utilisateur`=:newUserID
                            WHERE `ID_professionnel` = :proToUpdate; ';
//          Connexion PDO + prépare l'envoi de la requête.
            $repPDO = $PDOconnexion->prepare($sqlRequest);
//          Exécute la requête en affectant les valeurs données en paramètres aux étiquettes.
            $repPDO->execute(array(':newProName' => $updName, 
                                    ':newDecisionMaker' => $updDecisionMaker, 
                                    ':newMainPhone' => self::phoneFormatToInternational($updMainPhone), 
                                    ':newSecondaryPhone' => self::phoneFormatToInternational($updSecondaryPhone), 
                                    ':newMail' => $updMail, 
                                    ':newMainAdress' => $updMainAdress, 
                                    ':newSecondaryAdress' => $updSecondaryAdress, 
                                    ':newCp' => $updCp, 
                                    ':newCity' => $updCity, 
                                    ':newObservation' => $updObservation, 
                                    ':newUserID' => $updUserId, 
                                    ':proToUpdate' => $proId));
//          Réinitialise le curseur.
            $repPDO->closeCursor();
//          Ferme la connexion à la bdd.
            BddConnexion::disconnect();
        } catch(Exception $e) {
            die('Erreur : Accès interdit ou connexion impossible.');
        }
    }

//  °°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°
    public static function createNewProspect(Int $userId, Int $proActivityArea, String $proName, String $proDecisionMaker, 
                                        String $proMainPhone, String $proSecondaryPhone,
                                        String $proMail, String $proMainAdress, String $proSecondaryAdress,
                                        String $proCp, String $proCity, String $proObservation) {
        
        try {
//          Etablit une connexion à la base de données.
            $PDOconnexion = BddConnexion::getConnexion();
/*
            Prépare la requête SQL et l'enregistre dans une variable =>
            On souhaite ici insérer un nouveau prospect dans la base de données. 
*/
            $sqlRequest = ' INSERT INTO `professionnel` (
                            `ID_utilisateur`, `ID_secteur`, `libelle_entreprise`, `nom_decideur`, 
                            `tel`, `tel_2`, `mail`, `adresse`, `adresse_2`, `cp`, `ville`, 
                            `observation`) 
                            VALUES (
                            :ID_utilisateur, :ID_secteur, :libelle_entreprise, :nom_decideur, :tel, 
                            :tel_2, :mail, :adresse, :adresse_2, 
                            :cp, :ville, :observation); ';
//          Connexion PDO + prépare l'envoi de la requête.
            $repPDO = $PDOconnexion->prepare($sqlRequest);
//          Exécute la requête en affectant les valeurs données en paramètres aux étiquettes.
            $repPDO->execute(array(':ID_utilisateur' => $userId, ':ID_secteur' => $proActivityArea, 
                                    ':libelle_entreprise' => $proName, ':nom_decideur' => $proDecisionMaker,
                                    ':tel' => self::phoneFormatToInternational($proMainPhone), 
                                    ':tel_2' => self::phoneFormatToInternational($proSecondaryPhone), 
                                    ':mail' => $proMail, ':adresse' => $proMainAdress, 
                                    ':adresse_2' => $proSecondaryAdress, ':cp' => $proCp, 
                                    ':ville' => $proCity, ':observation' => $proObservation));
//          Réinitialise le curseur.
            $repPDO->closeCursor();
//          Ferme la connexion à la bdd.
            BddConnexion::disconnect();
        } catch(Exception $e) {
            die('Erreur : Accès interdit ou connexion impossible.');
        }
    }
//  °°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°
    public static function createNewCustomer(Int $userId, Int $proActivityArea, String $proName, String $proDecisionMaker, 
                                        String $proMainPhone, String $proSecondaryPhone,
                                        String $proMail, String $proMainAdress, String $proSecondaryAdress,
                                        $proCp, String $proCity, String $proObservation) {
        
        try {
//          Etablit une connexion à la base de données.
            $PDOconnexion = BddConnexion::getConnexion();
/*
            Prépare la requête SQL et l'enregistre dans une variable =>
            On souhaite ici insérer un nouveau client dans la base de données. 
*/
            $sqlRequest = ' INSERT INTO `professionnel` (
                            `ID_utilisateur`, `ID_secteur`, `libelle_entreprise`, `nom_decideur`, 
                            `tel`, `tel_2`, `mail`, `adresse`, `adresse_2`, `cp`, `ville`, 
                            `observation`, `prospect_ou_client`) 
                            VALUES (
                            :ID_utilisateur, :ID_secteur, :libelle_entreprise, :nom_decideur, :tel, 
                            :tel_2, :mail, :adresse, :adresse_2, 
                            :cp, :ville, :observation, :prospect_ou_client); ';
//          Connexion PDO + prépare l'envoi de la requête.
            $repPDO = $PDOconnexion->prepare($sqlRequest);
//          Exécute la requête en affectant les valeurs données en paramètres aux étiquettes.
            $repPDO->execute(array(':ID_utilisateur' => $userId, ':ID_secteur' => $proActivityArea, 
                                    ':libelle_entreprise' => $proName, ':nom_decideur' => $proDecisionMaker,
                                    ':tel' => self::phoneFormatToInternational($proMainPhone), 
                                    ':tel_2' => self::phoneFormatToInternational($proSecondaryPhone), 
                                    ':mail' => $proMail, ':adresse' => $proMainAdress, 
                                    ':adresse_2' => $proSecondaryAdress, ':cp' => $proCp, 
                                    ':ville' => $proCity, ':observation' => $proObservation,
                                    ':prospect_ou_client' => 1));
//          Réinitialise le curseur.
            $repPDO->closeCursor();
//          Ferme la connexion à la bdd.
            BddConnexion::disconnect();
        } catch(Exception $e) {
            die('Erreur : Accès interdit ou connexion impossible.');
        }
    }
//  °°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°
    public static function getLastAutoIncrementValue() {
        try {
//          Etablit une connexion à la base de données.
            $PDOconnexion = BddConnexion::getConnexion();
/*
            Prépare la requête SQL et l'enregistre dans une variable =>
            On souhaite ici récupérer : 
                - l'identifiant du prochain professionnel qui sera enregistré dans la base de données.
*/
            $sqlRequest = " SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES 
                            WHERE TABLE_SCHEMA = 'dbs5021355' AND TABLE_NAME = 'professionnel'; ";
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
    public static function prospectOrCustomer(int $paramId) {
        try {
//          Etablit une connexion à la base de données.
            $PDOconnexion = BddConnexion::getConnexion();
/*
            Prépare la requête SQL et l'enregistre dans une variable =>
            On souhaite ici récupérer : 
            - l'information prospect_ou_client pour un professionnel dont on fournit l'id en paramètre'.
*/
            $sqlRequest = " SELECT 
                            prospect_ou_client
                            FROM professionnel
                            WHERE ID_professionnel = :paramId ;";
//          Connexion PDO + prépare l'envoi de la requête.
            $repPDO = $PDOconnexion->prepare($sqlRequest);
//          Exécute la requête en affectant les valeurs données en paramètres aux étiquettes.
            $repPDO->execute(array(':paramId' => $paramId));
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
    public static function checkWhichUserIsInChargeOfThisPro(int $paramId) {
        try {
//          Etablit une connexion à la base de données.
            $PDOconnexion = BddConnexion::getConnexion();
/*
            Prépare la requête SQL et l'enregistre dans une variable =>
            On souhaite ici récupérer : 
            - l'utilisateur en charge du suivi d'un professionnel.
*/
            $sqlRequest = " SELECT 
                            ID_utilisateur
                            FROM professionnel
                            WHERE ID_professionnel = :paramId ;";
//          Connexion PDO + prépare l'envoi de la requête.
            $repPDO = $PDOconnexion->prepare($sqlRequest);
//          Exécute la requête en affectant les valeurs données en paramètres aux étiquettes.
            $repPDO->execute(array(':paramId' => $paramId));
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
    public static function getProListByCp(String $paramCp) {
        try {
//          Etablit une connexion à la base de données.
            $PDOconnexion = BddConnexion::getConnexion();
/*
            Prépare la requête SQL et l'enregistre dans une variable =>
            On souhaite ici récupérer : 
            - l'utilisateur en charge du suivi d'un professionnel.
*/
            $sqlRequest = " SELECT 
                            `libelle_entreprise`,
                            `nom_decideur`,
                            `adresse`,
                            `cp`, 
                            `ville`, 
                            `tel`,
                            `observation`,
                            `prospect_ou_client`
                            FROM professionnel
                            WHERE `cp` = :paramCp; ";
//          Connexion PDO + prépare l'envoi de la requête.
            $repPDO = $PDOconnexion->prepare($sqlRequest);
//          Exécute la requête en affectant les valeurs données en paramètres aux étiquettes.
            $repPDO->execute(array(':paramCp' => $paramCp));
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
    public static function checkIfExists(String $paramString) {
        try {
//          Etablit une connexion à la base de données.
            $PDOconnexion = BddConnexion::getConnexion();
/*
            Prépare la requête SQL et l'enregistre dans une variable =>
            On souhaite ici contrôler si la chaîne passée en paramètre 
            est un doublon d'un élement existant dans la bdd 
*/
            $sqlRequest = ' SELECT libelle_entreprise FROM professionnel 
                            WHERE LOWER(libelle_entreprise) = LOWER(?) ';
//          Lance la requête.
            $launchRequest = $PDOconnexion->prepare($sqlRequest);
            $launchRequest->execute(array($paramString));
//          Compte le nombre de retours de la requêtes. 
            $count = $launchRequest->rowCount();
//          Réinitialise le curseur.
            $launchRequest->closeCursor();
//          Ferme la connexion.
            BddConnexion::disconnect();
            return (int) $count;
        } catch(Exception $e) {
            die('Erreur : Accès interdit ou connexion impossible.');
        }
    }
//  °°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°
    public static function prospectBecomeClient(Int $paramIdPro) {
        try {
//          Etablit une connexion à la base de données.
            $PDOconnexion = BddConnexion::getConnexion();
/*
            Prépare la requête SQL et l'enregistre dans une variable =>
            On souhaite ici faire passer un prospect en client dans la bdd. 
*/
            $sqlRequest = ' UPDATE `professionnel` 
                            SET 
                            `prospect_ou_client` = 1
                            WHERE `ID_professionnel` = :proToUpdate ;';
//          Connexion PDO + prépare l'envoi de la requête.
            $repPDO = $PDOconnexion->prepare($sqlRequest);
//          Exécute la requête en affectant les valeurs données en paramètres aux étiquettes.
            $repPDO->execute(array(':proToUpdate' => $paramIdPro));
//          Réinitialise le curseur.
            $repPDO->closeCursor();
//          Ferme la connexion à la bdd.
            BddConnexion::disconnect();
        } catch(Exception $e) {
            die('Erreur : Accès interdit ou connexion impossible.');
        }
    }
    
//  °°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°
    public static function phoneFormatToFrench(String $phoneNumber) {
//  Permet de convertir un numéro de téléphone d'un format "+33..." à "06...".
        if ($phoneNumber == '') {
            return '';
        } else {
            $formattedPhoneNumber = substr_replace($phoneNumber, '0', 0, -9);
            return $formattedPhoneNumber;
        }
    }
//  °°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°
    public static function phoneFormatToInternational(String $phoneNumber) {
//  Permet de convertir un numéro de téléphone d'un format "06..." à "+33...".
        if ($phoneNumber == '') {
            return '';
        } else {
            $formattedPhoneNumber = substr_replace($phoneNumber, '+33', 0, -9);
            return $formattedPhoneNumber;
        }
    }
}
?>