<?php
include("./../../Config/config.php");
include("./../classes/user.php");

$query = $_POST['query'];
$userLoggedIn = $_POST['userLoggedIn'];


$names = explode(" ", $query);

if(strpos($query,"_") !== false){
	$userReturned = mysqli_query($con,"SELECT * FROM users WHERE user_name LIKE '$query%' AND user_closed='no' LIMIT 8");
}else if(count($names) == 2){
	$userReturned = mysqli_query($con,"SELECT * FROM users WHERE (first_name LIKE '%$names[0]' AND last_name LIKE '%$names[1]%') AND user_closed='no' LIMIT 8");
}
else {
	$userReturned = mysqli_query($con,"SELECT * FROM users WHERE (first_name LIKE '%$names[0]' OR last_name LIKE '%$names[0]%') AND user_closed='no' LIMIT 8");
}

if($query != "")
{
	while($row = mysqli_fetch_array($userReturned)){
		$user = new User($con,$userLoggedIn);
		$mutual_friends = "";
		if($row['user_name'] != $userLoggedIn){
			$mutual_friends = $user->getMutualFriends($row['user_name']) . " friends in commun";
		}
		else{
			$mutual_friends = "";
		}


		if($user->isFriend($row['user_name']))
		{
			echo "<div class='resultDisplay'> 
			<a href='messages.php?u=" . $row['user_name'] ."' style='color:#000;'>

			<div class='liveSearchProfilePic'>
			<img src ='" .$row['profile_pic']."'>

			</div>

			<div class='liveSearchText'> " . $row['first_name'] . "  " .  $row['last_name'] . "<p style='margin:0px;'>" . $row['user_name'] . " </p>
			<p id='gray' style='color: #6d2626;'>  " . $mutual_friends ." </p>
			</div>

			</a>

			</div>";
		}
	}
}
?>