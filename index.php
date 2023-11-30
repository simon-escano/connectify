<?php 
    session_start();
	include("backend/shared.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Connectify - Log In</title>
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
                <h1>LOG IN</h1>
                <p>to Connectify!</p>
            </div>
            <?php
                if (isset($_POST["login"])) {
                    global $users;
                    $found = false;
                    if (isset($_POST["username"]) && isset($_POST["password"])) {
                        foreach ($users->content as $user) {
                            if ($user["username"] == $_POST["username"]) {
                                $found = true;
                                if ($user["password"] == $_POST["password"]) {
                                    $_SESSION["user_id"] = $user["id"];
                                    header("Location: home.php");
                                    exit();
                                } else {
                                    echo say("Wrong password for " . $_POST["username"], "error");
                                }
                                break;
                            }
                        }
                        if (!$found) {
                            echo say("User " . $_POST["username"] . " doesn't exist", "error");
                        }
                    }
                }
            ?>
            <form action="index.php" method="POST">
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="submit" name="login" value="Log In">
            </form>
            <p id="redirect-account">Don't have an account yet? <a href="signup.php">Create one</a></p>
        </div>
	</main>
</body>
</html>