<?php 
include('../config/constants.php');
include('../login/functions.php');

if($_SERVER['REQUEST_METHOD'] == "POST")
{
    //something was posted
    $user_name=$_POST['user_name'];   
    $password=$_POST['password'];

    if(!empty($user_name) && !empty($password) && !is_numeric($user_name))
    {
        //save to database
        $user_id=random_num(50);
        $sql="INSERT INTO users (user_id,user_name,password) values ('$user_id','$user_name','$password')";

        mysqli_query($conn, $sql);
        header("Location: login-user.php");
        die();

    }
    else
    {
        echo "Please enter Valid information";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <style>
    body {
      background-image: url("../images/background/signup.jpeg");
      background-size: cover; /* Adjust the image sizing as needed */
      background-repeat: no-repeat; /* Prevent image repetition */
    }
    .container {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .tbl-30 {
      width: 30%;
      border-collapse: collapse;
    }

    .tbl-30 td {
      padding: 8px;
    }

    .form-label {
      color: #ff3f34;
    }

    .form-control {
      width: 100%;
      padding: 5px;
    }

    .show-password-btn {
      margin-top: 5px;
    }

    .form-check-label {
      color: #ff5e57;
    }
  </style>
</head>
<body>
  <div class="container">
    <form action="" method="post" class="tbl-30">
      <table>
        <tr>
          <td>
            <label for="user_name" class="form-label">Username</label>
          </td>
          <td>
            <input type="text" name="user_name" class="form-control">
          </td>
        </tr>
        <tr>
          <td>
            <label for="password" class="form-label">Password</label>
          </td>
          <td>
            <div class="password-wrapper">
              <input type="password" name="password" class="form-control" id="password-input">
              <button type="button" class="show-password-btn" onclick="togglePasswordVisibility()">Show Password</button>
            </div>
          </td>
        </tr>
        <tr>
          <td colspan="2">
            <div class="mb-3 form-check">
              <input type="checkbox" class="form-check-input" id="exampleCheck1">
              <label class="form-check-label" for="exampleCheck1">Check me out</label>
            </div>
          </td>
        </tr>
        <tr>
          <td colspan="2">
            <button type="submit" class="btn btn-primary">Signup</button>
            <a href="login-user.php">Click to Login</a>
          </td>
        </tr>
      </table>
    </form>
  </div>

  <script>
    function togglePasswordVisibility() {
      const passwordInput = document.getElementById('password-input');
      const button = document.querySelector('.show-password-btn');

      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        button.textContent = 'Hide Password';
      } else {
        passwordInput.type = 'password';
        button.textContent = 'Show Password';
      }
    }
  </script>
</body>
</html>