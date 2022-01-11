<div class="container">
<hr>
    <div class="container container d-flex justify-content-center">
        <fieldset class="fieldsetUserManagement">
            <legend class="fw-bold d-flex justify-content-center mb-5">Modifier un utilisateur :</legend>
            <form name="updUser" action="/outils/Controllers/Controller_admin.php?action=updatedUser" method="post" class="UPDUSER">
                    <input type="hidden" name="userId" value="<?php echo $_POST['userId'];?>">
                <div class="mb-3">
                    <label for="MAJUSERNAME" class="form-label">Nom :</label>
                    <input value="<?php echo $_POST['userName'];?>" type="text" class="form-control" name="majUserName" id="MAJUSERNAME" minlength="2" maxlength="40" pattern="^[\w'\-,.]*[^_!¡?÷?¿\/\\+=@#$%ˆ&*(){}|~<>;:[\]]*${1,40}">
                </div>
                <div class="mb-3">
                    <label for="MAJUSERSURNAME" class="form-label">Prénom :</label>
                    <input value="<?php echo $_POST['userSurname'];?>" type="text" class="form-control" name="majUserSurname" id="MAJUSERSURNAME" minlength="2" maxlength="40" pattern="^[\w'\-,.]*[^_!¡?÷?¿\/\\+=@#$%ˆ&*(){}|~<>;:[\]]*${1,40}">
                </div>
                <div class="mb-3">
                    <label for="MAJUSERPHONE" class="form-label">Numéro de téléphone :</label>
                    <input value="<?php echo User_Mgr::phoneFormatToFrench($_POST['userPhone']);?>" type="text" class="form-control" name="majUserPhone" id="MAJUSERPHONE" minlength="10" maxlength="10" pattern="[0-9]{10}">
                </div>
                <div class="mb-3">
                    <label for="MAJUSERMAIL" class="form-label">Adresse mail :</label>
                    <input value="<?php echo $_POST['userMail'];?>" type="mail" class="form-control" name="majUserMail" id="MAJUSERMAIL" minlength="5" maxlength="50">
                </div>
                <div class="mb-3">
                    <label for="MAJUSERPASSWORD" class="form-label">Nouveau mot de passe :</label>
                    <input value="<?php echo $_POST['userPassword'];?>" type="password" class="form-control" name="majUserPassword" id="MAJUSERPASSWORD" minlength="5" maxlength="50">
                    <input type="hidden" name="oldUserPassword" value="<?php echo $_POST['userPassword'];?>">
                </div>
                <div class="mb-3">
                    <label for="MAJUSERRIGHTS" class="form-label">Modifier rôle : </label>
                    <select required class="form-select" name="majUserRights" id="MAJUSERRIGHTS">
                        <option value="cdp">Chargé(e) de projet</option>
                        <option value="responsable">Responsable</option>
                        <option value="admin">Administrateur</option>
                    </select>
                </div>
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn" onclick="return confirm('Etes-vous sûr(e) de vouloir modifier ces informations ?')"><span>Valider</span></button>
                </div>
            </form>
        </fieldset>
    </div>
</div>




