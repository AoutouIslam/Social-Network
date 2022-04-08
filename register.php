<?php

require "./Config/config.php";
require "./includes/form_handlers/register_handler.php";
require "./includes/form_handlers/login_handler.php";

?> 

<hmtl>

    <head>
    
        <title>
        
            welcome to swirlfeed
        </title>
        <link rel="stylesheet" type="text/css" href="./Assets/css/register_style.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="./Assets/js/register.js" ></script>
    </head>
    <body>

        <?php 

            if(isset($POST['register_button']))
            {
                echo
                '<script>
                $(document).ready(function()
                {
                    $("#first").hide();
                    $("#second").show();

                    });
                </script>
                ';
            }

        ?>

        <div class="wrapper">

            <div class="login_box">
        

        <div class="login_header">
            <h1> swirlfeed</h1>
            login or sign up
        </div>
        <div id="first">
            <form action="register.php" method="post">
            
            <input type="text" name="log_email" placeholder="email adresse" value="<?php 
            if(isset($_SESSION['log_email']))
            {
                echo $_SESSION['log_email'];
            }?>" required/>
            <br>
            <input type="password" name="log_password" placeholder="password" required />
            <br>
        <input type="submit" name= "login_button" value = "login" >

        <?php if(in_array("Email or Password were incorrect <br>", $error_array)) echo "Email or Password were incorrect <br>"; ?>
            
            <br>
            <a href="#" id="signup" class="signup"> Need an account ,register here!!!</a>
        </form>
    </div>
        
    <div id="second">
        <form action="register.php" method="post">
        
            <input type = "text"  name="reg_fname" placeholder="first name" value="<?php 
            if(isset($_SESSION['reg_fname']))
            {
                echo $_SESSION['reg_fname'];
            }?>" required> 
            <br>
              <!-- first name checking -->
            <?php if(in_array("your first name must between 2 and 25 characters<br>",$error_array)) echo "your first name must between 2 and 25 characters<br>";?>
            
            <!-- end first name checking -->
        <input type = "text"  name="reg_lname" placeholder="last name" value="<?php 
            if(isset($_SESSION['reg_lname']))
            {
                echo $_SESSION['reg_lname'];
            }?>" required>
      
    
        <br>
            
            <!-- last name checking -->
         <?php if(in_array("your last name must between 2 and 25 characters<br>",$error_array)) echo "your last name must between 2 and 25 characters<br>";?>
            <!-- end last name checking -->
            <!-- email checking--> 
        <input type = "email"  name="reg_email" placeholder="email" value="<?php 
            if(isset($_SESSION['reg_email']))
            {
                echo $_SESSION['reg_email'];
            }?>" required>
            <br>
            
            <?php if(in_array("email already in use<br>",$error_array)) echo "email already in use<br>";else if(in_array("invalid format<br>",$error_array)) echo "invalid format<br>"; else if(in_array("emails dont match<br>",$error_array)) echo "emails dont match<br>";?>
            
            <!-- end email checking-->
                
                
        <input type = "email"  name="reg_email2" placeholder="confirm email" value="<?php 
            if(isset($_SESSION['reg_email2']))
            {
                echo $_SESSION['reg_email2'];
            }?>" required>
    
    
        <br>
            <!--email 2 checking-->
            <?php if(in_array("email already in use<br>",$error_array)) echo "email already in use<br>";
            else if(in_array("invalid format<br>",$error_array)) echo "invalid format<br>";
            else if(in_array("emails dont match<br>",$error_array)) echo "emails dont match<br>";?>
        
            <!-- end email 2 checking -->
            <input type = "password"  name="reg_password" placeholder="password" required>
            <br>
                
                <!-- password checking -->
             <?php if(in_array("your passwords do not match<br>",$error_array)) echo "your passwords do not match<br>";
            else  if(in_array( "your password must be between 5 and 30 characters",$error_array)) echo  "your password must be between 5 and 30 characters";
            else if(in_array( "your password can only contains english caracters and numbers<br>",$error_array)) echo "your password can only contains english caracters and numbers<br>";
             ?>
            <!-- end password checking -->
          
        <input type = "password"  name="reg_password2" placeholder="confirm password" required>
    
                <!-- password 2 checking >
     <?php if(in_array("your passwords do not match<br>",$error_array)) echo "your passwords do not match<br>";else if(in_array( "your password must be between 5 and 30 characters",$error_array)) echo  "your password must be between 5 and 30 characters";else if(in_array( "your password can only contains english caracters and numbers<br>",$error_array)) echo  "your password can only contains english caracters and numbers<br>";?>
            <!-- end password 2 checking -->
        <br>
            
            <input type="submit" name= "register_button" value = "register" >
            
            <br>
            <?php if(in_array("<span style='color:#14c800'>You're all set Go Ahead and login!!</span> <br>",$error_array)) echo "<span style='color:#14c800'>You're all set Go Ahead and login!!</span> <br>";?>
            
            <a href="#" id="signin" class="signin"> Already have an account ,sign  in here!!!</a>
              </form>
              </div>

              </div>

          </div>
    </body>
</hmtl>