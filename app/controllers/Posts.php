<?php 
	/**
	*  Posts Controller
	*/
	class Posts extends Controller
	{
		
		public function __construct()
		{
			// for access control. To make sure 
			// users that are not logged in cannot see the 
			// post page

			if (!isLoggedIn()) {
				redirect("users/login");
			}

			// Post model to feed data from database
			$this->postModel = $this->load_model("Post");
			// load User model to get User Id from database
			$this->userModel = $this->load_model("User");
		}

		public function index() {
			$result = $this->postModel->getPosts();

			$data = [
				"posts" => $result
			];
			$this->load_view("posts/index", $data);
		}

		public function add() {
			if ($_SERVER["REQUEST_METHOD"] == "POST") {
				// process form
				// Sanitize Inputs
				$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

				$data = [
					"title" => trim($_POST["title"]),
					"body" => trim($_POST["body"]),
					"title_err" => "",
					"body_err" => "",
					"user_id" => $_SESSION["user_id"]
				];

				// Validate $data
				if (empty($data["title"])) {
					$data["title_err"] = "Please Enter Post Title";
				}
				if (empty($data["body"])) {
					$data["body_err"] = "Please Enter Post Body Text";
				}

				// To confirm all data
				if (empty($data["title_err"]) && empty($data["body_err"])) {
					// Insert Post in database 
					if ($this->postModel->addPost($data)) {
						flash("post_message", "Post Added Successfully");
						redirect("posts");
					} else {
						die("Something went wrong. We've notified our engineers!");
					}
				} else {
					// load view with the errors
					$this->load_view("posts/add", $data);
				}
			} else {
				// show or load form
				$data = [
					"title" => "",
					"body" => "",
					"title_err" => "",
					"body_err" => "",
					"user_id" => $_SESSION["user_id"]
				];
				$this->load_view("posts/add", $data);
			}
			
		}

		public function edit($id) {
			if ($_SERVER["REQUEST_METHOD"] == "POST") {
				// process form
				$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

				$data = [
					"id" => $id,
					"title" => trim($_POST["title"]),
					"body" => trim($_POST["body"]),
					"title_err" => "",
					"body_err" => ""
				];

				if (empty($data["title"])) {
					$data["title_err"] = "Please Enter a title";
				}
				if (empty($data["body"])) {
					$data["body_err"] = "Please Enter the body of the post";
				}

				if (empty($data["title_err"]) && empty($data["body_err"])) {
					// No errors? Then connect to Post model and update data
					if ($this->postModel->updatePost($data)) {
						flash("post_message", "Post Updated");
						redirect("posts");
					} else {
						die("We're Sorry, Something went wrong. We've notified our engineers.");
					}
				}
			} else {
				// check if the post user wants to edit is user's own
				$post = $this->postModel->getPostById($id);
				if ($post->user_id != $_SESSION["user_id"]) {
					redirect("posts");
				}

				$data = [
					"id" => $post->id,
					"title" => $post->title,
					"body" => $post->body,
					"body_err" => "",
					"title_err" => ""
				];
				$this->load_view("posts/edit", $data);
			}
		}

		public function delete($id) {
			if (isset($_SESSION["user_id"])) {
				$post = $this->postModel->getPostById($id);
				// To check user
				if ($post->user_id != $_SESSION["user_id"]) {
					redirect("posts");
				}

				if ($this->postModel->deletePost($id)) {
					flash("post_message", "Post Removed");
					redirect("posts");
				} else {
					die("Something went Wrong. We've notified our engineers.");
				}
			}
		}

		// public function hasLiked($user_id, $post_id) {
		// 	$posts = $this->postModel->getUsersWhoLike($post_id);
		// 	$user_ids_who_like = $posts->users_who_like; // return long string
		// 	$user_ids_who_like = explode(" ", $user_ids_who_like);

		// 	if (!empty($user_ids_who_like)) {
		// 		foreach ($id as $user_ids_who_like) {
		// 			$id = intval($id);
		// 		}

		// 		if (in_array($_SESSION["user_id"], $user_ids_who_like)){
		// 			return $user_ids_who_like;
		// 		} 
		// 		else{
		// 			return false;
		// 		} 
		// 	} else {
		// 		return false;
		// 	}	

		// }

		// public function like($id) {
		// 	// We have to make sure logged in user cannot like more than once
		// 	$user_id = $_SESSION["user_id"];
		// 	$user_ids_wl = $this->hasLiked($user_id, $id);
		// 	if ($user_ids_wl) {
		// 		//$this->unlike($id);
				
		// 	} else {
		// 		$user_ids_wl = array_push($user_ids_wl, $user_id);
		// 		$user_ids_wl = implode(" ", $user_ids_wl);

		// 		$data = [
		// 		$post_id => $id,
		// 		$user_ids_wl => $user_ids_wl
		// 		];

		// 		if ($this->postModel->likePost($data)) {
		// 			redirect("posts");
		// 		} else {
		// 			die("Something went horribly wrong. We've notified our engineers.");
		// 		}
		// 	}
		// }

		public function show($id) {
			$post = $this->postModel->getPostById($id);
			$user = $this->userModel->getUserById($post->user_id);

			$data = [
				"post" => $post,
				"user" => $user 
			];

			$this->load_view("posts/show", $data);
		}
	}
 ?>