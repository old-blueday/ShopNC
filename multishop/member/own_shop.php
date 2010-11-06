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
 * FILE_NAME : own_shop.php   FILE_PATH : \multishop\member\own_shop.php
 * ....商铺管理
 *
 * @copyright Copyright (c) 2007 - 2010 www.shopnc.net
 * @author ShopNC Develop Team
 * @version Thu Sep 06 16:52:10 CST 2007
 */

require_once("../global.inc.php");

class OwnShopManage extends memberFrameWork{
	/**
	 * 商铺对象
	 *
	 * @var obj
	 */
	var $obj_shop;
	/**
	 * 商铺分类对象
	 *
	 * @var obj
	 */
	var $obj_shopcategory;
	/**
	 * 验证对象
	 *
	 * @var obj
	 */
	var $objvalidate;
	/**
	 * 会员对象
	 *
	 * @var obj
	 */
	var $objmember;
	/**
	 * 地区对象
	 *
	 * @var obj
	 */
	var $obj_area;
	/**
	*店铺模块对象
	*
	*@obj_module
	*/
	var $obj_module;

	/**
	 * 店铺等级对象
	 *
	 * @var obj
	 */
	var $obj_Grade;

	function main(){

		/**
		 * 创建商铺对象
		 */
		if (!is_object($this->obj_shop)){
			require_once("shop.class.php");
			$this->obj_shop = new ShopClass();
		}
		/**
		 * 创建商铺分类对象
		 */
		if (!is_object($this->obj_shopcategory)){
			require_once("shopcategory.class.php");
			$this->obj_shopcategory = new ShopCategoryClass();
		}
		/**
		 * 创建店铺等级对象
		 */
		if (!is_object($this->obj_Grade)) {
			require_once("shop_grade.class.php");
			$this->obj_Grade = new ShopGradeClass();
		}
		/**
		 * 创建验证对象
		 */
		if (!is_object($this->objvalidate)){
			require_once("commonvalidate.class.php");
			$this->objvalidate = new CommonValidate();
		}

		/**
		 * 创建会员对象
		 */
		if (!is_object($this->objmember)){
			require_once("member.class.php");
			$this->objmember = new MemberClass();
		}

		/**
		 * 语言包
		 */
		$this->getlang("shop,shop_grade_manage");

		//判断店铺删除状态
		//$this->isShopDel();


		$this->_input['hideMemberId'] = $_SESSION["s_login"]['id'];
		$this->_input['hideShopId'] = $_SESSION["s_shop"]['id'];

		/**
		 * 根据参数调用相应的方法
		 */
		switch ($this->_input['action']){
			case "modi":
				/**
				 * 菜单输出
				 */
				$this->memberMenu('my_shop','shop_manage','manage_shop');
				$this->_getShopInfo();
				break;
			case "new":
				/**
				 * 菜单输出
				 */
				$this->memberMenu('my_shop','shop_manage','add_shop');

				//判断用户组权限
				CheckPermission::memberGroupPermission('shop',$_SESSION['s_login']['id']);
				$this->_newShopInfo();
				break;
			case "save":
				$this->_saveShopInfo();
				break;
			case "save_modi":
				$this->_saveShopModi();
				break;
			case "update_shop_grade":
				/**
				 * 菜单输出
				 */
				$this->memberMenu('my_shop','shop_manage','add_shop');
				$this->updateShopGrade();
				break;
			case "update_grade_save":
				$this->updateShopGradeSave();
				break;
			case "dellogo":
				$this->_delLogo();
				break;
			case "intro":
				/**
				 * 菜单输出
				 */
				$this->memberMenu('my_shop','shop_manage','shop_intro');
				$this->_getIntro();
				break;
			case "saveintro":
				$this->_saveShopIntro();
				break;
			case 'entity_check':
				if ($_SESSION['s_shop']['id'] == ''){
					$this->redirectPath('error','../member/own_shop.php?action=new',$this->_lang['langShopNoHaveShop']);
					return false;
				}
				/**
				 * 菜单输出
				 */
				$this->memberMenu('seller','my_seller','entity_check');
				$this->_showEntityInfo();
				break;
			case 'save_shopentity':
				$this->_saveEntityInfo();
				break;
			case "delbanner":
				$this->_delBanner();
				break;
			case 'view':
				$this->_showMyStore();
				break;
			case 'pic_upload':
				$this->_pic_upload();
				break;
			case 'resizeThumbnailImage':
				$this->_resizeThumbnailImage();
				break;
			case 'resizeThumbnailImageBanner':
				$this->_resizeThumbnailImageBanner();
				break;
			default:
				$this->shopMenuModule();
				$this->_getShopInfo();
		}
	}
	//通过ajax保存原图
	function _pic_upload()
	{

		require_once("uploadfile.class.php");
		$upload = new UploadFile();
		$upload->allow_type = explode(',',$this->_fileconfig['allowuploadimagetype']);   //允许上传的文件类型

		$filename = $upload->upfile("image");
		echo $filename['getfilename'];//上传图片
	}
	//切割图片
	function _resizeThumbnailImage(){

		$image_name=$this->_input['img_name'];
		$image='../'.$image_name;
		$resize_image=explode(".",$image_name);
		$image_name1=$resize_image[0]."thumbnail.".$resize_image[1];
		$thumb_image_name='../'.$image_name1;
		$start_width =$this->_input["x1"];
		$start_height = $this->_input["y1"];
		$width =$this->_input["w"];
		$height =$this->_input["h"];
		$scale = 100/$width;
		list($imagewidth, $imageheight, $imageType) = getimagesize($image);
		$start_width = $start_width*$imagewidth/500;
		$start_height = $start_height*$imageheight/375;
		$width =$width*$imagewidth/500;
		$height =$height*$imageheight/375;
		$imageType = image_type_to_mime_type($imageType);
		$newImageWidth = 100;
		$newImageHeight =100;

		$newImage = imagecreatetruecolor($newImageWidth,$newImageHeight);
		switch($imageType) {
			case "image/gif":
				$source=imagecreatefromgif($image);
				break;
			case "image/pjpeg":
			case "image/jpeg":
			case "image/jpg":
				$source=imagecreatefromjpeg($image);
				break;
			case "image/png":
			case "image/x-png":
				$source=imagecreatefrompng($image);
				break;
		}
		imagecopyresampled($newImage,$source,0,0,$start_width,$start_height,$newImageWidth,$newImageHeight,$width,$height);
		switch($imageType) {
			case "image/gif":
				imagegif($newImage,$thumb_image_name);
				break;
			case "image/pjpeg":
			case "image/jpeg":
			case "image/jpg":

				imagejpeg($newImage,$thumb_image_name,90);
				break;
			case "image/png":
			case "image/x-png":
				imagepng($newImage,$thumb_image_name);
				break;
		}
		unlink($image);
		chmod($thumb_image_name, 0777);
		echo $image_name1;
	}
	//切割图片
	function _resizeThumbnailImageBanner(){

		$image_name=$this->_input['img_name_banner'];
		$image='../'.$image_name;
		$resize_image=explode(".",$image_name);
		$image_name1=$resize_image[0]."thumbnail.".$resize_image[1];
		$thumb_image_name='../'.$image_name1;
		$start_width =$this->_input["x1_b"];
		$start_height = $this->_input["y1_b"];
		$width =$this->_input["w_b"];
		$height =$this->_input["h_b"];
		$scale = 100/$width;
		list($imagewidth, $imageheight, $imageType) = getimagesize($image);
		$start_width = $start_width*$imagewidth/500;
		$start_height = $start_height*$imageheight/375;
		$width =$width*$imagewidth/500;
		$height =$height*$imageheight/375;
		$imageType = image_type_to_mime_type($imageType);
		$newImageWidth = 970;
		$newImageHeight =124;

		$newImage = imagecreatetruecolor($newImageWidth,$newImageHeight);
		switch($imageType) {
			case "image/gif":
				$source=imagecreatefromgif($image);
				break;
			case "image/pjpeg":
			case "image/jpeg":
			case "image/jpg":
				$source=imagecreatefromjpeg($image);
				break;
			case "image/png":
			case "image/x-png":
				$source=imagecreatefrompng($image);
				break;
		}
		imagecopyresampled($newImage,$source,0,0,$start_width,$start_height,$newImageWidth,$newImageHeight,$width,$height);
		switch($imageType) {
			case "image/gif":
				imagegif($newImage,$thumb_image_name);
				break;
			case "image/pjpeg":
			case "image/jpeg":
			case "image/jpg":

				imagejpeg($newImage,$thumb_image_name,90);
				break;
			case "image/png":
			case "image/x-png":
				imagepng($newImage,$thumb_image_name);
				break;
		}
		unlink($image);
		chmod($thumb_image_name, 0777);
		echo $image_name1;
	}
	/**
	 * 显示某商铺信息
	 *
	 */
	function _getShopInfo(){
		if ($_SESSION['s_shop']['id'] == ''){
			@header('Location: own_shop.php?action=new');exit;
		}
		$shop_id = $this->obj_shop->getShopID($_SESSION['s_login']['name'],"login_name","1");

		/**
		 * 获取商铺信息
		 */
		$shop_array = array();
		$shop_array = $this->obj_shop->getOneShop($shop_id);


		/**
		 * 判断店铺等级是否需要审核
		 */		
		if($shop_array['grade_state'] != '' and $shop_array['grade_state'] == 1 ) {
			$this->showpage('own_shop_grade_check');
			exit;
		}

		/*判断商品是否存在图片*/
		if (file_exists('../'.$shop_array['shop_pic']) && $shop_array['shop_pic'] !=''){
			/*判断缩略图宽高，按比例缩小*/
			$image_array = @getimagesize('../'.$shop_array['shop_pic']);
			if ($image_array[0] != 0 && $image_array[1] != 0){
				if ($image_array[0] >= $image_array[1]) {/*宽 > 高*/
					$shop_array['width'] = 100;
					$shop_array['height'] = @number_format($image_array[1]/($image_array[0]/100),0);
				}else if ($image_array[0] <= $image_array[1]) {
					$shop_array['width'] = @number_format($image_array[0]/($image_array[1]/100),0);
					$shop_array['height'] = 100;
				}
			}
		}
		//取地区内容
		//地区内容
		$array = Common::getAreaCache();
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
		//取已选择的地区内容
		if (!empty($shop_array) && $shop_array['shop_area_id'] !=''){
			//取地区内容
			if (!is_object($this->obj_area)){
				require_once ("area.class.php");
				$this->obj_area = new AreaClass();
			}
			$sel_area = $this->obj_area->getAreaPathList($shop_array['shop_area_id']);
		}
		/**
		 * 获取商铺的2级分类
		 */
		$category_array = $this->obj_shopcategory->getLevelCategory(2,'');
		if (is_array($category_array)) {
			$array = array();
			foreach ($category_array as $k => $v){
				if ($v['parent_id'] == '0'){
					$array[] = $v;
					/*取该类下的2级类别*/
					foreach ($category_array as $k2 => $v2){
						if ($v2['parent_id'] == $v['class_id']){
							$num = count($array)-1;
							$array[$num]['child'][] = $v2;
							unset($num);
						}
					}
				}
			}
		}
		/**
		     * 得到店铺等级信息
		     */
		$grade_info = array();
		$grade_info = $this->obj_Grade->getOneGrade(intval($shop_array['shop_grade']));
		/**
		     * 将商铺分类以下拉框的形式出现
		     */
		$this->output("grade_info",$grade_info);
		$this->output("area_array", $area_array);
		$this->output("sel_area", $sel_area);
		$this->output("shop_select_category", $array);    //输出商铺分类以下拉框
		$this->output("shop_info", $shop_array);
		$this->showpage("own_shop.modi");
	}
	/**
	 * 查看店铺
	 *
	 */
	function _showMyStore() {
		if ($_SESSION['s_login']['id']) {
			@header("location: ../store/index.php?userid=".$_SESSION['s_login']['id']);
		} else {
			@header("location: ../home");
		}
	}

