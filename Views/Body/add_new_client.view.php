<?php 
$userConnected = (int) $_SESSION['idUser'];
$rights = (int) $_SESSION['rights'];
?>
<div class="container">
<hr>
    <div class="container d-flex justify-content-center">
        <fieldset class="fieldsetManagement ps-1 pe-1">
            <legend class="fw-bold d-flex justify-content-center mb-4">NOUVEAU CLIENT :</legend>
            <hr>
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
                <input type="hidden" name="action" value="addedNewClient">
                <div class="d-md-flex flex-md-row justify-content-md-around w-md-100
                                d-xs-flex flex-xs-column justify-content-xs-center w-xs-100">
<!---------------------------------------------PRO NAME------------------------------------------->
                    <div class="w-100 d-flex justify-content-center">
                        <div class="w-75 mb-2">
                            <label for="CLIENTNAME" class="form-label">Nom de l'entreprise (requis):</label>
                            <input required placeholder="Ex : Toile de Com" type="text" class="form-control" name="clientName" id="CLIENTNAME" minlength="2" maxlength="50" pattern="^[\w'\-,.]*[^_!¡?÷?¿\/\\+=@#$%ˆ&*(){}|~<>;:[\]]*${1,50}">
                        </div>
                    </div>
<!-------------------------------------------DECISION MAKER--------------------------------------->
                    <div class="w-100 d-flex justify-content-center">    
                        <div class="w-75 mb-2">
                            <label for="CLIENTDECISIONMAKERNAME" class="form-label">Nom du décideur :</label>
                            <input placeholder="Ex : COSSON" type="text" class="form-control" name="clientDecisionMakerName" id="CLIENTDECISIONMAKERNAME" minlength="2" maxlength="50" pattern="^[\w'\-,.]*[^_!¡?÷?¿\/\\+=@#$%ˆ&*(){}|~<>;:[\]]*${1,50}">
                        </div>
                    </div>
                </div>
<!-------------------------------------------ACTIVITY AREA---------------------------------------->
                <div class="d-md-flex flex-md-row justify-content-md-around w-md-100
                                    d-xs-flex flex-xs-column justify-content-xs-center w-xs-100">
                    <div class="w-100 d-flex justify-content-center">
                        <div class="w-75 mb-2">
                            <label for="CLIENTACTIVITYAREA" class="form-label">Secteur d'activité :</label>
                            <select class="form-select" name="clientActivityArea" id="CLIENTACTIVITYAREA">
<?php
//                          Récupère la liste des secteurs d'activité.
                            $tActivityAreas = ActivityArea_Mgr::getActivityAreaList();
                            foreach($tActivityAreas as $tActivityArea) {
                                echo
                                    '<option value="';echo($tActivityArea['ID_secteur']);echo'">'.$tActivityArea['libelle_secteur'].'</option>';
                            }
?>
                            </select>
                        </div> 
                    </div>   
<!----------------------------------------------MAIN MAIL----------------------------------------->
                    <div class="w-100 d-flex justify-content-center">
                        <div class="w-75 mb-2">
                            <label for="CLIENTMAIL" class="form-label">Adresse mail :</label>
                            <input placeholder="Ex : adresse@mail.com" type="mail" class="form-control" name="clientMail" id="CLIENTMAIL" minlength="5" maxlength="60">
                        </div>
                    </div>
                </div>
<!---------------------------------------------MAIN PHONE----------------------------------------->
                <div class="d-md-flex flex-md-row justify-content-md-around w-md-100
                                d-xs-flex flex-xs-column justify-content-xs-center w-xs-100">
                    <div class="w-100 d-flex justify-content-center">
                        <div class="w-75 mb-2">
                            <label for="CLIENTMAINPHONE" class="form-label">N° Téléphone principal :</label>
                            <input placeholder="Ex : 0612233445" type="text" class="form-control" name="clientMainPhone" id="CLIENTMAINPHONE" minlength="10" maxlength="10" pattern="[0-9]{10}">
                        </div>
                    </div>
