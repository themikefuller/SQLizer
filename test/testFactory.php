<?php

chdir('../src');
require_once 'sqlFactory.php';

$settings = [

    "host"=>"localhost",
    "port"=>"3306",
    "user"=>"test",
    "pass"=>"password",
    "name"=>"generic"

];


$sqlfactory = new sqlFactory();

$db = $sqlfactory->NewSQL($settings);


var_dump($db);
