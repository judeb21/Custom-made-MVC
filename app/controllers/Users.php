<?php
  class Users extends Controller {
    public function __construct() {
      // instantiate User Model to gain access to 
      // the database to perform neccessary validations

      $this->userModel = $this->load_model("User");
    }

    public function register() {
      // depending on the url request method,
      // load form or submit form

      // check for POST
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //process form

        // Sanitize input 
        $_POST =  filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        // Init data 
        $data = [
          "name" => trim($_POST["name"]),
          "email" => trim($_POST["email"]) ,
          "password" => trim($_POST["password"]),
          "confirm_password" => trim($_POST["confirm_password"]),
          "name_err" => "",
          "email_err" => "",
          "password_err" => "",
          "confirm_password_err" => ""
        ];

        // Validate name
        if (empty($data["name"])) {
          $data["name_err"] = "Please Enter Your Name";
        }

        // Validate Email
        if (empty($data["email"])) {
          $data["email_err"] = "Please Enter Your Email";
        } else {
          // some more validation like if the email has been used and maybe regex
          if ($this->userModel->findUserByEmail($data["email"])) {
            $data["email_err"] = "Email Already Taken";
          }
        }

        // Validate Password
        if(empty($data["password"])) {
          $data["password_err"] = "Please Enter Password";
        } else {
          if (strlen($data["password"]) < 6) {
            $data["password_err"] = "Password Must Be At least 6 Characters Long";
          }
        }

        // Validate Confirm_passsword
        if (empty($data["confirm_password"])) {
          $data["confirm_password_err"] = "Please Confirm Password";
        } elseif ($data["password"] != $data["confirm_password"]) {
          $data["confirm_password_err"] = "Passwords Do Not Match";
        }

        // If all the Errors are empty
        // Registration Was Successful, Display Success page
        // Else load register view again with the error messages
        // in $data array filled and displayed appropriately
        if (empty($data["name_err"]) && empty($data["email_err"]) && empty($data["password_err"]) && empty($data["confirm_password_err"])) {
          // Hash The Password
          $data["password"] = password_hash($data["password"], PASSWORD_DEFAULT);

          if ($this->userModel->registerUser($data)) {
            // registration successful. Set flash message in $_SESSION 
            // Then Redirect to Login page

            flash("register_success", "You have successfully registered! You can now Login..");
            redirect("users/login");
          } else {
            die("Something Went Wrong. We've notified our engineers.");
          }
        } else {
          $this->load_view("users/register", $data);
        }
      } else {
        // load form

        // $data so if page re-renders probably as a result of
        // user input error, the already entered data remains
        $data = [
          "name" => "",
          "email" => "",
          "password" => "",
          "confirm_password" => "",
          "name_err" => "",
          "email_err" => "",
          "password_err" => "",
          "confirm_password_err" => ""
        ];

        $this->load_view("users/register", $data);
      }
    }

    public function login() {
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // process form  

        // Sanitize input 
        $_POST =  filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        // Init data 
        $data = [         
          "email" => trim($_POST["email"]) ,
          "password" => trim($_POST["password"]),         
          "email_err" => "",
          "password_err" => "",
        ];

        // Validate Email
        if (empty($data["email"])) {
          $data["email_err"] = "Please Enter Your Email";
        } else {
          // some more validation like if the email has been used and maybe regex
          if (!$this->userModel->findUserByEmail($data["email"])) {
            // User Email not Found in database
            $data["email_err"] = "Email not registered";
          }
        }

        // Validate Password
        if(empty($data["password"])) {
          $data["password_err"] = "Please Enter Your Password";
        } else {
          if (strlen($data["password"]) < 6) {
            $data["password_err"] = "Password Must Be At least 6 Characters Long";
          }
        }

        // If all the Errors are empty
        // Login Was Successful, Display User Account page
        // Else load login view again with the error messages
        // in $data array filled and displayed appropriately
        if (empty($data["email_err"]) && empty($data["password_err"])) {
          // variable we will retrieve the database values in and use to set
          // the user's $_SESSION

          $loggedIn = $this->userModel->loginUser($data["email"], $data["password"]);
          if ($loggedIn) {
            // Set the $_SESSION variables if user credentials check out
            $this->createUserSession($loggedIn);
            // redirect to User_Account or Post Page
            redirect("posts/index");
          } else {
            // Set the $data["password_err"] and load the view with the errors

            $data["password_err"] = "Password Incorrect!";
            $this->load_view("users/login", $data);
          }
        } else {
          $this->load_view("users/login", $data);
        }   
      } else {
        // load form

        $data = [
          "email" => "",
          "email_err" => "",
          "password" => "",
          "password_err" => ""
        ];                    

        $this->load_view("users/login", $data);       
      }
    }

    public function createUserSession($user) {
      // $user contains the returned row. It's an object
      $_SESSION["user_id"] = $user->id;
      $_SESSION["user_email"] = $user->email;
      $_SESSION["user_name"] = $user->name;
    }

    public function logout() {
      $_SESSION = array();
      session_destroy();
      redirect("users/login");
    }

  }

 ?>
