<?php

include("./includes/header.php");

$message_obj = new Message($con,$userLoggedIn);


if(isset($_GET['u']))
	$user_to = $_GET['u'];
else
{
	$user_to = $message_obj->getMostRecentUser();

	if($user_to == false)
		$user_to ='new';
}

if($user_to != "new")
	$user_to_obj = new User($con,$user_to);

if(isset($_POST['post_message']))
{
	if(isset($_POST['message_body']))
	{
		$body = mysqli_real_escape_string($con,$_POST['message_body']);
		$date = date("Y-m-d H:i:s");
		$message_obj->sendMessage($user_to,$body,$date);
	}
}

?>

<div class="user_details column">

		   	<a href="<?php echo $userLoggedIn;?>">
		   	 <img src="<?php echo($user['profile_pic']); ?>"/></a>

		   	<div class="user_details_left_right">
						
		   	<a href="<?php echo $userLoggedIn; ?>"> <?php  echo $user['first_name'] . " " . $user['last_name']; ?>
						</a>

						<br>
						<?php echo "Posts : " . $user['num_posts'];
						 echo "<br> Likes : " . $user['num_likes'];
						 ?>

			</div>
	</div>

	<div class="main_column column" id="main_column">
		<?php

		if($user_to !="new"){
			echo "<div class='convImage'>  <h4> <img src = ". $user_to_obj->getProfilePic() ." />    <a href='$user_to'>". $user_to_obj->getFirstAndLastName() . " </a></h4> <br>  </div><hr>";
			echo "<div class ='loading_messages' id='scroll_message'>";
			echo  $message_obj->getMessages($user_to);
			echo "</div>";
		}else
		{
			echo "<h4> New Message</h4>";
		}


?>

<div class="message_post">

<form action="" method="POST">

<?php
if($user_to == "new"){
	echo "select the friend you would like to message <br><br>";
	?>
	<p>   <?php echo $userLoggedIn; ?></p>
	To :  <input type="text" onKeyup='getUsers(this.value ,"<?php echo $userLoggedIn; ?>" )'  name="q" placeholder="Name" autocomplete="off" id="search_text_input" >
<?php
	echo "<div class='results'></div>";
	}else {
		echo "<textarea name='message_body' id='message_textarea' placeholder='write your message'> </textarea>";
		echo "<input type='submit' name='post_message' class='info' id='message_submit' value='send'>";
	}

		?>


</form>
</div>



	</div>

	<script > 
		var div = document.getElementById('scroll_message');
		div.scrollTop = div.scrollHeight;

	</script>


	<div class="user_details column" id="conversation">
		<h4> CONVERSATION</h4>
		<div class="loading_Conversation">
			
			<?php
				echo $message_obj->getConvos();?>
				<br>
		<a href="messages.php?u=new"> new message</a>
			
		</div>
	</div>