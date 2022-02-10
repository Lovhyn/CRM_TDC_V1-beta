<div class="container">
<hr>
    <div class="d-flex justify-content-center mt-3">
        <h2>Gestion des secteurs d'activité</h2>
    </div>
    <div class="d-flex justify-content-center">
        <form class="d-flex justify-content-center mt-3 w-25" action="/outils/Controllers/Controller_admin.php" method="post">
            <input class="form-control" placeholder="Nouveau secteur d'activité" type="text" name="newActivityArea" maxlength="50" pattern="^[\w'\-,.]*[^_!¡?÷?¿\/\\+=@#$%ˆ&*(){}|~<>;:[\]]*${0,50}">
            <input type="hidden" name="action" value="addAreaActivity">
            <button title="Ajouter secteur d'activité" type="submit" class="addAreaActivityBtn" onclick="return confirm('Etes-vous sûr(e) de vouloir ajouter ce secteur d\'activité ?')">
                <i class="fas fa-plus"></i>
            </button>
        </form>
    </div>
    <div class="table-responsive">
<!--    
        L'attribut *data-toggle="table"* de l'extension Bootstrap Table empêche le bon fonctionnement 
        de l'icône servant à valider les modifications des libellés depuis le champ de saisie.
        Par conséquent, aucune des fonctionnalités proposées par l'extension n'est déployable ici. 
-->
        <table class="table table-hover table-striped table-dark mt-4 w-auto"
                    data-toggle="table">
            <thead>
                <tr>
                    <th>Secteur d'activité</th>
                    <th class="text-center">Modifier / Supprimer</th>
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
                <td class="w-25">'.$tSecteur['libelle_secteur'].'</td>
                <td class="w-100">
                    <div class="d-flex flex-row align-items-center">
                        <div class="w-50">
                            <form class="d-flex flex-row" action="/outils/Controllers/Controller_admin.php" method="post">
                                <input class="form-control" type="text" name="updActivityArea" value="'.$tSecteur['libelle_secteur'].'" maxlength="50">
                                <input type="hidden" name="idActivityArea" value="'.$tSecteur['ID_secteur'].'">
                                <input type="hidden" name="action" value="updateActivityArea">
                        </div>
                        <div class="w-50 d-flex flex-row">
                            <div class="w-50 d-flex justify-content-center">
                                    <button title="Valider modification" class="validIcon" type="submit">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                            </div>
                            <div class="w-50 d-flex justify-content-center">';
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
                                '<form action="/outils/Controllers/Controller_admin.php" method="post">
                                    <input type="hidden" name="idActivityArea" value="'.$tSecteur['ID_secteur'].'">
                                    <input type="hidden" name="action" value="deleteActivityArea">
                                    <button title="Supprimer secteur d\'activité" class="delIcon" type="submit"'; echo($dialogBoxMsg); echo'>
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                </form>';
            } else {
                echo
                                '<div title="Ce secteur d\'activité est déjà affecté à un (ou plusieurs) professionnel(s)" class="delIconNoRights">
                                    <i class="far fa-trash-alt"></i>
                                </div>';
            }
            echo 
                            '</div>
                        </div>
                    </div>
                </td>
            </tr>';
            }
?>
        </table>
    </div>
</div>
