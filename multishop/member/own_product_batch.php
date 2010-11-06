<?php
/////////////////////////////////////////////////////////////////////////////
// 此文件是 ShopNC多用户商城 的一部分
//
// Copyright (c) 2007 - 2008 www.shopnc.net 
//
// 要查看完整的版权信息和许可信息，请查看源代码中附带的 COPYRIGHT 文件，
// 或者访问 http://www.shopnc.net/ 获得详细信息。
/////////////////////////////////////////////////////////////////////////////

/**
 * FILE_NAME : own_product_batch.php   FILE_PATH : E:\www\multishop\trunk\member\own_product_batch.php
 * ....商品批量操作类
 *
 * @copyright Copyright (c) 2007 - 2008 www.shopnc.net 
 * @author ShopNC Develop Team 
 * @version Wed Jun 04 10:19:04 CST 2008
 */
// 图片上传session传递
if (isset($_POST["PHPSESSID"])) {
	session_id($_POST["PHPSESSID"]);
}

require_once("../global.inc.php");

class OwnProductBatch extends memberFrameWork{
	/**
	 * 商品批量操作对象
	 *
	 * @var obj
	 */
	var $obj_product_batch;
	/**
	 * 商品类别对象
	 *
	 * @var obj
	 */
	var $obj_product_cate;
	/**
	 * 商品对象
	 *
	 * @var obj
	 */
	var $obj_product;
	/**
	 * 验证对象
	 *
	 * @var obj
	 */
	var $objvalidate;
	/**
	 * 文件压缩对象
	 *
	 * @var obj
	 */
	var $obj_zip;
	/**
	 * 分页对象
	 *
	 * @var obj
	 */
	var $obj_page;
	/**
	 * 店铺商品类别对象
	 *
	 * @var obj
	 */
	var $obj_shop_product_cate;
	/**
	 * 会员对象
	 *
	 * @var obj
	 */
	var $obj_member;
	/**
	 * 货币对象
	 *
	 * @var obj
	 */
	var $obj_exchange;
	/**
	 * 导入商品数量
	 *
	 * @var obj
	 */
	var $product_batch_num=50;
	/**
	 * 地区对象
	 *
	 * @var obj
	 */
	var $obj_area;
	
	function main(){
		/**
		 * 创建商品批量操作对象
		 */
		if (!is_object($this->obj_product_batch)){
			require_once("product_batch.class.php");
			$this->obj_product_batch = new BatchClass();
		}
		/**
		 * 商品分类
		 */
		if (!is_object($this->obj_product_cate)){
			require_once("productclass.class.php");
			$this->obj_product_cate = new ProductCategoryClass();
		}
		/**
		 * 创建商品对象
		 */
		if (!is_object($this->obj_product)){
			require_once("product.class.php");
			$this->obj_product = new ProductClass();
		}
		/**
		 * 创建验证对象
		 */
		if (!is_object($this->objvalidate)){
			require_once("commonvalidate.class.php");
			$this->objvalidate = new CommonValidate();
		}
		/**
		 * 实例化分页类
		 */
		if(!is_object($this->obj_page)){
			require_once("commonpage.class.php");
			$this->obj_page = new CommonPage();
		}
		/**
		 * 实例化地区类
		 */
		if (!is_object($this->obj_area)){
			require_once ("area.class.php");
			$this->obj_area = new AreaClass();
		}
		/**
		 * 语言包
		 */
		$this->getlang("product_manage,own_batch");
		/**
		 * 菜单输出
		 */
		$this->memberMenu('seller','my_seller','product_batch');
		
		switch ($this->_input['action']){
			case "upload":
				$this->_upload();
				break;
			case "upload_in":
				$this->_upload_in();
				break;
			case "upload_pic":
				$this->_upload_pic();
				break;
			case "upload_pic_save":
				$this->_upload_pic_save();
				break;
			case "export":
				$this->_export();
				break;
			case "export_upload":
				$this->_export_upload();
				break;
			default:
				$this->_manage();
		}
		
	}
	
