<?php
require_once "config.php"; // Include the database connection

$error = "";

if(isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = mysqli_query($conn, "select * from users where username = '$username'");
    if (mysqli_num_rows($query) > 0) {
        $result = mysqli_fetch_array($query);

        //echo $password ." ".$result['password'];
        //exit();
        if (password_verify($password, $result["password"])) {
            // Successful login
            $_SESSION["loggedin"] = true;
            $_SESSION["username"] = $username;
            $_SESSION["id"] = $row["id"];

            header("Location: welcome.php");
            exit(); // Stop further code execution
        } else {
            $error = "Invalid username or password";
        }
    } else {
        $error ="credentials not matched";
    }
}

// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     // Trim and sanitize the input
//     $username = trim($_POST["username"]);
//     $password = trim($_POST["password"]);
    
//     if (empty($username) || empty($password)) {
//         $error = "Please enter both username and password";
//     } else {
//         // Prepare the SQL statement to prevent SQL injection
//         $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
//         if ($stmt) {
//             $stmt->bind_param("s", $username); // Bind the username parameter
//             $stmt->execute(); // Execute the statement

//             // Get the result and check if a user with the given username exists
//             $result = $stmt->get_result();
//             if ($result->num_rows == 1) {
//                 $row = $result->fetch_assoc();

//                 // Verify the provided password against the hashed password in the database
//                 if (password_verify($password, $row["password"])) {
//                     // Successful login
//                     $_SESSION["loggedin"] = true;
//                     $_SESSION["username"] = $username;
//                     $_SESSION["id"] = $row["id"];

//                     header("Location: welcome.php");
//                     exit(); // Stop further code execution
//                 } else {
//                     $error = "Invalid username or password";
//                 }
//             } else {
//                 $error = "Invalid username or password";
//             }
//         } else {
//             $error = "Error preparing statement: " . mysqli_error($conn);
//         }

//         $stmt->close(); // Close the statement
//     }
// }

$conn->close(); // Close the connection
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



            <!-- login-form -->
            <div class="login-container" id="login">
                <div class="top">
                    <span>Don't have an account? <a href="register.php">Sing up</a></span>
                    <header>Login</header>
                </div>

                <form action="login.php" method="POST">

                    <div data-mdb-input-init class="input-box">
                        <input type="text" id="username" class="input-field" name="username" placeholder="username" required/>
                        <i class="bx bx-user"></i>
                    </div>

                    <div data-mdb-input-init class="input-box">
                        <input type="password" id="password" class="input-field" placeholder="Password" name="password" required/>
                        <i class="bx bx-lock-alt"></i>
                    </div>

                    <div class="input-box">
                        <input data-mdb-button-init data-mdb-ripple-init class="submit" name="submit" type="submit" value="Sing In" />
                    </div>

                    <div class="two-col">
                        <div class="one">
                            <?php if (!empty($error)) : ?>
                                <p><?php echo $error; ?></p>
                            <?php endif; ?>
                        </div>
                        <div class="two">
                            <label for="#">Forgot Password</label>
                        </div>
                    </div>
                </form>

            </div>

        </div>
    </div>

</body>

</html>