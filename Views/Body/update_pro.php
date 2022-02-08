<?php 
$unknown = 'Non renseigné';
$userConnected = (int) $_SESSION['idUser'];
$rights = (int) $_SESSION['rights'];
?>
<div class="container">
<hr>
    <div class="container d-flex justify-content-center">
        <fieldset class="fieldsetManagement ps-1 pe-1">
            <legend class="fw-bold d-flex justify-content-center mb-4">Modifier informations :</legend>
<?php 
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
                <input type="hidden" name="currentProId" value="<?php echo($_POST['ID_professionnel']);?>">
                <input type="hidden" name="prospect_ou_client" value="<?php echo($_POST['prospect_ou_client']);?>">
                <input type="hidden" name="action" value="updatedPro">
                <div class="d-flex flex-column justify-content-center w-100"></div>
<!-------------------------------------------------------------PRO NAME------------------------------------------------------------------------>
                    <div class="w-100 d-flex justify-content-center">
                        <div class="w-75 mb-2">
                            <label for="MAJPRONAME" class="form-label">Nom (entreprise) :</label>
                            <input required value="<?php echo($_POST['libelle_entreprise']);?>" type="text" class="form-control" name="majProName" id="MAJPRONAME" minlength="2" maxlength="50" pattern="^[\w'\-,.]*[^_!¡?÷?¿\/\\+=@#$%ˆ&*(){}|~<>;:[\]]*${1,50}">
                        </div>
                    </div>
<!----------------------------------------------------------DECISION MAKER--------------------------------------------------------------------->
                    <div class="w-100 d-flex justify-content-center">
                        <div class="w-75 mb-2">
                            <label for="MAJDECISIONMAKERNAME" class="form-label">Nom de l'interlocuteur principal (décideur) :</label>
<?php
                            if ($_POST['nom_decideur'] === "") {
?>
                                <input placeholder="<?php echo($unknown);?>" type="text" class="form-control" name="majDecisionMakerName" id="MAJDECISIONMAKERNAME" minlength="2" maxlength="50" pattern="^[\w'\-,.]*[^_!¡?÷?¿\/\\+=@#$%ˆ&*(){}|~<>;:[\]]*${1,50}">
<?php               
                            } else { 
?>
                                <input value="<?php echo($_POST['nom_decideur']);?>" type="text" class="form-control" name="majDecisionMakerName" id="MAJDECISIONMAKERNAME" minlength="2" maxlength="50" pattern="^[\w'\-,.]*[^_!¡?÷?¿\/\\+=@#$%ˆ&*(){}|~<>;:[\]]*${1,50}">
<?php
                            }
?>
                        </div>
                    </div>
<!--------------------------------------------------------------TEL 1-------------------------------------------------------------------------->
                    <div class="w-100 d-flex justify-content-center">
                        <div class="w-75 mb-2">
                            <label for="MAJPROPHONE" class="form-label">Numéro de téléphone principal :</label>
<?php
                            if ($_POST['tel'] === "") {
?>
                                <input placeholder="<?php echo($unknown);?>" type="tel" class="form-control" name="majProPhone" id="MAJPROPHONE" minlength="10" maxlength="10" pattern="[0-9]{10}"> 
<?php               
                            } else { 
?>
                                <input value="<?php echo(User_Mgr::phoneFormatToFrench($_POST['tel'])); ?>" type="tel" class="form-control" name="majProPhone" id="MAJPROPHONE" minlength="10" maxlength="10" pattern="[0-9]{10}">
<?php
                            }
?>
                        </div>
                    </div>
<!---------------------------------------------------------------TEL 2------------------------------------------------------------------------->
                    <div class="w-100 d-flex justify-content-center">
                        <div class="w-75 mb-2">
                            <label for="MAJPROPHONE2" class="form-label">Numéro de téléphone secondaire :</label>
<?php
                            if ($_POST['tel_2'] === "") {
?>
                                <input placeholder="<?php echo($unknown);?>" type="tel" class="form-control" name="majProPhone2" id="MAJPROPHONE2" minlength="10" maxlength="10" pattern="[0-9]{10}"> 
<?php               
                            } else { 
?>
                                <input value="<?php echo(User_Mgr::phoneFormatToFrench($_POST['tel_2'])); ?>" type="tel" class="form-control" name="majProPhone2" id="MAJPROPHONE2" minlength="10" maxlength="10" pattern="[0-9]{10}">
<?php
                            }
?>
                        </div>
                    </div>
<!----------------------------------------------------------------MAIL------------------------------------------------------------------------->
                    <div class="w-100 d-flex justify-content-center">
                        <div class="w-75 mb-2">
                            <label for="MAJPROMAIL" class="form-label">Adresse mail :</label>
<?php
                            if ($_POST['mail'] === "") {
?>
                                <input placeholder="<?php echo($unknown);?>" type="mail" class="form-control" name="majProMail" id="MAJPROMAIL" minlength="5" maxlength="60">
<?php               
                            } else { 
?>
                                <input value="<?php echo($_POST['mail']);?>" type="mail" class="form-control" name="majProMail" id="MAJPROMAIL" minlength="5" maxlength="60">
<?php
                            }
?>
                        </div>
                    </div>
