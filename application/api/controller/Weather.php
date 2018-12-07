<?php
namespace app\api\controller;

use think\Controller;

class Weather extends Controller {
    public function read() {
        $county_name = input('county_name');
        $model = model('Weather');
        $data = $model -> getNews($county_name);
        if ($data) {
            $code = 200; 
        } else {
            $code = 404; 
        }
        $data = [
            'code' => $code,
            'data' => $data
        ];
        return json($data);
    }
}
