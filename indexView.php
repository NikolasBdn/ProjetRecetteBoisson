<!DOCTYPE html>
<html dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Boissons</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript">
        function getSousCategorie(){
          var listSelected = "";
          var selects = $('.select_aliments option:selected');

          $('.select_aliments option:selected').each(function(i){
            listSelected += $(this).val()+'_';
          });
console.log(listSelected);
          $.ajax({
            url:'index.php/action?=listRecipes&levels?=' + listSelected,
            type:'GET'

          });
        }
    </script>
  </head>
  <body>

    <div id="liste_aliments">
      <select name="aliments" class="select_aliments" onchange="getSousCategorie()">
        <?php
        include 'Donnees.inc.php';
        $bad_characters = array(' ', '\'', ':', '.');
          foreach ($Hierarchie['Aliment']['sous-categorie'] as $aliment) {
            $value_aliment = str_replace($bad_characters, '', $aliment);
            echo '<option value="'.strtolower($value_aliment).'">'.$aliment.'</option>';
          }
         ?>
       </select>

        <?php
        include "controller.php";

        echo $lolo;
        var_dump($hierarchieLevel);
          for ($i=0; $i < sizeof($hierarchieLevel); $i++) {
            echo '<select class="select">';
              $hierarchieLevel[$i];
            echo '</select>';
          }

         ?>
       <!-- <select class="select_aliments" >
         <option value="lolo">lolo</option>
         <option value="lili">lili</option>
         <option value="lulu">lulu</option>
       </select> -->

    </div>
  </body>
</html>
