<?php


namespace app\store\controller\goods;


use app\store\controller\Base;
use app\store\model\GoodsUnit;

class Unit extends Base
{
    public function index()
    {
        $list = (new GoodsUnit)->getPage();
        return $this->fetch('index', compact('list'));
    }

    public function add()
    {
        $model=new GoodsUnit();
        if($this->ajax){
            $post=postData('unit');
            if($model->add($post))
                return ajaxSuccess(getchina('addSuccess'));
            return ajaxError(getchina('addError').":".$model->getError());
        }
        return $this->fetch('add');
    }

    public function edit($id)
    {
        $detail=(new GoodsUnit)->detail($id);
        if(!$detail)
            return ajaxError(getchina('noData'));
        if($this->ajax){
            $post=postData('unit');
            if($detail->edit($post))
                return ajaxSuccess(getchina('updateSuccess'),url('index'));
            return ajaxError(getchina('updateError'));
        }
        return $this->fetch('edit',compact('detail'));
    }

    public function delete($id){
        $detail=(new GoodsUnit)->detail($id);
        if(!$detail)
            return ajaxError(getchina('noData'));
        if($detail->delete())
            return ajaxSuccess(getchina('deleteSuccess'));
        return ajaxError(getchina('deleteError'));
    }
}