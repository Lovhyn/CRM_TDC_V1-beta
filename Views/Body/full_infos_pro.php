<!--$_POST = OK-->
<?php
$unknown = 'Non renseigné';
$userConnected = (int) $_SESSION['idUser'];
$rights = (int) $_SESSION['rights'];
?>
<div class="container">
<hr>
    <div class="container container d-flex justify-content-center">
        <fieldset class="fieldsetManagement">
            <legend class="fw-bold d-flex justify-content-center mb-5">Informations détaillées :</legend>
                <div class="d-flex justify-content-between">
                    <div class="w-50 text-center">
<!-------------------------------------------PRO NAME--------------------------------------------->              
                        <div class="mb-3">
                            <label id="infosPro" class="form-label">Professionnel :</label>
                                <span class="infosPro"><?php echo($_POST['libelle_entreprise']);?></span>
                            <hr>
                        </div>
<!-----------------------------------------lAST CONTACT------------------------------------------->
                        <div class="mb-3">
                            <label id="infosPro" class="form-label">Dernière prise de contact :</label>
<?php
                            if ($_POST['date_derniere_pdc'] === "") {
?>
                                <span class="infosPro"><?php echo($unknown);?></span>
<?php
                            } else {                        
?>
                                <span class="infosPro"><?php echo(Dates_Mgr::dateFormatDayMonthYear($_POST['date_derniere_pdc']));?></span>
<?php
                            }
?>
                            <hr>
                        </div>
<!-----------------------------------------FOLLOWED BY-------------------------------------------->
                        <div class="mb-3">
                            <label id="infosPro" class="form-label">Suivi par :</label>
                                <span class="infosPro"><?php echo($_POST['prenom'] . ' ' . $_POST['nom']);?></span>
                            <hr>
                        </div>
<!----------------------------------------DECISION MAKER------------------------------------------>
                        <div class="mb-3">
                            <label id="infosPro" class="form-label">Interlocuteur principal :</label>
<?php
                            if ($_POST['nom_decideur'] === "") {
?>
                                <span class="infosPro"><?php echo($unknown);?></span>
<?php               
                            } else { 
?>
                                <span class="infosPro"><?php echo($_POST['nom_decideur']);?></span>
<?php
                            }
?>
                            <hr>
                        </div>
<!-----------------------------------------AREA ACTIVITY------------------------------------------>
                        <div class="mb-3">
                            <label id="infosPro" class="form-label">Secteur d'activité :</label>
<?php
                            if ($_POST['libelle_secteur'] === "") {
?>
                                <span class="infosPro"><?php echo($unknown);?></span>
<?php
                            } else {
?>
                                <span class="infosPro"><?php echo($_POST['libelle_secteur']);?></span>
<?php
                            }
?>
                            <hr>
                        </div>
<!-------------------------------------------MAIN PHONE------------------------------------------->
                        <div class="mb-3">
                            <label id="infosPro" class="form-label">Téléphone principal :</label>
<?php
                            if ($_POST['tel'] === "") {
?>
                                <span class="infosPro"><?php echo($unknown);?></span>
<?php
                            } else {
?>
                                <span class="infosPro"><?php echo($_POST['tel']);?></span>
<?php
                            }
?>
                            <hr>
                        </div>
                    </div>
                    <div class="w-50 text-center">
<!----------------------------------------SECONDARY PHONE----------------------------------------->
                        <div class="mb-3">
                            <label id="infosPro" class="form-label">Téléphone secondaire :</label>
<?php
                            if ($_POST['tel_2'] === "") {
?>
                                <span class="infosPro"><?php echo($unknown);?></span>
<?php
                            } else {
?>
                                <span class="infosPro"><?php echo($_POST['tel_2']);?></span>
<?php
                            }
?>
                            <hr>
                        </div>
<!----------------------------------------------MAIL---------------------------------------------->
                        <div class="mb-3">
                            <label id="infosPro" class="form-label">Mail :</label>
