<?php
$unknown = 'Non renseigné';
$userConnected = (int) $_SESSION['idUser'];
$rights = (int) $_SESSION['rights'];
?>
<div class="container">
<hr>
    <div class="container d-flex justify-content-center">
        <fieldset class="fieldsetManagement ps-1 pe-1">
            <legend class="fw-bold d-flex justify-content-center mb-4">Informations détaillées :</legend>
                <div class="d-md-flex flex-md-row justify-content-md-around w-md-100
                                d-xs-flex flex-xs-column justify-content-xs-center w-xs-100">
<!-------------------------------------------PRO NAME--------------------------------------------->              
                    <div class="w-100 d-flex justify-content-center">
                        <div class="w-100 mb-2 d-flex justify-content-center">
                            <label id="infosPro" class="form-label">Professionnel :</label>
                                <span class="infosPro"><?php echo('&nbsp;'.$_POST['libelle_entreprise']);?></span>
                        </div>
                    </div>
                    
<!-----------------------------------------lAST CONTACT------------------------------------------->
                    <div class="w-100 d-flex justify-content-center">
                        <div class="w-100 mb-2 d-flex justify-content-center ">
                            <label id="infosPro" class="form-label">Dernier contact :</label>
<?php
                            if ($_POST['date_derniere_pdc'] === "") {
?>
                                <span class="infosPro"><?php echo('&nbsp;'.$unknown);?></span>
<?php
                            } else {                        
?>
                                <span class="infosPro"><?php echo('&nbsp;'.Dates_Mgr::dateFormatDayMonthYear($_POST['date_derniere_pdc']));?></span>
<?php
                            }
?>
                        </div>
                    </div>
                    
                </div>
<!-----------------------------------------FOLLOWED BY-------------------------------------------->
                <div class="d-md-flex flex-md-row justify-content-md-around w-md-100
                                d-xs-flex flex-xs-column justify-content-xs-center w-xs-100">
                    <div class="w-100 d-flex justify-content-center">
                        <div class="w-100 mb-2 d-flex justify-content-center">
                            <label id="infosPro" class="form-label">Suivi par :</label>
                                <span class="infosPro"><?php echo('&nbsp;'.$_POST['prenom'] . ' ' . $_POST['nom']);?></span>
                        </div>
                    </div>
                    
<!----------------------------------------DECISION MAKER------------------------------------------>
                    <div class="w-100 d-flex justify-content-center">
                        <div class="w-100 mb-2 d-flex justify-content-center">
                            <label id="infosPro" class="form-label">Décideur :</label>
<?php
                            if ($_POST['nom_decideur'] === "") {
?>
                                <span class="infosPro"><?php echo('&nbsp;'.$unknown);?></span>
<?php               
                            } else { 
?>
                                <span class="infosPro"><?php echo('&nbsp;'.$_POST['nom_decideur']);?></span>
<?php
                            }
?>
                        </div>
                    </div>
                    
                </div>
<!-----------------------------------------AREA ACTIVITY------------------------------------------>
                <div class="d-md-flex flex-md-row-reverse justify-content-md-around w-md-100
                                d-xs-flex flex-xs-column justify-content-xs-center w-xs-100">
                    <div class="w-100 d-flex justify-content-center">
                        <div class="w-100 mb-2 d-flex justify-content-center">
                            <label id="infosPro" class="form-label">Secteur d'activité :</label>
<?php
                            if ($_POST['libelle_secteur'] === "") {
?>
                                <span class="infosPro"><?php echo('&nbsp;'.$unknown);?></span>
<?php
                            } else {
?>
                                <span class="infosPro"><?php echo('&nbsp;'.$_POST['libelle_secteur']);?></span>
<?php
                            }
?>
                        </div>
                    </div>
                    
<!-------------------------------------------MAIN PHONE------------------------------------------->
                    <div class="w-100 d-flex justify-content-center">
                        <div class="w-100 mb-2 d-flex justify-content-center">
                            <label id="infosPro" class="form-label">Téléphone 1 :</label>
<?php
                            if ($_POST['tel'] === "") {
?>
                                <span class="infosPro"><?php echo('&nbsp;'.$unknown);?></span>
<?php
                            } else {
?>
                                <span class="infosPro"><?php echo('&nbsp;'.Pro_Mgr::phoneFormatToFrench($_POST['tel']));?></span>
<?php
                            }
?>
                        </div>
                    </div>
                    
                </div>
<!----------------------------------------SECONDARY PHONE----------------------------------------->
                <div class="d-md-flex flex-md-row justify-content-md-around w-md-100
                                d-xs-flex flex-xs-column justify-content-xs-center w-xs-100">
                    <div class="w-100 d-flex justify-content-center">
                        <div class="w-100 mb-2 d-flex justify-content-center">
                            <label id="infosPro" class="form-label">Téléphone 2 :</label>
