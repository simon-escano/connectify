<?php

class FileJSON {
	public $directory;
	public $content;
	public function __construct($directory) {
		$this->directory = $directory;
		$this->content = json_decode(file_get_contents($directory), true);
	}
	public function save() {
		file_put_contents($this->directory, json_encode($this->content, JSON_PRETTY_PRINT));
	}
}

class User {
	public $id;
	public $username;
	public $password;
	public $followers;
	public $following;
	public $avatar;
	public function __construct($id, $username, $password, $followers, $following) {
		$this->id = $id;
		$this->username = $username;
		$this->password = $password;
		$this->followers = $followers;
		$this->following = $following;
		$this->avatar = "https://ui-avatars.com/api/?rounded=true&name=$username";
	}
}

class Post {
	public $id;
	public $user;
	public $title;
	public $body;
	public $date;
	public $likes = array();
	public function __construct($id, $user, $title, $body) {
		$this->id = $id;
		$this->user = $user;
		$this->title = $title;
		$this->body = $body;
		date_default_timezone_set('Asia/Manila');
		$this->date = date("Y-m-d H:i:s");
	}
}

class Comment {
	public $id;
	public $post_id;
	public $user;
	public $body;
	public $date;
	public $likes = array();
	public function __construct($id, $post_id, $user, $body) {
		$this->id = $id;
		$this->user = $user;
		$this->post_id = $post_id;
		$this->body = $body;
		date_default_timezone_set('Asia/Manila');
		$this->date = date("Y-m-d H:i:s");
	}
}

?>