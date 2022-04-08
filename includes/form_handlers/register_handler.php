<?php

//declaring variables to prevent errors

$fname = ""; // first name
$lname = ""; // last name
$em = ""; // email
$em2 = ""; // email2
$password = ""; // password
$password2 = ""; // password 2
$date = ""; // sign up date
$error_array = array(); // holds error messages

if(isset($_POST["register_button"]))
{
    // registration from values
    
    //first name
    $fname = strip_tags($_POST['reg_fname']); // remove html tags
    $fname  = str_replace(' ','',$fname); // remove spaces
    $fname = ucfirst(strtolower($fname)); // uppercase first letter
    $_SESSION['reg_fname'] = $fname; // stores first name into session variable


    
    //last name
    $lname = strip_tags($_POST['reg_lname']); // remove html tags
    $lname  = str_replace(' ','',$lname); // remove spaces
    $lname = ucfirst(strtolower($lname)); // uppercase first letter
    $_SESSION['reg_lname'] = $lname; // stores last name into session variable
    
    
     //email
    $em = strip_tags($_POST['reg_email']); // remove html tags
    $em  = str_replace(' ','',$em); // remove spaces
    $em = ucfirst(strtolower($em)); // uppercase first letter
    $_SESSION['reg_email'] = $em; // stores email into session variable
    
    
     //email 2
    $em2 = strip_tags($_POST['reg_email2']); // remove html tags
    $em2  = str_replace(' ','',$em2); // remove spaces
    $em2 = ucfirst(strtolower($em2)); // uppercase first letter
    $_SESSION['reg_email2'] = $em2; // stores email 2 into session variable
    
    
     //password
    $password = strip_tags($_POST['reg_password']); // remove html tags
    
      //password2
    $password2 = strip_tags($_POST['reg_password2']); // remove html tags
    
    
    $date = date("Y-m-d"); //current date
    
    //check email
    if($em == $em2)
    {
        //check if email is in valid format 
        if(filter_var($em,FILTER_VALIDATE_EMAIL))
        {
            $em = filter_var($em,FILTER_VALIDATE_EMAIL);

            $e_check = mysqli_query($con,"SELECT email FROM users WHERE email='$em'");

            // count number of rows returned

            $num_rows = mysqli_num_rows($e_check);
            if($num_rows > 0)
            {
               array_push( $error_array,"email already in use<br>");
            }

        }   else{
            array_push($error_array, "invalid format<br>");
        }     
    }else
    {
        array_push($error_array, "emails dont match<br>");
    }
    
    // check if first name is valid
    if(strlen($fname) > 25 || strlen($fname) < 2)
    {
        array_push($error_array, "your first name must between 2 and 25 characters<br>");
    }

    // check if last name is valid
    if(strlen($lname) > 25 || strlen($lname) < 2)
    {
        array_push($error_array,"your last name must between 2 and 25 characters<br>");
    }

    // check if the password and password 2 are the same
    if($password != $password2)
    {
        array_push($error_array, "your passwords do not match<br>");
    }else
    {
        // check if password contains non english characters
        if(preg_match('/[^A-Za-z0-9]/', $password))
        {
            array_push($error_array, "your password can only contains english caracters and numbers<br>");
        }
    }


    // check password length
    if(strlen($password) > 30 || strlen($password) < 5)
    {
        array_push($error_array, "your password must be between 5 and 30 characters");
    }


    if(empty($error_array))
    {
        $password = md5($password); // encrypt password before send to database
        
        // generate username by concatinating first name and last name 
        $username = strtolower($fname ."_". $lname);
        $check_username_query = mysqli_query($con,"SELECT user_name FROM users WHERE user_name ='$username'")or die("invalid query " . mysqli_error($con));
        $i = 0;
        // if username existes add number to username
        while(mysqli_num_rows($check_username_query) != 0)
        {
            $i++;// add one to i
            $username = $username. "_" .$i;
             $check_username_query = mysqli_query($con,"SELECT user_name FROM users WHERE user_name ='$username'");
        }
        
        
        // profile picture assignement 
        $rand = rand(1,2); // random number between 1 and 2

         if($rand == 1)   
        $profile_pic = "./Assets/Images/Profile_Pics/Default/head_alizarin.png";
       else if($rand == 2)
            $profile_pic = "./Assets/Images/Profile_Pics/Default/head_pete_river.png";


        $query = mysqli_query($con,"INSERT INTO users VALUES('','$fname','$lname','$username','$em','$password','$date','$profile_pic','0','0','no',',')");

        array_push($error_array,"<span style='color:#14c800'>You're all set Go Ahead and login!!</span> <br>");
        
        //Clear Session Variable
        
        $_SESSION['reg_fname'] = "";
        $_SESSION['reg_lname'] = "";
        $_SESSION['reg_email'] = "";
        $_SESSION['reg_email2'] = "";
    }
    
}
?>