	/**
	 * 新建一个商店
	 *
	 */
	function _newShopInfo(){
		if(intval($this->_input['shop_grade']) != 0) {
			$shop_id = $this->obj_shop->getShopID($_SESSION['s_login']['name'],"login_name","1");

			if ($_SESSION['s_shop']['id'] != '' || $shop_id != '' ){
				@header('Location: own_shop.php?action=modi');
			}else {
				//地区内容
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
			 * 获取商铺的2级分类
			 */
				$category_array = $this->obj_shopcategory->getLevelCategory(2,'');
				if (is_array($category_array)) {
					foreach ($category_array as $k => $v){
						if ($v['parent_id'] == '0'){
							$array[] = $v;
							/*取该类下的2级类别*/
							foreach ($category_array as $k2 => $v2){
								if ($v2['parent_id'] == $v['class_id']){
									$num = count($array)-1;
									$array[$num]['child'][] = $v2;
									unset($num);
								}
							}
						}
					}
				}
				/**
		     * 得到店铺等级信息
		     */
				$grade_info = array();
				$grade_info = $this->obj_Grade->getOneGrade(intval($this->_input['shop_grade']));
				/**
		     * 将商铺分类以下拉框的形式出现
		     */
				$this->output("grade_info",$grade_info);
				$this->output("area_array", $area_array);
				$this->output("shop_select_category", $array);    //输出商铺分类以下拉框
				$this->showpage("own_shop.add");   //显示页面
			}
		} else {
			/**
			 * 获取店铺等级列表
			 */	
			$grade_array = array();
			$grade_array = $this->obj_Grade->listGrade(array('grade_sort'=>'sort'));

			$this->output('grade_array',$grade_array);
			$this->showpage("own_shop_grade");
		}
	}

