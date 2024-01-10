<?php include('partials/menu.php'); ?>
<link rel="stylesheet" href="../css/admin.css">
<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>
        <br>
        <br>

        <?php 
        if(isset($_SESSION['add']))//checking whether the session is set or not
        {
            echo $_SESSION['add']; //display session message if set
            unset ($_SESSION['add']);// remove session message
        }
        ?>
        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Full Name: </td>
                    <td>
                        <input type="text" name="Full_name" placeholder="Enter your name">
                    </td>
                </tr>
                <tr>
                    <td>Username</td>
                    <td>
                        <input type="text" name="Username" placeholder="Enter Username">
                    </td>
                </tr>
                <tr>
                    <td>Password:</td>
                    <td>
                        <input type="password" name="Password" placeholder="Enter password">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>
<?php include('partials/footer.php'); ?>
<?php
// process the value from form and save it in database

//check whether the button is clicked or not
if (isset($_POST['submit'])) {
    //button clicked 
    //echo "Button Clicked";


    //Get the data from form

    $full_name = $_POST['Full_name'];
    $username = $_POST['Username'];
    $password = md5($_POST['Password']); //password encryption with md5.

    //SQL query to save data into the database
    $sql = "INSERT INTO tbl_admin SET
    Full_name='$full_name',
    Username='$username',
    Password='$password'
   ";
   //Executing query and saving data into database
    $res=mysqli_query($conn, $sql) or die(mysqli_error($conn));
     //check whether the (query is executed) data is inserted or not and display appropriate message

     if($res==TRUE)
     {
            //data inserted
            //echo "Data Inserted";
            //create a session variable to display message

            $_SESSION ['add'] = "<div class='success'>Admin Added Successfully.</div>";
            //redirect page to manage admin
            header('location:'.SITEURL.'admin/manage-admin.php');
     }

     else
     {
            //failed to insert data
            //echo "failed to insert data";
             //create a session variable to display message

             $_SESSION ['add'] = "<div class='error'>Failed to Add Admin.</div>";
             //redirect page to Add admin
             header('location:'.SITEURL.'admin/add-admin.php');
     }
}
?>