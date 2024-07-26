<?php
require_once "config.php";

$first_name = $last_name = $username = $mobile_num = $password = $email = "";
$first_name_err = $last_name_err = $username_err = $mobile_num_err = $password_err = $email_err = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Validate first name
    if (empty(trim($_POST['first_name']))) {
        $first_name_err = "First Name cannot be blank";
    } elseif (!preg_match("/^[A-Za-z ]+$/", $_POST['first_name'])) {
        $first_name_err = "Invalid first name. Please enter letters without digits or special symbols.";
    } else {
        $sql = "SELECT id FROM users WHERE first_name = ?";
        if ($stmt = mysqli_prepare($conn, $sql)) {
            $param_firstname = trim($_POST['first_name']);
            mysqli_stmt_bind_param($stmt, "s", $param_firstname);

            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $first_name_err = "This first name is already taken";
                } else {
                    $first_name = $param_firstname;
                }
            } else {
                echo "Something went wrong while checking the first name.";
            }
            mysqli_stmt_close($stmt);
        }
    }

    // Validate last name
    if (empty(trim($_POST['last_name']))) {
        $last_name_err = "Last Name cannot be blank";
    } elseif (!preg_match("/^[A-Za-z ]+$/", $_POST['last_name'])) {
        $last_name_err = "Invalid last name. Please enter letters without digits or special symbols.";
    } else {
        $sql = "SELECT id FROM users WHERE last_name = ?";
        if ($stmt = mysqli_prepare($conn, $sql)) {
            $param_lastname = trim($_POST['last_name']);
            mysqli_stmt_bind_param($stmt, "s", $param_lastname);

            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $last_name_err = "This last name is already taken";
                } else {
                    $last_name = $param_lastname;
                }
            } else {
                echo "Something went wrong while checking the last name.";
            }
            mysqli_stmt_close($stmt);
        }
    }

    // Validate username
    if (empty(trim($_POST['username']))) {
        $username_err = "Username cannot be blank";
    } elseif (!preg_match("/^[a-z0-9_]+$/", $_POST['username'])) {
        $username_err = "Invalid username. Use lowercase letters and numbers without special characters.";
    } else {
        $sql = "SELECT id FROM users WHERE username = ?";
        if ($stmt = mysqli_prepare($conn, $sql)) {
            $param_username = trim($_POST['username']);
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $username_err = "This username is already taken";
                } else {
                    $username = $param_username;
                }
            } else {
                echo "Something went wrong while checking the username.";
            }
            mysqli_stmt_close($stmt);
        }
    }

    // Validate password
    if (empty(trim($_POST['password']))) {
        $password_err = "password cannot be blank";
    } elseif (strlen(trim($_POST['password'])) < 5) {
        $password_err = "password must be at least 5 characters long";
    } else {
        $password = trim($_POST['password']);
    }

    // Validate email
    if (empty(trim($_POST['email']))) {
        $email_err = "Email cannot be blank";
    } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $email_err = "Invalid email format.";
    } else {
        $email = trim($_POST['email']);
    }

    // Validate mobile number
    if (empty(trim($_POST['mobile_num']))) {
        $mobile_num_err = "Mobile number cannot be blank";
    } elseif (!preg_match("/^[0-9]{10}$/", trim($_POST['mobile_num']))) {
        $mobile_num_err = "Invalid mobile number. Enter 10 digits.";
    } else {
        $mobile_num = trim($_POST['mobile_num']);
    }
    if(isset($_POST['register'])) {

    // if there were no error, go ahead and insert into the database
    if (empty($first_name_err) && empty($last_name_err) && empty($username_err) && empty($email_err) && empty($mobile_num_err) && empty($passwoed_err)) {
        

        $sql = "INSERT INTO users (first_name, last_name, username, email, mobile_num, password) VALUES (?, ?, ?, ?, ?, ?)";
      
       
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt === false) {
            // Handle preparation failure, output error or log it
            echo "Error preparing SQL statement: " . mysqli_error($conn);
        } else {
            mysqli_stmt_bind_param($stmt, "ssssss", $param_firstname, $param_lastname, $param_username, $param_email, $param_mobile_num, $param_password);

            //set these parameters
            $param_firstname = $first_name;
            $param_lastname = $last_name;
            $param_username = $username;
            $param_email = $email;
            $param_mobile_num = $mobile_num;
            $param_password = password_hash($password, PASSWORD_DEFAULT);
            crypt($param_password, $salt);
          
            // echo"welcome .$param_password";

            
            //try to execute the query
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            // Check for SQL errors
            if (mysqli_stmt_execute($stmt)) {
                header("Location: login.php");
            } else {
                echo "something went wrong... cannot redirect !" . mysqli_stmt_error($stmt);
            }
            mysqli_stmt_close($stmt);
        }
    }
    mysqli_close($conn);
}
}

