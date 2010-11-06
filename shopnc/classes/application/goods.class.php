<?php
/////////////////////////////////////////////////////////////////////////////
// 这个文件是 网城创想单用户商城 项目的一部分
//
// Copyright (c) 2007 - 2008 www.shopnc.net
//
// 要查看完整的版权信息和许可信息，请查看源代码中附带的 COPYRIGHT 文件，
// 或者访问 http://www.shopnc.net/ 获得详细信息。
/////////////////////////////////////////////////////////////////////////////

/**
 * FILE_NAME : goods.class.php   FILE_PATH : \shopnc6\classes\application\goods.class.php
 * 商品应用类
 *
 * @copyright Copyright (c) 2007 - 2008 www.shopnc.net 
 * @author ShopNC Develop Team 
 * @package 
 * @subpackage 
 * @version Fri Jun 17 13:36:13 CST 2008
 */

class GoodsClass extends DataBase {
	/**
	 * 添加新的商品
	 *
	 * @param var[] $input_param 商品信息，一维数组
	 * @return bool
	 */
	function addGoods($input_param){
		try {
			$goods_array = array();
			$goods_array['goods_name']			= trim($input_param['txt_goods_name']);				//商品名称
			$goods_array['goods_bn']			= trim($input_param['txt_goods_bn']);				//商品编号
			$goods_array['class_id']			= intval($input_param['txt_class_id']);				//商品类别id
			$goods_array['brand_id']			= intval($input_param['txt_brand_id']);				//商品品牌id
			$goods_array['subject_id']			= intval($input_param['txt_subject_id']);			//商品品牌id
			$goods_array['goods_price']			= floatval($input_param['txt_goods_price']);		//市场价格
			$goods_array['goods_pricedesc']		= floatval($input_param['txt_goods_pricedesc']);	//网店价格
			$goods_array['goods_provider_price']= floatval($input_param['txt_goods_provider_price']);//供应商供货价格
			$goods_array['goods_storage']		= intval($input_param['txt_goods_storage']);		//商品库存
			$goods_array['goods_weight']		= intval($input_param['txt_goods_weight']);			//商品重量
			$goods_array['goods_color']			= trim($input_param['txt_goods_color']);			//商品颜色
			$goods_array['goods_size']			= trim($input_param['txt_goods_size']);				//商品规格
			$goods_array['goods_alarm_num']		= intval($input_param['txt_goods_alarm_num']);		//库存警告数量
			$goods_array['goods_alarm_text']	= trim($input_param['txt_goods_alarm_text']);		//库存警告内容
			$goods_array['goods_unit']			= trim($input_param['txt_goods_unit']);				//重量单位
			$goods_array['goods_click']			= intval($input_param['txt_goods_click']);			//商品浏览量
			$goods_array['provider_id']			= intval($input_param['txt_provider_id']);			//供应商id
			$goods_array['goods_image']			= trim($input_param['txt_goods_image']);			//商品图片
			$goods_array['goods_small_image']	= trim($input_param['txt_goods_small_image']);		//商品缩微图片
			$goods_array['goods_keywords']		= trim($input_param['txt_goods_keywords']);			//商品关键字
			$goods_array['goods_description']	= trim($input_param['txt_goods_description']);		//商品描述
			$goods_array['goods_body']			= trim($input_param['txt_goods_body']);				//商品详细介绍
			$goods_array['goods_add_time']		= time();											//商品添加时间
			$goods_array['goods_state']			= intval($input_param['txt_goods_state']);			//商品状态0、发布1、未发布2、删除
			$goods_array['goods_hot']			= intval($input_param['txt_goods_hot']);			//是否热卖
			$goods_array['goods_commend']		= intval($input_param['txt_goods_commend']);		//是否推荐
			$goods_array['goods_special']		= intval($input_param['txt_goods_special']);		//是否特价
			$goods_array['goods_attr_body']		= trim($input_param['txt_goods_attr_body']);		//商品属性
			$goods_array['goods_link_goods']	= trim($input_param['txt_goods_link_goods']);		//链接商品
			$goods_array['goods_link_article']	= trim($input_param['txt_goods_link_article']);		//链接文章


			$insert_rs = $this->InsertRow($goods_array, 'goods', 'goods_id');

			/*商品多图存在时，多图处理*/
			$insert_id	= mysql_insert_id();
			$array	= array(
			'goods_image_title'	=>$input_param['txt_goods_image_title'],
			'goods_image'		=>$input_param['more_goods_image'],
			'goods_image_small'	=>$input_param['txt_goods_image_small']);
			$insert_more_img = $this->addMoreImage($array,$insert_id);

			if ($insert_rs and $insert_more_img){
				/*扩展分类添加*/
				$this->goods_more_class_save($input_param['other_class'],$insert_id);

				return true;
			}
			else {
				return false;
			}
		}
		catch (Exception $e){
			return false;
		}

	}
	/**
	 * 逻辑删除商品
	 *
	 * @param array $goods_id_array
	 * @return true
	 */
	function logicDelGoods($goods_id_array){
		try {
			if(is_array($goods_id_array)){
				foreach ($goods_id_array as $goods_id){
					$goods_array['goods_state'] = 2;
					$this->UpdateRow($goods_id,$goods_array,"goods","goods_id");
				}
			}
			else {
				$goods_array['goods_state'] = 2;
				$this->UpdateRow($goods_id_array,$goods_array,"goods","goods_id");
			}
			return true;
		}
		catch (Exception $e){
			return false;
		}
	}

