<!--$_POST = OK-->
<div class="container">
<hr>
    <div class="container d-flex justify-content-center">
        <fieldset class="fieldsetManagement ps-1 pe-1">
            <legend class="fw-bold d-flex justify-content-center mb-4">Nouvel utilisateur :</legend>
            <form name="addUser" action="/outils/Controllers/Controller_admin.php" method="post" class="ADDUSER">
                <input type="hidden" name="action" value="addedUser">
                <div class="d-flex flex-column justify-content-center w-100">
                    <div class="w-100 d-flex justify-content-center">
                        <div class="w-75 mb-2">
                            <label for="NEWUSERNAME" class="form-label">Nom :</label>
                            <input required placeholder="Saisissez un nom" type="text" class="form-control" name="newUserName" id="NEWUSERNAME" maxlength="40" pattern="^[\w'\-,.]*[^_!¡?÷?¿\/\\+=@#$%ˆ&*(){}|~<>;:[\]]*${1,40}">
                        </div>
                    </div>
                    <div class="w-100 d-flex justify-content-center">
                        <div class="w-75 mb-2">
                            <label for="NEWUSERSURNAME" class="form-label">Prénom :</label>
                            <input required placeholder="Saisissez un prénom" type="text" class="form-control" name="newUserSurname" id="NEWUSERSURNAME" maxlength="40" pattern="^[\w'\-,.]*[^_!¡?÷?¿\/\\+=@#$%ˆ&*(){}|~<>;:[\]]*${1,40}">
                        </div>
                    </div>
                    <div class="w-100 d-flex justify-content-center">
                        <div class="w-75 mb-2">
                            <label for="NEWUSERPHONE" class="form-label">Numéro de téléphone :</label>
                            <input required placeholder="Ex : 0612233445" type="text" class="form-control" name="newUserPhone" id="NEWUSERPHONE" minlength="10" maxlength="10" pattern="[0-9]{10}">
                        </div>
                    </div>
                    <div class="w-100 d-flex justify-content-center">   
                        <div class="w-75 mb-2">
                            <label for="NEWUSERMAIL" class="form-label">Adresse mail :</label>
                            <input required placeholder="Ex : toiledecom@mail.com" type="mail" class="form-control" name="newUserMail" id="NEWUSERMAIL" minlength="5" maxlength="50">
                        </div>
                    </div> 
                    <div class="w-100 d-flex justify-content-center">
                        <div class="w-75 mb-2">
                            <label for="NEWUSERPASSWORD" class="form-label">Mot de passe :</label>
                            <input required placeholder="Définissez un mot de passe" type="password" class="form-control" name="newUserPassword" id="NEWUSERPASSWORD" minlength="5" maxlength="50">
                        </div>
                    </div>
                    <div class="w-100 d-flex justify-content-center">
                        <div class="w-75 mb-2">
                            <label for="NEWUSERPASSWORD²" class="form-label">Confirmation mot de passe :</label>
                            <input required placeholder="Confirmez le mot de passe" type="password" class="form-control" name="newUserPassword²" id="NEWUSERPASSWORD²" minlength="5" maxlength="50">
                        </div>
                    </div>
                    <div class="w-100 d-flex justify-content-center">
                        <div class="w-75 mb-5">
                            <label for="NEWUSERRIGHTS" class="form-label">Droits :</label>
                            <select required class="form-select" name="newUserRights" id="NEWUSERRIGHTS">
                                <option value="cdp">Chargé(e) de projet</option>
                                <option value="responsable">Responsable</option>
                                <option value="admin">Administrateur</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn" onclick="return confirm('Etes-vous sûr(e) de vouloir ajouter cet utilisateur ?')"><span>Valider</span></button>
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