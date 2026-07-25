<?php

$servidor="localhost";
$usuario="root";
$password="";
$bd="estetica_canina";

$conexion=new mysqli($servidor,$usuario,$password,$bd);

if($conexion->connect_error){

die("Error de conexión");

}

?>