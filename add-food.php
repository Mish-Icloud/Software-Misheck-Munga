<?php include('partials/menu.php'); ?>
<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1>

        <br> <br>

        <?php
        if(isset($_SESSION['upload']))
        {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }
        ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="Title" placeholder="Title of the food">
                    </td>
                </tr>
                <tr>
                    <td>Description: </td>
                    <td>
                        <textarea name="Description" cols="30" rows="5" placeholder="Food description"></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Price: </td>
                    <td>
                        <input type="number" name="Price">
                    </td>
                </tr>
                <tr>
                    <td>Select Image:</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td>Category: </td>
                    <td>
                        <select name="category_id">

                            <?php
                            //create php code to display categories from database

                            //1. create sql query to get all active categories from database
                            $sql = "SELECT * FROM tbl_category WHERE active='Yes'";

                            //executing query
                            $res = mysqli_query($conn, $sql);
                            //count rows to check whether we have categories or not
                            $count = mysqli_num_rows($res);

                            //if count is greater than 0, we have categories else we do not have categories
                            if ($count > 0) {
                                //we have categories
                                while ($row = mysqli_fetch_assoc($res)) {
                                    //get the details of categories
                                    $id = $row['Id'];
                                    $title = $row['Title'];
                            ?>

                                    <option value="<?php echo $id; ?>"><?php echo $title; ?></option>


                                <?php
                                }
                            } else {
                                //we do not have categories
                                ?>
                                <option value="0">No Category Found</option>

                            <?php
                            }

                            //2. display on dropdown


                            ?>
                        </select>

                    </td>
                </tr>
                <tr>
                    <td>Featured: </td>
                    <td>
                        <input type="radio" name="Featured" value="Yes">Yes
                        <input type="radio" name="Featured" value="No">No
                    </td>
                </tr>
                <tr>
                    <td>Active: </td>
                    <td>
                        <input type="radio" name="active" value="Yes">Yes
                        <input type="radio" name="active" value="No">No
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Food" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

        <?php 
        //check whether the button is clicked or not
        if(isset($_POST['submit']))
        {
            //add the food in database
           // echo "Food button is clicked";

           //1. get the data from form 
           $title=$_POST['Title'];
           $description=$_POST['Description'];
           $price=$_POST['Price'];
           $category=$_POST['category_id'];

           //check whether radio button for featured and active are checked or not
           if(isset($_POST['Featured']))
           {
            $featured=$_POST['Featured'];

           }
           else
           {
            $featured="No";//setting default value 
           }
            if(isset($_POST['active']))
            {
                $active=$_POST['active'];
            }
            else
            {
                $active="No";//setting default value
            }
           //2.  upload the image of selected
           // check whether the selcet image is clicked or not and upload the image only if the image is selected
           if(isset($_FILES['image']['name']))
           {
            //get the details of the selected image
            $image_name=$_FILES['image']['name'];

            //check whether the image is selected or not and upload image only if seleceted
            if($image_name!="")
            {
                //image is selected
                //a. rename the image
                //get the extension of selected image(jpg, png, gif etc.,)
                $ext =end(explode('.', $image_name));
                //$image_info = explode (".", $image_name);

                //create new name for image
                $image_name="Food-Name-".rand(0000,9999).".".$ext; //New Image Name may be "Food-Name-785.jpg"

                //b. Upload the image
                //get the source path and destination path

                //source path is the current location of the image
                $src=$_FILES['image']['tmp_name'];

                //destination pathfor the image to be uploaded
                $dst="../images/food/".$image_name;

                //finally upload the food image
                $upload=move_uploaded_file($src,$dst);

                //check whether image uploaded or not
                if($upload==false)
                {
                    //failed to upload the image
                    
                    $_SESSION['upload']= "<div class='error'>Failed to Upload Image.</div>";
                    //redirect to add food page with error message
                    header('location:'.SITEURL.'admin/add-food.php');
                    //stop the process
                    die();
                }
            }
           }
           else
           {
                $image_name=""; //setting default value as blank
           }

           //3. insert the data into database

           //create an sql query to save or add food 
           //for numerical we do not need to pass value inside quotes '' but for string value it is compulsory to add quotes ''

           $sql2="INSERT INTO tbl_food SET
                Title='$title',
                Description='$description',
                Price=$price,
                image_name='$image_name',
                category_id=$category,
                Featured='$featured',
                active='$active'
           ";

           //execute the query
           $res2=mysqli_query($conn,$sql2);
           //check whether data inserted or not

           //4. redirect with message to manage-food page 
           if($res2==true)
           {
            //data inserted successfully
            $_SESSION['add']="<div class='success'>Food Added Successfully.</div>";
            header('location:'.SITEURL.'admin/manage-food.php');
           }
           else
           {
            //failed to insert data
            $_SESSION['add']="<div class='error'>Failed to Add Food.</div>";
            header('location:'.SITEURL.'admin/manage-food.php');
           }

           
        }
        ?>

    </div>
</div>


<?php include('partials/footer.php'); 