	/**
	 * 商品批量操作页面
	 */
	function _manage(){
		//商品类别
		$array = $this->obj_product_cate->listClassDetail();
		if (is_array($array)){
			foreach ($array as $k => $v){
				if ($v[4] == '0') {
					$ProductCateArray[] = $v;
				}
			}
		}
		//销毁变量
		unset($array);
		
		/**
		 * 创建商铺宝贝分类对象
		 */
		if (!is_object($this->obj_shop_product_cate)){
			require_once("shopproductcategory.class.php");
			$this->obj_shop_product_cate = new ShopProductCategoryClass();
		}
		if ($_SESSION['s_shop']['id'] != ''){
			//得到店铺宝贝分类
			$condition_shop_product_cate['shop_id'] = $_SESSION['s_shop']['id'];
			$condition_shop_product_cate['order_by'] = " shop_product_class.class_parent_id asc,shop_product_class.class_sort asc,shop_product_class.class_id asc ";
			$shop_product_category = $this->obj_shop_product_cate->getCategory($condition_shop_product_cate,$page);
			//整理数组为多级
			$shop_product_category = $this->obj_shop_product_cate->_makeCategoryArray($shop_product_category);
		}
		//初始化会员类
		if (!is_object($this->obj_member)){
			require_once ("member.class.php");
			$this->obj_member = new MemberClass();
		}
		//取支付方式
		if (is_array($this->_configinfo['payment'])){
			//取会员信息,用来验证显示的支付方式
			$condition['id'] = $_SESSION['s_login']['id'];
			$member_array = $this->obj_member->getMemberInfo($condition,'*','more');
			foreach ($this->_configinfo['payment'] as $k => $v){
				if ($v == 1 && file_exists(BasePath.'/payment/'.$k.'/payment_module.php')){
					include_once(BasePath.'/payment/'.$k.'/payment_module.php');
					$class_name = $k.'PaymentMethod';
					$obj_p_module = new $class_name;
					$param_array = $obj_p_module->payment_param();
					//不是线下的，并且在会员信息中有值的
					if ($param_array['type'] != 'offline' && $member_array[$k] != ''){
						$payment_array[$k]['name'] = $param_array['name'];
						//支持的货币种类
						$payment_array[$k]['currency'] = $param_array['currency'];//数组形式
						$payment_array[$k]['currency_line'] = implode('|',$param_array['currency']);//数组形式
					}elseif ($param_array['type'] == 'offline'){//是线下的
						$payment_array[$k]['name'] = $param_array['name'];
						//支持的货币种类
						$payment_array[$k]['currency'] = $param_array['currency'];//数组形式
						$payment_array[$k]['currency_line'] = implode('|',$param_array['currency']);//数组形式
					}
					//默认为显示的支付方式全部选中
					if ($payment_array[$k]['name'] != ''){
						$payment_array[$k]['check'] = 1;
					}
					$payment_description[] = $param_array;
					//销毁变量
					unset($class_name,$obj_p_module,$param_array);
				}
			}
		}
		if (empty($payment_array)){
			$this->redirectPath("error",$this->_configinfo['websit']['site_url']."/member/own_payment.php",$this->_lang['errBatchPaymentIsEmpty']);
		}
		/**
		 * 创建汇率对象
		 */
		if (!is_object($this->obj_exchange)){
			require_once("exchange.class.php");
			$this->obj_exchange = new ExchangeClass();
		}
		//取货币种类
		$condition_exchange['state'] = 1;
		$exchange_array = $this->obj_exchange->listExchange($condition_exchange,$page);
		if (is_array($exchange_array)){
			foreach ($exchange_array as $k => $v){
				$exchange_array[$k]['display'] = 'block';//前台显示标识
			}
		}
		//控制货币前台显示
		if (is_array($payment_array)){
			$array = array();
			$product_currency = array();
			foreach ($payment_array as $k => $v){
				if ($v['check'] == 1){//选中的支付方式
					if (is_array($v['currency'])){
						foreach ($v['currency'] as $k2 => $v2){
							$array[]= $v2;
						}
					}
				}
				//默认取所有货币为支持的货币
				$product_currency = array_merge($product_currency,$v['currency']);
			}
			$array = array_unique($array);
			sort($array);
			if (is_array($exchange_array)){
				foreach ($exchange_array as $k => $v){
					if (!in_array($v['exchange_name'],$array)){
						$exchange_array[$k]['display'] = 'none';//前台显示标识
					}
				}
				sort($exchange_array);
			}
		}
		//去除重复的货币种类
		$product_currency = array_unique($product_currency);
		unset($array);
		
		//取地区信息
		$array = Common::getAreaCache('');
		$area_array = array();
		if (is_array($array)){
			foreach ($array as $k => $v){
				if ($v[1] == '0'){
					$v['area_id'] = $v[0];
					$v['area_parent_id'] = $v[1];
					$v['area_name'] = $v[2];
					$v['is_parent'] = $v[5];//1是父ID，0不是
					$area_array[] = $v;
				}
			}
		}
		unset($array);
		/**
		 * 页面输出
		 */
		$this->output('area_array',$area_array);
		$this->output('ProductCateArray',$ProductCateArray);
		$this->output("shop_product_cate_array",   $shop_product_category); 
		$this->output("payment_array", $payment_array);
		$this->output("payment_description", $payment_description);
		$this->output("exchange_array", $exchange_array);
		$this->showpage('own_product.batch');
	}
	
