<?php
/*
[帝国网站管理系统]

文件名称：帝国CMS与Discuz6.0通行证接口

Powered by pHome.net
*/


//*********************** 参数配置起始 ***********************

// 参数1：帝国CMS安装目录

$EcmsInstallPath=$site_config['api']['ecms_path_absolut'];    //

// 参数2：登录COOKIE设置，Discuz跟帝国CMS不在同一个域名下需要设置

$EcmsCookieDomain=$site_config['cookie']['cookiedomain'];    // cookie 作用域

$EcmsCookiePath=$site_config['cookie']['cookiepath'];     // cookie 作用路径

// 参数3：注册后自动登录的COOKIE保存时间，单位秒，不需要修改

$EcmsRegLogintime=$site_config['cookie']['cookie_expire'];

//*********************** 参数配置结束 ***********************



//----------------------- 以下内容请不要修改 -----------------------

//导入配置文件
require_once(BasePath . "/" . $EcmsInstallPath."/e/class/config.php");
require_once(BasePath . "/" . $EcmsInstallPath."/e/class/user.php");

if($utfdata&&!function_exists("iconv"))
{
	include_once(BasePath . "/" . $EcmsInstallPath."e/class/doiconv.php");
}
include(BasePath . "/" . $EcmsInstallPath."/e/class/connect.php");
$link=db_connect();

//取得随机数
function Ecms_make_password($pw_length){
	$low_ascii_bound=50;
	$upper_ascii_bound=122;
	$notuse=array(58,59,60,61,62,63,64,73,79,91,92,93,94,95,96,108,111);
	while($i<$pw_length)
	{
		mt_srand((double)microtime()*1000000);
		$randnum=mt_rand($low_ascii_bound,$upper_ascii_bound);
		if(!in_array($randnum,$notuse))
		{
			$password1=$password1.chr($randnum);
			$i++;
		}
	}
	return $password1;
}

//登录验证
function LoginEcms($username,$cookietime){
	global $user_tablename,$user_userid,$user_username,$user_group,$user_groupid,$user_rnd,$EcmsRegLogintime;
	//echo $EcmsRegLogintime;
	//echo "select ".$user_userid.",".$user_username.",".$user_group." from ".$user_tablename." where ".$user_username."='$username'";
	$sql=mysql_query("select ".$user_userid.",".$user_username.",".$user_group." from ".$user_tablename." where ".$user_username."='$username'") or die(mysql_error());
	$r=mysql_fetch_array($sql);

	if ($r){
		$rnd=Ecms_make_password(12);
		if(empty($r[$user_group]))
		{
			$r[$user_group]=$user_groupid;
		}
		$r[$user_group]=(int)$r[$user_group];
		$usql=@mysql_query("update ".$user_tablename." set ".$user_rnd."='$rnd',".$user_group."=".$r[$user_group]." where ".$user_userid."='$r[$user_userid]'");
		if($cookietime)
		{
			$cookietime=time()+$cookietime;
		}
		$username=doUtfAndGbk($r[$user_username],1);
		$set1=EcmsSetCookie("mlusername",$username,$cookietime);
		$set2=EcmsSetCookie("mluserid",$r[$user_userid],$cookietime);
		$set3=EcmsSetCookie("mlgroupid",$r[$user_group],$cookietime);
		$set4=EcmsSetCookie("mlrnd",$rnd,$cookietime);
	}else{
		$usql=@mysql_query("insert into ".$user_tablename." ($user_username) values ('$username')");
		//echo "insert into ".$user_tablename." ($user_username) values ($username)";
		
	}
}

//退出登录
function LoginOutEcms(){
	$set1=EcmsSetCookie("mlusername","",0);
	$set2=EcmsSetCookie("mluserid","",0);
	$set4=EcmsSetCookie("mlrnd","",0);
	$set3=EcmsSetCookie("mlgroupid","",0);
}

//设置cookie
function EcmsSetCookie($vname,$value,$cooktime){
	global $EcmsCookieDomain,$EcmsCookiePath,$phome_cookievarpre;
	$set=setcookie($phome_cookievarpre.$vname,$value,$cooktime,$EcmsCookiePath,$EcmsCookieDomain);
	return $set;
}

//编码转换
/*
function DoIconvVal($code,$targetcode,$str,$inc=0){
	global $EcmsInstallPath;
	$a=$EcmsInstallPath."e/class/";
	$iconv=new Chinese($a);
	$str=$iconv->Convert($code,$targetcode,$str);
	return $str;
}
*/
?>