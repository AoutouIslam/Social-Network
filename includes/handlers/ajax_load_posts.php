<?php 
include("../../Config/config.php");
include("../classes/user.php");
include("../classes/post.php");

$limit = 250; // number of posts to be loaded per call

$posts = new post($con,$_REQUEST['userLoggedIn']);
$posts->loadPostsFriends($_REQUEST,$limit);

?>