	/**
	 * 开店商铺信息
	 * 店铺名称、店铺类目、店铺介绍
	 *
	 */
	function _saveShopInfo(){

		/**
		 * 检验输入信息
		 */
		$this->objvalidate->validateparam = array(
		array("input"=>$this->_input["hideMemberId"],"require"=>"true","message"=>$this->_lang['errCMemberNoLogin']), //您尚未登陆，请登陆
		array("input"=>$this->_input["txtShopName"],"require"=>"true","message"=>$this->_lang['errShopEnterName']), //请填写商店名称
		array("input"=>$this->_input["slcShopClass"],"require"=>"true","message"=>$this->_lang['errShopSelectClass']), //请选择商店分类
		//array("input"=>$this->_input["sale_range"],"require"=>"true","message"=>$this->_lang['errShopEnterSaleRange']), //请填写商店经营范围
		array("input"=>$this->_input["area_id"],"require"=>"true","message"=>$this->_lang['langShopPleaseSelectLocus']), //请选择所在地区
		);
		/**
		 * 检验的错误信息
		 */

		$error = $this->objvalidate->validate();
		if($error != ""){
			$this->redirectPath("error","",$error);
		}else{
			//检测会员是否有店铺存在
			$array = $this->obj_shop->getOneShopByMemeberId($_SESSION['s_login']['id'],'1');
			if (!empty($array) || $_SESSION['s_login']['id'] == ''){
				$this->redirectPath("error","",$this->_lang['errShopIsExists']);
			}

			/**
			 * 创建会员对象
			 */
			if (!is_object($this->objmember)){
				require_once ("member.class.php");
				$this->objmember = new MemberClass();
			}
			//店铺审核标识
			$this->_input['ischeck'] = $this->_configinfo['shopinfo']['ifcheck'];

			//店铺二级域名
			if($this->_input['hideMemberId'] != ""){
				require_once("domain.class.php");
				$domain = new Domain();
				$domain_id = $domain->makeDomain($this->_input['hideMemberId']);
				$this->_input['shop_domain'] = $domain_id;
				unset($domain_id);
			}
			/**
			 * 店铺等级
			 */
			if(intval($this->_input['shop_grade']) != 0) {
				$grade_info = array();
				$grade_info = $this->obj_Grade->getOneGrade(intval($this->_input['shop_grade']));
				$this->_input['grade_state'] = $grade_info['shop_confirm'];

				$this->_input['shop_grade'] = $grade_info['grade_id'];
			}
			//新增店铺默认模板
			$this->_input['rdoStyle'] = '04';
			/**
			 * 添加店铺
			 */
			$result = $this->obj_shop->operateShop($this->_input);
			if ($result === true){
				//开店
				CreditsClass::saveCreditsLog('open_shop',$_SESSION["s_login"]['id'],false);
				//得到商城ID
				$shop_id = $this->obj_shop->getShopID($_SESSION['s_login']['name'],"login_name","1");
				if ($shop_id > 0){
					$_SESSION["s_shop"]['id'] = $shop_id;
					$_SESSION['s_shop']['shop_grade_state'] = $grade_info['shop_confirm'];
				}
				/**
				 * 创建商铺模块对象
				 */
				if (!is_object($this->obj_module)){
					require_once("shop_module.class.php");
					$this->obj_module = new ShopModule();
				}
				//开店生成默认的模块
				$data_name=array($this->_lang['langShopModuieShopinfo'],$this->_lang['langShopModuieProduct_search'],$this->_lang['langShopModuieCategory'],$this->_lang['langShopModuleMp3'],$this->_lang['langShopModuieLink'],$this->_lang['langShopModuieNotice'],$this->_lang['langShopModuieRecommend_product'],$this->_lang['langShopModuieProduct'],$this->_lang['langShopModuleVideo'],$this->_lang['langShopModuieMessage']);

				$this->obj_module->saveshop($_SESSION['s_login']['id'],$data_name);
				if ($this->_input['ischeck'] == "0"){//不需要审核
					$this->_input['member_type'] = "1";
					$_SESSION["s_login"]['type'] = "1";
					$this->objmember->modifyMember($this->_input,$_SESSION['s_login']['id'],"type");

					//如果开启缴费，则增加会员的试用期内容
					if($this->_configinfo['paymode']['shop_pay_mode'] == '1'){
						require_once('settings.class.php');
						$obj_settings = new SettingsClass();
						$array = array();
						$array['shop_availability_time'] = mktime(23,59,59,date('m'),date('d'),date('y'))+$obj_settings->getSettings('shoppay_shop_time')*24*60*60;
						$this->objmember->modifyMember($array,$_SESSION['s_login']['id'],'shoppay');
						unset($obj_settings,$array);
					}

					//开店成功后插入默认的邮费模板数据
					require_once 'postage.class.php';
					$obj_postage = new PostageClass();
					$obj_postage->addPostage(array('member_id'=>$_SESSION['s_login']['id'],'postage_fast'=>'a:1:{s:7:"default";a:2:{s:7:"default";s:2:"10";s:10:"default_up";s:1:"4";}}','postage_title'=>'STO','postage_content'=>'www.sto.cn','postage_update_time'=>time()));

					/**
			 * UC推送会员开通店铺的信息到uchome
			 */
					if ($this->makeFeed('createstore')){
						//商品信息参数
						$subject_url = $this->_configinfo['websit']['site_url'].'/store/index.php?userid='.$_SESSION['s_login']['id'];
						define('UC_APPID',$this->_configinfo['ucenter']['uc_appid']);
						$feed_param = array(
						'icon'=>'profile',
						'uid'=>$_SESSION['s_login']['id'],
						'username'=>$_SESSION['s_login']['name'],
						'title_template'=>'{actor}'.$this->_lang['langAt'].'{subject}',
						'title_data'=>array('subject'=>"<a href='".$this->_configinfo['websit']['site_url']."' target='_blank'>".$this->_configinfo['websit']['site_name']."</a>".$this->_lang['langAtCreateStore']."<a href='".$subject_url."'>".$this->_input["txtShopName"]."</a>"),
						);

						require_once('ucenter.class.php');
						$obj_ucenter = new ucenterClass();
						$obj_ucenter->uc_feed($feed_param);
						unset($obj_ucenter);
					}
					$this->redirectPath("succ",'member/own_shop.php?action=modi',$this->_lang['langShopInfoFillInOk']);
				}else {
					$this->redirectPath("succ",'member/own_shop.php?action=modi',$this->_lang['langShopInfoFillInOkWaitingCheck']);
				}
			}else {
				$this->redirectPath("error",'',$this->_lang['errShopAddFail']);
			}
		}
	}

