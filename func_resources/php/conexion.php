<?php

function conectar(){

    $config = include 'config.php';

    $host = $config['db']['host'];
    $user = $config['db']['user'];
    $pass = $config['db']['pass'];
    $bd = $config['db']['name'];

    $con = mysqli_connect($host, $user, $pass, $bd);
    
    return $con;
}