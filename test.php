<?php
        //check whether the submit button is clicked
        if (isset($_POST['submit'])) {
            //echo "Clicked";

            //get the value from form
            $title = $_POST['Title'];

            //for radio input, we need to check whether the button is selected or not
            if (isset($_POST['Featured'])) {
                //get the value from form
                $featured = $_POST['Featured'];
            } else {
                //set the default value
                $featured = "No";
            }
            if (isset($_POST['active'])) {
                $active = $_POST['active'];
            } else {
                $active = "No";
            }

            //create sql query to insert category into database
            $sql = "INSERT INTO tbl_category SET
            Title='$title',
            Featured='$featured',
            active='$active'
            ";
            //execute the query and save in database
            $res = mysqli_query($conn, $sql);

            //check whether the query executed or not and data added or not
            if ($res == true) {
                //Query executed and category added
                $_SESSION['add'] = "Category Added Successfully";
                //redirect to manage category page
                header('location:'.SITEURL.'admin/manage-category.php');
            } else {
                //failed to add category
                $_SESSION['add'] = "Failed to Add category";
                //redirect to manage category page
                header('location:'.SITEURL .'admin/add-category.php');
            }
        }

        ?>