	/**
	 * 保存店铺信息修改
	 *
	 */
	function _saveShopModi(){
		/**
		 * 检验输入信息
		 */
		$this->objvalidate->validateparam = array(
		array("input"=>$this->_input["hideMemberId"],"require"=>"true","message"=>$this->_lang['errCMemberNoLogin']), //您尚未登陆，请登陆
		array("input"=>$this->_input["txtShopName"],"require"=>"true","message"=>$this->_lang['errShopEnterName']), //请填写商店名称
		array("input"=>$this->_input["slcShopClass"],"require"=>"true","message"=>$this->_lang['errShopSelectClass']), //请选择商店分类
		//array("input"=>$this->_input["sale_range"],"require"=>"true","message"=>$this->_lang['errShopEnterSaleRange']), //请填写商店经营范围
		array("input"=>$this->_input["area_id"],"require"=>"true","message"=>$this->_lang['langShopPleaseSelectLocus']), //请选择所在地区
		);
		/**
		 * 检验的错误信息
		 */
		$error = $this->objvalidate->validate();

		if($error != ""){
			$this->redirectPath("error","",$error);
		}else{
			/**
			 * 创建会员对象
			 */
			if (!is_object($this->objmember)){
				require_once ("member.class.php");
				$this->objmember = new MemberClass();
			}
			/**
			 * 上传店标图片
			 *
			if($_FILES['fileShopLogo']['name'] != '' && $this->_input['hideShopId'] != ''){
				require_once("uploadfile.class.php");
				$upload = new UploadFile();
				$upload->allow_type = explode(',',$this->_fileconfig['allowuploadimagetype']);   //允许上传的文件类型
				$upload->max_size = '500';
				$filename = $upload->upfile("fileShopLogo");
				$this->_input["fileShopLogo"] = $filename['getfilename'];//上传图片
				unset($upload);
			}*/
			/**
			 * 上传店标切割图片
			 */
			if($this->_input["loge_hidden"]!='')
			{
				/**
				 * 获取商铺信息
				 */
				$shop_array2 = array();
				$shop_array2 = $this->obj_shop->getOneShop($_SESSION['s_shop']['id']);
				/**
				 * 删除图片
				 */
				if (file_exists("../" . $shop_array2['shop_pic'])){
					unlink("../" . $shop_array2['shop_pic']);
				}
				$this->_input["fileShopLogo"] = $this->_input["loge_hidden"];//上传图片
			}
			/**
			 * 上传店铺banner图片
			 
			if($_FILES['fileShopBanner']['name'] != '' && $this->_input['hideShopId'] != ''){
				require_once("uploadfile.class.php");
				$upload = new UploadFile();
				$upload->allow_type = explode(',',$this->_fileconfig['allowuploadimagetype']);   //允许上传的文件类型
				$upload->max_size = '500';
				$filename = $upload->upfile("fileShopBanner");
				$this->_input["fileShopBanner"] = $filename['getfilename'];//上传图片
				unset($upload);
			}*/
			if($this->_input["banner_hidden"]!='')
			{
				$shop_array1 = array();
				$shop_array1 = $this->obj_shop->getOneShop($_SESSION['s_shop']['id']);

				/**
				 * 删除图片
				 */
				if (file_exists("../" . $shop_array1['shop_banner_pic'])){
					@unlink("../" . $shop_array1['shop_banner_pic']);
				}

				$this->_input["fileShopBanner"] = $this->_input["banner_hidden"];//上传图片
			}
			/**
			 * 店铺二级域名
			 */
			if($this->_input['hideMemberId'] != ""){
				require_once("domain.class.php");
				$domain = new Domain();
				$domain_id = $domain->makeDomain($this->_input['hideMemberId']);
				$this->_input['shop_domain'] = $domain_id;
			}

			$result = $this->obj_shop->operateShop($this->_input);  //把信息放入数据库中
			if ($this->_configinfo['shopinfo']['ifcheck'] == '0'){//不需要审核
				$this->_input['member_type'] = "1";
				$_SESSION["s_login"]['type'] = "1";
				$shop_id = $this->obj_shop->getShopID($_SESSION['s_login']['name'],"login_name","1");  //得到商城ID
				if ($shop_id > 0){
					$_SESSION["s_shop"]['id'] = $shop_id;
				}
				$this->objmember->modifyMember($this->_input,$_SESSION['s_login']['id'],"type");
			}
			$this->redirectPath("succ",'member/own_shop.php?action=modi',$this->_lang['langShopInfoFillInOk']);//填写商铺信息成功!
		}
	}
	/**
	 * 更新店铺等级
	 *
	 */
	function updateShopGrade() {
		if ($_SESSION['s_shop']['id'] == ''){
			@header('Location: own_shop.php?action=new');exit;
		}
		$shop_id = $this->obj_shop->getShopID($_SESSION['s_login']['name'],"login_name","1");

		/**
		 * 获取商铺信息
		 */
		$shop_array = array();
		$shop_array = $this->obj_shop->getOneShop($shop_id);
		/**
			 * 获取店铺等级列表
			 */	
		$grade_array = array();
		$grade_array = $this->obj_Grade->listGrade(array('grade_sort'=>'sort'));

		$this->output('grade_array',$grade_array);
		$this->output('shop_array',$shop_array);
		$this->showpage('own_shop_grade_update');
	}
	/**
	 * 升级操作
	 *
	 */
	function updateShopGradeSave() {
		/**
			 * 店铺等级
			 */
		if(intval($this->_input['shop_grade']) != 0) {
			$grade_info = array();
			$grade_info = $this->obj_Grade->getOneGrade(intval($this->_input['shop_grade']));
			$this->_input['grade_state'] = $grade_info['shop_confirm'];

			$this->_input['shop_grade'] = $grade_info['grade_id'];
		}
		$result = $this->obj_shop->operateShop($this->_input);  //把信息放入数据库中
		
		$this->redirectPath("succ",'member/own_shop.php?action=modi',$this->_lang['langShopGradeUpdate']);//升级店铺等级!
	}
	/**
	 * 删除商店店标
	 *
	 */
	function _delLogo(){
		/**
		 * 获取商铺信息
		 */
		$shop_array = array();
		$shop_array = $this->obj_shop->getOneShop($_SESSION['s_shop']['id']);
		/**
		 * 删除图片
		 */
		if (file_exists("../" . $shop_array['shop_pic'])){
			unlink("../" . $shop_array['shop_pic']);
		}
		/**
		 * 更新数据库
		 */
		$result = $this->obj_shop->delPic($_SESSION['s_shop']['id']);
		$this->redirectPath("succ","member/own_shop.php?action=modi",$this->_lang['langShopDelLogo']);//您已经删除商铺LOGO了!
	}

