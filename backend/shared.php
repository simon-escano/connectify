<?php

include("classes.php");

$users = new FileJSON("data/users.json");
$posts = new FileJSON("data/posts.json");
$comments = new FileJSON("data/comments.json");

if (isset($_SESSION["user_id"])) {
    $currentUser = findUser($_SESSION["user_id"]);
}

function findUser($id) {
	global $users;
    foreach($users->content as $user) {
        if ($user["id"] == $id) {
            return $user;
        }
    }
    return null;
}

function createUser($username, $password) {
    global $users;
    $userAlreadyExists = false;
    foreach($users->content as $user) {
        if ($user["username"] == $username) {
            $userAlreadyExists = true;
            break;
        }
    }
    if (!$userAlreadyExists) {
        array_unshift($users->content, new User(count($users->content) + 1, $username, $password, array(), array()));
        $users->save();
    }
}

function say($message, $type) {
    return '<p class="'. $type .'-msg">'. $message .'</p>';
}

?>