<?php 
$unknown = 'Non renseigné';
?>
<div class="container">
<hr>
    <div class="container container d-flex justify-content-center">
        <fieldset class="fieldsetProManagement">
        <legend class="fw-bold d-flex justify-content-center mb-5">Modifier informations :</legend>
<?php 
    if ($_SESSION['rights'] === "1") {
?>
        <form name="updPro" action="/outils/Controllers/Controller_admin.php?action=updatedPro" method="post" class="UPDPRO">
                <input type="hidden" name="currentProId" value="<?php echo($_POST['pro_ID']);?>">
<?php
    } elseif ($_SESSION['rights'] === "2") {
?> 
        <form name="updPro" action="/outils/Controllers/Controller_responsable.php?action=updatedPro" method="post" class="UPDPRO">
                <input type="hidden" name="currentProId" value="<?php echo($_POST['pro_ID']);?>">
<?php
    } elseif ($_SESSION['rights'] === "3") {
?>
        <form name="updPro" action="/outils/Controllers/Controller_cdp.php?action=updatedPro" method="post" class="UPDPRO">
                <input type="hidden" name="currentProId" value="<?php echo($_POST['pro_ID']);?>">
<?php
    } 
?>
            <div class="mb-3">
                <label for="MAJPRONAME" class="form-label">Nom (entreprise) :</label>
                <input required value="<?php echo($_POST['pro_name']);?>" type="text" class="form-control" name="majProName" id="MAJPRONAME" minlength="2" maxlength="50" pattern="^[\w'\-,.]*[^_!¡?÷?¿\/\\+=@#$%ˆ&*(){}|~<>;:[\]]*${1,50}">
            </div>
<!----------------------------------------------------------DECISION MAKER--------------------------------------------------------------------->
            <div class="mb-3">
                <label for="MAJDECISIONMAKERNAME" class="form-label">Nom de l'interlocuteur principal (décideur) :</label>
<?php
                    if ($_POST['pro_decision_maker'] === "") {
?>
                        <input placeholder="<?php echo($unknown);?>" type="text" class="form-control" name="majDecisionMakerName" id="MAJDECISIONMAKERNAME" minlength="2" maxlength="50" pattern="^[\w'\-,.]*[^_!¡?÷?¿\/\\+=@#$%ˆ&*(){}|~<>;:[\]]*${1,50}">
<?php               
                    } else { 
?>
                        <input value="<?php echo($_POST['pro_decision_maker']);?>" type="text" class="form-control" name="majDecisionMakerName" id="MAJDECISIONMAKERNAME" minlength="2" maxlength="50" pattern="^[\w'\-,.]*[^_!¡?÷?¿\/\\+=@#$%ˆ&*(){}|~<>;:[\]]*${1,50}">
<?php
                    }
?>
            </div>
<!--------------------------------------------------------------TEL 1-------------------------------------------------------------------------->
            <div class="mb-3">
                <label for="MAJPROPHONE" class="form-label">Numéro de téléphone principal :</label>
<?php
                    if ($_POST['pro_phone'] === "") {
?>
                        <input placeholder="<?php echo($unknown);?>" type="tel" class="form-control" name="majProPhone" id="MAJPROPHONE" minlength="10" maxlength="10" pattern="[0-9]{10}"> 
<?php               
                    } else { 
?>
                        <input value="<?php echo(User_Mgr::phoneFormatToFrench($_POST['pro_phone'])); ?>" type="tel" class="form-control" name="majProPhone" id="MAJPROPHONE" minlength="10" maxlength="10" pattern="[0-9]{10}">
<?php
                    }
?>
            </div>
<!---------------------------------------------------------------TEL 2------------------------------------------------------------------------->
            <div class="mb-3">
                <label for="MAJPROPHONE2" class="form-label">Numéro de téléphone secondaire :</label>
<?php
                    if ($_POST['pro_phone2'] === "") {
?>
                        <input placeholder="<?php echo($unknown);?>" type="tel" class="form-control" name="majProPhone2" id="MAJPROPHONE2" minlength="10" maxlength="10" pattern="[0-9]{10}"> 
<?php               
                    } else { 
?>
                        <input value="<?php echo(User_Mgr::phoneFormatToFrench($_POST['pro_phone2'])); ?>" type="tel" class="form-control" name="majProPhone2" id="MAJPROPHONE2" minlength="10" maxlength="10" pattern="[0-9]{10}">
<?php
                    }
?>
            </div>
<!----------------------------------------------------------------MAIL------------------------------------------------------------------------->
            <div class="mb-3">
                <label for="MAJPROMAIL" class="form-label">Adresse mail :</label>
<?php
                    if ($_POST['pro_phone2'] === "") {
?>
                        <input placeholder="<?php echo($unknown);?>" type="mail" class="form-control" name="majProMail" id="MAJPROMAIL" minlength="5" maxlength="60">
<?php               
                    } else { 
?>
                        <input value="<?php echo($_POST['pro_mail']);?>" type="mail" class="form-control" name="majProMail" id="MAJPROMAIL" minlength="5" maxlength="60">
<?php
                    }