	/**
	 * 物理删除商品   
	 * @param  
	 * @return bool
	 */
	function delGoods($input_param,$filed){
		try {
			include('goodsComments.class.php');
			$comment_class	= new GoodsCommentsClass();

			if(is_array($input_param) && !empty($input_param)) {
				if(count($input_param)>0) {
					foreach ($input_param as $v) {
						if(intval($v) == 0) return false;
						$array['goods_id']	= intval($v);
						$array['goods_state']= 2;
						$goods_array = $this->getGoodsInfo($array);
						if($goods_array['goods_image']!='' && $goods_array['goods_image']!='default.jpg') {
							$image_info	= explode('.',$goods_array['goods_image']);
							@unlink(BasePath."/".$goods_array['goods_image']);
							@unlink(BasePath."/".$goods_array['goods_small_image']);
							@unlink(BasePath."/".$image_info[0]."_source.".$image_info[1]);
						}
						$this->delGoodsImage($array['goods_id']);//删除产品多图
						$comment_class->delCommentClass($array['goods_id'],'goods_id');//删除留言
						unset($array);
					}
				}
			} else {
				$array['goods_id']	= intval($input_param);
				$array['goods_state']= 2;
				if($array['goods_id'] == 0) return false;
				$goods_array = $this->getGoodsInfo($array);
				if($goods_array['goods_image']!='' && $goods_array['goods_image']!='default.jpg') {
					$image_info	= explode('.',$goods_array['goods_image']);
					@unlink(BasePath."/".$goods_array['goods_image']);
					@unlink(BasePath."/".$goods_array['goods_small_image']);
					@unlink(BasePath."/".$image_info[0]."_source.".$image_info[1]);
				}
				$this->delGoodsImage($array['goods_id']);//删除产品多图
				$comment_class->delCommentClass($array['goods_id'],'goods_id');//删除留言
			}
			//得到条件语句
			$rs = $this->DelRow($input_param,"goods",$filed);
			if ($rs) {
				return true;
			}
			else {
				return false;
			}
		}
		catch (Exception $e){
			return false;
		}
	}
	/**
	 * 删除商品多图
	 *
	 * @param	int	$id
	 * @return	bool
	 */
	function delGoodsImage($id,$type='goods_id') {
		$image_array	= array();
		$where_sql		= $type == 'goods_id' ? "WHERE goods_image.goods_id=".$id : "WHERE goods_image.goods_image_id=".$id;
		$input_param	= array($type=>$id);
		$image_array	= $this->GetList($where_sql,'','goods_image');
		if(is_array($image_array) and count($image_array)>0) {
			foreach ($image_array as $val) {
				$image_info	= explode('.',$val['goods_image']);
				@unlink(BasePath."/".$val['goods_image']);
				@unlink(BasePath."/".$val['goods_image_small']);
				@unlink(BasePath."/".$image_info[0]."_source.".$image_info[1]);
			}
		}
		$rs = $this->DelRow($input_param,"goods_image",$type);
		return $rs;
	}
	/**
	 * 商品还原   
	 * @param  array $input_param
	 * @return bool
	 */
	function reductGoods($input_param) {
		try {
			if(is_array($input_param['goods_id_array']) and count($input_param['goods_id_array'])>0 and $input_param['goods_id_array'][0]!='') {
				$where = " goods_id in (".implode(',',$input_param['goods_id_array']).")";
				$goods_array['goods_state']	= 1;
				$update_goods = $this->UpdateRows('goods',$goods_array,$where);
			}
			if($update_goods) {
				return true;
			} else {
				return false;
			}
		} catch (Exception $e) {
			return false;
		}
	}
	/**
	 * 修改商品
	 *
	 * @param var[] $input_param 商品分类信息
	 * @param int $modify_id 商品分类id
	 * @param string $parma 需要修改的字段
	 * @param string $filed 查询的条件字段
	 * @return bool
	 */
	function modifyGoods($input_param,$modify_id,$parma="all",$filed="goods_id"){
		try {
			if ($parma == "all") {
				$goods_array = array();
				$goods_array['goods_name']			= trim($input_param['txt_goods_name']);          		//商品名称
				$goods_array['goods_bn']			= trim($input_param['txt_goods_bn']);            		//商品编号
				$goods_array['class_id']			= intval($input_param['txt_class_id']);         		//商品类别id
				$goods_array['brand_id']			= intval($input_param['txt_brand_id']);         		//商品品牌id
				$goods_array['subject_id']			= intval($input_param['txt_subject_id']);       		//商品品牌id
				$goods_array['goods_price']			= floatval($input_param['txt_goods_price']);     		//市场价格
				$goods_array['goods_pricedesc']		= floatval($input_param['txt_goods_pricedesc']); 		//网店价格
				$goods_array['goods_provider_price']= floatval($input_param['txt_goods_provider_price']); 	//供应商供货价格
				$goods_array['goods_storage']		= intval($input_param['txt_goods_storage']);     		//商品库存
				$goods_array['goods_weight']		= intval($input_param['txt_goods_weight']);      		//商品重量
				$goods_array['goods_color']			= trim($input_param['txt_goods_color']);			//商品颜色
				$goods_array['goods_size']			= trim($input_param['txt_goods_size']);				//商品规格
				$goods_array['goods_alarm_num']   	= intval($input_param['txt_goods_alarm_num']);   		//库存警告数量
				$goods_array['goods_alarm_text']  	= trim($input_param['txt_goods_alarm_text']);  			//库存警告内容
				$goods_array['goods_unit']        	= trim($input_param['txt_goods_unit']);          		//重量单位
				$goods_array['goods_click']       	= intval($input_param['txt_goods_click']);       		//商品浏览量
				$goods_array['provider_id']      	= intval($input_param['txt_provider_id']);      		//供应商id
				$goods_array['goods_image']       	= trim($input_param['txt_goods_image']);         		//商品图片
				$goods_array['goods_small_image'] 	= trim($input_param['txt_goods_small_image']);   		//商品缩微图片
				$goods_array['goods_keywords']    	= trim($input_param['txt_goods_keywords']);      		//商品关键字
				$goods_array['goods_description'] 	= trim($input_param['txt_goods_description']);   		//商品描述
				$goods_array['goods_body']			= trim($input_param['txt_goods_body']);          		//商品详细介绍
				$goods_array['goods_state']       	= intval($input_param['txt_goods_state']);       		//商品状态0、发布1、未发布2、删除
				$goods_array['goods_hot']         	= intval($input_param['txt_goods_hot']);         		//是否热卖
				$goods_array['goods_commend']     	= intval($input_param['txt_goods_commend']);     		//是否推荐
				$goods_array['goods_special']     	= intval($input_param['txt_goods_special']);     		//是否特价
				$goods_array['goods_attr_body']   	= trim($input_param['txt_goods_attr_body']);   			//商品属性
				$goods_array['goods_link_goods']   	= trim($input_param['txt_goods_link_goods']);			//链接商品
				$goods_array['goods_link_article'] 	= trim($input_param['txt_goods_link_article']);			//链接文章

				$update_rs = $this->UpdateRow($modify_id,$goods_array,"goods",$filed);
				/*商品多图存在时，多图处理*/
				$array	= array(
				'goods_image_title'	=>$input_param['txt_goods_image_title'],
				'goods_image'		=>$input_param['more_goods_image'],
				'goods_image_small'	=>$input_param['txt_goods_image_small'],
				'goods_image_update'=>$input_param['goods_image_update'],
				'del_more_pic'		=>$input_param['del_more_pic'],
				'goods_image_id'	=>$modify_id);

				$this->addMoreImage($array,$modify_id);
			}
			else {
				$goods_array[$parma]=$input_param;
				$update_rs = $this->UpdateRow($modify_id,$goods_array,"goods",$filed);
			}
		}
		catch (Exception $e){
			return false;
		}
		/*扩展分类添加*/
		$this->goods_more_class_save($input_param['other_class'],$modify_id);

		return $update_rs;
	}
	/**
	 * 得到某商品的资料
	 *
	 * @param var[] $conditon  查询条件，一维数组形式
	 * @param string $field   所需要的字段名称
	 * @return var[]
	 */
	function getGoodsInfo($condition,$field = "*",$goods_more_class=false){
		try {
			//得到条件语句
			$condition_str = $this->getCondition($condition);
			$goods_array = $this->GetTheRow($condition_str,'goods',$field);
			/*扩展分类信息*/
			if($goods_more_class == true) {
				$goods_array['class_ext']	= $this->GetList("WHERE goods_id=".$goods_array['goods_id'],'','goods_more_class');
			}

			return $goods_array;
		}
		catch (Exception $e){
			return false;
		}
	}
	/**
	 * 得到某商品的多图
	 *
	 * @param string $id   所需要的id值
	 * @return var[]
	 */
	function getGoodsImage($id){
		$array	= array();
		if(intval($id)>0) {
			$where	= "where goods_id=".$id;
			/*获得完整sql语句，将查询值赋值给数组*/
			$sql	= $this->GetSql('goods_image',$where);
			$array	= $this->GetArray($sql);
		} elseif ($id == 'all') {
			$sql	= $this->GetSql('goods_image');
			$array	= $this->GetArray($sql);
		}
		return $array;
	}
	/**
	 * 获得商品记录数据，二维数组
	 *
	 * @param var[] $condition 查询条件，一维数组形式
	 * @param object $obj_page 分页对象，根据此对象获取相应的记录
	 * @param var $field 所需要的字段名称
	 * @return var[]
	 * 
	 */
	function getGoodsList($condition,$obj_page,$order_array = array(),$group_array = array(),$count=0){
		/*得到当前分类及和它有联系的下n级分类的id，实现想法，首先不使用递归实现，给定的$array数组里给
		*出来分类的class_id(分类id）,class_top_id（父级id）,key_id（键值），引入分类数组，从给定
		*数组的键值（key_id）开始向下查找相关联数组，当父级id为0或是和给定数组的父级id相同时停止
		*/
		if(is_array($condition) and count($condition)>0 and count($condition['sub_class1'])>0) {
			$sub_class	= '';
			include BasePath."/share/goods_class_show.php";
			for($i=($condition['sub_class1']['key_id']+1);$i<count($node_cache);$i++) {
				if($condition['sub_class1']['class_top_id'] == 0) {
					if($node_cache[$i][1] == 0) break;
					$sub_class .= $node_cache[$i][0].",";
				} else {
					if($condition['sub_class1']['class_top_id'] == $node_cache[$i][1] or $node_cache[$i][1] == 0) break;
					$sub_class .= $node_cache[$i][0].",";
				}
			}
			$condition['sub_class'] = $sub_class;
		}
		//得到条件语句
		if(count($condition)>0) {
			$condition_str = $this->getCondition($condition);
		} else {
			$condition_str = "and goods.goods_state=1";
		}
		//得到商品基本表中符合要求的数据
		$field = array('*','class_id,class_name');

		$goods_array = $this->GetJoinList($obj_page,
		array('goods','goods_class'),
		'inner join',
		array('goods.class_id = goods_class.class_id'),
		$field,
		$condition_str,
		$count,
		$order_array,
		$group_array);
		return $goods_array;
	}

