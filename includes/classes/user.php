<?php
/**
 * 
 */
class user 
{
	private $user;
	private $con;
	
	public function __construct($con,$user)
	{
		# code...
		$this->con = $con;
		$user_details_query = mysqli_query($con,"SELECT * FROM users WHERE user_name = '$user'");
		$this->user = mysqli_fetch_array($user_details_query);
	}
	public function getUserName()
	{
			return $this->user['user_name'];
	}

	public function getNumPosts()
	{
		$user_name = $this->user['user_name'];
		$query = mysqli_query($this->con,"SELECT num_posts FROM users WHERE user_name = '$user_name'");

		$row = mysqli_fetch_array($query);
		return $row['num_posts'];
	}

	public function getFirstAndLastName()
	{
		$username = $this->user['user_name'];
		$query = mysqli_query($this->con,"SELECT first_name, last_name FROM users WHERE user_name = '$username'");

		$row = mysqli_fetch_array($query);
		return $row['first_name']. " " . $row['last_name'];
	}

	public function getProfilePic()
	{
		$username = $this->user['user_name'];
		$query = mysqli_query($this->con,"SELECT profile_pic FROM users WHERE user_name = '$username'");

		$row = mysqli_fetch_array($query);
		return $row['profile_pic'];
	}


	public function isClosed()
	{
		$username = $this->user['user_name'];
		$query = mysqli_query($this->con,"SELECT user_closed FROM users WHERE user_name='$username'");
		$row = mysqli_fetch_array($query);
		if($row['user_closed'] == 'yes')
			return true;
		else
			return false;

		
	}



	public function isFriend($username_to_check)
	{
		$usernameComma = ","  .$username_to_check . ",";

		if(strstr($this->user['friend_array'],$usernameComma) || $username_to_check == $this->user['user_name'])
		{
			return true;
		}else
		{
			return false;
		}
	}

	public function didReceiveRequest($user_from)
	{
		$user_to = $this->user['user_name'];
		$check_request_query = mysqli_query($this->con,"SELECT * FROM friend_request WHERE user_to='$user_to' AND user_from ='$user_from'");
		if(mysqli_num_rows($check_request_query) > 0)
		{
			return true;
		}else
		{
			return false;
		}

	}
	public function didSendRequest($user_to)
	{
		$user_from = $this->user['user_name'];
		$check_request_query = mysqli_query($this->con,"SELECT * FROM friend_request WHERE user_to='$user_to' AND user_from ='$user_from'");
		if(mysqli_num_rows($check_request_query) > 0)
		{
			return true;
		}else
		{
			return false;
		}

	}

	public function removeFriend($user_to_remove)
	{
		$logged_in_user = $this->user['user_name'];

		$query = mysqli_query($this->con,"SELECT friend_array FROM users WHERE user_name='$user_to_remove'");
		$row = mysqli_fetch_array($query);
		$friend_array_username = $row['friend_array'];

		$row_friend_array = str_replace($user_to_remove . ",", "",$this->user['friend_array']);
		$remove_friend = mysqli_query($this->con,"UPDATE users SET friend_array='$row_friend_array' WHERE user_name='$logged_in_user'");

		$row_friend_array = str_replace($this->user['user_name']. ",", "",$friend_array_username );
		$remove_friend = mysqli_query($this->con,"UPDATE users SET friend_array='$row_friend_array' WHERE user_name='$user_to_remove'");



		

	}

	public function sendRequest($user_to)
	{
		$user_from = $this->user['user_name'];
		$query = mysqli_query($this->con,"INSERT INTO friend_request VALUES('','$user_to','$user_from');");
	}


	public function getFriendArray()
	{
		$username = $this->user['user_name'];
		$query = mysqli_query($this->con,"SELECT friend_array FROM users WHERE user_name = '$username'");

		$row = mysqli_fetch_array($query);
		return $row['friend_array'];
	}

	public function getMutualFriends($user_to_check)
	{
		$mutualFriends = 0;
		$user_array = $this->user['friend_array'];
		$user_array_explode = explode(",",$user_array);



		$query = mysqli_query($this->con,"SELECT friend_array FROM users WHERE user_name ='$user_to_check' ");
		$row = mysqli_fetch_array($query);
		$user_to_check_array = $row['friend_array'];
		$username_to_check_explode = explode(",", $user_to_check_array);

		foreach($user_array_explode as $i){
			foreach ($username_to_check_explode as $j) {
				# code...
				if($i == $j && $i != "")
				 	$mutualFriends++; 
			}
		}
		return $mutualFriends;
	}
}

?>