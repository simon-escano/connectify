<?php 
    session_start();
    include("backend/shared.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Connectify - Sign Up</title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="styles/root.css">
	<link rel="stylesheet" href="styles/general.css">
	<link rel="stylesheet" href="styles/header.css">
	<link rel="stylesheet" href="styles/login.css">
</head>
<body>
	<header>
		<section id="left">
			<img id="logo" src="">
			<p>Connectify</p>
		</section>
	</header>
	<main>
		<div id="login-box">
            <div>
                <h1>SIGN UP</h1>
                <p>to join Connectify!</p>
            </div>
            <?php
                if (isset($_POST["signup"])) {
                    global $users;
                    $found = false;
                    if (isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["confirm_password"])) {
                        foreach ($users->content as $user) {
                            if ($user["username"] == $_POST["username"]) {
                                $found = true;
                                break;
                            }
                        }
                        if (!$found) {
                            if ($_POST["password"] != $_POST["confirm_password"]) {
                                echo say("Passwords don't match", "error");
                            } else {
                                createUser($_POST["username"], $_POST["password"]);
                                header("Location: index.php");
                                exit();
                            }
                        } else {
                            echo say("User " . $_POST["username"] . " already exists", "error");
                        }
                    }
                }
            ?>
            <form action="signup.php" method="POST">
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="password" name="confirm_password" placeholder="Confirm password" required>
                <input type="submit" name="signup" value="Sign Up">
            </form>
            <p id="redirect-account">Already have an account? <a href="index.php">Log in</a></p>
        </div>
	</main>
</body>
</html>