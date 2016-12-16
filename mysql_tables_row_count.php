<?php

$db = new mysqli("localhost", "root", "jtTMHiG2", "mysql");

$sql = "SHOW DATABASES";
$q = $db->query($sql) or die($db->error);
$databases = array();
while($r = $q->fetch_assoc()){
	$databases[] = $r["Database"];
}
asort($databases);

$report = array();

foreach($databases as $database){
	$sql = "SHOW TABLES FROM $database";
	$q = $db->query($sql) or die($db->error);
	$tables = array();
	while($r = $q->fetch_assoc()){
		$tables[] = array_shift($r);
	}
	asort($tables);
	$report[$database] = $tables;
}

foreach($report as $database => $tables){
	foreach($tables as $table){
		$sql = "SELECT COUNT(*) AS rows FROM $database.$table";
		$q = $db->query($sql) or die($db->error);
		$r = $q->fetch_assoc();
		$report[$database][$table]["rows"] = $r["rows"];
		echo $database . " " . $table  . " " . $r["rows"] .  "\n";
	}
}

$db->close();

