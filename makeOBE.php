<?php
require_once("HamiltonianClass.php");
session_start();
$h = $_SESSION["hamiltonian"];

$vals = json_decode(filter_input(INPUT_POST,"arr"),true);
//var_dump($vals);
$h->readValues($vals);
$html = $h->makeOBETable();
$out = new jsOutArray("obeTableDiv",$html);
$out->printToJSON();

?>