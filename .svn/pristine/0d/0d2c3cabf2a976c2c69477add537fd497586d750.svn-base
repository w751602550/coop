<?php

namespace app\home\controller\member_goods;

use app\home\controller\Base;
use app\home\model\MemberCategory;
use app\home\model\MemberGoods;

class Category extends Base
{
    public function index()
    {
        $list = (new MemberCategory)->getTree();
        return $this->fetch('index', compact('list'));
    }

    public function add($category_id = '')
    {
        $model = new MemberCategory();
        $categoryList = $model->getTree();
        if ($this->ajax) {
            $post = postData('category');
            if ($post['pid']) {
                $parent = MemberCategory::detail($post['pid'])->toArray();
                if (!$parent)
                    return ajaxError(getchina('noParent'));
                $post['level'] = ++$parent['level'];
                if ($post['level'] == 2)
                    $post['ptree'] = $post['pid'];
                elseif ($post['level'] >= 3)
                    $post['ptree'] = $parent['ptree'] . '-' . $post['pid'];
            } else {
                $post['level'] = 1;
                $post['ptree'] = 0;
            }
            if ((new MemberCategory)->add($post))
                return ajaxSuccess(getchina('addSuccess'));
            return ajaxError(getchina('addError'));
        }
        return $this->fetch('add', compact('categoryList', 'category_id'));
    }

    public function addAll(){
        $model = new MemberCategory();
        $categoryList = $model->getTree();
        if($this->ajax){
            $post=postData('category');
            if ($post['pid']) {
                $parent = MemberCategory::detail($post['pid'])->toArray();
                if (!$parent)
                    return ajaxError(getchina('noParent'));
               $level = ++$parent['level'];
                if ($level == 2)
                    $ptree = $post['pid'];
                elseif ($level >= 3)
                   $ptree = $parent['ptree'] . '-' . $post['pid'];
            } else {
               $level = 1;
               $ptree= 0;
            }

            $categoryArr=explode(',',$post['name']);
            $data=[];
          foreach ($categoryArr as $key => $val){
              if(!$val)
                  continue;
              $data[$key]['name']=$val;
              $data[$key]['member_id']=$this->member['member']['member_id'];
              $data[$key]['pid']=$post['pid'];
              $data[$key]['level']=$level;
              $data[$key]['ptree']=$ptree;
              $data[$key]['sort']=$post['sort'];
          }
          if($model->saveAll($data))
              return ajaxSuccess(getchina('addSuccess'),url('index'));
          return ajaxError(getchina('addError'));
        }
        return $this->fetch('addall',compact('categoryList'));
    }

    public function edit($category_id)
    {
        $model = new MemberCategory();
        $categoryList = $model->getTree();
        $category = MemberCategory::detail($category_id);
        if (!$category) {
            return ajaxError(getchina('noData'));
        }
        if ($this->ajax) {
            $post = postData('category');
            if ($category->edit($post)) {
                return ajaxSuccess(getchina('updateSuccess'), url('index'));
            }
            return ajaxError(getchina('updateError'));
        }
        return $this->fetch('edit', compact('category', 'categoryList'));
    }

    public function delete($category_id)
    {
        $detail = MemberCategory::detail($category_id);
        if (!$detail)
            return ajaxError(getchina('noData'));
        $model = new MemberCategory();
        if ($model->setDelete($category_id))
            return ajaxSuccess(getchina('deleteSuccess'), url('index'));
        return ajaxError(getchina('deleteError') . ":" . $model->getError());
    }

    public function addGoods($category_id = '', $keywords = '')
    {
        $model = new MemberCategory;
        $goodsModel = new MemberGoods;
        if ($this->ajax) {
            $post = postData('goods');
            $data = [];
            $category = MemberCategory::detail($category_id);
            $parent = explode('-', $category['ptree']);
            $cid1 = isset($parent[0])? $parent[0]: 0;
            $cid2 = isset($parent[1])? $parent[1]: 0;
            $str = 'cid' . $category['level'];
            foreach ($post as $key => $val) {
                $data[$key]['member_goods_id'] = $val;
                $data[$key]['category_id'] = $category_id;
                $data[$key]['cid1']=$cid1;
                $data[$key]['cid2']=$cid2;
                $data[$key][$str]=$category_id;
            }
            if ($goodsModel->saveAll($data))
                return ajaxSuccess(getchina('addSuccess'));
            return ajaxError(getchina('addError'));
        }
        $condition = [];
        $keywords && $condition[] = ['name', 'like', '%' . trim($keywords) . '%'];
        $categoryList = $model->getTree();
        $category=$model->getCategoryById();
        $goodsList = $goodsModel->getpage($condition);
        return $this->fetch('goods', compact('categoryList', 'category','category_id', 'goodsList', 'keywords'));
    }

    public function addGoodsOne($member_goods_id, $category_id)
    {
        $detail = MemberGoods::detail($member_goods_id);
        if (!$detail)
            return ajaxError(getchina('noData'));
        $category = MemberCategory::detail($category_id);
        $parent = explode('-', $category['ptree']);
        $cid1 = isset($parent[0])? $parent[0]: 0;
        $cid2 =isset($parent[1])? $parent[1]: 0;
        $str = 'cid' . $category['level'];
        $data['category_id'] = $category_id;
        $data['cid1']=$cid1;
        $data['cid2']=$cid2;
        $data[$str]=$category_id;
        if ($detail->save($data))
            return ajaxSuccess(getchina('addSuccess'));
        return ajaxError(getchina('addError'));
    }

    public function deleteGoodsOne($member_goods_id, $category_id)
    {
        $detail = MemberGoods::detail($member_goods_id);
        if (!$detail)
            return ajaxError(getchina('noData'));
        $data['category_id'] = 0;
        $data['cid1']=0;
        $data['cid2']=0;
        $data['cid3']=0;
        if ($detail->save($data))
            return ajaxSuccess(getchina('deleteSuccess'));
        return ajaxError(getchina('deleteSuccess'));
    }
}