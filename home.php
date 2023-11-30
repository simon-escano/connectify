<?php 
    session_start();
	if (empty($_SESSION["user_id"])) {
		header("Location: index.php");
		exit();
	}
	include("backend/shared.php");
    include("backend/main.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Connectify - Home</title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="styles/root.css">
	<link rel="stylesheet" href="styles/general.css">
	<link rel="stylesheet" href="styles/header.css">
	<link rel="stylesheet" href="styles/posts.css">
</head>
<body>
	<header>
		<section id="left">
			<img id="logo" src="">
			<p>Connectify</p>
		</section>
		<section id="middle">
			<form action="">
				<input type="text" placeholder="Search Connectify">
				<input type="submit" value="Search">
			</form>
		</section>
		<section id="right">
			<form id="createpost-form" action="home.php" method="POST">
				<input type="submit" name="create_post_btn" value="+">
			</form>
			<?php 
				if (isset($_POST["create_post_btn"])) {
					echo '
					<div id="createpost-box">
						<p>Create a post</p>
						<form action="home.php" method="GET">
							<input type="text" name="title" id="createpost-title" placeholder="Title">
							<textarea type="text" name="body" id="createpost-body" placeholder="Say something..."></textarea>
							<input type="submit" name="create_post" value="Post as '. $currentUser["username"] .'">
						</form>
					</div>
					';
				}
				if (isset($_POST["create_post"])) {
					if (!empty($_POST["createpost-title"]) && !empty($_POST["createpost-body"])) {
						createPost($_POST["createpost-title"], $_POST["createpost-body"]);
					}
				}
			?>
			<form id="logout-form" action="home.php" method="POST">
				<?php
					echo '<p id="username">'. $currentUser["username"] .'</p>';
				?>
				<input type="submit" name="logout_btn" value="LOG OUT">
			</form>
			<?php
				if (isset($_POST["logout_btn"])) {
					session_destroy();
					header("Location: index.php");
					exit();
				}
			?>
		</section>
	</header>
	<main>
		<section id="posts">
			<?php echo generatePosts() ?>
		</section>
	</main>
</body>
</html>

<?php
	if (isset($_POST["delete_post"])) {
		deletePost($_POST["post_id"]);
	}
	
	if (isset($_POST["delete_comment"])) {
		deleteComment($_POST["comment_id"]);
	}
	
	if (isset($_POST["comment"])) {
		if (isset($_POST["comment_input"]) && $_POST["comment_input"] != "") {
			comment($_POST["post_id"], $_POST["comment_input"]);
		}
	}
?>