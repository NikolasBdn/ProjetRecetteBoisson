<?php

require('Donnees.inc.php');

function readableRecettes($recettes) {
    $out = "<h1>Recettes</h1><ul>";
    foreach ($recettes as $key => $value) {
        $out .= "<li>$key";

        // TODO

        $out .= "</li>\n";
    }
    return $out . "</ul>";
}

function readableHierarchie($hierarchie) {
    $out = "<h1>Hierarchie</h1><ul>";
    foreach ($hierarchie as $key => $value) {
        $out .= "<li>$key";
        if (isset($value["sous-categorie"])) {
            $out .= ", sous-categorie[";
            foreach ($value["sous-categorie"] as $subCat) {
                $out .= "$subCat, ";
            }
            $out = substr_replace($out, "", -2) . "]";
        }
        if (isset($value["super-categorie"])) {
            $out .= ", super-categorie[";
            foreach ($value["super-categorie"] as $supCat) {
                $out .= "$supCat, ";
            }
            $out = substr_replace($out, "", -2) . "]";
        }
        $out .= "</li>\n";

    }
    return $out . "</ul>";
}

echo readableHierarchie($Hierarchie);
