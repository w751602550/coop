<?php


namespace app\home\model;


class MemberCategory extends BaseMember
{
    protected $name = 'member_goods_category';
    protected $pk = 'category_id';

    public function getAll()
    {
        return $this->order('sort asc,update_time desc')->select();
    }

    public function getTree()
    {
        $list = $this->getAll()->toArray();
        $category = [];
        foreach ($list as $key => $val) {
            $category[$val['category_id']] = $val;
        }
        $tree = [];
        foreach ($category as $key => $val) {
            if ($val['pid']) {
                $category[$val['pid']]['child'][$val['category_id']] = &$category[$key];
            } else {
                $tree[] = &$category[$key];
            }
        }
        return $tree;
    }

    public function getCategoryById(){
        $list = $this->getAll()->toArray();
        $category = [];
        foreach ($list as $key => $val) {
            $category[$val['category_id']] = $val['name'];
        }
        $category[0]='';
        return $category;
    }

    public function add($post)
    {
        $post['member_id'] = $this->member_id;
        return $this->allowField(true)->save($post);
    }

    public function edit($post)
    {
        return $this->allowField(true)->save($post);
    }

    public function setDelete($category_id)
    {
        if ($this->checksub($category_id)) {
            $this->error = '存在下级类目,请先删除下级分类';
            return false;
        }
        return self::destroy($category_id);
    }

    public static function detail($key)
    {
        return self::get($key);
    }

    public function checksub($category_id)
    {
        return $this->where('pid', $category_id)->find();
    }


}