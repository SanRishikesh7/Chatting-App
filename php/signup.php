<?php
session_start();
include_once "config.php";
$fname = mysqli_real_escape_string($conn, $_POST["fname"]);
$lname = mysqli_real_escape_string($conn, $_POST["lname"]);
$email = mysqli_real_escape_string($conn, $_POST["email"]);
$password = mysqli_real_escape_string($conn, $_POST["password"]);

// checking all fileds
if (!empty($fname) && !empty($lname) && !empty($email) && !empty($password)) {
    // checking email
    if (filter_var($email, FILTER_VALIDATE_EMAIL)){
        $sql = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");
        if (mysqli_num_rows($sql) > 0) {
            echo "$email - This email already exist!";
        }else {
            if (isset($_FILES)) {
                $img_name = $_FILES["image"]["name"];
                $img_type = $_FILES["image"]["type"];
                $tmp_name = $_FILES["image"]["tmp_name"]; // img path

                $temp_arr = explode(".", $img_name);
                $img_ext = end($temp_arr);

                $types = ["image/jpeg", "image/jpg", "image/png"];
                $extensions = ["jpeg", "png", "jpg"];

                if ( in_array($img_type, $types) === true &&
                    in_array($img_ext, $extensions) === true
                ) {
                    $time = time();
                    $new_img_name = $time . $img_name;
                    if (
                        move_uploaded_file($tmp_name, "images/" . $new_img_name)
                    ){
                        $ran_id = rand(time(), 100000000);
                        $status = "Active now";
                        $encrypt_pass = md5($password);

                        $insertq = mysqli_query(
                            $conn,
                            "INSERT INTO `users` (unique_id, fname, lname, email, password, img, status) VALUES ('{$ran_id}', '{$fname}','{$lname}', '{$email}', '{$encrypt_pass}', '{$new_img_name}', '{$status}')"
                        ); 
                        if ($insertq){
                            $selectq = mysqli_query(
                                $conn,
                                "SELECT * FROM `users` WHERE `email` = '{$email}'"
                            );
                            if (mysqli_num_rows($selectq) > 0) {
                                $result = mysqli_fetch_assoc($selectq);
                                $_SESSION['unique_id'] = $result['unique_id'];
                                echo "success";
                            } else {
                                echo "email dose not exists";
                            }
                        } else {
                            echo "ERROR";
                        }
                    } else {
                        echo "Error - Something went Wrong";
                    }
                } else {
                    echo "Please upload an image file - jpeg, png, jpg";
                }
            } else {
                echo "Plese Select Image";
            }
        }
    } else {
        echo "$email is not a valid email!";
    }
} else {
    echo "All input fields are required!";
}
?>
