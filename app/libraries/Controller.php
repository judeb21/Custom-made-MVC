<?php
  /*
  * Base Controller
  * To load models and views
  */

  class Controller {

    // method to load models
    public function load_model($model) {
      require_once "../app/models/$model.php";

      // instantiate the model
      return new $model();
    }

    // method to load views
    public function load_view($view, $data=[]) {
      if (file_exists("../app/views/$view.php")) {
        require_once "../app/views/$view.php";
      } else {
        die("View does not exist!");
      }
    }
  }
?>
