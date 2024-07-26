

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
        <div class="container">
            <div class="welcome">
                <h1>welcome</h1>
                <p>You have successfully accessed your page after logging in.</p>
                <div class="button">
                  <a class="btn" id="logoutBtn" href="logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
