<?php include('partials/menu.php') ?>
<div class="main-content">

    <div class="wrapper">
        <h1>Update Category</h1>

        <br> <br>
        <?php

        //check whether the id is set or not
        if (isset($_GET['Id'])) {
            //get the id and all other details
            //echo "Getting the data";
            $id = $_GET['Id'];
            //create sql query to get all other data
            $sql = "SELECT * FROM tbl_category WHERE Id=$id";

            //execute the query
            $res = mysqli_query($conn, $sql);

            //count the rows to check whether the id is valid or not
            $count = mysqli_num_rows($res);

            if ($count == 1) {
                //get all the data 
                $row = mysqli_fetch_assoc($res);
                $title = $row['Title'];
                $current_image = $row['image_name'];
                $featured = $row['Featured'];
                $active = $row['active'];
            } else {
                //redirect to manage category with session message
                $_SESSION['no-category-found'] = "<div class='error'>Category not Found. </div>";

                header('location:' . SITEURL . 'admin/manage-category.php');
            }
        } else {
            //redirect to manage-category
            header('location' . SITEURL . 'admin/manage-category.php');
        }

        ?>
        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title:</td>
                    <td>
                        <input type="text" name="Title" value="<?php echo $title ?>">
                    </td>
                </tr>
                <tr>
                    <td>Current Image: </td>
                    <td>
                        <?php
                        if ($current_image != "") {
                            //display the image
                        ?>
                            <img src="<?php echo SITEURL; ?>images/category/<?php echo $current_image; ?>" width="150px">
                        <?php
                        } else {
                            //display message
                            echo "<div class='error'>Image Not Added.</div>";
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>New Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td>Featured: </td>
                    <td>
                        <input <?php if ($featured == "Yes") {
                                    echo "checked";
                                } ?> type="radio" name="Featured" value="Yes">Yes

                        <input <?php if ($featured == "No") {
                                    echo "checked";
                                } ?> type="radio" name="Featured" value="No">No
                    </td>
                </tr>
                <tr>
                    <td>Active: </td>
                    <td>
                        <input <?php if ($active == "Yes") {
                                    echo "checked";
                                } ?> type="radio" name="active" value="Yes">Yes

                        <input <?php if ($active == "No") {
                                    echo "checked";
                                } ?> type="radio" name="active" value="No">No
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                        <input type="hidden" name="Id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Category" class="btn-secondary">
                    </td>

                </tr>
            </table>
        </form>
        <?php
        if (isset($_POST['submit'])) {
            //echo "Clicked";
            //get all the values from our form

            $id = $_POST['Id'];
            $title = $_POST['Title'];
            $current_image = $_POST['image_name'];
            $featured = $_POST['Featured'];
            $active = $_POST['active'];

            //work on updtaing new image if selected
            //check whether image is selected or not
            if (isset($_FILES['image']['name'])) {
                //get the image Details
                $image_name = $_FILES['image']['name'];

                //check whether the image is available or not
                if ($image_name != "") {
                    //image available
                    //upload the new image

                    //Auto rename our image
                    $tmp = explode('.', $image_name); //gets the extension of the image
                    $ext = end($tmp);
                   //this will be renamed image
                    //rename the image
                    $image_name = "Food_Category".rand(000, 999).'.'.$ext;

                    $source_path = $_FILES['image']['tmp_name'];

                    $destination_path = "../images/category/" . $image_name;

                    //finally upload the image
                    $upload = move_uploaded_file($source_path, $destination_path);
                    //check whether the image is uploaded or not
                    //And if the image is not uploaded then we will stop the process and redirect with error message

                    if ($upload == false) {
                        //set message
                        $_SESSION['upload'] = "<div class='error'> Failed to Upload Image.</div>";

                        //redirect to add category page
                        header('location:' . SITEURL . 'admin/manage-category.php');
                        //stop the process
                        die();
                    }
                    //Remove the current image if available
                    if ($current_image = "") {
                        $remove_path = "../images/category/".$current_image;

                        $remove = unlink($remove_path);

                        //check whether the image is removed or not
                        //if failed to remove then display message and stop the process

                        if ($remove == false) {
                            //failed to remove image
                            $_SESSION['failed-remove'] = "<div class='error'>Failed to Remove Current Image.</div>";
                            header('location:' . SITEURL . 'admin/manage-category.php');
                            die(); //stop the process
                        }
                    }
                } else {
                    $image_name = $current_image;
                }
            } else {
                $image_name = $current_image;
            }

            //update the database
            $sql2 = "UPDATE tbl_category SET
            
                Title='$title',
                image_name='$image_name',
                Featured='$featured',
                active='$active'
                WHERE Id=$id
            ";
            //execute the query
            $res2 = mysqli_query($conn, $sql2);

            //redirect to manage category with message
            //check whether query executed or not
            if ($res2 == true) {
                //category updated
                $_SESSION['update'] = "<div class='success'>Category Updated Successfully.</div>";
                header('location:' . SITEURL . 'admin/manage-category.php');
            } else {
                //failed to update category
                $_SESSION['update'] = "<div class='error'>Failed to Update Category.</div>";
                header('location:' . SITEURL . 'admin/manage-category.php');
            }
        }


        ?>
    </div>
</div>
<?php include('partials/footer.php') ?>