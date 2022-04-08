<?php
require "./Config/config.php";
include("includes/classes/user.php");
include("includes/classes/post.php");
include("includes/classes/message.php");

if(isset($_SESSION["username"]))
{
	$userLoggedIn = $_SESSION["username"];
    $user_details_querry =mysqli_query($con,"SELECT * FROm users WHERE user_name ='$userLoggedIn'");
    $user = mysqli_fetch_array($user_details_querry);
}else
{
	header("location: register.php");
}


?>

<html>

    <head>
    
        <title>Swirlfeed</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="./Assets/js/bootbox.min.js"></script> 
        <script src="./Assets/js/bootstrap.js"></script> 
        <script src="./Assets/js/Social Network.js"></script>
        <script src="Assets/js/jquery.jcrop.js"></script>
    <script src="Assets/js/jcrop_bits.js"></script>







        
        <link rel="stylesheet" type="text/css" href="./Assets/css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="./Assets/css/style.css">
       <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="Assets/css/jquery.Jcrop.css" type="text/css" />
    </head>

    <body>
    	<div class="top_bar">
    		<div class="logo">
    			<a href="index.php"> swirlfeed</a>
    		</div>

            <nav>
                 <a href="<?php
                   echo $userLoggedIn;
                 ?>"><?php
                   echo $user['first_name'];
                 ?></a>
                <a href="index.php"><i class="fa fa-home fa-lg"></i></a>
                <a href="#"><i class="fa fa-envelope-square fa-lg"></i></a>
                 <a href="#"><i class="fa fa-bell-o fa-lg"></i></a>
                  <a href="requests.php"><i class="fa fa-users fa-lg"></i></a>
                <a href="#"><i class="fa fa-cog fa-lg"></i></a>
                 <a href="./includes/handlers/logout.php"><i class="fa fa-sign-out fa-lg"></i></a>
                
            </nav>

    	</div>

      <div class="wrapper">