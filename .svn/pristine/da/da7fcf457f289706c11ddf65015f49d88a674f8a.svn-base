<?php


namespace app\home\controller;

use app\home\model\MemberCategory;
use app\home\model\MemberGoods as memberGoodsModel;
use app\home\model\Goods;
use think\Exception;
use think\Image;

class MemberGoods extends Base
{
    private $exportError = [];
    private $excel_dir = '';

    public function initialize()
    {
        parent::initialize();
        $this->excel_dir = WEB_PATH . 'excel' . DS . $this->member['member']['member_id'];
    }

    public function index($keywords = '')
    {
        $condition = [];
        $keywords && $condition[] = ['name', 'like', '%' . trim($keywords) . '%'];
        $list = (new memberGoodsModel)->getPage($condition);
        $category = (new MemberCategory)->getCategoryById();
        return $this->fetch('index', compact('list', 'category', 'keywords'));
    }

    public function edit($member_goods_id)
    {
        if ($this->ajax) {
            $goods = memberGoodsModel::detail($member_goods_id);
            if (!$goods)
                return ajaxError(getchina('noData'));
            $categoryList = (new MemberCategory)->getTree();
            return $this->fetch('edit', compact('categoryList', 'goods'));
        }
    }

    public function editSave()
    {
        if ($this->ajax) {
            $post = postData('goods');
            $goods = memberGoodsModel::detail($post['member_goods_id']);
            if (!$goods)
                return ajaxError(getchina('noData'));
            $categoryArr = explode('-', $post['category_id']);
           /* isset($categoryArr[0]) && $post['cid1'] = $categoryArr[0];
            isset($categoryArr[1]) && $post['cid2'] = $categoryArr[1];
            isset($categoryArr[2]) && $post['cid3'] = $categoryArr[2];
            $post['category_id'] = array_push($categoryArr);*/
			if(isset($categoryArr[0])){
				$post['cid1'] = $categoryArr[0];
				$post['category_id'] = $categoryArr[0];
			}
			if(isset($categoryArr[1])){
				$post['cid2'] = $categoryArr[1];
				$post['category_id'] = $categoryArr[1];
			}
			if(isset($categoryArr[2])){
				$post['cid3'] = $categoryArr[2];
				$post['category_id'] = $categoryArr[2];	
			}
            if ($goods->save($post))
                return ajaxSuccess(getchina('updateSuccess'), url('index'));
            return ajaxError(getchina('updateError'));
        }
    }

    public function export()
    {
        $list = (new memberGoodsModel)->getAll();
        $category = (new MemberCategory)->getCategoryById();
        $field = ['商品大类', '商品小类', '商品细类', '商品编号', '商品名称', '单价(元)', '商品单位', '规格', '商品详情', '图片名称', '是否更新图片'];
        $data = [];
        foreach ($list as $key => $val) {
            $data[$key][] = isset($category[$val['cid1']]) ? $category[$val['cid1']] : '';
            $data[$key][] = isset($category[$val['cid2']]) ? $category[$val['cid2']] : '';
            $data[$key][] = isset($category[$val['cid3']]) ? $category[$val['cid3']] : '';
            $data[$key][] = $val['member_goods_id'];
            $data[$key][] = subString($val['name'], 15);
            $data[$key][] = $val['price'];
            $data[$key][] = $val['unit_name'];
            $data[$key][] = $val['spec'];
            $data[$key][] = $val['name'];
            $data[$key][] = $val['member_goods_id'] . '.jpg';
            $data[$key][] = '是';
        }
        $date = date('Ym', time());
        $dir = $this->excel_dir . DS . $date . DS;
        $zipName = $dir . $this->member['member']['member_id'] . '-' . $date . '.zip';
        if (is_file($zipName))
            $this->outputZip($zipName);
        $filename = $this->member['member']['member_name'] . '电商商品信息表';
        $file = $dir . $filename . $date;
        $excelName = $file . '.xlsx';
        $imageDir = $dir . 'image' . DS;
		$thumbDir = $dir . 'thumbimg' . DS;
        !is_dir($dir) && mkdir($dir, 0777, true);
        !is_dir($imageDir) && mkdir($imageDir, 0777, true);
		!is_dir($thumbDir) && mkdir($thumbDir, 0777, true);//创建缩略图文件夹
        !is_file($excelName) && $this->exportExcel($excelName, $field, $data, $filename);
        $this->exportImage($list, $imageDir);
		$this->exporthumbImage($list,$imageDir,$thumbDir);//创建缩略图
        $this->exportZip($zipName, $dir);
		$this->outputZip($zipName);
    }

