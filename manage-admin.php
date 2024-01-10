<?php include('partials/menu.php') ?>
<!---Main Content section Starts--->

<div class="main-content">
    <div class="wrapper">
        <h1>Manage Admin</h1>
        <br> <br>
        <?php
        if (isset($_SESSION['add'])) {
            echo $_SESSION['add']; //displaying session message
            unset($_SESSION['add']); // removing session message
        }
        if (isset($_SESSION['delete'])) {
            echo $_SESSION['delete'];
            unset($_SESSION['delete']);
        }
        if (isset($_SESSION['update'])) 
        {
            echo $_SESSION['update'];
            unset($_SESSION['update']);
        }

        if(isset($_SESSION['user-not-found']))
        {
            echo $_SESSION['user-not-found'];
            unset($_SESSION['user-not-found']);
        }
        if(isset($_SESSION['pwd-not-match']))
        {
            echo $_SESSION['pwd-not-match'];
            unset($_SESSION['pwd-not-match']);
        }
        if(isset($_SESSION['change-pwd']))
    {
        echo $_SESSION['change-pwd'];
        unset($_SESSION['change-pwd']);
    }
        ?>
        <br> <br> <br>
        <!---Button to add admin--->
        <a href="add-admin.php" class="btn-primary">Add Admin</a>
        <br>
        <br>
        <table class="tbl-full">
            <tr>
                <th>S.N.</th>
                <th>Full Name</th>
                <th>Username</th>
                <th>Actions</th>
            </tr>
            <?php
            //query to get all admin
            $sql = "SELECT * FROM tbl_admin";
            //execute the query
            $res = mysqli_query($conn, $sql);

            //Check whether the query is executed or not

            if ($res == TRUE) {
                //Count Rows to check whether we have data in database or not
                $count = mysqli_num_rows($res); //function to get all the rows in database
                $sn = 1; //create a variable and assign a value
                //check the num of rows
                if ($count > 0) {
                    //we have data in database
                    while ($rows = mysqli_fetch_assoc($res)) {
                        //using while loop to get all the data from the database
                        //and while loop will run as long as we have data in database

                        //get individual DATA
                        $id = $rows['Id'];
                        $full_name = $rows['Full_name'];
                        $username = $rows['Username'];

                        //display the values in our table
            ?>
                        <tr>
                            <td><?php echo $sn++; ?></td>
                            <td><?php echo $full_name; ?></td>
                            <td><?php echo $username; ?></td>
                            <td>
                            <a href="<?php echo SITEURL; ?>/admin/update-password.php?Id=<?php echo $id; ?>" class="btn-primary">Change Password</a>    
                            <a href="<?php echo SITEURL; ?>/admin/update-admin.php?Id=<?php echo $id; ?>" class="btn-secondary">Update Admin</a>
                            <a href="<?php echo SITEURL; ?>/admin/delete-admin.php?Id=<?php echo $id; ?>" class="btn-danger">Delete Admin</a>
                            </td>
                        </tr>

            <?php

                    }
                } else {
                    //we do not have data in database
                }
            }
            ?>
        </table>
    </div>

</div>
<!---Main Content section Ends--->
<?php include('partials/footer.php') ?>