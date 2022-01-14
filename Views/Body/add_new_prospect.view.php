<div class="container">
<hr>
    <div class="container d-flex justify-content-center">
        <fieldset class="fieldsetAddNewProspect">
            <legend class="fw-bold d-flex justify-content-center mb-4">NOUVEAU PROSPECT :</legend>
            <hr>
            <!--
            <form name="addNewProspect" action="<?php echo($_SERVER['PHP_SELF']);?>" method="post" class="ADDNEWPROSPECT">
                <div class="w-100 d-flex justify-content-between"> 
                <input type="hidden" name="action" value="addedNewProspect">  
            -->
            <form name="addNewProspect" action="/outils/Controllers/Controller_cdp.php?action=addedNewProspect" method="post" class="ADDNEWPROSPECT">
                <div class="w-100 d-flex justify-content-between">
<!-------------->
<!-----PRO------>
<!-------------->
<!---------------------------------------------PRO NAME------------------------------------------->
                    <div class="w-50 d-flex justify-content-center">
                        <div class="w-75 mb-2">
                            <label for="NEWPROSPECTNAME" class="form-label">Nom de l'entreprise (requis):</label>
                            <input required placeholder="Ex : Toile de Com" type="text" class="form-control" name="newProspectName" id="NEWPROSPECTNAME" minlength="2" maxlength="50" pattern="^[\w'\-,.]*[^_!¡?÷?¿\/\\+=@#$%ˆ&*(){}|~<>;:[\]]*${1,50}">
                        </div>
                    </div>
<!-------------------------------------------DECISION MAKER--------------------------------------->
                    <div class="w-50 d-flex justify-content-center">
                        <div class="w-75 mb-2">
                            <label for="NEWDECISIONMAKERNAME" class="form-label">Nom décideur :</label>
                            <input placeholder="Ex : COSSON" type="text" class="form-control" name="newDecisionMakerName" id="NEWDECISIONMAKERNAME" minlength="2" maxlength="50" pattern="^[\w'\-,.]*[^_!¡?÷?¿\/\\+=@#$%ˆ&*(){}|~<>;:[\]]*${1,50}">
                        </div>
                    </div>
                </div>
<!-------------------------------------------ACTIVITY AREA---------------------------------------->
                <div class="w-100 d-flex justify-content-between">
                    <div class="w-50 d-flex justify-content-center">
                        <div class="w-75 mb-2">
                            <label for="NEWACTIVITYAREA" class="form-label">Secteur d'activité :</label>
                            <select class="form-select" name="newActivityArea" id="NEWACTIVITYAREA">
<?php
//                      Récupère la liste des secteurs d'activité.
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
                    <div class="w-50 d-flex justify-content-center">
                        <div class="w-75 mb-2">
                            <label for="NEWPROSPECTMAIL" class="form-label">Adresse mail :</label>
                            <input placeholder="Ex : adresse@mail.com" type="mail" class="form-control" name="newProspectMail" id="NEWPROSPECTMAIL" minlength="5" maxlength="60">
                        </div>
                    </div>
                </div>
<!---------------------------------------------MAIN PHONE----------------------------------------->
                <div class="w-100 d-flex justify-content-between">
                    <div class="w-50 d-flex justify-content-center">
                        <div class="w-75 mb-2">
                            <label for="NEWPROSPECTMAINPHONE" class="form-label">N° Téléphone principal :</label>
                            <input placeholder="Ex : 0612233445" type="text" class="form-control" name="newProspectMainPhone" id="NEWPROSPECTMAINPHONE" minlength="10" maxlength="10" pattern="[0-9]{10}">
                        </div>
                    </div>
<!-------------------------------------------SECONDARY PHONE-------------------------------------->
                    <div class="w-50 d-flex justify-content-center">
                        <div class="w-75 mb-2">
                            <label for="NEWPROSPECTSECONDARYPHONE" class="form-label">N° Téléphone secondaire :</label>
                            <input placeholder="Ex : 0674859330" type="text" class="form-control" name="newProspectSecondaryPhone" id="NEWPROSPECTSECONDARYPHONE" minlength="10" maxlength="10" pattern="[0-9]{10}">
                        </div>
                    </div>
                </div>
<!---------------------------------------------MAIN ADRESS---------------------------------------->
                <div class="w-100 d-flex justify-content-between">
                    <div class="w-50 d-flex justify-content-center">
                        <div class="w-75 mb-2">
                            <label for="NEWPROSPECTMAINADRESS" class="form-label">Adresse principale :</label>
                            <input placeholder="Ex : 3 rue des bidules" type="text" class="form-control" name="newProspectMainAdress" id="NEWPROSPECTMAINADRESS" minlength="5" maxlength="50">
                        </div>
                    </div>
<!-------------------------------------------SECONDARY ADRESS------------------------------------->
                    <div class="w-50 d-flex justify-content-center">
                        <div class="w-75 mb-2">
                            <label for="NEWPROSPECTSECONDARYADRESS" class="form-label">Complément d'adresse :</label>
                            <input placeholder="Ex : 12 impasse des choses" type="text" class="form-control" name="newProspectSecondaryAdress" id="NEWPROSPECTSECONDARYADRESS" minlength="5" maxlength="50">
                        </div>
                    </div>
                </div>