	/**
	 * 上传文件，进行处理，并且入库
	 */
	function _upload(){
		//组合支付方式
		if (is_array($this->_input['txtPayment'])){
			foreach ($this->_input['txtPayment'] as $k => $v){
				$this->_input['pay_method'] .= $v.'|';
			}
			$this->_input['pay_method'] = trim($this->_input['pay_method'],'|');
		}
		if ($this->_input['pay_method'] == ''){
			$this->redirectPath("error","",$this->_lang['errBatchPaymentIsEmpty']);
		}else {
			$this->_input['pay_method'] = '|'.$this->_input['pay_method'].'|';
		}
		//组合支持交易的货币种类
		if (!empty($this->_input['currency'])){
			$this->_input['p_currency_category'] = '|'.@implode('|',$this->_input['currency']).'|';
		}else {
			$this->redirectPath("error","",$this->_lang['errBatchPaymentIsEmpty']);
		}
		/**
		 * 信息验证
		 */
		$this->objvalidate->validateparam = array(
			array("input"=>$this->_input["searchcate"],"require"=>"true","message"=>$this->_lang['langBatchClassIsEmpty']),
			array("input"=>$_FILES['file']['tmp_name'],"require"=>"true","message"=>$this->_lang['errBatchFileIsEmpty']),
			array("input"=>$this->_input["area_id"],"require"=>"true","message"=>$this->_lang['errBatchAreaIsEmpty']),
		);
		$error = $this->objvalidate->validate();
		if($error != ""){
			$this->redirectPath("error","",$error);
		}else{
			if ($this->_input['batch_type'] == 'taobao'){//淘宝数据
				$array = $this->get_csv_date($_FILES['file']['tmp_name']);
			}
			if (empty($array)){
				$this->redirectPath("error","",$this->_lang['errBatchFileIsEmpty']);
			}
			/**
			 * 页面输出
			 */
			$this->output("product_array",$array);
			$this->output("condition",$this->_input);
			$this->showpage('own_product.batch_upload');
		}
	}
	
