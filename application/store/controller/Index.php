<?php


namespace app\store\controller;


class Index extends Base
{
    public function index()
    {
        return $this->fetch();
    }
}