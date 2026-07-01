<?php

$host   = 'localhost';
$dbname = 'vetclinica';
$user   = 'root';
$senha  = '1234';
 
$db = mysqli_connect($host, $user, $senha, $dbname);

if(!$db){
    die("Erro na conexão com o banco!");
}