	/**
	 * 解析csv文件
	 */
	function get_csv_date($file_name){
		$str = file_get_contents($file_name);
        if($str{0} != "\xFF" || $str{1} != "\xFE"){
            return false;
        }
        //转码
        $str = Common::unicodeToUtf8(substr($str, 2));
        if (strtolower($this->_configinfo['websit']['ncharset']) == 'gbk'){
        	$str = Common::nc_change_charset($str,'utf8_to_gbk',false);
        }
        //切割字符串
        $str = preg_replace('/\t\"([^\t]+?)\"\t/es', "'\t\"' . stripslashes(str_replace(\"\n\", \"\", '\\1')) . '\"\t'", $str);
        $csv_array = explode("\n", $str);
        unset($csv_array[count($csv_array) -1]);
        unset($csv_array[0]);
        if (!empty($csv_array)){
        	$product_array = array();
        	foreach ($csv_array as $k => $v){
        		if ($k > $this->product_batch_num){
        			break;
        		}
        		$tmp = explode("\t", $v);
        		//商品名称
        		$tmp['p_name'] = str_replace("'",'',str_replace('"','',$tmp[0]));
        		//库存
        		$tmp['p_storage'] = $tmp[9];
        		//商品价格
        		$tmp['p_price'] = number_format($tmp[7],2);
        		//568商品类型
        		switch ($value_array['radioType']){
        			case "5"://全新
	        			$tmp['radioType'] = 0;
	        			break;
        			case "6"://二手
	        			$tmp['radioType'] = 1;
	        			break;
        			case "8"://闲置
	        			$tmp['radioType'] = 2;
	        			break;
        			default:
        				$tmp['radioType'] = 0;
        		}
        		//交易类型
        		switch ($tmp[6]){
        			case "a"://拍卖
	        			$tmp['radioSelltype'] = 0;
	        			break;
        			case "b"://一口价
	        			$tmp['radioSelltype'] = 1;
	        			break;
        			case "c"://团购
	        			$tmp['radioSelltype'] = 2;
	        			break;
        			default:
        				$tmp['radioSelltype'] = 1;
        		}
        		//拍卖 加价设置
        		if ($tmp[8] == 0){//自动加价
        			$tmp['system_step'] = 1;
        			$tmp['price_step'] = 0;
        		}else {
        			$tmp['system_step'] = 0;
        			$tmp['price_step'] = $tmp[8];
        		}
        		//团购价格和团购数量
        		if ($tmp[27] != 0){//团购价
        			$tmp['group_price'] = $tmp[27];
        			$tmp['group_mincount'] = $tmp[28];
        		}
        		//运费
        		if ($tmp[11] == '2'){//卖家承担运费淘宝是2本站是0
        			$tmp['radioTransfee'] = '0';
        			$tmp['pyTF'] = '0.00';
        			$tmp['emsTF'] = '0.00';
        			$tmp['kdTF'] = '0.00';
        		}else {//买家承担都是1
        			$tmp['radioTransfee'] = '1';
        			$tmp['pyTF'] = $tmp[12]?number_format($tmp[12],2):'0.00';
        			$tmp['emsTF'] = $tmp[13]?number_format($tmp[13],2):'0.00';
        			$tmp['kdTF'] = $tmp[14]?number_format($tmp[14],2):'0.00';
        		}
        		//过滤商品详情
        		$tmp['p_info'] = str_replace("'",'',str_replace('"','',$tmp[24]));
        		//发票
        		$tmp['invoices'] = $tmp[17];
        		//保修
        		$tmp['warranty'] = $tmp[18];
				if(trim($tmp[35],'"') != ''){
					//图片，多图字符串
					$tmp['p_pic'] = trim($tmp[35],'"');
				}
        		$product_array[] = $tmp;
        	}
        }
        return $product_array;
	}