?>

<!--  -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

</head>

<body>

    <div class="wrapper">
        <nav class="nav">
            <div class="nav-logo">
                <p>LOGO.</p>
            </div>

            <div class="nav-menu" id="navMenu">
                <ul>
                    <li><a href="#" class="link active">Home</a></li>
                    <li><a href="#" class="link">About</a></li>
                    <li><a href="#" class="link">Services</a></li>
                    <li><a href="#" class="link">Blog</a></li>
                </ul>
            </div>

            <div class="nav-button">
                <a class="btn white-btn" id="loginBtn" href="login.php">Sing In</a>
                <a class="btn" id="registerBtn" href="register.php">Sing up</a>
            </div>
        </nav>

        <div class="form-box">


        
            <!-- registration-form -->
            <div class="register">
                <div class="top">
                    <span>Have an account? <a href="login.php">Login</a></span>
                    <header>Sing up</header>
                </div>


                <form action="register.php" method="POST">

                    <div class="two-forms">
                        
                        <div data-mdb-input-init class="input-box">
                            <input type="text" id="firstName" class="input-field" placeholder="Firstname" name="first_name" value="<?php if (isset($first_name_err)) {
                                                                                                                                        echo $first_name;
                                                                                                                                    } ?>" />
                            <i class="bx bx-user"></i>
                        </div>
                        
                        <div data-mdb-input-init class="input-box">
                            <input type="text" id="lastName" class="input-field" placeholder="Lastname" name="last_name" value="<?php if (isset($last_name_err)) {
                                                                                                                                    echo $last_name;
                                                                                                                                } ?>" />
                            <i class="bx bx-user"></i>
                        </div>

                    </div>

                    <div data-mdb-input-init class="input-box">
                        <input type="text" id="username" class="input-field" placeholder="username" name="username" value="<?php if (isset($username_err)) {
                                                                                                                                echo $username;
                                                                                                                            } ?>" />
                        <i class="bx bx-user"></i>
                    </div>

                    <div data-mdb-input-init class="input-box">
                        <input type="email" id="emailAddress" class="input-field" placeholder="Email" name="email" value="<?php if (isset($email_err)) {
                                                                                                                                echo $email;
                                                                                                                            } ?>" />
                        <i class="bx bx-envelope"></i>
                    </div>


                    <div data-mdb-input-init class="input-box">
                        <input type="tel" id="number" class="input-field" placeholder="number" name="mobile_num" value="<?php if (isset($mobile_num_err)) {
                                                                                                                            echo $mobile_num;
                                                                                                                        } ?>" />
                        <i class="bx bx-phone-call"></i>

                    </div>

                    <div data-mdb-input-init class="input-box">
                        <input type="password" id="passeord" class="input-field" placeholder="Passwoed" name="password" />
                        <i class="bx bx-lock-alt"></i>
                    </div>

                    <div class="input-box">
                        <input data-mdb-button-init data-mdb-ripple-init class="submit"  type="submit" name="register" value="Register" />
                    </div>
                    <div class="two-col">
                        <div class="one">
                            
                        <?php
                        // Initialize as array to avoid undefined variable issues
                        $first_name_err = isset($first_name_err) ? (array) $first_name_err : [];

                        if (!empty($first_name_err) && is_array($first_name_err)) {
                            foreach ($first_name_err as $error) {
                                echo '<p class="meg">'.$error.'</p>';
                            }
                        } else {
                            echo "Error: \$first_name_err must be an array.";
                        }
                        ?>
                        </div>
                        <div class="two">
                            <label for="#">Terms & conditions</label>
                        </div>
                    </div>

                </form>
            </div>

        </div>
    </div>
   
</body>

</html>