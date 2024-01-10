
<?php include('../config/constants.php');?>
<!DOCTYPE html>
<head>
    <title>Login-Food Order System</title>
    <style>
    body {
      background-image: url("../images/background/login.jpeg");
      background-size: cover; /* Adjust the image sizing as needed */
      background-repeat: no-repeat; /* Prevent image repetition */
    }
  </style>
    <link rel="stylesheet" href="../css/admin.css">
    </head>
<body>
    <p class="text-container" style="color: #0fbcf9;">Welcome to Clyde's Restaurant, Your Wish is Our Command.</p>
    <div class="login">
        <h1 class="text-center" style="color: #ff3f34;">Login</h1>
        <br> <br>
        <?php 
        if(isset($_SESSION['login']))
        {
            echo $_SESSION['login'];
            unset ($_SESSION['login']);
        }
        if(isset($_SESSION['no-login-message']))
        {
            echo $_SESSION['no-login-message'];
            unset ($_SESSION['no-login-message']);
        }
        ?>
        <br> <br>
        <!--login form starts here-->
        <form action="" method="POST" class="text-center" style="color: #ff5e57;">
            Username: <br> <br>
            <input type="text" name="Username" placeholder="Input username"> <br><br>
            Password: <br> <br>
            <input type="password" name="Password" placeholder="Input password"> <br><br>
            <input type="submit" name="submit" value="Login" class="btn-primary">
            <br> <br>
        </form>

        <!--login form ends here-->
        <p class="text-center" style="color: #00d8d6;">Created by- <a href="mishclyde">Misheck Munga</a></p>

    </div>
</body>

</head>

</html>
<?php
//check whether the submit button is clicked or not
if(isset($_POST['submit']))
{
    //process for login
    //get the data from login form
    $username=$_POST['Username'];
    $password=md5($_POST['Password']);

    //sql to check whether the user with username and password exists or not
    $sql="SELECT * FROM tbl_admin WHERE Username='$username' AND Password='$password'";
    //execute the query
    $res=mysqli_query($conn, $sql);
    
    //count rows to check whether the user exists or not

    $count=mysqli_num_rows($res);
    if($count==1)
    {
        //user available and login success
        $_SESSION['login']="<div class='success'> Login Successful.</div>";
        $_SESSION['user']=$username; //to check whether the user is logged in or not and logout will unset it
        //redirect to Home Page/dashboard
        header('location:'.SITEURL.'admin/');
    }
    else
    {
        //user not available and login fail
        $_SESSION['login']="<div class='error text-center'> Username or Password did not match.</div>";
        //redirect to Home Page/dashboard
        header('location:'.SITEURL.'admin/login.php');
    }


}
?>