<?php

include("functions.php");


function createPost($title, $body) {
    global $posts, $currentUser;
    array_unshift($posts->content, new Post(count($posts->content) + 1, $currentUser, $title, $body));
	$posts->save();
}

function findPost($id) {
    global $posts;
    foreach($posts->content as $post) {
        if ($post["id"] == $id) {
            return $post;
        }
    }
    return null;
}

function generatePosts() {
    global $posts, $currentUser;
    if (!$currentUser) return;
    $html = "";
    foreach ($posts->content as $post) {
        $post = (array) $post;
        $html .= '
        <div class="post">
            <section class="post-info">
                <div>
                    <img src="'. $post["user"]["avatar"] .'">
                    <div>
                        <p class="post-user">'. $post["user"]["username"] .'</p>
                        <p class="post-date">'. formatDate($post["date"]) .'</p>
                    </div>
                </div>
                '. (($post["user"] == $currentUser) ? '
                    <form action="home.php" method="POST">
                        <input type="hidden" name="post_id" value="'. $post["id"] .'">
                        <input type="submit" name="delete_post" value="Delete">
                    </form>
                ' : null) .'
            </section>
            <section class="post-txt">
                <p class="post-title">'. $post["title"] .'</p>
                <p class="post-body">'. $post["body"] .'</p>
            </section>
            '. generateComments($post["id"]) .'
            <section class="comment-box">
                <form action="home.php" method="POST">
                    <input type="hidden" name="post_id" value="'. $post["id"] .'">
                    <input type="text" name="comment_input" placeholder="Say something about '. (($post["user"] == $currentUser) ? "your own" : ($post["user"]["username"] . "'s")) .' post...">
                    <input type="submit" name="comment" value="Comment">
                </form>
            </section>
        </div>
    ';

    }
    return $html;
}

function comment($id, $body) {
    global $comments, $currentUser;
    if (!$currentUser) return;
    array_unshift($comments->content, new Comment(count($comments->content) + 1, $id, $currentUser, $body));
    $comments->save();
}

function generateComments($id) {
    global $comments, $currentUser;
    if (!$currentUser) return;
    $html = "";
    $bool = false;
    foreach($comments->content as $comment) {
        $comment = (array) $comment;
        if ($comment["post_id"] == strval($id)) {
            $bool = true;
            $html .= '
            <div class="comment">
                <img src="'. $comment["user"]["avatar"] .'">
                <section>
                    <div class>
                        <p class="comment-user">'. $comment["user"]["username"] .'</p>
                        <p class="comment-date">'. formatDate($comment["date"]) .'</p>
                    </div>
                    <p class="comment-txt">'. $comment["body"].'</p>
                </section>
                '. (($comment["user"] == $currentUser) ? '
                    <form action="home.php" method="POST">
                        <input type="hidden" name="comment_id" value="'. $comment["id"] .'">
                        <input type="submit" name="delete_comment" value="Delete">
                    </form>
                ' : null) .'
            </div>
            ';
        } 
    }
    return (!$bool) ? "" : '<section class="comments-box">' . $html . '</section>';
}

function deletePost($id) {
    global $posts;
    for ($i = 0; $i < count($posts->content); $i++) {
        if ($posts->content[$i]["id"] == $id) {
            array_splice($posts->content, $i, 1);
            $posts->save();
        }
    }
}

function deleteComment($id) {
    global $comments;
    for ($i = 0; $i < count($comments->content); $i++) {
        if ($comments->content[$i]["id"] == $id) {
            array_splice($comments->content, $i, 1);
            $comments->save();
        }
    }
}

function formatDate($date) {
    $timeZone = new DateTimeZone('Asia/Manila');
    $dateTime = new DateTime($date, $timeZone);
    $currentTime = new DateTime("", $timeZone);
    $timeDifference = $currentTime->getTimestamp() - $dateTime->getTimestamp();
    if ($timeDifference >= 604800) {
        return $dateTime->format('F d \a\t g:i A');
    }
    $intervals = array(
        86400 => 'day',
        3600 => 'hour',
        60 => 'minute',
        1 => 'second'
    );
    foreach ($intervals as $seconds => $label) {
        $interval = floor($timeDifference / $seconds);
        if ($interval >= 1) {
            $suffix = ($interval > 1) ? 's' : '';
            return "$interval $label$suffix ago";
        }
    }
    return 'Just now';
}

?>