	/**
	 * 得到店铺信息
	 *
	 */
	function _getIntro(){
		/**
		 * 获取商铺信息
		 */
		$shop_array = array();
		$shop_array = $this->obj_shop->getOneShop($_SESSION['s_shop']['id']);
		$shop_array['shop_intro'] = $shop_array['shop_intro'];
		/**
		 * 页面输出
		 */
		$this->output("shop_intro", $shop_array['shop_intro']);    //输出商铺介绍
		$this->showpage("own_shopintro.modi");   //显示页面
	}

	/**
	 * 保存店铺介绍
	 *
	 */
	function _saveShopIntro(){
		$result = $this->obj_shop->operateShop($this->_input);  //把信息放入数据库中
		$this->redirectPath("succ","member/own_shop.php?action=intro",$this->_lang['langShopAmendIntroOk']);//您已修改商铺介绍!
	}

	/**
	 * 实体店认证
	 */
	function _showEntityInfo(){
		$shop_id = $_SESSION['s_shop']['id'];
		$result = $this->obj_shop->getOneShop($shop_id,'1','audit_state');

		if ($result['audit_state'] == '1') {
			$this->redirectPath("succ","member/own_main.php",$this->_lang['langShopWaitAuditing']);//您的验证信息正处于等待审核状,管理员会尽快审核您的信息!
		}elseif ($result['audit_state'] == '2') {
			$this->redirectPath("succ","member/own_main.php",$this->_lang['langShopPassAuditing']);//您的验证信息已经被审核通过,恭喜您的店铺成为实体店铺!
		}elseif ($result['audit_state'] == '3'){
			$this->output('isRefuse','yes');
		}
		$this->showpage("own_shopentity_check.add");   //显示页面
	}

