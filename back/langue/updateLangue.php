<?php
////////////////////////////////////////////////////////////
//
//  CRUD langue (PDO) - Modifié : 4 Juillet 2021
//
//  Script  : updateLangue.php  -  (ETUD)  BLOGART22
//
////////////////////////////////////////////////////////////

// Mode DEV
require_once __DIR__ . '/../../util/utilErrOn.php';

// controle des saisies du formulaire
require_once __DIR__ . '/../../util/ctrlSaisies.php';

// Insertion classe Langue

require_once __DIR__ . '/../../class_crud/langue.class.php';

// Instanciation de la classe langue

$maLangue = new langue();

$monPays = new PAYS();

// Gestion des erreurs de saisie
$erreur = false;

// Gestion du $_SERVER["REQUEST_METHOD"] => En post
if ($_SERVER["REQUEST_METHOD"] === "post") {


    if (isset($_post['Submit'])) {
        $Submit = $_post['Submit'];
    } else {
        $Submit = "";
    }

    if ((isset($_post["Submit"])) and ($Submit === "Initialiser")) {
        $sameId = $_post['id'];
        header("Location: ./updateLangue.php?id=" . $sameId);
    }


    if (((isset($_post['lib1Lang'])) and !empty($_post['lib1Lang']))
        and ((isset($_post['lib2Lang'])) and !empty($_post['lib2Lang']))
        and ((isset($_post['TypPays'])) and !empty($_post['TypPays']))
        and ($_post['TypPays'] != -1)
        and (!empty($_post['Submit']) and ($Submit === "Valider"))
    ) {

        $erreur = false;

        $lib1Lang = ctrlSaisies(($_post['lib1Lang']));
        $lib2Lang = ctrlSaisies(($_post['lib2Lang']));
        $numPays = ctrlSaisies(($_post['TypPays']));

        $numLang = ctrlSaisies(($_post['id']));

        $maLangue->update($numLang, $lib1Lang, $lib2Lang, $numPays);

        header("Location: ./langue.php");
    } else {
        // Saisies invalides
        $erreur = true;
        $errSaisies =  "Erreur, la saisie est obligatoire !";
    }
}
include __DIR__ . '/initLangue.php';
?>
<!DOCTYPE html>
<html lang="fr-FR">

<head>
    <meta charset="utf-8" />
    <title>Admin - CRUD Langue</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <link href="../css/style.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <h1>BLOGART22 Admin - CRUD Langue</h1>
    <h2>Modification d'une langue</h2>
    <?php
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $oneLangue = $maLangue->get_1Langue($id);
        $numLang = $oneLangue['numLang'];
        $lib1Lang = $oneLangue['lib1Lang'];
        $lib2Lang = $oneLangue['lib2Lang'];
        $numPays = $oneLangue['numPays'];
        $frPays = $oneLangue['frPays'];
    }

    ?>
    <form method="post" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data" accept-charset="UTF-8">

        <fieldset>
            
            <input type="hidden" id="id" name="id" value="<?= isset($_GET['id']) ? $_GET['id'] : '' ?>" />

            <div class="control-group">
                <label class="control-label" for="lib1Lang"><b>Libellé court :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></label>
                <input type="text" name="lib1Lang" id="lib1Lang" size="80" maxlength="80" value="<?= $lib1Lang; ?>" tabindex="10" autofocus="autofocus" /><br><br>
            </div>
            <div class="control-group">
                <label class="control-label" for="lib2Lang"><b>Libellé long :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></label>
                <input type="text" name="lib2Lang" id="lib2Lang" size="80" maxlength="80" value="<?= $lib2Lang; ?>" tabindex="20" />
            </div>
            <br>
            <!-- Listbox Pays -->
            <br>
            <div class="control-group">
                <div class="controls">

                    <label for="LibTypPays" title="Sélectionnez le pays !">
                        <b>Quel pays :&nbsp;&nbsp;&nbsp;</b>
                    </label>
                    <input type="hidden" id="idPays" name="idPays" value="<?= $numPays; ?>" />
                    <select size="1" name="TypPays" id="TypPays" class="form-control form-control-create" title="Sélectionnez le pays !">
                        <option value="-1">- - - Choisissez un pays - - -</option>
                        <?php
                        $listNumPays = "";
                        $listfrPays = "";

                        $result = $monPays->get_AllPays();

                        if ($result) {
                            foreach ($result as $row) {
                                $listNumPays = $row["numPays"];
                                $listfrPays = $row["frPays"];
                                if ($numPays == $row['numPays']) {
                        ?>
                                    <option value="<?= $listNumPays; ?>" selected>
                                        <?= $listfrPays; ?>
                                    </option>
                                <?php
                                } else {
                                ?>
                                    <option value="<?= $listNumPays; ?>">
                                        <?= $listfrPays; ?>
                                    </option>
                        <?php
                                }
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <!-- FIN Listbox Pays -->
            <div class="control-group">
                <div class="error">
                    <?php
                    if ($erreur) {
                        echo ($errSaisies);
                    } else {
                        $errSaisies = "";
                        echo ($errSaisies);
                    }
                    ?>
                </div>
            </div>

            <div class="control-group">
                <div class="controls">
                    <br><br>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="submit" value="Initialiser" style="cursor:pointer; padding:5px 20px; background-color:black; border:Opx; border-radius:5px; color:white;" name="Submit" />
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="submit" value="Valider" style="cursor:pointer; padding:5px 20px; background-color:black; border:Opx; border-radius:5px; color:white;" name="Submit" />
                    <br>
                </div>
            </div>
        </fieldset>
    </form>
    <?php
    require_once __DIR__ . '/footerLangue.php';

    require_once __DIR__ . '/footer.php';
    ?>
</body>

</html>