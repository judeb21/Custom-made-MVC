<?php 
	session_start();

	// Function to display flash messages to user
	// stores the messages in a $_SESSION variable
	// and is written in a way that it can be called
	// with different forms of argument

	function flash ($name="", $message="", $class='alert alert-success') {
		if (!empty($name)) {
			// We want to set the $message to $_SESSION[$name]
			// Basically if there's a message and it's not already stored
			// We want to store it and the $class too in the $_SESSION
			if (!empty($message) && empty($_SESSION[$name])) {
				// Let's check if there's already sth stored in the 
				// $_SESSION variable

				if (!empty($_SESSION[$name. "_class"])) {
					unset($_SESSION[$name. "_class"]);
				}

				// Set the variables
				$_SESSION[$name] = $message;
				$_SESSION[$name. "_class"] = $class;
			} elseif (empty($message) && !empty($_SESSION[$name])) {
				// This is to support another form of function call
				// if there's a message in the $_SESSION[$name] and 
				// the param $message is not passed a value, we want to 
				// display the flash message

				$class = !(empty($_SESSION[$name."_class"])) ? $_SESSION[$name. "_class"] : '';

				echo "<div class='".$class. " alert-dismissible fade show' id=\"msg-flash\">
					<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>".
					 $_SESSION[$name].	"</div>";

				// unset all the $_SESSION variables

				unset($_SESSION[$name]);
				unset($_SESSION[$name. "_class"]);
			}
		}
	}

	function isLoggedIn() {
		if (isset($_SESSION["user_id"])) {
			return true;
		} else {
			return false;
		}
	}
 ?>