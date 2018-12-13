<?php
    
    error_reporting( ~E_NOTICE ); // avoid notice
    
    require_once 'dbconfig.php';
    
    if(isset($_POST['btnsave']))
    {
        $username = $_POST['user_name'];// user name
        $userdepartment = $_POST['department_name'];
         $userclock = $_POST['user_clock'];
         $userissue = $_POST['user_issue'];
        $userjob = $_POST['user_job'];// user email

        $imgFile = $_FILES['user_image']['name'];
        $tmp_dir = $_FILES['user_image']['tmp_name'];
        $imgSize = $_FILES['user_image']['size'];
        
        
        if(empty($username)){
            
            $errMSG = "Please Enter your full name.";
        }
        else if(empty($userdepartment)){
            $errMSG = "Please Enter department";
        }
   
        
         else if(empty($userjob)){
                            $errMSG = "Please Enter Your Job Work.";
                        }
           else if(empty($imgFile)){
                            $errMSG = "Please Select Image File.";
                        }
            else
                        {
                            $upload_dir = 'user_images/'; // upload directory
                            
                            $imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // get image extension
                            
                            // valid image extensions
                            $valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
                            
                            // rename uploading image
                            $userpic = rand(1000,1000000).".".$imgExt;
                            
                            // allow valid image file formats
                            if(in_array($imgExt, $valid_extensions)){
                                // Check file size '5MB'
                                if($imgSize < 5000000)                {
                                    move_uploaded_file($tmp_dir,$upload_dir.$userpic);
                                }
                                else{
                                    $errMSG = "Sorry, your file is too large.";
                                }
                            }
                            else{
                                $errMSG = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                            }
                        }
                        
                        
                        // if no error occured, continue ....
                        if(!isset($errMSG))
                        {
                            $stmt = $DB_con->prepare('INSERT INTO tbl_users(userName,userDepartment,userClock, userIssue, userProfession,userPic) VALUES(:uname,  :udepart, :uclock, :uissue, :ujob, :upic)');
                            $stmt->bindParam(':uname',$username);
                            $stmt->bindParam(':udepart',$userdepartment);
                            $stmt->bindParam(':uclock',$userclock);
                             $stmt->bindParam(':uissue',$userissue);
                             $stmt->bindParam(':ujob',$userjob);
                            $stmt->bindParam(':upic',$userpic);
                            
                            if($stmt->execute())
                            {
                                $successMSG = "Submitted successfully, thank you!";
                                //header("refresh:5;index.php"); // redirects image view page after 5 seconds.
                            }
                            else
                            {
                                $errMSG = "error while inserting....";
                            }
                        }
                    }
                    ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Upload, Insert, Update, Delete an Image using PHP MySQL - Coding Cage</title>

<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
<!-- Optional theme -->
<link rel="stylesheet" href="bootstrap/css/bootstrap-theme.min.css">

</head>
<body>
<?php
    if(isset($errMSG)){
        ?>
<div class="alert alert-danger">
<span class="glyphicon glyphicon-info-sign"></span> <strong><?php echo $errMSG; ?></strong>
</div>
<?php
    }
    else if(isset($successMSG)){
        ?>
<div class="alert alert-success">
<strong><span class="glyphicon glyphicon-info-sign"></span> <?php echo $successMSG; ?></strong>
</div>
<?php
    }
    ?>
<div id="wrapper">
<form method="post" enctype="multipart/form-data" class="form-horizontal">

<input class="form-control" type="text" name="user_name" placeholder="Full Name" value="<?php echo $username; ?>" />

<select class="form-control" name="department_name" >
<option value="department">Department</option>
<option value="Front Facia">Front Facia</option>
<option value="Rear Facia">Rear Facia</option>
<option value="Boinding">Boinding</option>
<option value="LiftGate">LiftGate</option>
<option value="Molding">Molding</option>
</select>

<input class="form-control" type="text" name="user_clock" placeholder="Clock NUmber" value="<?php echo $userclock; ?>" />
<textarea class="form-control"  name="user_issue" placeholder="What's the issue.." value="<?php echo $userissue ?>" ></textarea><br>
<textarea class="form-control"  name="user_job" placeholder="What's the changes.." value="<?php echo $userjob; ?>" ></textarea><br>
<input type="file" multiple class="choose" name="user_image" accept="image/*" >
<br>
<button type="submit" name="btnsave" class="button" value="Submit">Submit

</button>


</form>

</div>

<style>
.choose::-webkit-file-upload-button {
color: white;
display: inline-block;
background: #1CB6E0;
border: none;
padding: 7px 15px;
    font-weight: 700;
    border-radius: 3px;
    white-space: nowrap;
cursor: pointer;
    font-size: 10pt;
}

#wrapper {
width:400px;
margin:100px auto;
padding:20px;

box-shadow: inset 0 1px 2px rgba(255, 255, 255, 0.3), 0 0 5px rgba(0, 0, 0, .3);

}

.button {
    background-color: #1CB6E0; /* skyblue */
border: none;
padding: 1em;
    border-radius: 2px;
color: white;
width: 100%;
    text-align: center;
    text-decoration: none;
display: inline-block;
    font-size: 12px;
    -webkit-appearance: none;
cursor: pointer;
    -webkit-transition-duration: 0.4s; /* Safari */
    transition-duration: 0.4s;
}



input[type=submit] {
    background-color: #008f00; /* Green */
border: none;
    border-radius: 2px;
color: white;
width: 100%;
height:auto;
    text-align: center;
    text-decoration: none;
display: inline-block;
    font-size: 12px;
    -webkit-appearance: none;
cursor: pointer;
    -webkit-transition-duration: 0.4s; /* Safari */
    transition-duration: 0.4s;
}


input[type=text] {
    background-color: #eeeded;
width: 100%;
padding: 10px 15px;
margin: 8px 0;
    box-sizing: border-box;
border: 2px solid #E7E7E7;
    border-radius: 4px;
}


</style>




</body>
</html>
