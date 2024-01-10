<?php include('partials/menu.php'); ?>
<div class="main-content">
    <div class="wrapper">
        <h1>Add Category</h1>

        <br> <br>
        <?php
        if (isset($_SESSION['add'])) {
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }

        if (isset($_SESSION['upload'])) {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }
        ?>
        <br> <br>
        <!--Add category form starts-->
        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="Title" placeholder="Category Title">
                    </td>
                </tr>
                <tr>
                    <td>Select Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>

                </tr>
                <tr>
                    <td>Featured: </td>
                    <td>
                        <input type="radio" name="Featured" value="Yes"> Yes
                        <input type="radio" name="Featured" value="No"> No
                    </td>
                </tr>
                <tr>
                    <td>Active: </td>
                    <td>
                        <input type="radio" name="active" value="Yes"> Yes
                        <input type="radio" name="active" value="No"> No
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add category" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>


        <!--Add category form ends-->

        <?php
        //check whether the submit button is clicked
        if (isset($_POST['submit'])) {
            //echo "Clicked";
            $id=$_POST['Id'];
            $title=$_POST['Title'];
            $image_name=$_POST['image_name'];
            $featured=$_POST['Featured'];
            $active=$_POST['active'];

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
            //check whether the image is seleceted or not and set the value for image name accordingly
            // print_r($_FILES['image']);
            //die(); //break the code here
            if (isset($_FILES['image'])) {
                //upload the image
                //to upload image we need image name, source path and destination path
                $image_name = $_FILES['image']['name'];

                //upload image only if image is selected
                if ($image_name != "") {


                    //Auto rename our image  
                    //get the extension of our image(jpg, png, git etc)e.g "food1.jpg"
                    $ext = end(explode('.', $image_name));
                    //rename the image
                    $image_name = "Food_Category_".rand(000, 999).'.'.$ext;

                    $source_path = $_FILES['image']['tmp_name'];

                    $destination_path = "../images/category/".$image_name;

                    //finally upload the image
                    $upload=move_uploaded_file($source_path, $destination_path);
                    //check whether the image is uploaded or not
                    //And if the image is not uploaded then we will stop the process and redirect with error message

                    if ($upload == false) {
                        //set message
                        $_SESSION['upload'] = "<div class='error'> Failed to Upload Image.</div>";

                        //redirect to add category page
                        header('location:'.SITEURL.'admin/add-category.php');
                        //stop the process
                        die();
                    }
                }
            } else {
                //dont upload image and the the image_name value as blank
                $image_name = "";
            }
            //create sql query to insert category into database
            $sql = "INSERT INTO tbl_category SET
            Title='$title',
            image_name='$image_name',
            Featured='$featured',
            active='$active'
            ";
            //execute the query and save in database
            $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));
            //check whether the query executed or not and data added or not
            if ($res == true) {
                //Query executed and category added
                $_SESSION['add'] = "<div class='success'>Category Added Successfully.</div>";
                //redirect to manage category page
                header('location:' . SITEURL . 'admin/manage-category.php');
            } else {
                //failed to add category
                $_SESSION['add'] = "<div class='error'>Failed to Add Category.</div>";
                //redirect to manage category page
                header('location:' . SITEURL . 'admin/add-category.php');
            }
        }

        ?>

    </div>
</div>
<?php include('partials/footer.php'); ?>