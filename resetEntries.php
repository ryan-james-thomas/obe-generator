<?php
require_once("HamiltonianClass.php");
session_start();
$h = $_SESSION["hamiltonian"];
$h->resetEntries();
$out = new jsOutArray("entryTableDiv",$h->makeTable());
$out->printToJSON();

$_SESSION["hamiltonian"] = $h;

?>