	/**
	 * 上传文件的商品入库
	 */
	function _upload_in(){
		if (!empty($this->_input['chboxPid'])){
			//判断权限
			//取当前会员信息
			//初始化会员类
			if (!is_object($this->obj_member)){
				require_once ("member.class.php");
				$this->obj_member = new MemberClass();
			}
			$condition['id'] = $_SESSION['s_login']['id'];
			$member_array = $this->obj_member->getMemberInfo($condition,'*','more');
			CheckPermission::memberGroupPermission('sell_num',$_SESSION['s_login']['id'],array('sell_num'=>count($this->_input['chboxPid'])+$member_array['sell_product_count']));

			//取商品编号
			$last_id = $this->obj_product->getProductLastId();
			
			foreach ($this->_input['chboxPid'] as $k => $v){
				$value_array = array();
				$value_array['p_name'] = $this->_input['p_name'][$k];
				$value_array['pc_id'] = $this->_input['searchcate'];
				$value_array['theme_id'] = $this->_input['shop_product_category'];
				$value_array['member_id'] = $_SESSION['s_login']['id'];
				//商品编号
				if('' == $last_id){
					$last_id = 1;
				}else{
					$last_id += 1;
				}
				$chars = array(
					"a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k",
					"l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v",
					"w", "x", "y", "z", "A", "B", "C", "D", "E", "F", "G",
					"H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R",
					"S", "T", "U", "V", "W", "X", "Y", "Z"
				);
				$value_array['p_code'] = md5($last_id.Common::genRandomString($chars, 4));
				$value_array['p_price'] = intval($this->_input['p_price'][$k])?intval($this->_input['p_price'][$k]):1;
				$value_array["p_point"] = 0;
				$value_array["p_view_num"] = 0;
				$value_array["p_valid_days"] = 7;
				$value_array["p_state"] = 0;
				$value_array["p_auto_publish"] = 0;
				
				$value_array['p_storage'] = intval($this->_input['p_storage'][$k])?intval($this->_input['p_storage'][$k]):1;
				$value_array['p_intro'] = str_replace("'",'',str_replace('"','',$this->_input['p_info'][$k]));
				//$this->_input['p_info'][$k];
				//$value_array['p_sell_type'] = 1;
				$value_array['p_sell_type'] = $this->_input['radioSelltype'][$k];
				$value_array['p_type'] = $this->_input['radioType'][$k];
				$value_array['p_group_price'] = $this->_input['group_price'][$k];
				$value_array['p_group_mincount'] = $this->_input['group_mincount'][$k];
				$value_array['p_system_step'] = $this->_input['system_step'][$k];
				$value_array['p_price_step'] = $this->_input['price_step'][$k];
//				$value_array['slProvince'] = $this->_input['txtProvince'];
//				$value_array['slCity'] = $this->_input['txtCity'];
				$value_array['p_transfee_charge'] = $this->_input['radioTransfee'][$k];
				$value_array['p_tf_py'] = $this->_input['pyTF'][$k];
				$value_array['p_tf_kd'] = $this->_input['kdTF'][$k];
				$value_array['p_tf_ems'] = $this->_input['emsTF'][$k];
				$value_array['p_have_invoices'] = $this->_input['invoices'][$k];
				$value_array['p_have_warranty'] = $this->_input['warranty'][$k];
				$value_array['p_recommended'] = 0;
				$value_array['p_pay_method'] = $this->_input['pay_method'];
				$value_array['p_currency_category'] = $this->_input['p_currency_category'];
				$value_array['p_area_id'] = $this->_input['area_id'];
				if($this->_input['p_pic'][$k] != ''){
					//分割图片字符串 取第一个为默认图，其他的插入 商品图片表
					$pic_array = $this->_get_p_pic($this->_input['p_pic'][$k]);
					$value_array['p_pic'] = $pic_array[0];
				}
				$this->obj_product->addProduct($value_array);
				//将图片内容入商品图片库
				if($this->_input['p_pic'][$k] != ''){
					$insert_pic = array();
					foreach($pic_array as $k_pic => $v_pic){
						if($v_pic != ''){
							$insert_pic['p_pic'] = $v_pic;
							$insert_pic['p_code'] = $value_array['p_code'];
							$this->obj_product->addProductPic($insert_pic);
							unset($insert_pic);
						}
					}
				}
				unset($value_array);
			}
			//图片上传页面
			@header("location: own_product_batch.php?action=upload_pic");
			exit;
			//$this->redirectPath("succ","member/own_product_list.php?action=listinstock",$this->_lang['langBatchSucc']);
		}else {
			$this->redirectPath("error","own_product_batch.php",$this->_lang['errBatchFileIsEmpty']);
		}
	}
	
	/**
	 * 分割图片字符串
	 *
	 * @param string $pic_string 图片字符串
	 * @return array 数组格式的返回内容
	 */
	function _get_p_pic($pic_string){
		if($pic_string == ''){
			return false;
		}
		$pic_array = explode(';',$pic_string);
		if(is_array($pic_array)){
			$line = '';
			foreach($pic_array as $k => $v){
				$line = explode(':',$v);//[0] 文件名tbi [2] 排序
				if($line[0] != ''){
					$array[] = $line[0];
				}
			}
			return $array;
		}else{
			return false;
		}
	}
	
