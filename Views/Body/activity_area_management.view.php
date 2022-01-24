<!--$_POST = OK-->
<div class="container">
<hr>
    <div class="d-flex justify-content-center mt-3">
        <h2 >Gestion des secteurs d'activité</h2>
    </div>
    <div class="d-flex justify-content-center">
        <form id="newActivityAreaForm" class="d-flex justify-content-center mt-3" action="/outils/Controllers/Controller_admin.php" method="post">
            <input class="form-control" placeholder="Nouveau secteur d'activité" type="text" name="newActivityArea" maxlength="50" pattern="^[\w'\-,.]*[^_!¡?÷?¿\/\\+=@#$%ˆ&*(){}|~<>;:[\]]*${0,50}">
            <input type="hidden" name="action" value="addAreaActivity">
            <button type="submit" class="addAreaActivityBtn" onclick="return confirm('Etes-vous sûr(e) de vouloir ajouter ce secteur d\'activité ?')">
                <i class="fas fa-plus"></i>
            </button>
        </form>
    </div>
    <div class="d-flex justify-content-center">
<!--    
        L'attribut *data-toggle="table"* de l'extension Bootstrap Table empêche le bon fonctionnement 
        de l'icône servant à valider les modifications des libellés depuis le champ de saisie.
        Par conséquent, aucune des fonctionnalités proposées par l'extension n'est déployable ici. 
-->
        <table class="table table-hover table-dark mt-3 w-auto">
            <thead>
                <tr>
                    <th class="text-center">Secteur d'activité</th>
                    <th class="text-center">Modifier</th>
                    <th class="text-center">Valider</th>
                    <th class="text-center">Supprimer</th>
                </tr>
            </thead>
<?php
//      Récupère une liste permettant de contrôler quels secteurs ne sont pas déjà affectés à un professionnel.
        $tPros = ActivityArea_Mgr::getUndetailedProsList();
//      Récupère la liste des secteurs d'activité.
        $tSecteurs = ActivityArea_Mgr::getActivityAreaList();
        foreach($tSecteurs as $tSecteur) {
            echo
            '<tr>
                <td>' . $tSecteur['libelle_secteur'] . '</td>
                <form class="d-flex justify-content-center" action="/outils/Controllers/Controller_admin.php" method="post">
                    <td>
                        <input class="form-control" type="text" name="updActivityArea" value="'.$tSecteur['libelle_secteur'].'" maxlength="50">
                        <input type="hidden" name="idActivityArea" value="'.$tSecteur['ID_secteur'].'">
                        <input type="hidden" name="action" value="updateActivityArea">
                    </td>
                    <td class="text-center">
                        <button class="validIcon" type="submit">
                            <i class="fas fa-check"></i>
                        </button>
                    </td>
                </form>';
            $flag = false;
            foreach($tPros as $tPro) {
                if ($tPro['ID_secteur'] == $tSecteur['ID_secteur']) {
                    $flag = true;
                    break;
                }
            }
            if ($flag == false) {
                $dialogBoxMsg = 'onclick="return confirm(`Etes-vous sûr(e) de vouloir supprimer ce secteur d\'activité ?`)"';
                echo
                '<td>
                    <form class="d-flex justify-content-center" action="/outils/Controllers/Controller_admin.php" method="post">
                        <input type="hidden" name="action" value="deleteActivityArea">
                        <input type="hidden" name="idActivityArea" value="' . $tSecteur['ID_secteur']. '">
                        <button class="delIcon" type="submit"'; echo($dialogBoxMsg); echo'>
                            <i class="far fa-trash-alt"></i>
                        </button>
                    </form>
                </td>
            </tr>';
            }
        }
?>
        </table>
    </div>
</div>