    public function record()
    {
        $list = read_file($this->excel_dir, false);
        return $this->fetch('record', compact('list'));
    }

    public function downRecord($record)
    {
        $zipName = $this->excel_dir . DS . $record . DS . $this->member['member']['member_id'] . '-' . $record . '.zip';
        if (is_file($zipName))
            $this->outputZip($zipName);
        return ajaxError('该记录文件不存在,请删除后重新导出');
    }

    public function rmRecord($record)
    {
        $dir = $this->excel_dir . DS . $record;
        delete_file($dir);
        return ajaxSuccess(getchina('deleteSuccess'));
    }

    public function delete($member_goods_id)
    {
        if ($this->ajax) {
            $goods = (new memberGoodsModel)->get($member_goods_id);
            if (!$goods) {
                return ajaxError('合约商品不存在');
            }
            if ($goods->delete())
                return ajaxSuccess('删除成功', url('index'));
            return ajaxError('删除失败');
        }
    }

    public function add($member_goods_id)
    {
        if ($this->ajax) {
            $goods = (new Goods)->detail($member_goods_id);
            if (!$goods || $goods['status'] != 1) {
                return ajaxError('商品不存在或己下架');
            }
            if ((new memberGoodsModel)->add($goods))
                return ajaxSuccess('加入成功', url('goods/index'));
            return ajaxError('删除失败');
        }
    }

    protected function exportExcel($file, $field, $data, $title = '导出列表')
    {
        $objPHPExcel = new \PHPExcel();
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $sheet = $objPHPExcel->getActiveSheet();
        $start = 'A';
        $style_array = [
            'borders' => [
                'allborders' => [
                    'style' => \PHPExcel_Style_Border::BORDER_THIN,
					//'color' => array ('argb' => 'FF000000'),          //设置border颜色
                ],
            ],
        ];
//    $sheet->getDefaultRowDimension()->setRowHeight(20);//所有单元格（行）默认高度
//    $sheet->getDefaultColumnDimension()->setWidth(20);//所有单元格（列）默认宽度
//    $sheet->getRowDimension('1')->setRowHeight(30);//设置行高度
//    $sheet->getColumnDimension('C')->setWidth(30);//设置列宽度
//    $sheet->getStyle('A1')->getFont()->setSize(18);//设置文字大小
//    $sheet->getStyle('A1')->getFont()->setBold(true);//设置是否加粗
//    $sheet->getStyle('A1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);// 设置文字颜色
//    $sheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);//设置文字居左（HORIZONTAL_LEFT，默认值）中（HORIZONTAL_CENTER）右（HORIZONTAL_RIGHT）
//    $sheet->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);//垂直居中
//    $sheet->getStyle('A1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);//设置填充颜色
//    $sheet->getStyle('A1')->getFill()->getStartColor()->setARGB('FF7F24');//设置填充颜色
        $rowsLetter = chr(ord($start) + count($field) - 1);
        $sheet->mergeCells('A1:' . $rowsLetter . '1');//合并单元格（如果要拆分单元格是需要先合并再拆分的，否则程序会报错）
        $sheet->setCellValue('A1', $title);
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->getStyle('A1')->getFont()->setSize(18);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        //$sheet->freezePane('A2');
		//   处理第二行格式

        $sheet->mergeCells('A2:B2');
        $sheet->setCellValue('A2', '商品信息所属月份：');
        $sheet->setCellValue('C2', date('Ym', time()));
        $sheet->setCellValue('E2', '电商名称:');
        $sheet->mergeCells('F2:H2');
        $sheet->setCellValue('F2', '广东盛世商潮网络科技有限公司');
        $sheet->mergeCells('I2:J2');
        $sheet->setCellValue('I2', '表格生成日期:');
        $sheet->setCellValue('K2', date('Ymd', time()));
//    处理数据
        foreach ($field as $key => $val) {
            $sheet->setCellValue(chr(ord($start) + $key) . '3', $val);
        }
        foreach ($data as $key => $val) {
            foreach ($field as $k => $v) {
                $sheet->setCellValue(chr(ord($start) + $k) . ($key + 4), $val[$k]);
            }
        }
//    处理结尾统计
        $count = count($data) + 3;
        $sheet->mergeCells('A' . $count . ':' . $rowsLetter . $count);
        $sheet->setCellValue('A' . $count, '商品各类数量合计：' . count($data));
        $sheet->getStyle('A' . $count)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle("A3:" . $rowsLetter . $count)->applyFromArray($style_array);
//    header("Pragma: public");
//    header("Expires: 0");
//    header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
//    header("Content-Type:application/force-download");
//    header("Content-Type:application/vnd.ms-execl");
//    header("Content-Type:application/octet-stream");
//    header("Content-Type:application/download");;
//    header('Content-Disposition:attachment;filename="' . $filename . '.xlsx"');
//    header("Content-Transfer-Encoding:binary");
//    $objWriter->save('php://output');
        if (!is_file($file)) {
            $objWriter->save($file);
        }
		
		
    }

