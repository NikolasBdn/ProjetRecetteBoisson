<?php

require('Donnees.inc.php');


function ingredientDataGenerator($hierarchie) {
    $out = array();
    foreach ($hierarchie as $key => $value) {
        array_push($out, $key);
    }
    return $out;
}

function recetteDataGenerator($recettes) {
    $out = array();
    foreach ($recettes as $value) {
        $data = array();
        $data["title"] = $value["titre"];
        $data["ingredientsText"] = $value["ingredients"];
        $data["preparation"] = $value["preparation"];
        array_push($out, $data);
    }
    return $out;
}

function hierarchieDataGenerator($hierarchie) {
    $tableIngredient = ingredientDataGenerator($hierarchie);
    $outSubCat = array();
    $outSupCat = array();
    foreach ($hierarchie as $key => $value) {
        if (isset($value["sous-categorie"])) {
            foreach ($value["sous-categorie"] as $subCat) {
                array_push($outSubCat, array(array_search($key, $tableIngredient) => array_search($subCat, $tableIngredient)));
            }
        }
        if (isset($value["super-categorie"])) {
            foreach ($value["super-categorie"] as $supCat) {
                array_push($outSupCat, array(array_search($key, $tableIngredient) => array_search($supCat, $tableIngredient)));
            }
        }
    }

    return array("sous-categorie" => $outSubCat, "super-categorie" => $outSupCat);
}


function recetteUseDataGenerator($recettes, $hierarchie) {
    $tableIngredient = ingredientDataGenerator($hierarchie);
    $tableRecette = recetteDataGenerator($recettes);
    $out = array();
    foreach ($recettes as $value) {
        foreach ($value["index"] as $index) {
            array_push($out, array(multidimensional_array_search("title", $value["titre"], $tableRecette) => array_search($index, $tableIngredient)));
        }
    }
    return $out;
}

function multidimensional_array_search($field, $value, $array) {
    foreach($array as $key => $sub_array) {
        if ($sub_array[$field] === $value)
            return $key;
    }
    return false;
}


function createSql($tableIngredient, $tableRecette) {
    $out = <<<sql
create table Recette (
    id int,
    title varchar(256),
    ingredientsText varchar(1024),
    preparation varchar(1024),
    primary key (id)
);

create table Ingredient (
    id int,
    name varchar(128),
    primary key (id)
);
sql;
    $out .= "\n\n";

    foreach ($tableIngredient as $key => $value) {
        $val = str_replace ("'", "\\'", $value);
        $out .= "insert into Ingredient values ($key, '$val');\n";
    }
    $out .= "\n";
    foreach ($tableRecette as $key => $value) {
        $title = str_replace ("'", "\\'", $value["title"]);
        $ingredientsText = str_replace ("'", "\\'", $value["ingredientsText"]);
        $preparation = str_replace ("'", "\\'", $value["preparation"]);
        $out .= "insert into Recette values ($key, '$title', '$ingredientsText', '$preparation');\n";
    }
    return $out;
}

function readableRecettes($recettes) {
    $out = "<h1>Recettes</h1><ul>";
    foreach ($recettes as $key => $value) {
        $out .= "<li>" . $value["titre"] . "<ul>";
        $out .= "<li>" . $value["ingredients"] . "</li>";
        $out .= "<li>" . $value["preparation"] . "</li>";
        $out .= "<li>Index<ul>";

        foreach ($value["index"] as $element)
            $out .= "<li>" . $element . "</li>";

        $out .= "</ul></li></ul></li>\n";
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

//echo readableRecettes($Recettes);
//echo readableHierarchie($Hierarchie);
//echo createSql(ingredientDataGenerator($Hierarchie));
//print_r(ingredientDataGenerator($Hierarchie));
//echo createSql(ingredientDataGenerator($Hierarchie), recetteDataGenerator($Recettes));
//print_r(hierarchieDataGenerator($Hierarchie));
print_r(recetteUseDataGenerator($Recettes, $Hierarchie));
//print_r(recetteDataGenerator($Recettes));