<!-------------------------------------------------CP--------------------------------------------->
                <div class="w-100 d-flex justify-content-between">
                    <div class="w-50 d-flex justify-content-center">
                        <div class="w-75 mb-4">
                            <label for="NEWPROSPECTCP" class="form-label">Code postal :</label>
                            <input placeholder="Ex : 14692" type="text" class="form-control" name="newProspectCP" id="NEWPROSPECTCP" minlength="5" maxlength="5" pattern="[0-9]{5}">
                        </div>
                    </div>
<!------------------------------------------------VILLE------------------------------------------->
                    <div class="w-50 d-flex justify-content-center">
                        <div class="w-75 mb-4">
                            <label for="NEWPROSPECTCITY" class="form-label">Ville :</label>
                            <input placeholder="Ex : Saint-Martin-Des-Besaces" type="text" class="form-control" name="newProspectCity" id="NEWPROSPECTCITY" minlength="2" maxlength="50" pattern="^[\w'\-,.]*[^_!¡?÷?¿\/\\+=@#$%ˆ&*(){}|~<>;:[\]]*${1,50}">
                        </div>
                    </div>
                </div>
<!----------------------------------------------OBSERVATION--------------------------------------->
                <div class="w-100 d-flex justify-content-center">
                    <div class="w-75">
                        <div class="mb-2 text-center">
                            <label for="NEWPROSPECTOBSERVATION" class="form-label">Observation(s) / Commentaire(s) :</label>
                            <textarea placeholder="Entrez une note à propos du prospect (facultatif)" class="form-control" name="newProspectObservation" id="NEWPROSPECTOBSERVATION" maxlength="250"></textarea>
                        </div>
                    </div>
                </div>
                <hr>
<!-------------->
<!--CONTACTING-->
<!-------------->
<!---------------------------------------------INTERLOCUTOR--------------------------------------->
                <div class="w-100 d-flex justify-content-between">
                    <div class="w-25 mb-4 text-center">
                        <label for="NEWCONTACTINTERLOCUTOR" class="form-label">Interlocuteur :</label>
                        <select class="form-select" name="newContactInterlocutor" id="NEWCONTACTINTERLOCUTOR">
<?php
//                  Récupère la liste des types d'interlocuteurs.
                    $tInterlocutors = Contacting_Mgr::getInterlocutorsList();
                    foreach($tInterlocutors as $tInterlocutor) {
                        echo
                            '<option value="';echo($tInterlocutor['ID_interlocuteur']);echo'">'.$tInterlocutor['libelle_interlocuteur'].'</option>';
                    }
?>
                        </select>
                    </div> 
<!------------------------------------------------TYPE OF----------------------------------------->
                    <div class="w-25 mb-4 text-center">
                        <label for="NEWCONTACTTYPE" class="form-label">Type de contact :</label>
                        <select class="form-select" name="newContactType" id="NEWCONTACTTYPE">
<?php
//                  Récupère la liste des types de contact.
                    $tContactTypes = Contacting_Mgr::getContactTypeList();
                    foreach($tContactTypes as $tContactType) {
                        echo
                            '<option value="';echo($tContactType['ID_nature']);echo'">'.$tContactType['libelle_nature'].'</option>';
                    }
?>
                        </select>
                    </div> 
<!----------------------------------------------CONCLUSION---------------------------------------->
                    <div class="w-25 mb-4 text-center">
                        <label for="NEWCONTACTCONCLUSION" class="form-label">Conclusion :</label>
                        <select class="form-select" name="newContactConclusion" id="NEWCONTACTCONCLUSION" onchange="displayCalendar();">
                            <option selected value="0">Précisez :</option>
<?php
//                  Récupère la liste des scénarios (conclusions).
                    $tConclusions = Conclusions_Mgr::getConclusionsList();
                    foreach($tConclusions as $tConclusion) {
                        echo
                            '<option value="';echo($tConclusion['ID_conclusion']);echo'">'.$tConclusion['libelle_conclusion'].'</option>';
                    }
?>
                        </select>
                    </div>
                </div>
<!----------------------------------------------CALENDAR------------------------------------------>
                <div id="displayMeetingDiv">
                    <div class="w-100 d-flex justify-content-center">
                        <div class="w-25 mb-4 text-center">
                            <label for="meetingCalendar" id="meetingCalendarLabel"></label>
                            <input class="form-select" type="datetime-local" name="meetingCalendar" id="meetingCalendar">
                        </div>
                    </div>
                </div>
                <div id="displayRecallDiv">
                    <div class="w-100 d-flex justify-content-center">
                        <div class="w-25 mb-4 text-center">
                            <label for="recallCalendar" id="recallCalendarLabel"></label>
                            <input class="form-select" type="date" name="recallCalendar" id="recallCalendar">
                        </div>
                    </div>
                </div>
<!---------------------------------------------COMMENTAIRE---------------------------------------->
                <div class="w-100 d-flex justify-content-center">
                    <div class="w-75">
                        <div class="mb-2 text-center">
                            <label for="NEWCONTACTCOMMENT" class="form-label">Compte-rendu :</label>
                            <textarea required placeholder="Résumez brièvement votre prise de contact (requis)" class="form-control" name="newContactComment" id="NEWCONTACTCOMMENT" maxlength="250"></textarea>
                        </div>
                    </div>
                </div>
                <hr>

<!---------------------------------------------SUBMIT BUTTON-------------------------------------->
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn" onclick="return confirm('Etes-vous sûr(e) de vouloir enregistrer ce nouveau suivi ?')" id="submitFormBtn"><span>Valider</span></button>
                </div>
            </form>
        </fieldset>
    </div>
</div>