?>
            </div>
<!-------------------------------------------------------------ADRESS 1------------------------------------------------------------------------>
            <div class="mb-3">
                <label for="MAJPROADRESS" class="form-label">Adresse principale :</label>
<?php
                    if ($_POST['pro_adress'] === "") {
?>
                        <input placeholder="<?php echo($unknown);?>" type="text" class="form-control" name="majProAdress" id="MAJPROADRESS" minlength="3" maxlength="50">
<?php               
                    } else { 
?>
                        <input value="<?php echo($_POST['pro_adress']);?>" type="text" class="form-control" name="majProAdress" id="MAJPROADRESS" minlength="3" maxlength="50">
<?php
                    }
?>
            </div>
<!-------------------------------------------------------------ADRESS 2------------------------------------------------------------------------>
            <div class="mb-3">
                <label for="MAJPROADRESS2" class="form-label">Complément d'adresse :</label>
<?php
                    if ($_POST['pro_adress2'] === "") {
?>
                        <input placeholder="<?php echo($unknown);?>" type="text" class="form-control" name="majProAdress2" id="MAJPROADRESS2" minlength="3" maxlength="50">
<?php               
                    } else { 
?>
                        <input value="<?php echo($_POST['pro_adress2']);?>" type="text" class="form-control" name="majProAdress2" id="MAJPROADRESS2" minlength="3" maxlength="50">
<?php
                    }
?>
            </div>
<!----------------------------------------------------------------CP--------------------------------------------------------------------------->
            <div class="mb-3">
                <label for="MAJPROCP" class="form-label">Code postal :</label>
<?php
                    if ($_POST['pro_cp'] === "") {
?>                
                        <input placeholder="<?php echo($unknown);?>" type="text" class="form-control" name="majProCp" id="MAJPROCP" minlength="5" maxlength="5" pattern="[0-9]{5}">
<?php               
                    } else { 
?>
                        <input value="<?php echo($_POST['pro_cp']);?>" type="text" class="form-control" name="majProCp" id="MAJPROCP" minlength="5" maxlength="5" pattern="[0-9]{5}">
<?php
                    }
?>
            </div>
<!----------------------------------------------------------------CITY------------------------------------------------------------------------->
            <div class="mb-3">
                <label for="MAJPROCITY" class="form-label">Ville :</label>
<?php
                    if ($_POST['pro_city'] === "") {
?>           
                        <input placeholder="<?php echo($unknown);?>" type="text" class="form-control" name="majProCity" id="MAJPROCITY" minlength="2" maxlength="50">
<?php               
                    } else { 
?>
                        <input value="<?php echo($_POST['pro_city']);?>" type="text" class="form-control" name="majProCity" id="MAJPROCITY" minlength="2" maxlength="50">
<?php
                    }
?>
            
            </div>
<!-------------------------------------------------------------OBSERVATION--------------------------------------------------------------------->
            <div class="mb-3">
                <label for="MAJPROOBSERVATION" class="form-label">Observation(s) :</label>
<?php
                    if ($_POST['pro_observation'] === "") {
?>           
                        <textarea placeholder="<?php echo($unknown);?>" class="form-control" name="majProObservation" id="MAJPROOBSERVATION" maxlength="250"></textarea>
<?php               
                    } else { 
?>
                        <textarea class="form-control" name="majProObservation" id="MAJPROOBSERVATION" maxlength="250"><?php echo($_POST['pro_observation']);?></textarea>
<?php
                    }
?>
            </div> 
<!------------------------------------------------------------FOLLOWED BY---------------------------------------------------------------------->
<?php
        if (($_SESSION['rights'] === "1") OR ($_SESSION['rights'] === "2")) {
?>
            <div class="mb-3">
                <label for="MAJPROFOLLOWEDBY" class="form-label">Suivi par :</label>
                <select class="form-select" name="majProFollowedBy">
                    <option selected value="<?php echo($_POST['user_ID']);?>"><?php echo($_POST['user_surname'].' '.$_POST['user_name']);?></option>            
<?php 
//          Récupère la liste des utilisateurs.
            $tUsers = User_Mgr::getUsersList();
            foreach($tUsers as $tUser) {
                echo
                    '<option value="';echo($tUser['ID_utilisateur']);echo'">'.$tUser['nom'].' '.$tUser['prenom'].'</option>';
            }
?>
                </select>
            </div>
<?php
        }
?>
            <div class="d-flex justify-content-center">
                <button type="submit" class="btn" onclick="return confirm('Etes-vous sûr(e) de vouloir modifier ces informations ?')"><span>Valider</span></button>
            </div>
        </form>
    </fieldset>
</div>
</div>