	/**
	 * 保存实体店认证信息
	 */
	function _saveEntityInfo(){
		if ($_SESSION['s_shop']['id'] == ''){
			$this->redirectPath('error','../member/own_shop.php?action=new',$this->_lang['langShopNoHaveShop']);
			return false;
		}
		require_once('uploadfile.class.php');
		$upload = new UploadFile();
		$upload->allow_type = explode(',',$this->_fileconfig['allowuploadimagetype']);
		$upload->ifresize = false;
		//身份证正面扫描图
		if(isset($_FILES['identity_card_copy_up']['name']) && $_FILES['identity_card_copy_up']['name'] != ''){
			$filename = $upload->upfile('identity_card_copy_up');
			$this->_input['identity_card_copy_up'] = $filename["getfilename"];
		}
		//身份证背面扫描图
		if(isset($_FILES['identity_card_copy_back']['name']) && $_FILES['identity_card_copy_back']['name'] != ''){
			$filename = $upload->upfile('identity_card_copy_back');
			$this->_input['identity_card_copy_back'] = $filename['getfilename'];
		}
		//营业执照扫描图
		if(isset($_FILES['license_copy']['name']) && $_FILES['license_copy']['name'] != ''){
			$filename = $upload->upfile('license_copy');
			$this->_input['license_copy'] = $filename["getfilename"];
		}
		unset($upload);

		$array = array();
		$array['shop_id']                 = $_SESSION['s_shop']['id'];
		$array['identity_card_copy_up']   = $this->_input['identity_card_copy_up'];    //身份证正面扫描图
		$array['identity_card_copy_back'] = $this->_input['identity_card_copy_back'];  //身份证背面扫描图
		$array['license_copy']            = $this->_input['license_copy'];             //营业执照扫描图
		$array['audit_state']             = '1';                                       //审核状态
		if ($this->obj_shop->_updateShop($array)) {
			//实名认证
			CreditsClass::saveCreditsLog('shop_entity',$_SESSION["s_login"]['id'],false);
			$this->redirectPath("succ","member/own_main.php",$this->_lang['langShopSubmitentityInfoOk']);
		}else {
			$this->redirectPath("succ","member/own_main.php",$this->_lang['langShopentityInfoLost']);
		}
	}

	/**
	 * 删除Banner图片
	 */
	function _delBanner(){
		/**
		 * 获取商铺信息
		 */
		$shop_array = array();
		$shop_array = $this->obj_shop->getOneShop($_SESSION['s_shop']['id']);

		/**
		 * 删除图片
		 */
		if (file_exists("../" . $shop_array['shop_banner_pic'])){
			@unlink("../" . $shop_array['shop_banner_pic']);
		}
		/**
		 * 更新数据库
		 */
		$value_array = array();
		$value_array['shop_id'] = $shop_array['shop_id'];
		$value_array['shop_banner_pic'] = '';
		$result = $this->obj_shop->_updateShop($value_array);
		unset($value_array);
		$this->redirectPath("succ","member/own_shop.php?action=modi",$this->_lang['langShopDelBanner']);//您已经删除商铺LOGO了!

	}
}


$shop_manage = new OwnShopManage();
$shop_manage->main();
unset($shop_manage);
?>