<?php
                            if ($_POST['mail'] === "") {
?>
                                <span class="infosPro"><?php echo($unknown);?></span>
<?php
                            } else {
?>
                                <span class="infosPro"><?php echo($_POST['mail']);?></span>
<?php
                            }
?>
                            <hr>
                        </div>
<!-------------------------------------------MAIN ADRESS------------------------------------------>
                        <div class="mb-3">
                            <label id="infosPro" class="form-label">Adresse principale :</label>
<?php
                            if ($_POST['adresse'] === "") {
?>
                                <span class="infosPro"><?php echo($unknown);?></span>
<?php
                            } else {
?>
                                <span class="infosPro"><?php echo($_POST['adresse']);?></span>
<?php
                            }
?>
                            <hr>
                        </div>
<!-----------------------------------------SECONDARY ADRESS--------------------------------------->
                        <div class="mb-3">
                            <label id="infosPro" class="form-label">Complément d'adresse :</label>
<?php
                            if ($_POST['adresse_2'] === "") {
?>
                                <span class="infosPro"><?php echo($unknown);?></span>
<?php
                            } else {
?>
                                <span class="infosPro"><?php echo($_POST['adresse_2']);?></span>
<?php
                            }
?>
                            <hr>
                        </div>
<!-----------------------------------------------CP----------------------------------------------->
                        <div class="mb-3">
                            <label id="infosPro" class="form-label">Code postal :</label>
<?php
                            if ($_POST['cp'] === "") {
?>
                                <span class="infosPro"><?php echo($unknown);?></span>
<?php
                            } else {
?>
                                <span class="infosPro"><?php echo($_POST['cp']);?></span>
<?php
                            }
?>
                            <hr>
                        </div>
<!----------------------------------------------CITY---------------------------------------------->
                        <div class="mb-3">
                            <label id="infosPro" class="form-label">Ville :</label>
<?php
                            if ($_POST['ville'] === "") {
?>
                                <span class="infosPro"><?php echo($unknown);?></span>
<?php
                            } else {
?>
                                <span class="infosPro"><?php echo($_POST['ville']);?></span>
<?php
                            }
?>
                            <hr>
                        </div>
                    </div>
                </div>
<!-------------------------------------------OBSERVATION------------------------------------------>
                <div class="mb-3 text-center">
                        
<?php
                if ($_POST['observation'] === "") {
?>
                    <label id="infosPro" class="form-label">Observation :</label>
                        <span class="infosPro"><?php echo($unknown);?></span>
<?php
                } else {
?>
                    <textarea class="w-100 form-control">Observation : <?php echo($_POST['observation']);?></textarea>
<?php
                }
?>
                    <hr>
                </div>
<!----------------------------------------BACK RETURN BUTTON-------------------------------------->
<?php
            if ($_POST['prospect_ou_client'] === "0") {
                if ($rights === 1) {
?>
                    <form action="/outils/Controllers/Controller_admin.php" method="post">
<?php
                } elseif ($rights === 2) {
?>
                    <form action="/outils/Controllers/Controller_responsable.php" method="post">
<?php
                } elseif ($rights === 3) {
?>
                    <form action="/outils/Controllers/Controller_cdp.php" method="post">
<?php
                }
?>
                        <input type="hidden" name="action" value="prospectsListing">
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn"><span>Retour</span></button>
                        </div>
                    </form>
<?php
            } else {
                if ($rights === 1) {
?>
                    <form action="/outils/Controllers/Controller_admin.php" method="post">
<?php
                } elseif ($rights === 2) {
?>
                    <form action="/outils/Controllers/Controller_responsable.php" method="post">
<?php
                } elseif ($rights === 3) {
?>
                    <form action="/outils/Controllers/Controller_cdp.php" method="post">
                        
<?php
                }
?>
                        <input type="hidden" name="action" value="clientsListing">
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn"><span>Retour</span></button>
                        </div>
                    </form>
<?php
            }
?>
        </fieldset>
    </div>
</div>




