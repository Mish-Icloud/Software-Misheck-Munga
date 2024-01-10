<?php
function check_login($conn)
{
    if(isset($_SESSION['user_id']))
    {
      $id = $_SESSION['user_id'];
      $sql = "SELECT * FROM users WHERE user_id = '$id' LIMIT 1";
      $res = mysqli_query($conn, $sql);
  
      if($res && mysqli_num_rows($res) > 0)
      {
        $user_data = mysqli_fetch_assoc($res); // Associative array
        return $user_data;
      }
      // Redirect to login 
    header('location:'.SITEURL.'login/login-user.php');
    die(); // Terminate script execution after redirect
    }
    
    
  }
  function random_num($length)
  {
    $text ="";
    if($length < 5)
    {
        $length = 5;
    }
    $len =rand(4, $length);

  for ($i=0; $i < $len; $i++){

    $text .=rand(0,9);

  }
  return $text;
  }
  


?>
