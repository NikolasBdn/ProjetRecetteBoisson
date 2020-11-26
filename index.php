<?php
require('controller.php');

if (isset($_GET['action'])) {
  if ($_GET['action'] == 'listRecipes' && isset($_GET['level'])) {
    recipiesHierarchy();
  }
}else {
  index();
}
