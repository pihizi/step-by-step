<?php

namespace Controller;

class Login extends \Controller
{
    public function __index(array $params=[])
    {
        $form = $_POST;
        if (!empty($form)) {
            $username = $form['name'];
            $password = $form['password'];
            $user = new \Model\User();
            if (!$user->verify($username, $password)) {
                $error = '用户名和密码不匹配';
            }
            else {
                header('Location: /home');
            }
        }
        return new \View('login', [
            'form'=> $form,
            'error'=> $error
        ]);
    }
}
