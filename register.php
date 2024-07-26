<?php
require_once "config.php";

        if (isset($_POST["register"])) {
            $first_name = $_POST["first_name"];
            $last_name = $_POST["last_name"];
            $username = $_POST["username"];
           $email = $_POST["email"];
           $mobile_num = $_POST["mobile_num"];
           $password = $_POST["password"];
           
           $passwordHash = password_hash($password, PASSWORD_DEFAULT);

           $errors = array();
           
           if (empty($first_name) OR empty($last_name) OR empty($username) OR empty($email) OR empty($mobile_num) OR empty($password)) {
            array_push($errors,"All fields are required");
           }
           if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            array_push($errors, "Email is not valid");
           }
           if (strlen($password)<8) {
            array_push($errors,"Password must be at least 8 charactes long");
           }
           
          
           $sql = "SELECT * FROM users WHERE email = '$email'";
           $result = mysqli_query($conn, $sql);
           $rowCount = mysqli_num_rows($result);
           if ($rowCount>0) {
            array_push($errors,"Email already exists!");
           }
           if (count($errors)>0) {
            foreach ($errors as  $error) {
                echo "<div class='alert alert-danger'>$error</div>";
            }
           }else{
            
            $sql = "INSERT INTO users (first_name, last_name, username, email, mobile_num, password) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_stmt_init($conn);
            $prepareStmt = mysqli_stmt_prepare($stmt,$sql);
            if ($prepareStmt) {
                mysqli_stmt_bind_param($stmt,"ssssss",$first_name, $last_name, $username, $email, $mobile_num, $passwordHash);
                mysqli_stmt_execute($stmt);
                header("Location: login.php");
                // echo "<div class='alert alert-success'>You are registered successfully.</div>";
            }else{
                die("Something went wrong");
            }
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
                        <input data-mdb-button-init data-mdb-ripple-init class="submit" type="submit" name="register" value="Register" />
                    </div>
                    <div class="two-col">
                        <div class="one">


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