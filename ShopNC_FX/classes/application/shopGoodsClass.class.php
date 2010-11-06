<?php
/////////////////////////////////////////////////////////////////////////////
// 这个文件是 网城创想分销王系统 项目的一部分
//
// Copyright (c) 2007 - 2009 www.shopnc.net 
//
// 要查看完整的版权信息和许可信息，请查看源代码中附带的 COPYRIGHT 文件，
// 或者访问 http://www.shopnc.net/ 获得详细信息。
/////////////////////////////////////////////////////////////////////////////

/**
* FILE_NAME : shopGoodsClass.class.php D:\root\shopnc6_jh\classes\application\shopGoodsClass.class.php
* 商品分类应用类
*
* @copyright Copyright (c) 2007 - 2009 www.shopnc.net 
* @author 网城创想分销王系统开发团队 php_netproject@yahoo.com.cn
* @package 
* @subpackage 
* @version Sat Jul 04 10:07:22 CST 2009
*/
class ShopGoodsClassClass extends DataBase {
	/**
	 * 添加新的商品分类
	 *
	 * @param var[] $input_param 商品分类信息，一维数组
	 * @return var
	 */
	function addGoodsClass($input_param){
		try {
			$goods_class_array = array();
			$goods_class_array['class_top_id']      = $input_param['txt_class_top_id'];      //父级分类id
			$goods_class_array['class_name']        = $input_param['txt_class_name'];        //分类名称
			$goods_class_array['class_state']       = $input_param['txt_class_state'];       //分类状态0、开启1、关闭
			$goods_class_array['class_keywords']    = $input_param['txt_class_keywords'];    //分类关键字
			$goods_class_array['class_description'] = $input_param['txt_class_description']; //分类描述
			$goods_class_array['class_sort']        = $input_param['txt_class_sort'];        //分类排序
			$goods_class_array['class_language']    = $input_param['txt_class_language'];    //分类语言显示
			$goods_class_array['class_url']         = $input_param['txt_class_url'];         //分类指向的url外联
			$goods_class_array['class_language']    = $input_param['txt_class_language'];    //分类语言
			$goods_class_array['goods_type_id']     = $input_param['txt_goods_type_id'];    //分类类型
			$goods_class_array['class_other_attr']	= $input_param['txt_class_attr'];		//独有属性

			$insert_rs = $this->InsertRow($goods_class_array, 'shop_goods_class', 'class_id');
			if ($insert_rs){
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
	 * 物理删除商品分类
	 * @author     
	 * @param  
	 * @return bool
	 */
	function delGoodsClass($input_param,$filed){
		try {
			$rs = $this->DelRow($input_param,"shop_goods_class",$filed);
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
	 * 修改商品分类
	 *
	 * @param var[] $input_param 商品分类信息
	 * @param int $modify_id 商品分类id
	 * @return bool
	 */
	function modifyGoodsClass($input_param,$modify_id,$param="all"){
		try {
			if ($param=="all") {
				$goods_class_array = array();
				$goods_class_array['class_top_id']      = $input_param['txt_class_top_id'];      //父级分类id
				$goods_class_array['class_name']        = $input_param['txt_class_name'];        //分类名称
				$goods_class_array['class_state']       = $input_param['txt_class_state'];       //分类状态0、开启1、关闭
				$goods_class_array['class_keywords']    = $input_param['txt_class_keywords'];    //分类关键字
				$goods_class_array['class_description'] = $input_param['txt_class_description']; //分类描述
				$goods_class_array['class_sort']        = $input_param['txt_class_sort'];        //分类排序
				$goods_class_array['class_language']    = $input_param['txt_class_language'];    //分类语言显示
				$goods_class_array['class_url']         = $input_param['txt_class_url'];         //分类指向的url外联
				$goods_class_array['class_language']    = $input_param['txt_class_language'];    //分类语言
				$goods_class_array['goods_type_id']     = $input_param['txt_goods_type_id'];    //分类类型
				$goods_class_array['class_other_attr']	= $input_param['txt_class_attr'];		//独有属性
			}
			if ($param == "move") {
				$goods_class_array['class_top_id']      = $input_param['txt_class_top_id'];      //父级分类id
			}
			$update_rs	= $this->UpdateRow($modify_id,$goods_class_array,"shop_goods_class","class_id");

			/*修改子级属性*/
			if($input_param['txt_modify_sub'] == 1) {
				include(BasePath."/share/shop_goods_class_show.php");
				$result		= array();
				$sub_array	= $this->getArrayById($node_cache,$result,$modify_id);
				if(is_array($sub_array) and count($sub_array)>0) {
					foreach ($sub_array as $v) {
						$this->UpdateRow($v,array('goods_type_id'=>$goods_class_array['goods_type_id']),"shop_goods_class","class_id");
					}
				}
			}
		}
		catch (Exception $e){
			return false;
		}
		return $update_rs;
	}
	/**
	 * 修改多个商品分类
	 *
	 * @param array $input_param
	 * @param string $condition
	 */
	function modifyMoreGoodsClass($input_param,$condition){
		try {
			//得到条件语句
			$condition_str = $this->getCondition($condition);
			$update_rs = $this->UpdateRows('shop_goods_class', $input_param, $condition_str);
		}
		catch (Exception $e) {
			return false;
		}
		return true;
	}
	/**
	 * 得到某商品分类的资料
	 *
	 * @param var[] $conditon  查询条件，一维数组形式
	 * @param string $field   所需要的字段名称
	 * @return var[]
	 */
	function getGoodsClassInfo($condition,$field = "*"){
		try {
			//得到条件语句
			$condition_str = $this->getCondition($condition);
			$goods_class_array = $this->GetTheRow($condition_str,'shop_goods_class',$field);
			$goods_class_array['class_other_attr'] = @unserialize($goods_class_array['class_other_attr']);
			return $goods_class_array;
		}
		catch (Exception $e){
			return false;
		}
	}
	/**
	 * 获得商品分类记录数据，二维数组
	 *
	 * @param var[] $condition 查询条件，一维数组形式
	 * @param object $obj_page 分页对象，根据此对象获取相应的记录
	 * @param var $field 所需要的字段名称，在$operate_genre为simple的时候，此参数为字符串形式，字段间用,分隔，在$operate_genre为more的时候为一维数组，对应每一个表的字段集合
	 * @param string $operate_genre  simple查询基本会员信息，more查询会员所有信息，extend查询会员扩展信息
	 * @param string $show_genre  显示类型，1只显示正常状态的会员，0显示锁定的会员，2显示被逻辑删除的会员，空是显示所有会员
	 * @return var[]
	 * 
	 */
	function getGoodsClass($condition,$obj_page,$field = "*"){
		//得到条件语句
		$condition_str = $this->getCondition($condition);
		//得到会员基本表中符合要求的数据
		$goods_class_array = $this->GetList($condition_str,$obj_page,'shop_goods_class',$field,0);

		return $goods_class_array;
	}

	function getCondition($conditon_array){
		$condition_sql = "";
		if ($conditon_array['class_id'] != "") {
			$condition_sql .= " and shop_goods_class.class_id=".$conditon_array['class_id'];
		}
		if ($conditon_array['order_by_class_sort'] == 'yes') {
			$condition_sql .= " order by shop_goods_class.class_top_id asc,shop_goods_class.class_sort asc,shop_goods_class.class_id asc";
		}
		if ($conditon_array['more_id'] != "") {
			$class_id_array = explode(",",$conditon_array['more_id']);
			$condition_sql = "";
			foreach ($class_id_array as $class_id) {
				$condition_sql .= " or class_id=".intval($class_id);
			}
			$condition_sql = substr($condition_sql,4);
		}
		if ($conditon_array['class_top_id'] != "") {
			$condition_sql .= " and class_top_id=".intval($conditon_array['class_top_id']);
		}
		if ($conditon_array['class_state'] != "") {
			$condition_sql .= " and class_state='".$conditon_array['class_state']."'";
		}
		return $condition_sql;
	}

	/**
	 * 生成商品分类的一维数组
	 * @author     
	 * @param  
	 * @return array
	 */
	function getOneLevelArray(&$result, $node, $depth=0,$Fields){
		$this->node_cache = $node;
		if (is_array($this->node_cache)) {
			foreach ($this->node_cache as $k => $v){
				$num = count($result);
				$result[$num][0] = $v[$Fields[0]];
				$result[$num][1] = Common::magic_value($v[$Fields[1]]);
				$result[$num][2] = Common::magic_value($v[$Fields[2]]);
				$result[$num][3] = $v[$Fields[3]];
				$result[$num][4] = $depth;
				$result[$num][5] = Common::magic_value($v[$Fields[5]]);;
				$result[$num][6] = Common::magic_value($v[$Fields[6]]);;
				if (is_array($v['child'])){
					$line = $depth+1;
					$this->getOneLevelArray($result, $v['child'], $line,$Fields);
				}
				unset($num);
			}
		}
		return $result;
	}
	/**
	 * 把一维数组拼成字符串
	 * 
	 * @author     
	 * @param  
	 * @return string
	 */
	function getOneLevelString($param){
		if (is_array($param)) {
			foreach ($param as $k => $v){
				$file_string .="array('".$v[0]."','".$v[1]."','".$v[2]."','".$v[3]."','".$v[4]."',";
				/*
				$file_string .="\n       array(".$v[0].",";
				$file_string .="\n        ".$v[1].",";
				$file_string .="\n        '".$v[2]."',";
				$file_string .="\n        ".$v[3].",";
				$file_string .="\n        ".$v[4].",";
				*/
				foreach ($param as $k2 => $v2){
					$i = 0;
					if ($v[0] == $v2[1]){         /*$v['id'] == $v2['parentId']*/
						$i = 1;
						break;
					}
				}
				//haveson
				if ($i == 1){
					$file_string .="1,'".$v[5]."','".$v[6]."'";
				}else {
					$file_string .="0,'".$v[5]."','".$v[6]."'";
				}
				$file_string .="),\n";
			}
		}
		return $file_string;
	}
	/**
	 * 构成商品类目的多维数组
	 * 
	 * @author     
	 * @param  
	 * @return int/bool/object/array
	 */
	function makeArray($d,$Fields,$depth=0){
		require_once("common.class.php");
		if (is_array($d)){
			/*
			foreach ($d as $k => $v){
			$file_string .="\n       array(".$v[$Fields[0]].",";
			$file_string .="\n        ".$v[$Fields[1]].",";
			$file_string .="\n        '".$v[$Fields[2]]."',";
			$file_string .="\n        ".$v[$Fields[3]].",";
			$file_string .="\n        ".$depth.",";
			$file_string .="\n        ".$v[$Fields[4]].",";
			if (!empty($v['child'])) {
			$line = $depth+1;
			$file_string .="\n        array(".$this->makeArray($v['child'],$Fields,$line)."),";
			}
			$file_string .="\n       ), \n";
			}
			}
			*/
			foreach ($d as $k => $v){
				$file_string .="array('".$v[$Fields[0]]."','".$v[$Fields[1]]."','".Common::magic_value($v[$Fields[2]])."','".$v[$Fields[3]]."','".$depth."','".$v[$Fields[4]]."','".$v[$Fields[5]]."','".$v[$Fields[6]]."'";
				if (!empty($v['child'])) {
					$line = $depth+1;
					$file_string .=",array(".$this->makeArray($v['child'],$Fields,$line).")";
				}
				$file_string .="),\n";
			}
		}

		return $file_string;
	}
	/**
	 * 创建商品分类数组文件
	 *
	 */
	function createGoodsClassArray(){

		$creatfile = BasePath."/share/shop_goods_class_show.php";


		require_once("fileoperate.class.php");
		/**
		 * 生成 多维数组 形式的
		 */
		$class_array = $this->getGoodsClass(array('order_by_class_sort'=>'yes'),'',"*");

		$productClassArray = array();
		foreach ($class_array as $va) {
			if($va['class_top_id'] != 0) {
				$sub_class = $this->GetList('and class_top_id='.$va['class_id'],'','shop_goods_class','class_id',0);
				if(count($sub_class)>0) {
					$class_sub_state	= 1;
				} else {
					$class_sub_state	= 0;
				}
			} else {
				$class_sub_state	= 1;
			}

			$productClassArray[]	= array(0=> $va['class_id'],
			1=> $va['class_top_id'],
			5=> $class_sub_state);
		}

		$k	= 0;
		$ar	= array();
		foreach ($class_array as $val) {
			if($val['class_top_id'] == 0) {
				$ar[$k]		= $val;
				$k++;

				$sub_array = $this->getArrayById($productClassArray,$result,$val['class_id']);
				if(is_array($sub_array) and count($sub_array)>0) {
					foreach ($sub_array as $sub_val) {
						foreach ($class_array as $value) {
							if($value['class_id'] == $sub_val) {
								$ar[$k]		= $value;
								$k++;
							}
						}
					}
				}
			} else {
				break;
			}
		}

		//定义目标数组
		$d = array();
		//定义索引数组，用于记录节点在目标数组的位置
		$ind = array();
		foreach($ar as $v) {
			$v[child] = array(); //给每个节点附加一个child项
			if($v[class_top_id] == 0) {
				$i = count($d);
				$d[$i] = $v;
				$ind[$v[class_id]] = &$d[$i];
			}else {
				$i = count($ind[$v[class_top_id]][child]);
				$ind[$v[class_top_id]][child][$i] = $v;
				$ind[$v[class_id]] = &$ind[$v[class_top_id]][child][$i];
			}

		}
		unset($ind);

		/*将生成的多维数组写入文件，用于前台*/
		if (is_array($d)){
			$string = $this->makeArray($d,array(0=>'class_id',1=>'class_top_id',2=>'class_name',3=>'class_sort',4=>'$depth',5=>'class_keywords',6=>'class_description'),0);
		}

		FileOperate::makeClassFlie($string,$creatfile);
		/*生成一维数组，用于后台新增和修改页面的下拉列表*/
		$result = array();
		$string = $this->getOneLevelArray($result,$d,'0',array(0=>'class_id',1=>'class_top_id',2=>'class_name',3=>'class_sort',4=>'$depth',5=>'class_keywords',6=>'class_description'));
		$file_string = $this->getOneLevelString($string);
		FileOperate::makeClassFlie($file_string,$creatfile);
		return true;
	}
	/**
	 * 获得商品类格式化后一维数组
	 * 
	 * 下标信息
	 * 多维 
	 * id,parentId,name,sort,depth,child(array)
	 * 一维
	 * id,parentId,name,sort,depth,haveson
	 * 
	 * @param mix $conditionstr
	 * @param object $Objpage
	 * @return array
	 */
	function listClassDetail($string="&nbsp;&nbsp;&nbsp;&nbsp;"){

		if (!is_file(BasePath."/share/shop_goods_class_show.php")  || strlen(trim(file_get_contents(BasePath."/share/shop_goods_class_show.php")))<25 ){
			$this->createGoodsClassArray();
		}
		include BasePath."/share/shop_goods_class_show.php";
		if (is_array($node_cache)){
			foreach ($node_cache as $k => $v){
				$line = str_repeat($string,$v[4]);
				$node_cache[$k][2] = $line.$v[2];
				/*增加页面输出的下拉菜单下标参数*/
				$node_cache[$k]['id'] = $node_cache[$k][0];
				$node_cache[$k]['name'] = $node_cache[$k][2];
			}
		}
		return  $node_cache;
	}
	/**
	 * 取指定ID的所有下级类别 一维数组
	 * $class_array 类别数组,$result结果集,$pc_id父类ID
	 * @author     
	 * @param  
	 * @return array
	 */
	function getArrayById($class_array,$result,$pc_id){
		if (is_array($class_array)){
			foreach ($class_array as $v){
				if ($v[1] == $pc_id){
					$result[] = $v[0];
					if ($v[5] == '1') {
						$result = $this->getArrayById($class_array,$result,$v[0]);
					}
				}
			}
		}
		return $result;
	}
	/**
	 * 取指定ID的下一级类别 一维数组
	 * $class_array 类别数组,$result结果集,$pc_id父类ID
	 * @author     
	 * @param  
	 * @return array
	 */
	function getOneArrayById($class_array,$result,$pc_id){
		if (is_array($class_array)){
			foreach ($class_array as $v){
				if ($v[1] == $pc_id){
					$result[] = $v[0];
				}
			}
		}
		return $result;
	}
	/**
	 * 用于前台显示，1-2级排序的分类
	 *
	 * @param string[] $array
	 * @return array[]
	 */
	function getClassSort() {
		$product_class_array = $this->listClassDetail();
		if(is_array($product_class_array) and count($product_class_array)>0) {
			$array	= array();
			foreach ($product_class_array as $v) {
				if($v[1] ==0) {
					$array[$v[0]]['class_id']	= $v[0];
					$array[$v[0]]['class_top_id']= $v[1];
					$array[$v[0]]['class_name']	= $v[2];
					$array[$v[0]]['class_sort']	= $v[3];

				} else {
					$array[$v[1]]['sub_class'][] = $v;
				}
			}

			$i=0;
			foreach ($array as $val) {
				$class_array[$i]	= $val;
				$i++;
			}
		}
		return $class_array;
	}
	/**
	 * 改变分类状态
	 *
	 * @param 	array $array
	 * @return 	string
	 */
	function ajaxClassUpdate($array) {
		$class_array		= array();
		$class_array[$array['ajax_type']]	= $array['old_state'] == 1 ? "0" : "1";

		$update_rs = $this->UpdateRow($array['class_id'],$class_array,"shop_goods_class",'class_id');
		if($update_rs) {
			return $class_array[$array['ajax_type']];
		}
	}
}
?>