    protected function exportImage($data, $dir)
    {
        foreach ($data as $key => $val) {
			
            $this->download($val['goods_image'], $dir, $val['member_goods_id']);
        }
    }
	//缩略图
	protected function exporthumbImage($data,$dir,$thumbdir)
    {
        foreach ($data as $key => $val) {
			
            $this->createthumb($thumbdir,$dir, $val['member_goods_id']);
			
        }
    }
	//生成缩略图
	protected function createthumb($url,$path,$imagename){
		$address = $path.$imagename.'.jpg';
		$thumbimg =$url.$imagename.'.jpg';
		$image = \think\Image::open($address);
		$image->thumb(300,300)->save($thumbimg);
	}

    protected function download($url, $path, $imageName)
    {
        if (is_file($path . $imageName . '.jpg'))
            return;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        $file = curl_exec($ch);
        curl_close($ch);
        $resource = fopen($path . $imageName . '.jpg', 'a');
        fwrite($resource, $file);
        fclose($resource);
    }

    protected function exportZip($zipFile, $dir)
    {
        $zip = new \ZipArchive();
        if ($zip->open($zipFile, \ZIPARCHIVE::CREATE) !== true)
            throw new Exception('无法压缩文件');
        $this->addFileToZip($dir, $zip);
        $zip->close();
    }

    private function addFileToZip($path, $zip, $parent = '')
    {
        $handler = opendir($path);
        while (($filename = readdir($handler)) !== false) {
            if ($filename != "." && $filename != "..") {
                if (is_dir($path . "/" . $filename)) {
                    $this->addFileToZip($path . "/" . $filename, $zip, $filename);
                } else { //将文件加入zip对象
                    if (!$parent)
                        $zip->addFile($path . "/" . $filename, $filename);
                    else
                        $zip->addFile($path . "/" . $filename, $parent . DS . $filename);
                }
            }
        }
        @closedir($path);
    }

    private function outputZip($zipName)
    {
        if (!is_file($zipName))
            exit();
        header('Content-Type: application/zip;charset=utf8');
        header('Content-disposition: attachment; filename=' . basename($zipName));
        header('Content-Length: ' . filesize($zipName));
        readfile($zipName);
        exit();
    }
}