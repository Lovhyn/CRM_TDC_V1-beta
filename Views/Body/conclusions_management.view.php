<div class="container">
<hr>
    <div class="d-flex justify-content-center mt-3">
        <h2>Gestion des scénarios</h2>
    </div>
    <div class="d-flex justify-content-center">
        <form class="d-flex justify-content-center mt-3 w-25" action="/outils/Controllers/Controller_admin.php" method="post">
            <input class="form-control" placeholder="Nouveau scénario" type="text" name="newConclusion" maxlength="50" pattern="^[\w'\-,.]*[^_!¡?÷?¿\/\\+=@#$%ˆ&*(){}|~<>;:[\]]*${0,50}">
            <input type="hidden" name="action" value="addConclusion">
            <button title="Ajouter un scénario" type="submit" class="addConclusionBtn" onclick="return confirm('Etes-vous sûr(e) de vouloir ajouter ce scénario ?')">
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
                    <th>Scénario</th>
                    <th class="text-center">Modifier / Supprimer</th>
                </tr>
            </thead>
<?php
//      Récupère une liste permettant de contrôler quelles conclusions ne sont pas déjà affectées à un suivi.
        $tPros = Conclusions_Mgr::getUndetailedProsList();
//      Récupère la liste des conclusions.
        $tConclusions = Conclusions_Mgr::getConclusionsListExcept();
        foreach($tConclusions as $tConclusion) {
            echo
            '<tr>
                <td class="w-25">'.$tConclusion['libelle_conclusion'].'</td>
                <td class="w-100">
                    <div class="d-flex flex-row align-items-center">
                        <div class="w-50">
                            <form class="d-flex flex-row" action="/outils/Controllers/Controller_admin.php" method="post">
                                <input class="form-control" type="text" name="updConclusion" value="'.$tConclusion['libelle_conclusion'].'" maxlength="50">
                                <input type="hidden" name="idConclusion" value="'.$tConclusion['ID_conclusion'].'">
                                <input type="hidden" name="action" value="updateConclusion">
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
                if ($tPro['ID_conclusion'] == $tConclusion['ID_conclusion']) {
                    $flag = true;
                    break;
                }
            }
            if ($flag == false) {
                $dialogBoxMsg = 'onclick="return confirm(`Etes-vous sûr(e) de vouloir supprimer ce scénario ?`)"';
                echo
                                '<form action="/outils/Controllers/Controller_admin.php" method="post">
                                    <input type="hidden" name="idConclusion" value="'.$tConclusion['ID_conclusion'].'">
                                    <input type="hidden" name="action" value="deleteConclusion">
                                    <button title="Supprimer scénario" class="delIcon" type="submit"'; echo($dialogBoxMsg); echo'>
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                </form>';
            } else {
                echo
                                '<div title="Ce scénario est déjà affecté à un (ou plusieurs) suivi(s)" class="delIconNoRights">
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
