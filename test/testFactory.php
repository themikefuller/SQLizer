<?php

// Require sqlFactory
chdir('../src');
require_once 'sqlFactory.php';

// dbA settings
$settingsA = [

    "host"=>"localhost",
    "port"=>"3306",
    "user"=>"sqlizer",
    "pass"=>"password",
    "name"=>"sqlizer"

];

// dbB settings
$settingsB = [

    "host"=>"localhost",
    "port"=>"3306",
    "user"=>"test",
    "pass"=>"password",
    "name"=>"generic"

];

// New sqlFactory
$sqlfactory = new sqlFactory();

// Create a new connection using dbA settings
$dbA = $sqlfactory->NewSQL($settingsA);

// Create a new connection using dbB settings
$dbB = $sqlfactory->NewSQL($settingsB);

// List all connection. This is for testing purposes, not production.
echo "LIST OF CONNECTIONS \n";
$conns = $sqlfactory->ListCon();
print_r($conns);
echo "\n";

// Use a connection. Useful for utilizing a connection that was already created previously.
// This example uses the first connection available in the list: $this->dbs[0];
echo "USE THIS CONNECTION \n";
$dbC = $sqlfactory->UseCon(0);
print_r($dbC);
echo "\n";