	/**
	 * 商品上传 上传图片
	 *
	 * @return 输出模板
	 */
	function _upload_pic(){
		/**
		 * 页面输出
		 */
		$this->output('session_id',session_id());
		$this->showpage('own_product.batch_upload_pic');
	}

	/**
	 * 商品上传 上传图片 保存
	 *
	 * @param input  图片上传内容
	 * @return 输出模板
	 */
	function _upload_pic_save(){

		if (!is_object($this->obj_upload)){
			require_once("uploadfile.class.php");
			$this->obj_upload = new UploadFile();
			$this->obj_upload->allow_type = array('jpg','tbi');
		}
		//用于更新商品表和商品图片表中的内容
		$update_pic = substr($_FILES['Filedata']['name'],0,-4);
		//上传文件改名
		$_FILES['Filedata']['name'] = substr($_FILES['Filedata']['name'],0,-3).'jpg';
		//判断该图片是否在商品图片表中存在，如果不存在则说明商品没有使用该图，不继续上传
		$pic_condition['p_pic'] = $update_pic;
		$pic_result = $this->obj_product->getProductPic($pic_condition,$page);
		if(empty($pic_result)){
			echo 2;
			return false;
		}
		//上传商品图片
		$filename = $this->obj_upload->upfile('Filedata');

		/*按比例生成图片*/
		$cut = $this->_configinfo['productinfo']['imageresize_ifcut'];
		if ($filename !== false){
			
			//更新商品表和商品图片表中的内容
			$update_array = array();
			$update_array['update_pic'] = $filename['getfilename'];
			$update_array['p_pic'] = $update_pic;
			$update_array['member_id'] = $_SESSION['s_login']['id'];
			$this->obj_product->updateProductPicCSV($update_array);
			
			//加水印
			if ($this->_configinfo['gdimage']['wm_image_sign'] == 1 && file_exists(BasePath.'/'.$this->_configinfo['gdimage']['wm_image_name'])) {
				//图片名
				$return_name = $filename["getfilename"];
				require_once ("gdimage.class.php");
				$img = new GDImage();
				$img->wm_image_transition = $this->_configinfo['gdimage']['wm_image_transition'];//透明度
				$img->wm_image_pos = $this->_configinfo['gdimage']['wm_image_pos'];//位置
				$img->save_file = BasePath.'/'.$return_name;//返回文件名称
				$img->wm_image_name = BasePath.'/'.$this->_configinfo['gdimage']['wm_image_name'];//水印图片
				$img->create(BasePath.'/'.$return_name);
				unset($img);
			}
			include_once ('resizeImage.class.php');
			//判断图片大小
			$image_info = @getimagesize($filename['filename']);
			$width = $image_info[0];
			$height = $image_info[1];
			if ($width > $height){//用宽度
				$pic_param = $width;
				$small_percent = number_format($pic_param/$this->_configinfo['productinfo']['imageresize_width'],2);
			}else {//用高度
				$pic_param = $height;
				$small_percent = number_format($pic_param/$this->_configinfo['productinfo']['imageresize_height'],2);
			}
			//小图
			if (intval($small_percent) > 1){
				$obj_small = new resizeImage($filename['filename'],intval($width/$small_percent),intval($height/$small_percent),$cut);
			}elseif (intval($small_percent) == 1){
				//取与标准尺寸的差值
				$pic_percent = $small_percent;
				$pic_percent = ($pic_percent-1)>0.5?$pic_percent-1:(1-($pic_percent-1));
				$small_width = intval($width*($pic_percent));
				$small_height = intval($height*($pic_percent));
				$obj_small = new resizeImage($filename['filename'],$small_width,$small_height,$cut);
			}else {
				$obj_small = new resizeImage($filename['filename'],$width,$height,$cut);
			}
			//中图
			if (intval($pic_param/192) > 1){
				$obj_mid = new resizeImage($filename['filename'],intval($width/($pic_param/192)),intval($height/($pic_param/192)),$cut,"_mid.");
			}elseif (intval($pic_param/192) == 1){
				//取与标准尺寸的差值
				$pic_percent = number_format($pic_param/192,2);
				$pic_percent = ($pic_percent-1)>0.5?$pic_percent-1:(1-($pic_percent-1));
				$mid_width = intval($width*($pic_percent));
				$mid_height = intval($height*($pic_percent));
				$obj_mid = new resizeImage($filename['filename'],$mid_width,$mid_height,$cut,"_mid.");
			}else {
				$obj_mid = new resizeImage($filename['filename'],$width,$height,$cut,"_mid.");
			}
			//大图
			if (intval($pic_param/288) > 1){
				$obj_big = new resizeImage($filename['filename'],intval($width/($pic_param/288)),intval($height/($pic_param/288)),$cut,"_big.");
			}elseif (intval($pic_param/288) == 1){
				//取与标准尺寸的差值
				$pic_percent = number_format($pic_param/288,2);
				$pic_percent = ($pic_percent-1)>0.5?$pic_percent-1:(1-($pic_percent-1));
				$big_width = intval($width*($pic_percent));
				$big_height = intval($height*($pic_percent));
				$obj_big = new resizeImage($filename['filename'],$big_width,$big_height,$cut,"_big.");
			}else {
				$obj_big = new resizeImage($filename['filename'],$width,$height,$cut,"_big.");
			}
			echo 1;//抛出数据使flash继续运行
			unset($obj_small,$obj_mid,$obj_big);
		}
		
	}
	
