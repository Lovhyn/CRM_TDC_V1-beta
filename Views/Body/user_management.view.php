<div class="container">
<hr>
    <div class="d-flex justify-content-center mt-3">
        <h2 >Gestion des utilisateurs</h2>
    </div>
    <form class="d-flex justify-content-center mt-3" action="/outils/Controllers/Controller_admin.php?action=addUser" method="post">
        <button type="submit" value="addUser" class="addUserIcon">
            <i class="fas fa-user-plus"></i>
        </button>
    </form>
    <div class="d-flex justify-content-center">
        <table class="table table-hover table-striped table-dark mt-3 w-auto" 
                data-toggle="table" data-search="true" data-show-columns="true" data-pagination="true">
            <thead>
                <th>Nom</th>
                <th class="text-center">Prénom</th>
                <th class="text-center">Mail</th>
                <th class="text-center">Rôle</th>
                <th class="text-center">Modifier</th>
                <th class="text-center">Appeler</th>
                <!-- <th class="text-center">Supprimer</th> -->
            </thead>
<?php
//      Récupère la liste des utilisateurs.
        $tUsers = User_Mgr::getUsersList();
        foreach($tUsers as $tUser) {
            echo
            '<tr>
                <td>' . $tUser['nom'] . '</td>
                <td class="text-center">' . $tUser['prenom'] . '</td>
                <td class="text-center">' . $tUser['mail'] . '</td>
                <td class="text-center">' . $tUser['libelle_droit'] . '</td>
                <td>
                    <form class="d-flex justify-content-center" action="/outils/Controllers/Controller_admin.php?action=updateUser" method="post">
                        <input type="hidden" name="userId" value="' . $tUser['ID_utilisateur']. '">
                        <input type="hidden" name="userName" value="' . $tUser['nom']. '">
                        <input type="hidden" name="userSurname" value="' . $tUser['prenom']. '">
                        <input type="hidden" name="userPassword" value="' . $tUser['mot_de_passe']. '">
                        <input type="hidden" name="userMail" value="' . $tUser['mail']. '">
                        <input type="hidden" name="userPhone" value="' . $tUser['tel']. '">
                        <input type="hidden" name="userIdRights" value="' . $tUser['ID_droit']. '">
                        <input type="hidden" name="userLibRights" value="' . $tUser['libelle_droit']. '">
                        <button class="updIcon" type="submit" name="action" value="updUser">
                            <i class="far fa-edit"></i>
                        </button>
                    </form>
                </td>
            <td>';
                if ($tUser['tel'] != '') {
                    echo
                    '<div class="d-flex justify-content-center">
                        <button class="phoneIcon">
                            <a title="'.$tUser['tel'].'" href="tel:'.$tUser['tel'].'">
                                <i id="iconPhone" class="fas fa-phone"></i>
                            </a>
                        </button>
                    </div>';
                }
                '</td>
            </tr>';
/*
                <td>
                    <form class="d-flex justify-content-center" action="/outils/Controllers/Controller_admin.php?action=deleteUser" method="post">
                        <button class="delIcon" type="submit" name="action" value="delUser">
                            <i class="far fa-trash-alt"></i>
                        </button>
                            <input type="hidden" name="idUser" value="' . $tUser['ID_utilisateur']. '">
                    </form>
                </td>';
*/
        }
?>
        </table>
    </div>
</div>