	/**
 	* 保存商品多图
 	*
 	* @param array $array	多图信息，数组
 	* @param int $id	商品id
 	* @return bool
 	*/
	function addMoreImage($array,$id) {
		$image_array	= array();
		if(is_array($array['goods_image_small']) and count($array['goods_image_small'])>0) {
			//for($i=1;$i<=count($array['goods_image_small']);$i++) {
			foreach ($array['goods_image_small'] as $i => $val) {
				if(intval($array['del_more_pic'][$i]) != 0) {
					$this->delGoodsImage(intval($array['del_more_pic'][$i]),'goods_image_id');
					continue;
				}

				$image_array['goods_id']				= $id;
				$image_array['goods_image_title']	= trim($array['goods_image_title'][$i]);
				$image_array['goods_image']			= $array['goods_image'][$i];
				$image_array['goods_image_small']	= $array['goods_image_small'][$i];
				if ($array['goods_image_update'][$i]) {
					$this->UpdateRow($array['goods_image_id'][$i],$image_array,'goods_image','goods_image_id');
				} else {
					$this->InsertRow($image_array, 'goods_image', 'goods_image_id');
				}
				$image_array	= array();
			}
		}
		return true;
	}
	/**
 	* 移动商品
 	*
 	*/	
	function moveGoods($input_param,$condition) {
		try {
			//得到条件语句
			$condition_str = $this->getCondition($condition);
			$update_rs = $this->UpdateRows('goods', $input_param,$condition_str);
		}
		catch (Exception $e) {
			return false;
		}
		return true;
	}
	/**
 	* ajax搜索
 	*
 	* @param string[] $array
 	* @return array[]
 	*/
	function ajaxGoodsSearch($condition,$fields='goods_id,goods_name,goods_small_image') {
		if(is_array($condition['class_array']['sub_class1']) and count($condition['class_array']['sub_class1'])>0) {
			$sub_class	= '';
			include BasePath."/share/goods_class_show.php";
			for($i=($condition['class_array']['sub_class1']['key_id']+1);$i<count($node_cache);$i++) {
				if($condition['class_array']['sub_class1']['class_top_id'] == 0) {
					if($node_cache[$i][1] == 0) break;
					$sub_class .= $node_cache[$i][0].",";
				} else {
					if($condition['class_array']['sub_class1']['class_top_id'] == $node_cache[$i][1] or $node_cache[$i][1] == 0) break;
					$sub_class .= $node_cache[$i][0].",";
				}
			}
			$condition['sub_class'] = $sub_class;
			$condition['class_id']	= $condition['class_array']['sub_class1']['class_id'];
		}

		//得到条件语句
		if(count($condition)>0) {
			$condition_str = $this->getCondition($condition);
		}
		$condition_str		= $condition_str =='' ? ' and goods_state=1' : $condition_str;
		
		$sql	= $this->GetSql('goods',$condition_str,$fields);

		$goods_array	= $this->GetArray($sql);
		return $goods_array;
	}
	/**
 	* ajax更新商品状态
 	*
 	*/
	function ajaxUpdate($array) {
		$goods_array		= array();
		$goods_array[$array['ajax_type']]	= $array['old_state'] == 1 ? "0" : "1";

		$update_rs = $this->UpdateRow($array['goods_id'],$goods_array,"goods",'goods_id');
		if($update_rs) {
			return $goods_array[$array['ajax_type']];
		}
	}
	/**
 	* ajax删除商品缩微图
 	*
 	*/
	function ajaxDelGoodsPic($goods_id) {
		$goods_info		= $this->getGoodsInfo(array('goods_id'=>intval($goods_id)));

		$image_info	= explode('.',$goods_info['goods_image']);
		@unlink(BasePath."/".$goods_info['goods_image']);
		@unlink(BasePath."/".$goods_info['goods_small_image']);
		@unlink(BasePath."/".$image_info[0]."_source.".$image_info[1]);

		$this->UpdateRow($goods_id,array('goods_image'=>'','goods_small_image'=>''),"goods",'goods_id');
		echo 1;
	}
	/**
	 * 添加扩展分类
	 *
	 * @param array		$array
	 * @param string	$goods_id
	 * 
	 */
	function goods_more_class_save($array,$goods_id='') {
		if(is_array($array) and count($array)>0) {
			$more_array		= array();
			$this->DelRow($goods_id,"goods_more_class","goods_id");
			foreach ($array as $v) {
				if($v != 0) {
					$more_array['class_id'] 	= $v;
					$more_array['goods_id']		= $goods_id;
					$this->InsertRow($more_array, 'goods_more_class', 'goods_id');
					$more_array	= array();
				}
			}
		}
	}
	/**
	 * 将条件数组组合为SQL语句的条件部分
	 *
	 * @param var[] $condition_array
	 * @return string
	 */
	function getCondition($condition_array){
		$condition_sql = "";
		if (intval($condition_array['no_state']) != "" ) {
			if($condition_array['no_state'] == 2) {
				$condition_sql .= " and goods.goods_state<>".$condition_array['no_state'];
			} else {
				$condition_sql .= " and goods.goods_state=2";
			}
		}
		if ($condition_array['state'] != "") {
			$condition_sql .= " and goods.goods_state = ".intval($condition_array['state']);
		}
		if (intval($condition_array['goods_id']) !="") {
			$condition_sql .= " and goods.goods_id = ".$condition_array['goods_id'];
		}
		if ($condition_array['class_id'] != "") {
			$condition_sql .= " and goods.class_id in (".$condition_array['sub_class'].$condition_array['class_id'].")";
		}
		if ($condition_array['brand_id'] != "") {
			$condition_sql .= " and goods.brand_id=".$condition_array['brand_id'];
		}
		if ($condition_array['provider_id'] != "") {
			$condition_sql .= " and goods.provider_id=".$condition_array['provider_id'];
		}
		if ($condition_array['subject_id'] != "") {
			$condition_sql .= " and goods.subject_id=".$condition_array['subject_id'];
		}
		if ($condition_array['goods_name'] != "") {
			$condition_sql .= " and goods.goods_name like '%".$condition_array['goods_name']."%'";
		}
		if ($condition_array['more_id'] != "") {
			$condition_sql	.= " class_id IN (".$condition_array['more_id'].")";
		}
		/*用于ajax查找商品时使用（相关商品查找）*/
		if($condition_array['search_class_id'] != '' or $condition_array['goods_keywords'] != '' or $condition_array['goods_id_str'] != '') {
			$condition_sql	.= $condition_array['search_class_id'] != ''?"and class_id=".$condition_array['search_class_id']:'';
			$condition_sql	.= $condition_array['goods_keywords'] != ''?"and goods_name like '%".$condition_array['goods_keywords']."%'":'';
			$condition_sql	.= $condition_array['goods_id_str'] != ''?" or goods_id in (".$condition_array['goods_id_str'].")".(($condition_array['class_id']!= '' and $condition_array['goods_keywords']!='') ? '' :' and 1=1'):'';
			if($condition_array['other_action'] == '' and $condition_array['goods_keywords']=='') {
				$condition_sql	.= " or 1=1";
			}
			$condition_sql	= (substr($condition_sql,1,2) =='or' ? "and ".substr($condition_sql,4) :$condition_sql)." and goods_state=1";
		}
		if($condition_array['admin_provider_id'] != '') {
			$condition_sql	.= " and goods.provider_id!=0";
		}
		return $condition_sql;
	}

}
?>