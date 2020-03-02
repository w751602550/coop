<?php


namespace app\store\model;


class GoodsUnit extends BaseModel
{
    public function getPage($condition=[]){
        return $this->where($condition)->paginate($this->psize);
    }

    public function getAll($condition=[]){
        return $this->where($condition)->all();
    }

    public function add($data){
        if($this->checkName($data['name'])){
            $this->error='该单位名称己存在';
            return false;
        }
        return $this->allowField(true)->save($data);
    }

    public function edit($data){
        if($data['name'] != $this->name && $this->checkName($data['name'])){
            $this->error='该单位名称己存在';
            return false;
        }
        return $this->allowField(true)->isUpdate(true)->save($data);
    }

    protected function checkName($name){
        return $this->where('name',$name)->find();
    }

    public function detail($key){
        return self::get($key);
    }
}