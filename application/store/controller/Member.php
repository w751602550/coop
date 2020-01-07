<?php


namespace app\store\controller;

use app\store\model\Member as memberModel;

class Member extends Base
{
    public function index(){
        $list=(new memberModel)->getPage();
        return $this->fetch('index',compact('list'));
    }

    public function add(){
        if($this->ajax){
            $post=postData('member');
            $model=new memberModel();
            if($model->add($post))
                return ajaxSuccess(getchina('addSuccess'),url('index'));
            return ajaxError(getchina('addError').':'.$model->getError());
        }
        return $this->fetch('add');
    }

    public function edit($member_id){
        $member=(new memberModel)->detail($member_id);
        if(!$member)
            return ajaxError(getchina('noData'));
        if($this->ajax){
            $post=postData('member');
            if($member->edit($post))
                return ajaxSuccess(getchina('addSuccess'),url('index'));
            return ajaxError(getchina('addError').":".$member->getError());
        }
        return $this->fetch('edit',compact('member'));
    }


}