	/**
	 * 导出CSV格式文件
	 */
	function _export(){
		//商品类别显示
		$parent_id = $this->_input['parent_id']?$this->_input['parent_id']:'0';
		$array = $this->obj_product_cate->listClassDetail('');
		if (is_array($array)){
			foreach ($array as $k => $v){
				//取子类别的信息
				if ($v[1] == $parent_id) {
					$ProductCateArray[] = $v;
				}
			}
		}
		//取类别导航
		if ($parent_id != '0'){
			$cate_path = $this->obj_product_cate->get_path($array, $parent_id);
		}
		//商品列表检索条件
		$condition['member'] = $_SESSION['s_login']['id'];//会员
		if ($this->_input['search_key'] != ''){//商品名 
			$condition['keygenre'] = 1;
			$key_array = @explode(' ',trim($this->_input['search_key']));
			$condition['key'] = $key_array;
		}
		if ($this->_input['search_price_start'] != ''){//价格下限
			$condition['price_min'] = $this->_input['search_price_start'];
		}
		if ($this->_input['search_price_end'] != ''){//价格上限
			$condition['price_max'] = $this->_input['search_price_end'];
		}
		if ($parent_id != '0'){
			$condition['search_cate'] = $parent_id;//商品类别
		}
		if ($this->_input['search_sell_type'] != ''){//买卖方式
			$condition['sell_type'] = $this->_input['search_sell_type'];
		}
		if ($this->_input['search_transfee_charge'] != ''){//运费由卖家支付
			$condition['tf_charge'] = $this->_input['search_transfee_charge'];
		}
		if ($this->_input['search_close_day'] > 0){//结束天数
			$condition['end_time'] = $this->_input['search_slCity'];
		}
		if ($this->_input['search_state'] != ''){//商品状态
			$condition['state'] = $this->_input['search_state'];
		}else {
			$condition['state'] = 'none';
		}
		if ($this->_input['search_sort'] != ''){//排序
			if ($this->_input['search_sort'] == 'price'){//时间 低->高
				$condition['order'] = '2';
				$condition['sorttype'] = '1';
			}else if ($this->_input['search_sort'] == 'time'){//按时间排序 新->旧
				$condition['order'] = '1';
				$condition['sorttype'] = '2';
			}
		}
		//商品列表
		$this->obj_page->pagebarnum(20);
		$product_array = $this->obj_product->getProductList($condition,$this->obj_page);
		$this->obj_page->new_style = true;
		$page_list = $this->obj_page->show('member');
		//销毁变量
		unset($array,$condition);
		/**
		 * 页面输出
		 */
		$this->output('ProductCateArray',$ProductCateArray);
		$this->output('parent_id',$parent_id);
		$this->output('cate_path',$cate_path);
		$this->output('product_array',$product_array);
		$this->output('page_list',$page_list);
		$this->output('input_param',$this->_input);
		$this->showpage('own_product.batch_export');
	}
	
