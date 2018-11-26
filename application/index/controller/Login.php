<?php
namespace app\index\controller;

use think\Controller;

class Login extends Controller {
    public function index() {
        return $this->fetch();
    }

    // 处理登录逻辑
    public function doLogin() {
        $param = input('post.');
        if (empty($param['user_name'])) {
            $this -> error("用户名不能为空");
        }

        if (empty($param['user_pwd'])) {
            $this -> error("密码不能为空");
        }
        $action = $_POST["mySubmit"];
        switch($action) {
            case "login":
                // 验证用户名
                $has = db('users') -> where('user_name', $param['user_name']) -> find();
                if (empty($has)) {
                    $this -> error("用户名密码错误");
                }

                // 验证密码
                if ($has['user_pwd'] != md5($param['user_pwd'])) {
                    $this -> error("用户名密码错误");
                }

                // 记录用户登录信息
                cookie('user_id', $has['id'], 3600);    //一个小时的有效期
                cookie('user_name', $has['user_name'], 3600);
 
                $this -> redirect(url('index/index'));
                break;
            case "register":
                $has = db('users') -> where('user_name', $param['user_name']) -> find();
                if (!empty($has)) {
                    $this -> error("该用户名已被注册");
                }
                $userName = $param['user_name'];
                $userPwd = md5($param['user_pwd']);
                $data = ['user_name' => $userName, 'user_pwd' => $userPwd];
                $result = db('users') -> insert($data);
                //$userName = $param['user_name'];
                //$userPwd = md5($param['user_pwd']);
                //$registerSQL = "insert into users(user_name, user_pwd) values ('".$userName."', '".$userPwd."');";
                //echo $registerSQL;
                //$result = mysql_query($registerSQL);
            
                if (!$result) {
                    $this -> error("注册失败"); 
                } else {
                    $this -> success("注册成功");
                }
                break;
        }
       
        
        
    }

    // 退出登录
    public function loginOut() {
        cookie('user_id', null);
        cookie('user_name', null);

        $this -> redirect(url('login/index'));
    }
}

