CREATE DATABASE `demall`;
use demall;
DROP TABLE IF EXISTS `bin_member`;
CREATE TABLE IF NOT EXISTS `bin_member`(
`member_id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
`member_name` VARCHAR(100) NOT NULL DEFAULT '' COMMENT '用户名',
`store_id` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '店铺ID',
`phone` VARCHAR(20) NOT NULL DEFAULT '' COMMENT '电话',
`password` VARCHAR(32) NOT NULL DEFAULT '' COMMENT '密码',
`true_name` VARCHAR(100) NOT NULL DEFAULT '' COMMENT '真实姓名',
`last_time` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '最后登录时间',
`login_times` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '登录次数',
`image_url` VARCHAR(100) NOT NULL DEFAULT '' COMMENT '头像',
`gender` TINYINT UNSIGNED NOT NULL DEFAULT 1 COMMENT '性别',
`status` TINYINT NOT NULL DEFAULT 1 COMMENT '状态',
`ip` VARCHAR(50) NOT NULL DEFAULT '' COMMENT 'ip地址',
`create_time` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建时间',
`update_time` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '更新时间',
INDEX member_name(`member_name`),
INDEX phone(`phone`)
)ENGINE=INNODB DEFAULT CHARSET=UTF8;


INSERT INTO `bin_member` (`member_name`,`password`) values ('binbin','1697e0a24a5d9b4bb0e82ad793d86a93');

DROP TABLE IF EXISTS `bin_order`;
CREATE TABLE IF NOT EXISTS `bin_order`(
`order_id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
`member_id` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '用户ID',
`order_sn` VARCHAR(50)  NOT NULL DEFAULT 0 COMMENT '订单编号',
`payment_sn`  VARCHAR(50) NOT NULL DEFAULT 0 COMMENT '付款编号',
`payment_type` VARCHAR(50)  NOT NULL DEFAULT 0 COMMENT '付款方式',
`payment_id` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '付款类型id',
`payment_name` VARCHAR(50)  NOT NULL DEFAULT 0 COMMENT '付款类型',
`pay_time` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '付款时间',
`confirm_time` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '确认时间',
`delivery_time` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '发货时间',
`receive_time` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '签收时间',
`complete_time` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '完成时间',
`total_price` DECIMAL(10,2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '总价格',
`pay_price` DECIMAL(10,2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '付款价格',
`year` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '年',
`month` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '月',
`status` TINYINT UNSIGNED NOT NULL DEFAULT 10 COMMENT '状态10待审核20待发货30己发货40己送达50己付款60己完成70己关闭',
`remark` VARCHAR(200) NOT NULL DEFAULT '' COMMENT '备注',
`create_time` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '订单时间',
`update_time` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '更新时间'
)ENGINE=INNODB DEFAULT CHARSET=UTF8;


DROP TABLE IF EXISTS `bin_order_goods`;
CREATE TABLE IF NOT EXISTS `bin_order_goods`(
`order_goods_id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
`order_id` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '订单ID',
`member_goods_id` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '合约商品ID',
`goods_name` VARCHAR(200) NOT NULL DEFAULT '' COMMENT '商品名称',
`goods_image` VARCHAR(200) NOT NULL DEFAULT '' COMMENT '商品图片',
`remark` VARCHAR(200) NOT NULL DEFAULT '' COMMENT '备注',
`number` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '数量',
`price` DECIMAL(10,2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '价格',
`total_price`  DECIMAL(10,2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '总价',
INDEX orderid(`order_id`),
INDEX membergoods(`member_goods_id`)
)ENGINE=INNODB DEFAULT CHARSET =UTF8;

DROP TABLE IF EXISTS `bin_order_address`;
CREATE TABLE IF NOT EXISTS `bin_order_address`(
`address_id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
`order_id` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '订单ID',
`member_id` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '用户ID',
`name` VARCHAR(100) NOT NULL DEFAULT '' COMMENT '收件人姓名',
`first_address` VARCHAR(200) NOT NULL DEFAULT '' COMMENT '地址',
`address` VARCHAR(200) NOT NULL DEFAULT '' COMMENT '详情地址',
`code` VARCHAR(20) NOT NULL DEFAULT '' COMMENT '邮编',
`phone` VARCHAR(20) NOT NULL DEFAULT '' COMMENT '电话',
`update_time` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '更新时间',
INDEX orderid(`order_id`),
INDEX memberid(`member_id`)
)ENGINE=INNODB DEFAULT CHARSET=UTF8;

DROP TABLE IF  EXISTS `bin_payment`;
CREATE TABLE IF NOT EXISTS `bin_payment`(
`payment_id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
`payment_name` VARCHAR(200) NOT NULL DEFAULT '' COMMENT '付款名称',
`values` VARCHAR(200) NOT NULL DEFAULT '' COMMENT '值',
`create_time` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建时间',
`update_time` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '更新时间'
)ENGINE=INNODB DEFAULT CHARSET=UTF8;


-- 管理后台

-- 商家后台
DROP TABLE IF EXISTS `bin_store`;
CREATE TABLE IF NOT EXISTS `bin_store`(
`store_id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
`store_name` VARCHAR(100) NOT NULL DEFAULT '' COMMENT '店铺名称',
`account` VARCHAR(100) NOT NULL DEFAULT '' COMMENT '用户名',
`phone` VARCHAR(20) NOT NULL DEFAULT '' COMMENT '电话',
`password` VARCHAR(32) NOT NULL DEFAULT '' COMMENT '密码',
`true_name` VARCHAR(100) NOT NULL DEFAULT '' COMMENT '真实姓名',
`last_time` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '最后登录时间',
`login_times` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '登录次数',
`status` TINYINT NOT NULL DEFAULT 1 COMMENT '状态',
`ip` VARCHAR(50) NOT NULL DEFAULT '' COMMENT 'ip地址',
`is_delete` INT NOT NULL DEFAULT 0 COMMENT '是否己删除',
`sell_id` INT NOT NULL DEFAULT 0 COMMENT '广货店铺ID',
`create_time` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建时间',
`update_time` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '更新时间',
INDEX member_name(`store_name`),
INDEX phone(`phone`)
)ENGINE=INNODB DEFAULT CHARSET=UTF8;

INSERT INTO `bin_store` (`account`,`password`,`sell_id`) values ('binbin','1697e0a24a5d9b4bb0e82ad793d86a93','8811');

DROP TABLE IF EXISTS `bin_goods`;
CREATE TABLE IF NOT EXISTS `bin_goods`(
`goods_id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY ,
`gh_goods_id` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '商城商品ID',
`gh_goods_commonid` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '商城商品commonid',
`store_id` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '店铺id',
`goods_name` VARCHAR(100) NOT NULL DEFAULT '' COMMENT '商品名称',
`goods_jingle` VARCHAR(200) NOT NULL DEFAULT  '' COMMENT '商品介绍',
`goods_price` DECIMAL(10,2) NOT NULL DEFAULT 0 COMMENT '商品价格',
`goods_marketprice` DECIMAL(10,2) NOT NULL DEFAULT 0 COMMENT '市场价格',
`goods_spec` VARCHAR(200) NOT NULL DEFAULT  '' COMMENT '商品规格',
`goods_image` VARCHAR(100) NOT NULL DEFAULT  '' COMMENT '商品图',
`goods_storage` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '库存',
`goods_edittime` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '商品更新时间',
`category_name` VARCHAR(200)  NOT NULL DEFAULT '' COMMENT '分类名',
`goods_body` TEXT NULL COMMENT '详情',
`status` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '状态 0下架，1正常，10违规（禁售）',
`create_time` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建时间',
`update_time` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '更新时间',
INDEX store_id(`store_id`),
INDEX goods_name(`goods_name`),
INDEX status(`status`)
)ENGINE=INNODB DEFAULT CHARSET = UTF8 AUTO_INCREMENT=10000;

DROP TABLE IF EXISTS `bin_goods_images`;
CREATE TABLE IF NOT EXISTS `bin_goods_images`(
`image_id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY ,
`store_id` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '店铺ID',
`goods_id` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '商品ID',
`url` VARCHAR(100) NOT NULL DEFAULT  '' COMMENT '超链接',
`file_id` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '文件ID',
INDEX store_id(`store_id`),
INDEX goods_id(`goods_id`)
)ENGINE=INNODB DEFAULT CHARSET =UTF8 AUTO_INCREMENT=10000;

DROP TABLE IF EXISTS `bin_member_goods`;
CREATE TABLE IF NOT EXISTS `bin_member_goods`(
`member_goods_id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY ,
`store_id` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '店铺ID',
`member_id` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '用户ID',
`goods_id` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '商品ID',
`name`  VARCHAR(200) NOT NULL DEFAULT  '' COMMENT '商品名称',
`category_id`  INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '分类ID',
`cid1` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '1级分类ID',
`cid2` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '2级分类ID',
`cid3` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '3级分类ID',
`thumb` VARCHAR(200) NOT NULL DEFAULT  '' COMMENT '商品图',
`price` DECIMAL(10,2) NOT NULL DEFAULT 0 COMMENT '合约价',
`remark` VARCHAR(200) NOT NULL DEFAULT  '' COMMENT '备注',
`create_time` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建时间',
`update_time` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '更新时间',
INDEX store_id(`store_id`,`member_id`),
INDEX goods_id(`goods_id`)
)ENGINE=INNODB DEFAULT CHARSET =UTF8 AUTO_INCREMENT=10000;

ALTER TABLE `bin_member_goods` ADD COLUMN `thumb` VARCHAR(200) NOT NULL DEFAULT  '' COMMENT '商品图' AFTER `goods_id`;
ALTER TABLE `bin_member_goods` ADD COLUMN `category_id`  INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '分类ID' AFTER `goods_id`;
ALTER TABLE `bin_member_goods` ADD COLUMN `name`  VARCHAR(200) NOT NULL DEFAULT  '' COMMENT '商品名称' AFTER `goods_id`;
ALTER TABLE `bin_member_goods` ADD COLUMN `cid1` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '1级分类ID';
ALTER TABLE `bin_member_goods` ADD COLUMN `cid2` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '2级分类ID';
ALTER TABLE `bin_member_goods` ADD COLUMN `cid3` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '3级分类ID';

DROP TABLE IF EXISTS `bin_member_goods_category`;
CREATE TABLE IF NOT EXISTS `bin_member_goods_category`(
`category_id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY ,
`name` VARCHAR(200) NOT NULL DEFAULT  '' COMMENT '名称',
`member_id` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '用户ID',
`pid` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '父类ID',
`level` TINYINT UNSIGNED NOT NULL DEFAULT 1 COMMENT '分类等级',
`ptree` VARCHAR(150) NOT NULL DEFAULT '' COMMENT '父类树',
`sort` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '排序',
`number` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '商品数量',
`create_time` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建时间',
`update_time` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '更新时间',
INDEX memberid(`member_id`),
INDEX pid(`pid`),
INDEX sort(`sort`),
INDEX updatetime(`update_time`)
)ENGINE=INNODB DEFAULT CHARSET=UTF8;

DROP TABLE IF EXISTS `bin_invoice`;
CREATE TABLE IF NOT EXISTS `bin_invoice` (
  `invoice_id` INT UNSIGNED AUTO_INCREMENT COMMENT '发票信息ID',
  `member_id` INT UNSIGNED  NOT NULL DEFAULT  0 COMMENT '会员ID',
  `invoice_state` ENUM('1','2') DEFAULT NULL COMMENT '发票类型 1:普通发票 2:增值税发票',
  `invoice_title` VARCHAR(50) DEFAULT '' COMMENT '发票抬头[普通发票]',
  `invoice_code` VARCHAR(50) DEFAULT '' COMMENT '纳税人识别号[普通发票]',
  `invoice_content` VARCHAR(10) DEFAULT '' COMMENT '发票内容[普通发票]',
  `invoice_company` VARCHAR(50) DEFAULT '' COMMENT '单位名称',
  `invoice_company_code` VARCHAR(50) DEFAULT '' COMMENT '纳税人识别号',
  `invoice_reg_addr` VARCHAR(50) DEFAULT '' COMMENT '注册地址',
  `invoice_reg_phone` VARCHAR(30) DEFAULT '' COMMENT '注册电话',
  `invoice_reg_bname` VARCHAR(30) DEFAULT '' COMMENT '开户银行',
  `invoice_reg_baccount` VARCHAR(30) DEFAULT '' COMMENT '银行帐户',
  `invoice_rec_name` VARCHAR(20) DEFAULT '' COMMENT '收票人姓名',
  `invoice_rec_mobphone` VARCHAR(15) DEFAULT '' COMMENT '收票人手机号',
  `invoice_rec_province` VARCHAR(30) DEFAULT '' COMMENT '收票人省份',
  `invoice_goto_addr` VARCHAR(50) DEFAULT '' COMMENT '送票地址',
  `create_time` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '更新时间',
  PRIMARY KEY (`invoice_id`),
  INDEX memberid(`member_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1000 DEFAULT CHARSET=utf8 COMMENT='买家发票信息表';


DROP TABLE IF EXISTS `bin_order_account`;
CREATE TABLE IF NOT EXISTS `bin_order_account`(
`account_id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY COMMENT '对帐单ID',
`member_id` INT UNSIGNED  NOT NULL DEFAULT 0 COMMENT '会员ID',
`invoice_id` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '发票信息ID',
`invoice_state` ENUM('1','2') DEFAULT NULL COMMENT '发票类型 1:普通发票 2:增值税发票',
`invoice_title` VARCHAR(50) DEFAULT '' COMMENT '发票抬头[普通发票]',
`invoice_code` VARCHAR(50) DEFAULT '' COMMENT '纳税人识别号[普通发票]',
`invoice_content` VARCHAR(10) DEFAULT '' COMMENT '发票内容[普通发票]',
`invoice_company` VARCHAR(50) DEFAULT '' COMMENT '单位名称',
`invoice_company_code` VARCHAR(50) DEFAULT '' COMMENT '纳税人识别号',
`invoice_reg_addr` VARCHAR(50) DEFAULT '' COMMENT '注册地址',
`invoice_reg_phone` VARCHAR(30) DEFAULT '' COMMENT '注册电话',
`invoice_reg_bname` VARCHAR(30) DEFAULT '' COMMENT '开户银行',
`invoice_reg_baccount` VARCHAR(30) DEFAULT '' COMMENT '银行帐户',
`total_price` DECIMAL(10,2) NOT NULL DEFAULT 0 COMMENT '支付额',
`status` TINYINT UNSIGNED NOT NULL DEFAULT 0 COMMENT '状态0未确认,1己确认',
`confirm_time` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '确认时间',
`create_time` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建时间',
`update_time` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '更新时间',
INDEX memberid(`member_id`),
INDEX invoiceid(`invoice_id`)
)ENGINE=INNODB DEFAULT CHARSET = UTF8;

ALTER TABLE `bin_order` ADD COLUMN `account_id` INT NOT NULL DEFAULT  0 COMMENT '对帐单ID' AFTER `order_id`;
ALTER TABLE `bin_order` ADD INDEX accountid(`account_id`);


DROP TABLE IF EXISTS `bin_order_payment`;
CREATE TABLE IF NOT EXISTS `bin_order_payment`(
`id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY COMMENT '对帐单ID',
`payment_sn` VARCHAR(50) DEFAULT '' COMMENT '支付编码',
`total_price` DECIMAL(10,2) NOT NULL DEFAULT 0 COMMENT '支付额',
`pay_price` DECIMAL(10,2) NOT NULL DEFAULT 0 COMMENT '支付额',
`invoice_state` ENUM('1','2') DEFAULT NULL COMMENT '发票类型 1:普通发票 2:增值税发票',
`invoice_title` VARCHAR(50) DEFAULT '' COMMENT '发票抬头[普通发票]',
`invoice_code` VARCHAR(50) DEFAULT '' COMMENT '纳税人识别号[普通发票]',
`invoice_content` VARCHAR(10) DEFAULT '' COMMENT '发票内容[普通发票]',
`invoice_company` VARCHAR(50) DEFAULT '' COMMENT '单位名称',
`invoice_company_code` VARCHAR(50) DEFAULT '' COMMENT '纳税人识别号',
`invoice_reg_addr` VARCHAR(50) DEFAULT '' COMMENT '注册地址',
`invoice_reg_phone` VARCHAR(30) DEFAULT '' COMMENT '注册电话',
`invoice_reg_bname` VARCHAR(30) DEFAULT '' COMMENT '开户银行',
`invoice_reg_baccount` VARCHAR(30) DEFAULT '' COMMENT '银行帐户',
`confirm_time` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '确认时间',
`create_time` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建时间',
`update_time` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '更新时间',
INDEX paymentsn(`payment_sn`)
)ENGINE=INNODB DEFAULT CHARSET =UTF8;

UPDATE `bin_order` set pay_price = total_price;



-- 20191112
ALTER TABLE `bin_member_goods` ADD COLUMN `goods_code` VARCHAR(200) NOT NULL DEFAULT '' CO
MMENT '自定义商品编号';


-- 20191210
ALTER TABLE `bin_goods` ADD COLUMN `unit` VARCHAR(200) NOT NULL DEFAULT '' COMMENT '商品单位';

DROP TABLE IF EXISTS `bin_goods_unit`;
CREATE TABLE IF NOT EXISTS `bin_goods_unit`(
`id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
`name` VARCHAR(100) NOT NULL DEFAULT '' COMMENT ''
)ENGINE=INNODB DEFAULT CHARSET =UTF8;


ALTER TABLE `bin_member_goods`  ADD COLUMN `unit` INT UNSIGNED NOT NULL DEFAULT  0 COMMENT '单位id';
ALTER TABLE `bin_member_goods`  ADD COLUMN `unit_name` VARCHAR(200) NOT NULL DEFAULT '' COMMENT '单位名称';
ALTER TABLE `bin_member_goods`  ADD COLUMN `spec` VARCHAR(200) NOT NULL DEFAULT '' COMMENT '商品规格';
ALTER TABLE `bin_member_goods` ADD COLUMN `last_update` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '最后更新时间';
