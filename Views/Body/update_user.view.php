<!--$_POST = OK-->
<div class="container">
<hr>
    <div class="container d-flex justify-content-center">
        <fieldset class="fieldsetManagement ps-1 pe-1">
            <legend class="fw-bold d-flex justify-content-center mb-4">Modifier un utilisateur :</legend>
            <form name="updUser" action="/outils/Controllers/Controller_admin.php" method="post">
                <input type="hidden" name="action" value="updatedUser">
                <input type="hidden" name="userId" value="<?php echo $_POST['userId'];?>">
                <div class="d-flex flex-column justify-content-center w-100">
<!-------------------------------------------USER NAME-------------------------------------------->
                    <div class="w-100 d-flex justify-content-center">
                        <div class="w-75 mb-2">
                            <label for="MAJUSERNAME" class="form-label">Nom :</label>
                            <input required value="<?php echo $_POST['userName'];?>" type="text" class="form-control" name="majUserName" id="MAJUSERNAME" minlength="2" maxlength="40" pattern="^[\w'\-,.]*[^_!¡?÷?¿\/\\+=@#$%ˆ&*(){}|~<>;:[\]]*${1,40}">
                        </div>
                    </div>
<!-----------------------------------------USER SURNAME------------------------------------------->
                    <div class="w-100 d-flex justify-content-center">
                        <div class="w-75 mb-2">
                            <label for="MAJUSERSURNAME" class="form-label">Prénom :</label>
                            <input required value="<?php echo $_POST['userSurname'];?>" type="text" class="form-control" name="majUserSurname" id="MAJUSERSURNAME" minlength="2" maxlength="40" pattern="^[\w'\-,.]*[^_!¡?÷?¿\/\\+=@#$%ˆ&*(){}|~<>;:[\]]*${1,40}">
                        </div>
                    </div>
<!-------------------------------------------USER PHONE------------------------------------------->
                    <div class="w-100 d-flex justify-content-center">
                        <div class="w-75 mb-2">
                            <label for="MAJUSERPHONE" class="form-label">Numéro de téléphone :</label>
                            <input required value="<?php echo User_Mgr::phoneFormatToFrench($_POST['userPhone']);?>" type="text" class="form-control" name="majUserPhone" id="MAJUSERPHONE" minlength="10" maxlength="10" pattern="[0-9]{10}">
                        </div>
                    </div>
<!-------------------------------------------USER MAIL-------------------------------------------->
                    <div class="w-100 d-flex justify-content-center">
                        <div class="w-75 mb-2">
                            <label for="MAJUSERMAIL" class="form-label">Adresse mail :</label>
                            <input required value="<?php echo $_POST['userMail'];?>" type="mail" class="form-control" name="majUserMail" id="MAJUSERMAIL" minlength="5" maxlength="50">
                        </div>
                    </div>
<!-----------------------------------------USER PASSWORD------------------------------------------>
                    <div class="w-100 d-flex justify-content-center">
                        <div class="w-75">
                            <input type="hidden" name="oldUserPassword" value="<?php echo($_POST['userPassword']);?>">
                            <div id="newPasswordDiv" class="mb-2">
                                <label for="MAJUSERPASSWORD" class="form-label">Nouveau mot de passe :</label>
                                <input placeholder="Définir nouveau mot de passe" type="password" class="form-control" name="newUserPassword" id="MAJUSERPASSWORD" minlength="5" maxlength="50">
                            </div>
                            <div id="confirmNewPasswordDiv" class="mb-2">
                                <label for="MAJUSERPASSWORD²" class="form-label">Confirmation nouveau mot de passe :</label>
                                <input placeholder="Confirmer le nouveau mot de passe" type="password" class="form-control" name="confirmNewUserPassword" id="MAJUSERPASSWORD²" minlength="5" maxlength="50">
                            </div>
                        </div>
                    </div>
<!-------------------------------------------USER ROLE-------------------------------------------->
                    <div class="w-100 d-flex justify-content-center">
                        <div class="w-75 mb-4">
                            <label for="MAJUSERRIGHTS" class="form-label">Modifier rôle : </label>
                            <select required class="form-select" name="majUserRights" id="MAJUSERRIGHTS">
                                <option value="cdp">Chargé(e) de projet</option>
                                <option value="responsable">Responsable</option>
                                <option value="admin">Administrateur</option>
                            </select>
                        </div>
                    </div>
<!------------------------------------------SUBMIT BTN-------------------------------------------->
                </div>      
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn" onclick="return confirm('Etes-vous sûr(e) de vouloir modifier ces informations ?')"><span>Valider</span></button>
                </div>
            </form>
            <form action="/outils/Controllers/Controller_admin.php" method="post">
                <input type="hidden" name="action" value="userManagement">
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn"><span>Retour</span></button>
                </div>
            </form>
        </fieldset>
    </div>
</div>




