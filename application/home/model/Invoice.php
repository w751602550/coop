<?php


namespace app\home\model;


class Invoice extends BaseMember
{
    protected $pk = 'invoice_id';

    public function getInvoiceStateAttr($value)
    {
        $data = [
            1 => '普通发票',
            2 => '增值税发票'
        ];
        return ['text' => $data[$value], 'value' => $value];
    }

    public function getPage($condition = [])
    {
        return $this->where($condition)->paginate($this->psize);
    }

    public function getAll($condition=[]){
        return $this->where($condition)->select();
    }

    public function add($data)
    {
        $data['member_id'] = $this->member_id;
        return $this->allowField(true)->save($data);
    }

    public function setDelete($invoice_id)
    {
        return self::destroy($invoice_id);
    }

    public function detail($invoice_id)
    {
        return self::get($invoice_id);
    }
}