<!-------------------------------------------------------------ADRESS 1------------------------------------------------------------------------>
                    <div class="w-100 d-flex justify-content-center">
                        <div class="w-75 mb-2">
                            <label for="MAJPROADRESS" class="form-label">Adresse principale :</label>
<?php
                            if ($_POST['adresse'] === "") {
?>
                                <input placeholder="<?php echo($unknown);?>" type="text" class="form-control" name="majProAdress" id="MAJPROADRESS" minlength="3" maxlength="50">
<?php               
                            } else { 
?>
                                <input value="<?php echo($_POST['adresse']);?>" type="text" class="form-control" name="majProAdress" id="MAJPROADRESS" minlength="3" maxlength="50">
<?php
                            }
?>
                        </div>
                    </div>
<!-------------------------------------------------------------ADRESS 2------------------------------------------------------------------------>
                    <div class="w-100 d-flex justify-content-center">
                        <div class="w-75 mb-2">
                            <label for="MAJPROADRESS2" class="form-label">Complément d'adresse :</label>
<?php
                            if ($_POST['adresse_2'] === "") {
?>
                                <input placeholder="<?php echo($unknown);?>" type="text" class="form-control" name="majProAdress2" id="MAJPROADRESS2" minlength="3" maxlength="50">
<?php               
                            } else { 
?>
                                <input value="<?php echo($_POST['adresse_2']);?>" type="text" class="form-control" name="majProAdress2" id="MAJPROADRESS2" minlength="3" maxlength="50">
<?php
                            }
?>
                        </div>
                    </div>
<!----------------------------------------------------------------CP--------------------------------------------------------------------------->
                    <div class="w-100 d-flex justify-content-center">
                        <div class="w-75 mb-2">
                            <label for="MAJPROCP" class="form-label">Code postal :</label>
<?php
                            if ($_POST['cp'] === "") {
?>                
                                <input placeholder="<?php echo($unknown);?>" type="text" class="form-control" name="majProCp" id="MAJPROCP" minlength="5" maxlength="5" pattern="[0-9]{5}">
<?php               
                            } else { 
?>
                                <input value="<?php echo($_POST['cp']);?>" type="text" class="form-control" name="majProCp" id="MAJPROCP" minlength="5" maxlength="5" pattern="[0-9]{5}">
<?php
                            }
?>
                        </div>
                    </div>
<!----------------------------------------------------------------CITY------------------------------------------------------------------------->
                    <div class="w-100 d-flex justify-content-center">
                        <div class="w-75 mb-2">
                            <label for="MAJPROCITY" class="form-label">Ville :</label>
<?php
                            if ($_POST['ville'] === "") {
?>           
                                <input placeholder="<?php echo($unknown);?>" type="text" class="form-control" name="majProCity" id="MAJPROCITY" minlength="2" maxlength="50">
<?php               
                            } else { 
?>
                                <input value="<?php echo($_POST['ville']);?>" type="text" class="form-control" name="majProCity" id="MAJPROCITY" minlength="2" maxlength="50">
<?php
                            }
?>
                        </div>
                    </div>
<!-------------------------------------------------------------OBSERVATION--------------------------------------------------------------------->
                    <div class="w-100 d-flex justify-content-center">
                        <div class="w-75 mb-2">
                            <label for="MAJPROOBSERVATION" class="form-label">Observation(s) :</label>
<?php
                            if ($_POST['observation'] === "") {
?>           
                                <textarea placeholder="<?php echo($unknown);?>" class="form-control" name="majProObservation" id="MAJPROOBSERVATION" maxlength="250"></textarea>
<?php               
                            } else { 
?>
                                <textarea class="form-control" name="majProObservation" id="MAJPROOBSERVATION" maxlength="250"><?php echo($_POST['observation']);?></textarea>
<?php
                            }
?>
                        </div> 
                    </div>
<!------------------------------------------------------------FOLLOWED BY---------------------------------------------------------------------->
<?php
                if ($rights === 1) {
?>
                    <div class="w-100 d-flex justify-content-center">
                        <div class="w-75 mb-4">
                            <label for="MAJPROFOLLOWEDBY" class="form-label">Suivi par :</label>
                            <select class="form-select" name="majProFollowedBy">
                                <option selected value="<?php echo($_POST['ID_utilisateur']);?>"><?php echo($_POST['prenom'].' '.$_POST['nom']);?></option>            
<?php 
//                              Récupère la liste des utilisateurs.
                                $tUsers = User_Mgr::getUsersList();
                                foreach($tUsers as $tUser) {
                                    echo
                                        '<option value="';echo($tUser['ID_utilisateur']);echo'">'.$tUser['prenom'].' '.$tUser['nom'].'</option>';
                                }
?>
                            </select>
                        </div>
                    </div>
<?php
                }
?>
            <div class="d-flex justify-content-center">
                <button type="submit" class="btn" onclick="return confirm('Etes-vous sûr(e) de vouloir modifier ces informations ?')"><span>Valider</span></button>
            </div>
        </form>
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
                            <button type="submit" class="btnBack"><span>Retour</span></button>
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
                            <button type="submit" class="btnBack"><span>Retour</span></button>
                        </div>
                    </form>
<?php
            }
?>
        </fieldset>
    </div>
</div>