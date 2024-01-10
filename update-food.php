<?php include('partials/menu.php'); ?>

<?php

//check whether id is set or not
if (isset($_GET['Id'])) {
    //get all the details
    $id = $_GET['Id'];

    //sql query to get the selected food
    $sql2 = "SELECT * FROM tbl_food WHERE Id=$id";
    //execute the query
    $res2 = mysqli_query($conn, $sql2);

    //get the value based on query executed
    $row2 = mysqli_fetch_assoc($res2);


    //get the individual values of selected food
    $title = $row2['Title'];
    $description = $row2['Description'];
    $price = $row2['Price'];
    $current_image = $row2['image_name'];
    $current_category = $row2['category_id'];
    $featured = $row2['Featured'];
    $active = $row2['active'];
} else {
    //redirect to manage food
    header('location:' . SITEURL . 'admin/manage-food.php');
}
?>
<div class="main-content">
    <div class="wrapper">
        <h1>Update Food</h1>
        <br> <br>

        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-30">

                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="Title" value="<?php echo $title ?>">
                    </td>
                </tr>

                <tr>
                    <td>Description: </td>
                    <td>
                        <textarea name="Description" cols="30" rows="5"><?php echo $description ?></textarea>
                    </td>
                </tr>

                <tr>
                    <td>Price:</td>
                    <td>
                        <input type="number" name="Price" value="<?php echo $price; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Current Image: </td>
                    <td>
                        <?php

                        if ($current_image == "") {
                            //image not Available
                            echo "<div class='error'>Image Not Available.</div>";
                        } else {
                            //Image available
                        ?>

                            <img src="<?php echo SITEURL; ?>/images/food/<?php echo $current_image; ?>"width="100px">

                        <?php
                        }

                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Select New Image:</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                <tr>
                    <td>Category:</td>
                    <td>
                        <select name="category_id">
                            <?php
                            //query to get active categories
                            $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
                            //execute the query
                            $res = mysqli_query($conn, $sql);
                            //count rows
                            $count = mysqli_num_rows($res);

                            //check whether category available or not
                            if ($count > 0) {
                                //category available
                                while ($row = mysqli_fetch_assoc($res)) {

                                    $category_id = $row['Id'];
                                    $category_title = $row['Title'];
                            ?>

                                    <option <?php if ($current_category == $category_id) {
                                                echo "selected";
                                            } ?> value="<?php echo $category_id; ?>"> <?php echo $category_title; ?></option>
                            <?php
                                }
                            } else {
                                //category not available
                                echo "<option value='0'>Category Not Available</option>";
                            }

                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Featured:</td>
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
                        <input type="hidden" name="Id" value="<?php echo $id; ?>">
                        <input type="hidden" name="image_name" value="<?php echo $current_image; ?>">
                        <input type="submit" name="submit" value="Update Food" class="btn-secondary">
                    </td>
                </tr>

            </table>

        </form>
        <?php


        if (isset($_POST['submit'])) {
            // echo "Button Clicked";
            //1. Get all the details from the form
            $id = $_POST['Id'];

            $title = $_POST['Title'];

            $description=$_POST['Description'];

            $price = $_POST['Price'];

            $current_image = $_POST['image_name'];

            $category = $_POST['category_id'];

            $featured = $_POST['Featured'];
            $active = $_POST['active'];




            //2.upload the image if selected

            //check whether the upload is clicked or not
            if (isset($_FILES['image']['name'])) {
                //upload button clicked
                $image_name = $_FILES['image']['name']; //new image name

                //check whether the file is available or not
                if ($image_name != "") {
                    //image is available
                    //A. Uploading image
                    //rename the image
                    $tmp = explode('.', $image_name); //gets the extension of the image
                    $ext = end($tmp);
                    $image_name = "Food-Name" . rand(0000, 9999) . '.' . $ext; //this will be renamed image

                    //create the source path and destination path
                    $src_path = $_FILES['image']['tmp_name']; //source path
                    $dst_path = "../images/food/" . $image_name; //destination path

                    //upload the image
                    $upload = move_uploaded_file($src_path, $dst_path);

                    //check whether the image is uploaded or not
                    if ($upload == false) {
                        //failed to upload the image

                        $_SESSION['upload'] = "<div class='error'>Failed to Upload New Image.</div>";
                        //redirect to manage food page
                        header('location:' . SITEURL . 'admin/manage-food.php');
                        //stop the process
                        die();
                    }
                    //3. Remove the image if new image is upload and current image image exists
                    //B. Remove current image if available
                    if ($current_image != "") {
                        //current image is available
                        //Remove the image
                        $remove_path = "../images/food/" . $current_image;

                        $remove = unlink($remove_path);

                        //check whether the image is removed or not
                        if ($remove == false) {
                            //failed to remove current image
                            $_SESSION['remove-failed'] = "<div class='error'>Failed to  remove current image.</div>";

                            //redirect to manage food
                            header('location:' . SITEURL . 'admin/manage-food.php');
                            //stop the proccess
                            die();
                        }
                    }
                }
                else
                {
                    $image_name = $current_image;//default image when image is not selected
                }
            } 
            else 
            {
                $image_name = $current_image;//default image when button is not clicked
            }

            //4.Update the food in database
            $sql3 = "UPDATE tbl_food SET 
           
           Title='$title',
           Description='$description',
           Price=$price,
           image_name='$image_name',
           category_id='$category',
           Featured='$featured',
           active='$active'

           WHERE Id=$id
           
           ";

            //execute the sql query
            $res3 = mysqli_query($conn, $sql3);

            //check whether query is executed or not
            if ($res3 == true) {
                //query executed and food updated
                //redirect food to manage food with a session message
                $_SESSION['update'] = "<div class='success text-center'>Food Updated Successfully.</div>";
                header('location:'.SITEURL.'admin/manage-food.php');
            } else {
                //failed to update food
                $_SESSION['update'] = "<div class='error'>Failed to Update Food.</div>";
                header('location:' . SITEURL . 'admin/manage-food.php');
            }
        }

        ?>
    </div>
</div>

<?php include('partials/footer.php'); ?>