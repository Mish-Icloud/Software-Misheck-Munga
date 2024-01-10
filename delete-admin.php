<?php 

//include constants.php file here
include('../config/constants.php');
//get the id of admin to be deleted

$id=$_GET['Id'];
//create sql query to delete admin
$sql="DELETE FROM tbl_admin WHERE Id=$id";
//execute the query
$res=mysqli_query($conn, $sql);

//check whether the query execued successfully or not
if($res==true)
{
    //query executed successfully and admin deleted
    //echo "Admin Deleted";
    //create session variable to display message
    $_SESSION['delete'] ="<div class='success'>Admin Deleted Successfully </div>";
    //redirect to manage admin page
    header('location:'.SITEURL. '/admin/manage-admin.php');
}
else
{
    //failed to delete admin
    //echo "Failed to Delete Admin";
    $_SESSION['delete']="<div class='error'> Failed to Delete Admin. Try Again Later.</div>";
    header('location:'.SITEURL. '/admin/manage-admin.php');
}
//redirect to manage admin page with message(success/error)

?>