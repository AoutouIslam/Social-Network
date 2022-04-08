<?php
/**
 * 
 */
class Message
{
	private $user_obj;
	private $con;
	private $user_inset;
	
	public function __construct($con,$user)
	{
		# code...
		$this->con = $con;
		$this->user_obj = new user($con,$user);
		$this->user_inset = $user;



	}

	public function getMostRecentUser()
	{
		$userLoggedIn = $this->user_obj->getUserName();
		$query = mysqli_query($this->con,"SELECT user_to,user_from FROM messages WHERE user_to ='$userLoggedIn' OR user_from='$userLoggedIn' ORDER BY id DESC LIMIT 1");
		if(mysqli_num_rows($query) == 0)
			return false;

		$row = mysqli_fetch_array($query);
		$user_to = $row['user_to'];
		$user_from = $row['user_from'];

		if($user_to != $userLoggedIn)
			return $user_to;
		else 
			return $user_from;

	}

	public function sendMessage($user_to,$body,$date)
	{
		if(trim($body)){
			$userLoggedIn = $this->user_obj->getUserName();
			$query = mysqli_query($this->con,"INSERT INTO messages VALUES('','$user_to','$userLoggedIn','$body','$date','no','no','no');");
		}
	}


	public function getMessages($otherUser)
	{
		$userLoggedIn = $this->user_obj->getUserName();
		$data = "";

		$query = mysqli_query($this->con,"UPDATE messages SET opened='yes' WHERE user_to='$userLoggedIn' AND user_from ='$otherUser'");

		$get_messages_query = mysqli_query($this->con,"SELECT * FROM messages WHERE (user_to='$userLoggedIn' AND user_from = '$otherUser') OR (user_to='$otherUser' AND user_from = '$userLoggedIn')");
		while($row = mysqli_fetch_array($get_messages_query))
		{
			$user_to = $row['user_to'];
			$user_from = $row['user_from'];
			$body = $row['body'];

			$div_top = ($user_to == $userLoggedIn) ?"<div class='message' id= 'green'>" :"<div class='message' id= 'blue'>";

			$data = $data . $div_top . $body . "</div> <br><br>";
		}

		return $data;
	}

	public function getLatestMessage($userLoggedIn,$User2)
	{
		$details_array = array();
		$query = mysqli_query($this->con,"SELECT body,user_to,date FROM messages WHERE (user_to ='$userLoggedIn' AND user_from = '$User2' ) OR(user_from ='$userLoggedIn' AND user_to = '$User2' )  ORDER BY id DESC");

		$row = mysqli_fetch_array($query);
		$sent_by = ($row['user_to'] == $userLoggedIn) ?"they said :": "you said :";


		//TimeFrame
				$date_time_now = date("Y-m-d H:i:s");
				$start_date = new DateTime($row['date']);
				$end_date = new DateTime($date_time_now);
				$interval = $start_date->diff($end_date);
				if($interval->y == 1)
				{
					if($interval == 1)
						$time_message = $interval->y . "year ago";
					else 
						$time_message = $interval->y . "years ago";
					// end if INtervale->y
				}else if($interval->m >=1)
				{
					if($interval->d == 0)
					{
						$days = " ago";
					}else if($interval->d == 1)
					{
						$days = $interval->d ." day ago";
					}
					else 
					{
						$days = $interval->d ." days ago";
					}
					if($interval->m == 1)
					{
						$time_message = $interval->m . " month " . $days;
					}else{
						$time_message = $interval->d . " months " . $days;
					}

				} //end month condition
				else if($interval->d >=1){
					if($interval->d == 1)
					{
						$time_message = " Yesterday";
					}
					else 
					{
						$time_message = $interval->d ." days ago";
					}
				} //end day condition
				else if($interval->h >= 1)
				{
					if($interval->h == 1)
					{
						$time_message = $interval->h ." hour ago";
					}
					else 
					{
						$time_message = $interval->h ." hours ago";
					}

				} // end hour condition
				else if($interval->i >= 1)
				{
					if($interval->i == 1)
					{
						$time_message = $interval->i ." minute ago";
					}
					else 
					{
						$time_message = $interval->i ." minutes ago";
					}

				} // end minute condition
				else 
				{
					if($interval->s <= 30)
					{
						$time_message =  " Just Now";
					}
					else 
					{
						$time_message = $interval->s ." seconds ago";
					}

				} // end second condition


		array_push($details_array,$sent_by);
		array_push($details_array,$row['body']);
		array_push($details_array,$time_message);


		return $details_array;

	}



	public function getConvos()
	{
		$userLoggedIn = $this->user_obj->getUserName();
		$return_string = "";
		$convos =  array( );
		$query = mysqli_query($this->con,"SELECT user_to,user_from FROM messages WHERE user_to='$userLoggedIn' OR user_from ='$userLoggedIn' ORDER BY id DESC");

		while($row = mysqli_fetch_array($query))
		{
			$user_to_push = ($row['user_to']!= $userLoggedIn)?$row['user_to']: $row['user_from'];

			if(!in_array($user_to_push, $convos)){
				array_push($convos, $user_to_push);
			}
		}

		foreach($convos as $UserName)
		{
			$user_found_obj = new User($this->con,$UserName);
			$latest_message_details = $this->getLatestMessage($userLoggedIn,$UserName);

			$dots = (strlen($latest_message_details[1]) >=12) ? "...": "";
			$split = (str_split($latest_message_details[1],12));
			$split = $split[0] . $dots;

			$return_string .= "<a href='messages.php?u=$UserName'>
			<div class='user_found_messages'>
				<img src = '" . $user_found_obj->getProfilePic() ."'' style='border-raduis:5px ;margin-right:5px;'>" . $user_found_obj->getFirstAndLastName() . "
				<span class='timestamp_smaler' id='gray'>" . $latest_message_details[2] ."</span>
				<p id='gray' style='margin:0;' >" . $latest_message_details[0] . $split ." </P>
			</div>

			</a>";
		}
		return $return_string;
	}


}


?>