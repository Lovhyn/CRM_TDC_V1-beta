<div class="container">
<hr>
    <div class="d-flex justify-content-center mt-3">
        <h2 >Gestion des utilisateurs</h2>
    </div>
    <form class="d-flex justify-content-center mt-3" action="/outils/Controllers/Controller_admin.php" method="post">
        <input type="hidden" name="action" value="addUser">
        <button title="Ajouter un utilisateur" type="submit" value="addUser" class="addUserIcon">
            <i class="fas fa-user-plus"></i>
        </button>
    </form>
    <div class="table-responsive">
        <table class="table table-hover table-striped table-dark mt-3 w-auto" 
                data-toggle="table" data-search="true" data-show-columns="true" data-pagination="true">
            <thead>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Mail</th>
                <th>Rôle</th>
                <th></th>
                <th></th>
            </thead>
<?php
//      Récupère une liste permettant de contrôler quels utilisateurs ne sont pas affectés à un professionnel.
        $tUndeletableUsers = User_Mgr::getUndeletableUsersList();
//      Récupère la liste des utilisateurs.
        $tUsers = User_Mgr::getUsersList();
        foreach($tUsers as $tUser) {
            echo
            '<tr>
                <td>' . $tUser['nom'] . '</td>
                <td>' . $tUser['prenom'] . '</td>
                <td>' . $tUser['mail'] . '</td>
                <td>' . $tUser['libelle_droit'] . '</td>
                <td>
                    <form class="d-flex justify-content-center" action="/outils/Controllers/Controller_admin.php" method="post">
                        <input type="hidden" name="userId" value="' . $tUser['ID_utilisateur']. '">
                        <input type="hidden" name="userName" value="' . $tUser['nom']. '">
                        <input type="hidden" name="userSurname" value="' . $tUser['prenom']. '">
                        <input type="hidden" name="userPassword" value="' . $tUser['mot_de_passe']. '">
                        <input type="hidden" name="userMail" value="' . $tUser['mail']. '">
                        <input type="hidden" name="userPhone" value="' . $tUser['tel']. '">
                        <input type="hidden" name="userIdRights" value="' . $tUser['ID_droit']. '">
                        <input type="hidden" name="userLibRights" value="' . $tUser['libelle_droit']. '">
                        <input type="hidden" name="action" value="updateUser">
                        <button title="Modifier l\'utilisateur" class="updIcon" type="submit">
                            <i class="far fa-edit"></i>
                        </button>
                    </form>
                </td>
                <td>';
            $flag = false;
            foreach($tUndeletableUsers as $tUndeletableUser ) {
                if ($tUndeletableUser['ID_utilisateur'] == $tUser['ID_utilisateur']) {
                    $flag = true;
                    break;
                }
            }
            if ($flag == false) {
                $dialogBoxMsg = 'onclick="return confirm(`Etes-vous sûr(e) de vouloir supprimer cet utilisateur ?`)"';
                echo
                '<form class="d-flex justify-content-center" action="/outils/Controllers/Controller_admin.php" method="post">
                    <input type="hidden" name="idUser" value="' . $tUser['ID_utilisateur']. '">
                    <input type="hidden" name="action" value="deleteUser">
                    <button title="Supprimer l\'utilisateur" class="delIcon" type="submit"'; echo($dialogBoxMsg); echo'>
                        <i class="far fa-trash-alt"></i>
                    </button>
                </form>';
            } else {
                echo
                '<div title="Cet utilisateur est en charge d\'un (ou plusieurs) suivi(s)" class="d-flex justify-content-center">
                    <div class="delIconNoRights">
                        <i class="far fa-trash-alt"></i>
                    </div>
                </div>';
            }
            echo
            '</td>
        </tr>';
        }
?>
        </table>
    </div>
</div>
