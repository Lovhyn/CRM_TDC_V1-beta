<div class="container">
<hr>
    <div class="d-flex justify-content-center mt-3">
        <h2 >Gestion des scénarios</h2>
    </div>
    <div class="d-flex justify-content-center">
        <!--Pour une question de sécurité du point de vue du bon fonctionnement de l'application,
            la possibilité d'ajouter ou de supprimer des éléments de la liste des scénarios a été retirée.
            Les formulaires d'ajout et de suppression sont donc commentés.-->

        <form class="d-flex justify-content-center mt-3" action="/outils/Controllers/Controller_admin.php" method="post">
            <input type="hidden" name="action" value="addConclusion">
            <input class="form-control" placeholder="Nouveau scénario" type="text" name="newConclusion" maxlength="50" pattern="^[\w'\-,.]*[^_!¡?÷?¿\/\\+=@#$%ˆ&*(){}|~<>;:[\]]*${0,50}">
            <button title="Ajouter un scénario" type="submit" class="addConclusionBtn" onclick="return confirm('Etes-vous sûr(e) de vouloir ajouter ce scénario ?')">
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
                    <th>Scénario</th>
                    <th>Modifier</th>
                    <th class="text-center">Valider</th>
                    <th class="text-center">Supprimer</th>
                </tr>
            </thead>
<?php
//      Récupère la liste non détaillée des professionnels.
        $tPros = Conclusions_Mgr::getUndetailedProsList();
//      Récupère la liste des conclusions.
        $tConclusions = Conclusions_Mgr::getConclusionsListExcept();
        foreach($tConclusions as $tConclusion) {
            echo
            '<tr>
                <td>'.$tConclusion['libelle_conclusion'].'</td>
                <form class="d-flex justify-content-center" action="/outils/Controllers/Controller_admin.php" method="post">
                    <td>
                        <input class="form-control" type="text" name="updConclusion" value="'.$tConclusion['libelle_conclusion'].'" maxlength="50">
                        <input type="hidden" name="idConclusion" value="'.$tConclusion['ID_conclusion'].'">
                        <input type="hidden" name="action" value="updateConclusion">
                    </td>
                    <td class="text-center">
                        <button title="Valider modification" class="validIcon" type="submit">
                            <i class="fas fa-check"></i>
                        </button>
                    </td>
                </form>
                <td>';
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
                    '<form class="d-flex justify-content-center" action="/outils/Controllers/Controller_admin.php" method="post">
                        <input type="hidden" name="idConclusion" value="'.$tConclusion['ID_conclusion'].'">
                        <input type="hidden" name="action" value="deleteConclusion">
                        <button title="Supprimer scénario" class="delIcon" type="submit" '; echo($dialogBoxMsg); echo'>
                            <i class="far fa-trash-alt"></i>
                        </button>
                    </form>';
                }
            }
            echo 
                '</td>
            </tr>';
?>
        </table>
    </div>
</div>
