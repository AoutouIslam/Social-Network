<!DOCTYPE html>
<html>
<head>
	<title></title>

	<link rel="stylesheet" type="text/css" href="./Assets/css/style.css">
</head>
<body>

	<style type="text/css">
	*{
		font-family: Arial,Helvetica,Sans-serif;
	}
	body{
		background-color: #fff;
	}
	form{
		background-color: transparent;
	position: absolute;
	top: 0;
	}


	</style>
	<?php
	require "./Config/config.php";
	include("./includes/classes/user.php");
	include("./includes/classes/post.php");



	if(isset($_SESSION["username"]))
	{
		$userLoggedIn = $_SESSION["username"];
	    $user_details_querry =mysqli_query($con,"SELECT * FROM users WHERE user_name ='$userLoggedIn'");
	    $user = mysqli_fetch_array($user_details_querry);
	}else
	{
		header("location: register.php");
	}


	if(isset($_GET['post_id']))
	{
		$post_id = $_GET['post_id'];

	}

	$get_likes = mysqli_query($con,"SELECT likes,added_by FROM posts WHERE id='$post_id'");
	$row = mysqli_fetch_array($get_likes);

	$total_likes = $row['likes'];
	$user_liked = $row['added_by'];
	$total_user_likes = $row['likes'];


	$user_details_querry = mysqli_query($con,"SELECT * FROM users WHERE user_name='$user_liked'");
	$row = mysqli_fetch_array($user_details_querry);
	
	// like Button
	if(isset($_POST['like_button']))
	{
		$total_likes++;
		$query = mysqli_query($con,"UPDATE posts SET LIKES='$total_likes' WHERE id ='$post_id'; ");
		$total_user_likes = $row['num_likes'];
		$total_user_likes++;
		$user_likes = mysqli_query($con,"UPDATE users SET num_likes='$total_user_likes' WHERE user_name = '$user_liked'");
		$insert_user = mysqli_query($con,"INSERT INTO  likes VALUES('','$userLoggedIn','$post_id');");



		// insert stream_notification
		
	}


	//unlike Button

		// like Button
	if(isset($_POST['unlike_button']))
	{

		$total_likes--;
		$query = mysqli_query($con,"UPDATE posts SET LIKES='$total_likes' WHERE id ='$post_id' ");
		$total_user_likes = $row['num_likes'];
		$total_user_likes--;
		$user_likes = mysqli_query($con,"UPDATE users SET num_likes='$total_user_likes' WHERE user_name = '$user_liked'");
		$insert_user = mysqli_query($con,"DELETE FROM  likes WHERE user_name='$userLoggedIn' AND post_id='$post_id';");



		
	}


	// check for previous likes

	$check_query = mysqli_query($con,"SELECT * FROM likes WHERE user_name='$userLoggedIn' AND post_id='$post_id'");
	$num_rows = mysqli_num_rows($check_query);
	if($num_rows > 0)
	{
		echo '<form action="like.php?post_id=' .$post_id. '" method="POST" > 
		<input type="submit" class="comment_like" name="unlike_button" value="unlike">
		<div class="like_value">'.$total_likes.' Likes
		 </div>
		 </form>
		 ';
	}else
		echo '<form action="like.php?post_id=' .$post_id. '" method="POST" > 
		<input type="submit" class="comment_like" name="like_button" value="like">
		<div class="like_value">'.$total_likes.' likes
		 </div>
		 </form>
		 ';;

?>



</body>
</html>