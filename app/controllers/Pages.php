<?php
  class Pages extends Controller {
    public function __construct() {
      if (isLoggedIn()) {
        redirect("posts");
      }
    }

    public function index() {
      $data = [
        "title"=> "PostR",
        "description" => "Simple Social Network where users can share and see other users posts"
      ];
      $this->load_view("pages/index", $data);
    }

    public function about() {
      $data = [
        "title"=> "About PostR",
        "description" => "App for users to share and view posts built on <strong>Nonso's RivrbankMVC PHP
        framework</strong> with so much love <i class='fa fa-heart'></i>."
      ];
      $this->load_view("pages/about", $data);
    }
  }
?>