<?php
                            if ($_POST['tel_2'] === "") {
?>
                                <span class="infosPro"><?php echo('&nbsp;'.$unknown);?></span>
<?php
                            } else {
?>
                                <span class="infosPro"><?php echo('&nbsp;'.Pro_Mgr::phoneFormatToFrench($_POST['tel_2']));?></span>
<?php
                            }
?>
                        </div>
                    </div>
                    
<!----------------------------------------------MAIL---------------------------------------------->
                    <div class="w-100 d-flex justify-content-center">
                        <div class="w-100 mb-2 d-flex justify-content-center">
                            <label id="infosPro" class="form-label">Mail :</label>
<?php
                            if ($_POST['mail'] === "") {
?>
                                <span class="infosPro"><?php echo('&nbsp;'.$unknown);?></span>
<?php
                            } else {
?>
                                <span class="infosPro"><?php echo('&nbsp;'.$_POST['mail']);?></span>
<?php
                            }
?>
                        </div>
                    </div>
                    
                </div>
<!-------------------------------------------MAIN ADRESS------------------------------------------>
                <div class="d-md-flex flex-md-row justify-content-md-around w-md-100
                                d-xs-flex flex-xs-column justify-content-xs-center w-xs-100">
                    <div class="w-100 d-flex justify-content-center">
                        <div class="w-100 mb-2 d-flex justify-content-center">
                            <label id="infosPro" class="form-label">Adresse :</label>
<?php
                            if ($_POST['adresse'] === "") {
?>
                                <span class="infosPro"><?php echo('&nbsp;'.$unknown);?></span>
<?php
                            } else {
?>
                                <span class="infosPro"><?php echo('&nbsp;'.$_POST['adresse']);?></span>
<?php
                            }
?>
                        </div>
                    </div>
                    
<!-----------------------------------------SECONDARY ADRESS--------------------------------------->
                    <div class="w-100 d-flex justify-content-center">    
                        <div class="w-100 mb-2 d-flex justify-content-center">
                            <label id="infosPro" class="form-label">Complément d'adresse :</label>
<?php
                            if ($_POST['adresse_2'] === "") {
?>
                                <span class="infosPro"><?php echo('&nbsp;'.$unknown);?></span>
<?php
                            } else {
?>
                                <span class="infosPro"><?php echo('&nbsp;'.$_POST['adresse_2']);?></span>
<?php
                            }
?>
                        </div>
                    </div>
                    
                </div>
<!-----------------------------------------------CP----------------------------------------------->
                <div class="d-md-flex flex-md-row justify-content-md-around w-md-100
                                d-xs-flex flex-xs-column justify-content-xs-center w-xs-100">
                    <div class="w-100 d-flex justify-content-center">
                        <div class="w-100 mb-2 d-flex justify-content-center">
                            <label id="infosPro" class="form-label">Code postal :</label>
<?php
                            if ($_POST['cp'] === "") {
?>
                                <span class="infosPro"><?php echo('&nbsp;'.$unknown);?></span>
<?php
                            } else {
?>
                                <span class="infosPro"><?php echo('&nbsp;'.$_POST['cp']);?></span>
<?php
                            }
?>
                        </div>
                    </div>
                    
<!----------------------------------------------CITY---------------------------------------------->
                    <div class="w-100 d-flex justify-content-center">
                        <div class="w-100 mb-2 d-flex justify-content-center">
                            <label id="infosPro" class="form-label">Ville :</label>
<?php
                            if ($_POST['ville'] === "") {
?>
                                <span class="infosPro"><?php echo('&nbsp;'.$unknown);?></span>
<?php
                            } else {
?>
                                <span class="infosPro"><?php echo('&nbsp;'.$_POST['ville']);?></span>
<?php
                            }
?>
                        </div>
                    </div>
                </div>
                <hr>
<!-------------------------------------------OBSERVATION------------------------------------------>
                <div class="w-100 d-flex justify-content-center">
                    <div class="w-75 mb-2 d-flex justify-content-center">
                        
<?php
                    if ($_POST['observation'] === "") {
?>
                        <label id="infosPro" class="form-label">Observation :</label>
                            <span class="infosPro"><?php echo('&nbsp;'.$unknown);?></span>
<?php
                    } else {
?>
                        <textarea class="w-100 form-control">Observation : <?php echo('&nbsp;'.$_POST['observation']);?></textarea>
<?php
                    }
?>
                    </div>
                </div>
                <hr>
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




