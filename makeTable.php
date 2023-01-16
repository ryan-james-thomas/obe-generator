<?php
session_start();
require_once("HamiltonianClass.php");
$nDim = filter_input(INPUT_POST,"dimensions");

$h = new Hamiltonian($nDim);
$out = new jsOutArray("entryTableDiv",$h->makeTable());
$out->printToJSON();

$_SESSION["hamiltonian"] = $h;

?>