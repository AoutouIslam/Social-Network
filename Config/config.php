<?php
ob_start(); //Turns on output buffering
session_start();

$timezone = date_default_timezone_set("Europe/London");

$con = mysqli_connect("localhost","root","","Social"); // connection varialbe

if(mysqli_connect_errno())
{
    echo 'failled to connect ' . mysqli_connect_errno() ;
}
?>