	/**
	 * 导出文件
	 */
	function _export_upload(){
		//字段
		$field =  array('goods_name'=>'""', 'goods_class'=>0, 'shop_class'=>0, 'new_level'=>5, 'province'=>"", 'city'=>"", 'sell_type'=>'"b"', 'store_price'=>0, 'add_price'=>0, 'stock'=>0, 'die_day'=>14, 'load_type'=>1, 'post_express'=>0, 'ems'=>0, 'express'=>0, 'pay_type'=>2, 'allow_alipay'=>1, 'invoice'=>0, 'repair'=>0, 'resend'=>1, 'is_store'=>0, 'window'=>0, 'add_time'=>'"1980-1-1  0:00:00"', 'story'=>'""', 'goods_desc'=>'""', 'goods_img'=>'""', 'goods_attr'=>'""', 'group_buy'=>0, 'group_buy_num'=>0, 'template'=>0, 'discount'=>0, 'modify_time'=>'""', 'upload_status'=>100, 'img_status'=>0);
		if (is_array($this->_input['chboxPid'])){
			//导入商品内容
			$product_array = array();
			foreach ($this->_input['chboxPid'] as $k => $v){
				if ($v != ''){
					$field_array = $field;//字段
					$array = $this->obj_product->getProductRow($v);
					if (!empty($array)){
						$field_array['goods_name'] = $array['p_name'];
						switch ($array['p_sell_type']){
							case '0':
								$field_array['sell_type'] = 'a';
								break;
							case '1':
								$field_array['sell_type'] = 'b';
								break;
							case '2'://团购，淘宝目前没有团购了
								$field_array['sell_type'] = 'b';
								break;
						}
						$field_array['store_price'] = $array['p_price'];
						if ($array['p_price_step'] > 0){
							$field_array['add_price'] = $array['p_price_step'];
						}
						$field_array['stock'] = $array['p_storage'];
						if ($array['p_transfee_charge'] == '1'){
		        			$field_array['load_type'] = '1';
		        			$field_array['post_express'] = $array['p_tf_py'];
		        			$field_array['ems'] = $array['p_tf_kd'];
		        			$field_array['express'] = $array['p_tf_ems'];
		        		}else {
		        			$field_array['load_type'] = '2';
		        		}
		        		if ($array['p_have_invoices'] == '1'){
		        			$field_array['invoice'] = '1';
		        		}
		        		if ($array['p_have_warranty'] == '1'){
		        			$field_array['repair'] = '1';
		        		}
		        		$field_array['goods_desc'] = str_replace("'",'',str_replace('"','',$array['p_intro']));
		        		$product_array[] = $field_array;
					}
					unset($array,$field_array);
				}
			}
			
			/**
			 *  生成文件
			 */
			header("Content-Disposition: attachment; filename=product.csv");
        	header("Content-Type: application/unknown");
			$str = "";
	        foreach ($this->_b_config['csv_taobao'] as $key=>$val){
	            $str .= $val . "\t";
	        }
	        $str = preg_replace("/\t$/", "\n", $str);
	        if (strtoupper($cache_config['websit']['ncharset']) == 'GBK'){
	        	$str = Common::nc_change_charset($str,'gbk_to_utf8');
	        }
	        echo "\xFF\xFE" . Common::utf2uni($str);
			if (!empty($product_array)){
				foreach ($product_array as $k => $v){
					$line = implode("\t", $v) . "\n";
					if (strtoupper($cache_config['websit']['ncharset']) == 'GBK'){
			        	$line = Common::nc_change_charset($line,'gbk_to_utf8');
			        }
			        echo Common::utf2uni($line);
				}
			}
			exit;
		}else {
			$this->redirectPath("error","",$this->_lang['langBatchProductIsEmpty']);
		}
	}
}

$product_batch = new OwnProductBatch();
$product_batch->main();
unset($product_batch);
?>