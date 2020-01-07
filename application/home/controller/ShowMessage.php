<?php


namespace app\home\controller;


class ShowMessage
{
    public function index(){
        dump(input('get.'));
        dump(input('post.'));
    }
}