<!-------------------------------------------SECONDARY PHONE-------------------------------------->
                    <div class="w-100 d-flex justify-content-center">
                        <div class="w-75 mb-2">
                            <label for="CLIENTSECONDARYPHONE" class="form-label">N° Téléphone secondaire :</label>
                            <input placeholder="Ex : 0674859330" type="text" class="form-control" name="clientSecondaryPhone" id="CLIENTSECONDARYPHONE" minlength="10" maxlength="10" pattern="[0-9]{10}">
                        </div>
                    </div>
                </div>
<!---------------------------------------------MAIN ADRESS---------------------------------------->
                <div class="d-md-flex flex-md-row justify-content-md-around w-md-100
                                d-xs-flex flex-xs-column justify-content-xs-center w-xs-100">
                    <div class="w-100 d-flex justify-content-center">
                        <div class="w-75 mb-2">
                            <label for="CLIENTMAINADRESS" class="form-label">Adresse principale :</label>
                            <input placeholder="Ex : 3 rue des bidules" type="text" class="form-control" name="clientMainAdress" id="CLIENTMAINADRESS" minlength="5" maxlength="50">
                        </div>
                    </div>
<!-------------------------------------------SECONDARY ADRESS------------------------------------->
                    <div class="w-100 d-flex justify-content-center">
                        <div class="w-75 mb-2">
                            <label for="CLIENTSECONDARYADRESS" class="form-label">Complément d'adresse :</label>
                            <input placeholder="Ex : 12 impasse des choses" type="text" class="form-control" name="clientSecondaryAdress" id="CLIENTSECONDARYADRESS" minlength="5" maxlength="50">
                        </div>
                    </div>
                </div>
<!-------------------------------------------------CP--------------------------------------------->
                <div class="d-md-flex flex-md-row justify-content-md-around w-md-100
                                d-xs-flex flex-xs-column justify-content-xs-center w-xs-100">
                    <div class="w-100 d-flex justify-content-center">
                        <div class="w-75 mb-2">
                            <label for="CLIENTCP" class="form-label">Code postal :</label>
                            <input placeholder="Ex : 14692" type="text" class="form-control" name="clientCp" id="CLIENTCP" minlength="5" maxlength="5" pattern="[0-9]{5}">
                        </div>
                    </div>
<!------------------------------------------------VILLE------------------------------------------->
                    <div class="w-100 d-flex justify-content-center">
                        <div class="w-75 mb-4">
                            <label for="CLIENTCITY" class="form-label">Ville :</label>
                            <input placeholder="Ex : Saint-Martin-Des-Besaces" type="text" class="form-control" name="clientCity" id="CLIENTCITY" minlength="2" maxlength="50" pattern="^[\w'\-,.]*[^_!¡?÷?¿\/\\+=@#$%ˆ&*(){}|~<>;:[\]]*${1,50}">
                        </div>
                    </div>
                </div>
<!----------------------------------------------OBSERVATION--------------------------------------->
                <div class="w-100 d-flex justify-content-center">
                    <div class="w-75">
                        <div class="mb-2 text-center">
                            <label for="CLIENTOBSERVATION" class="form-label">Observation(s) / Commentaire(s) :</label>
                            <textarea placeholder="Entrez une note à propos du prospect (facultatif)" class="form-control" name="clientObservation" id="CLIENTOBSERVATION" maxlength="250"></textarea>
                        </div>
                    </div>
                </div>
                <hr>
<!---------------------------------------------SUBMIT BUTTON-------------------------------------->
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn" onclick="return confirm('Etes-vous sûr(e) de vouloir enregistrer ce nouveau suivi ?')"><span>Valider</span></button>
                </div>
            </form>
<!---------------------------------------------RETURN BUTTON-------------------------------------->
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
            <input type="hidden" name="action" value="clientsListing">
            <div class="d-flex justify-content-center">
                    <button type="submit" class="btn"><span>Retour</span></button>
                </div>
            </form>
        </fieldset>
    </div>
</div>