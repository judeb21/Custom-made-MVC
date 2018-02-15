<?php
    /*
    * App Core Class
    * Creates URL & Loads core controller
    * URL FORMAT - /controller/method/params
    */
  class Core {
    protected $currentController = "Pages";
    protected $currentMethod = "index";
    protected $params = [];

    public function __construct() {
      //print_r($this->getUrl());

      $url = $this->getUrl();

      // look in controllers folder for first value of $url
      // array.
      // to get $currentController we'd pass a path like we're in
      // the index.php file in public folder since everything is
      // directed through there
      $control = ucfirst($url[0]);
      if (file_exists('../app/controllers/'. $control. '.php')) {
        // Set file to be $currentController
        $this->currentController = $control;
        
        // unset $url zero index
        unset($url[0]);
      }

      // require the $currentController
      require_once "../app/controllers/".$this->currentController.".php";

      // instantiate $currentController
      $this->currentController = new $this->currentController;

      // Let's do for the method. To get the $currentMethod

      if (isset($url[1])) {
        if (method_exists($this->currentController, $url[1])) {
          // set $currentMethod to it
          $this->currentMethod = $url[1];

          // unset $url[1]
          unset($url[1]);
        }
      }


      // for the params
      // if there's anything left in $url, we want to
      // create an array of what's left and make sure
      // the array starts at index 0 otherwise, set the
      // $this->params array to an empty array.

      $this->params = $url ? array_values($url) : [];

      // call back function that takes array as parameter
      // This is basically what invokes all this junk.

      call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
    }

    public function getUrl() {
      if (isset($_GET["url"])) {
        $url = rtrim($_GET["url"], "/");
        $url = filter_var($url, FILTER_SANITIZE_URL);
        $url = explode ("/", $url);
        return $url;
      }
    }

    
  } // end Core class
?>
