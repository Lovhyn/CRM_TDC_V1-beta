<!--$_POST = OK-->
<?php
$unknown = 'Non renseigné';
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
                                <span class="infosPro"><?php echo($_POST['pro_name']);?></span>
                            <hr>
                        </div>
<!--------------------------------------------START----------------------------------------------->
                        <div class="mb-3">
                            <label id="infosPro" class="form-label">Dernière prise de contact :</label>
<?php
                            if ($_POST['last_contact'] === "") {
?>
                                <span class="undefined"><?php echo($unknown);?></span>
<?php
                            } else {                        
?>
                                <span class="infosPro"><?php echo(Dates_Mgr::dateFormatDayMonthYear($_POST['last_contact']));?></span>
<?php
                            }
?>
                            <hr>
                        </div>
<!-----------------------------------------FOLLOWED BY-------------------------------------------->
                        <div class="mb-3">
                            <label id="infosPro" class="form-label">Suivi par :</label>
                                <span class="infosPro"><?php echo($_POST['user_surname'] . ' ' . $_POST['user_name']);?></span>
                            <hr>
                        </div>
<!----------------------------------------DECISION MAKER------------------------------------------>
                        <div class="mb-3">
                            <label id="infosPro" class="form-label">Interlocuteur principal :</label>
<?php
                            if ($_POST['pro_decision_maker'] === "") {
?>
                                <span class="undefined"><?php echo($unknown);?></span>
<?php               
                            } else { 
?>
                                <span class="infosPro"><?php echo($_POST['pro_decision_maker']);?></span>
<?php
                            }
?>
                            <hr>
                        </div>
<!-----------------------------------------AREA ACTIVITY------------------------------------------>
                        <div class="mb-3">
                            <label id="infosPro" class="form-label">Secteur d'activité :</label>
<?php
                            if ($_POST['area_lib'] === "") {
?>
                                <span class="undefined"><?php echo($unknown);?></span>
<?php
                            } else {
?>
                                <span class="infosPro"><?php echo($_POST['area_lib']);?></span>
<?php
                            }
?>
                            <hr>
                        </div>
<!-------------------------------------------MAIN PHONE------------------------------------------->
                        <div class="mb-3">
                            <label id="infosPro" class="form-label">Téléphone principal :</label>
<?php
                            if ($_POST['pro_phone'] === "") {
?>
                                <span class="undefined"><?php echo($unknown);?></span>
<?php
                            } else {
?>
                                <span class="infosPro"><?php echo($_POST['pro_phone']);?></span>
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
                            if ($_POST['pro_phone2'] === "") {
?>
                                <span class="undefined"><?php echo($unknown);?></span>
<?php
                            } else {
?>
                                <span class="infosPro"><?php echo($_POST['pro_phone2']);?></span>
<?php
                            }
?>
                            <hr>
                        </div>
<!----------------------------------------------MAIL---------------------------------------------->
                        <div class="mb-3">
                            <label id="infosPro" class="form-label">Mail :</label>
<?php
                            if ($_POST['pro_mail'] === "") {
?>
                                <span class="undefined"><?php echo($unknown);?></span>
<?php
                            } else {
?>
                                <span class="infosPro"><?php echo($_POST['pro_mail']);?></span>
<?php
                            }
?>
                            <hr>
                        </div>
<!-------------------------------------------MAIN ADRESS------------------------------------------>
                        <div class="mb-3">
                            <label id="infosPro" class="form-label">Adresse principale :</label>
<?php
                            if ($_POST['pro_adress'] === "") {
?>
                                <span class="undefined"><?php echo($unknown);?></span>
<?php
                            } else {
?>
                                <span class="infosPro"><?php echo($_POST['pro_adress']);?></span>
<?php
                            }
?>
                            <hr>
                        </div>
<!-----------------------------------------SECONDARY ADRESS--------------------------------------->
                        <div class="mb-3">
                            <label id="infosPro" class="form-label">Complément d'adresse :</label>
<?php
                            if ($_POST['pro_adress2'] === "") {
?>
                                <span class="undefined"><?php echo($unknown);?></span>
<?php
                            } else {
?>
                                <span class="infosPro"><?php echo($_POST['pro_adress2']);?></span>
<?php
                            }
?>
                            <hr>
                        </div>
<!-----------------------------------------------CP----------------------------------------------->
                        <div class="mb-3">
                            <label id="infosPro" class="form-label">Code postal :</label>
<?php
                            if ($_POST['pro_cp'] === "") {
?>
                                <span class="undefined"><?php echo($unknown);?></span>
<?php
                            } else {
?>
                                <span class="infosPro"><?php echo($_POST['pro_cp']);?></span>
<?php
                            }
?>
                            <hr>
                        </div>
<!----------------------------------------------CITY---------------------------------------------->
                        <div class="mb-3">
                            <label id="infosPro" class="form-label">Ville :</label>
<?php
                            if ($_POST['pro_city'] === "") {
?>
                                <span class="undefined"><?php echo($unknown);?></span>
<?php
                            } else {
?>
                                <span class="infosPro"><?php echo($_POST['pro_city']);?></span>
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
                    if ($_POST['pro_observation'] === "") {
?>
                        <label id="infosPro" class="form-label">Observation :</label>
                            <span class="undefined"><?php echo($unknown);?></span>
<?php
                    } else {
?>
                        <textarea class="w-100 form-control">Observation : <?php echo($_POST['pro_observation']);?></textarea>
<?php
                    }
?>
                    <hr>
                </div>
<!----------------------------------------BACK RETURN BUTTON-------------------------------------->
<?php
            if ($_POST['pro_status'] === "0") {
                if ($_SESSION['rights'] === "1") {
?>
                    <form action="/outils/Controllers/Controller_admin.php" method="post">
                        <input type="hidden" name="action" value="prospectsListing">
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn"><span>Retour</span></button>
                        </div>
                    </form>
<?php
                } elseif ($_SESSION['rights'] === "2") {
?>
                    <form action="/outils/Controllers/Controller_responsable.php" method="post">
                        <input type="hidden" name="action" value="prospectsListing">
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn"><span>Retour</span></button>
                        </div>
                    </form>
<?php
                } elseif ($_SESSION['rights'] === "3") {
?>
                    <form action="/outils/Controllers/Controller_cdp.php" method="post">
                        <input type="hidden" name="action" value="prospectsListing">
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn"><span>Retour</span></button>
                        </div>
                    </form>
<?php
                }
            } else {
                if ($_SESSION['rights'] === "1") {
?>
                    <form action="/outils/Controllers/Controller_admin.php" method="post">
                        <input type="hidden" name="action" value="clientsListing">
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn"><span>Retour</span></button>
                        </div>
                    </form>
<?php
                } elseif ($_SESSION['rights'] === "2") {
?>
                    <form action="/outils/Controllers/Controller_responsable.php" method="post">
                        <input type="hidden" name="action" value="clientsListing">
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn"><span>Retour</span></button>
                        </div>
                    </form>
<?php
                } elseif ($_SESSION['rights'] === "3") {
?>
                    <form action="/outils/Controllers/Controller_cdp.php" method="post">
                        <input type="hidden" name="action" value="clientsListing">
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn"><span>Retour</span></button>
                        </div>
                    </form>
<?php
                }
            }
?>
        </fieldset>
    </div>
</div>




