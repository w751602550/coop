<?php


namespace app\home\controller;


class Account extends Base
{
    public function index(){

        return $this->fetch('index');
    }

    public function add(){
        if($this->ajax){
            $post=postData('order');
        }
    }
    public function edit(){

    }
}