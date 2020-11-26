<?php
require('Donnees.inc.php');
$lolo = "toto";
function index()
{
  require('indexView.php');
}

function recipiesHierarchy()
{
  $hierarchieLevel = array();
  $hierarchieLevel = explode("_", $_GET('levels'));
  echo "lolo ".$hierarchieLevel;
  require('indexView.php');
}
