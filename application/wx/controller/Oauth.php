<?php
namespace app\wx\controller;

use think\Controller;

class oauth extends Controller {
    public function index() {
        if (isset($_GET['code'])){
        echo $_GET['code'];
        } else{
            echo "NO CODE";
        }
    }
}
  


