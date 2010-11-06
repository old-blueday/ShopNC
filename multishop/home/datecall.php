<?php
/////////////////////////////////////////////////////////////////////////////
// 此文件是 ShopNC多用户商城 的一部分
//
// Copyright (c) 2007 - 2010 www.shopnc.net
//
// 要查看完整的版权信息和许可信息，请查看源代码中附带的 COPYRIGHT 文件，
// 或者访问 http://www.shopnc.net/ 获得详细信息。
/////////////////////////////////////////////////////////////////////////////

/**
 * FILE_NAME : datecall.php   FILE_PATH : \multishop\home\datecall.php
 * ....数据调用入口文件
 *
 * @copyright Copyright (c) 2007 - 2010 www.shopnc.net 
 * @author ShopNC Develop Team 
 * @package 
 * @subpackage 
 * @version Wed Aug 08 13:42:53 CST 2007
 */

require ("../global.inc.php");

class DatecallManage extends CommonFrameWork {
	/**
	 * 调用对象
	 * 
	 * @var obj
	 */
	var $obj_datecall;

	function main(){
		/**
		 * 创建调用对象
		 */
		if (!is_object($this->obj_datecall)) {
			require_once('product_datecall.class.php');
			$this->obj_datecall = new ProductDatecallClass();
		}
		/**
		 * 语言包
		 */
		$this->getlang("sys_product_datecall.manage");

		switch ($this->_input['action']){
			default:
				$this->_datecall_output();
		}
	}

	/**
	 * 调用输出
	 */
	function _datecall_output(){
		if (intval($this->_input['pd_id']) > 0) {
			//根据ID取调用记录
			$datecall_array = $this->obj_datecall->getDatecall($this->_input['pd_id']);

			//创建商品对象
			if (!is_object($obj_product)) {
				require_once('product.class.php');
				$obj_product = new ProductClass();
			}

			//根据查询条件取商品
			if ($datecall_array['condition_p_cate'] != '' && intval($datecall_array['condition_p_cate']) > 0) {
				$condition['search_cate'] = $datecall_array['condition_p_cate'];
			}
			if ($datecall_array['condition_price_left'] != '') {
				$condition['price_min'] = $datecall_array['condition_price_left'];
			}
			if ($datecall_array['condition_price_right'] != '') {
				$condition['price_max'] = $datecall_array['condition_price_right'];
			}
			if ($datecall_array['condition_keyword'] != '') {
				$condition['key'] = $datecall_array['condition_keyword'];
			}
			if ($datecall_array['condition_sort'] != '') {
				$condition['sorttype'] = $datecall_array['condition_sort'];
			}
			if ($datecall_array['datecall_num'] != '') {
				$condition['limit_num'] = $datecall_array['datecall_num'];
			}
			$product_list = $obj_product->getProductList($condition,$page);

			//整理商品信息，截取商品名称，判断是否存在商品静态页
			if ($datecall_array['p_name_size'] != '') {
				if (is_array($product_list)){
					$charset = $datecall_array['charset'] == 0 ? 'UTF-8' : 'GBK';
					foreach ($product_list as $k => $v){
						$product_list[$k]['cut_p_name'] = Char_class::cut_str($product_list[$k]['p_name'],$datecall_array['p_name_size'],0,$charset);
						$product_list[$k] = $obj_product->checkOneProductIfHtml($product_list[$k],$this->_configinfo['productinfo']['ifhtml']);
					}
				}
			}

			$datecall_array['templates_head'] = str_replace("\"","\\\"",$datecall_array['templates_head']);
			$datecall_array['templates_head'] = preg_replace("((\r\n)+)", '', $datecall_array['templates_head']);
			$datecall_array['templates_connect'] = str_replace("\"","\\\"",$datecall_array['templates_connect']);
			$datecall_array['templates_connect'] = preg_replace("((\r\n)+)", '', $datecall_array['templates_connect']);
			$datecall_array['templates_footer'] = str_replace("\"","\\\"",$datecall_array['templates_footer']);
			$datecall_array['templates_footer'] = preg_replace("((\r\n)+)", '', $datecall_array['templates_footer']);

			//模板变量array
			$variable_arr = array(
			'{product_pic_url}' => 'p_pic',         //商品图片链接地址
			'{product_url}' => 'product_url',       //商品链接地址
			'{product_full_name}' => 'p_name',      //商品全称
			'{product_name}' => 'product_name',     //截取后的商品名称
			'{product_price}' => 'p_price',         //商品单价
			'{img_url}' => 'img_url'          		//图片链接
			);

			if (is_array($product_list)) {
				for ($i=0;$i<count($product_list);$i++){
					$templates_connect = $datecall_array['templates_connect'];
					$line .=  "document.write(\"";
					$line .= $datecall_array['templates_head'];
					//取模板内容中所用到的模板变量并赋值
					foreach ($variable_arr as $key => $val){
						$str = strstr($templates_connect,$key);
						if ($str != '') {
							if ($val == 'product_url') {
								//检查是否开启商品静态
								if ($this->_configinfo['productinfo']['ifhtml'] == 1) {
									$product_list[$i] = $obj_product->checkOneProductIfHtml($product_list[$i],1);
								}
								$url = $product_list[$i]['html_url'] != '' ? $product_list[$i]['html_url'] : $this->_configinfo['websit']['site_url'] . '/home/product.php?action=view&pid=' . $product_list[$i]['p_code'];															
								$templates_connect = str_replace($key,$url,$templates_connect);
							}elseif ($val == 'product_name') {
								$templates_connect = str_replace($key,$product_list[$i]['cut_p_name'],$templates_connect);
							}elseif ($val == 'p_pic') {
								$product_pic_ex = array();
								if ($product_list[$i]['p_pic'] != '' && $product_list[$i]['p_pic'] != 'null') {
									$product_pic_ex = explode(".",$product_list[$i]['p_pic']);
								}
								$p_pic_url = $product_pic_ex ? $this->_configinfo['websit']['site_url'] . '/' . $product_pic_ex[0]."_small.".$product_pic_ex[1] : $this->_configinfo['websit']['site_url'] . '/templates/' . $this->_configinfo['websit']['templatesname'] . '/images/noimgs.gif';								
								$templates_connect = str_replace($key,$p_pic_url,$templates_connect);
							}elseif ($val == 'img_url') {
								//检查是否开启商品静态
								if ($this->_configinfo['productinfo']['ifhtml'] == 1) {
									$product_list[$i] = $obj_product->checkOneProductIfHtml($product_list[$i],1);
								}
								$img_url = $product_list[$i]['html_url'] != '' ? $product_list[$i]['html_url'] : $this->_configinfo['websit']['site_url'] . '/home/product.php?action=view&pid=' . $product_list[$i]['p_code'];								
								$templates_connect = str_replace($key,$img_url,$templates_connect);								
							}else {
								$templates_connect = str_replace($key,$product_list[$i][$val],$templates_connect);
							}
						}
					}
					$line .= $templates_connect;
					$line .= $datecall_array['templates_footer'];
					$line .= "\");";
				}
				echo $line;
				unset($condition,$datecall_array,$variable_arr,$product_list,$line);
				exit;
			}
		}else {
			$this->redirectPath('error','',$this->_lang['langSysPDatecallIdNullErr'],1);
		}
	}
}
$datecall = new DatecallManage();
$datecall->main();
unset($datecall);
?>