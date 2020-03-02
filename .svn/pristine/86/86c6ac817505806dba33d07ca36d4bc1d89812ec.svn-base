<?php


namespace app\home\controller\member;

use app\home\controller\Base;
use app\home\model\Invoice as invoiceModel;
class Invoice extends Base
{
    public function index()
    {
        $list=(new invoiceModel)->getPage();
        return $this->fetch('index',compact('list'));
    }

    public function add()
    {
        if($this->ajax){
            $data=postData('invoice');
            if((new invoiceModel)->add($data))
                return ajaxSuccess(getchina('addSuccess'),url('index'));
            return ajaxError(getchina('addError'));
        }
        return $this->fetch('add');
    }

    public function edit($invoice_id){
        $invoice=(new invoiceModel)->detail($invoice_id);
        if(!$invoice)
            return $this->error(getchina('noData'));
        if($this->ajax){
            $post=postData('invoice');
            if($invoice->add($post))
                return ajaxSuccess(getchina('updateSuccess'),url("index"));
            return ajaxError(getchina('updateError'));
        }
        return $this->fetch('edit',compact('invoice'));
    }

    public function delete($invoice_id){
        if($this->ajax){
            if((new invoiceModel)->setDelete($invoice_id))
                return ajaxSuccess(getchina('deleteSuccess'),url('index'));
            return ajaxError(getchina('deleteError'));
        }
    }
}