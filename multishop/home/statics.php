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
 * FILE_NAME : statics.php   FILE_PATH : E:\www\multishop\home\statics.php
 * 统计文件
 *
 * @copyright Copyright (c) 2007 - 2007 www.shopnc.net 
 * @author ShopNC Develop Team 
 * @package 
 * @subpackage 
 * @version Thu Mar 20 09:31:59 CST 2008
 */

require_once("../global.inc.php");

class Statics extends CommonFrameWork{
	function pv($daturl,$user_time){
		$fileurl = $daturl."/pv.dat";
		if (!file_exists($fileurl)) {/*判断文件是否存在*/
			$this->pvnew($daturl);
		}
		$garray = file($fileurl);
		$num = @explode("|",$garray[0]);
		$num[$user_time]=$num[$user_time]+1;/*该小时的访问次数+1*/
		if(filesize($fileurl)>40){/*文件大于40个字节*/
			$num = implode("|", $num);
			$fp = @fopen($fileurl,"w");
			@flock($fp,LOCK_EX);
			@fwrite($fp,$num);
			@flock($fp,LOCK_UN);
			fclose($fp);
		}
	}

	function ip($daturl,$user_time){
		$fileurl=$daturl."/ip.dat";
		if (!file_exists($fileurl)) {/*判断文件是否存在*/
			$this->ipnew($daturl);
		}
		$garray = file($fileurl);
		$num = explode("|",$garray[0]);
		$num[$user_time]=$num[$user_time]+1;
		if(filesize($fileurl)>40){
			$num = implode("|", $num);
			$fp = @fopen($fileurl,"w");
			flock($fp,LOCK_EX);
			fwrite($fp,$num);
			flock($fp,LOCK_UN);
			fclose($fp);
		}
	}

	function from($daturl,$user_time2,$user_ip,$filename2,$user_ad){
		$fileurl=$daturl."/from.dat";
		if (!file_exists($fileurl)) {/*判断文件是否存在*/
			$this->fromnew2($daturl);
		}
		$user_xi=array($user_time2,$user_ip,$filename2,$user_ad);
		$user_xi = implode("|", $user_xi)."|\r\n";
		$garray = @file($fileurl);
		$fp=@fopen($fileurl,"w");
		flock($fp,LOCK_EX);
		@fwrite($fp,$user_xi);
		for($i=0; $i<49; $i++){
			@fwrite($fp,$garray[$i]);
		}
		flock($fp,LOCK_UN);
		@fclose($fp);
	}

	function pvip($daturl){/*整理访问和IP数量，每个小时间用|隔开*/
		$fileurl1 = $daturl."/pv.dat";
		if (!file_exists($fileurl1)) {
			$this->pvnew($daturl);
		}
		$fileurl2 = $daturl."/ip.dat";
		if (!file_exists($fileurl2)) {
			$this->ipnew($daturl);
		}
		$fileurl3 = $daturl."/pvip.dat";
		if (!file_exists($fileurl3)) {
			$this->pvipnew($daturl);
		}

		$garray1 = file($fileurl1);
		$garray2 = file($fileurl2);
		$garray3 = file($fileurl3);
		$num1 = explode("|", $garray1[0]);/*访问量*/
		$num1a = explode("|", $garray3[0]);
		$num2 = explode("|", $garray2[0]);/*IP数量*/
		$num2a = explode("|", $garray3[1]);
		for($i=0; $i<24; $i++){
			$num1[$i] = $num1[$i] + $num1a[$i];
			$num2[$i] = $num2[$i] + $num2a[$i];
		}
		$num1 = implode("|", $num1);
		$num2 = implode("|", $num2);
		$fp = @fopen($fileurl3,"w");
		flock($fp, LOCK_EX);
		fwrite($fp, $num1);
		fwrite($fp, $num2);
		flock($fp, LOCK_UN);
		fclose($fp);
	}

	function pvip_month($daturl,$pvdaynum,$ipdaynum,$user_today){
		$fileurl=$daturl."/pvip_mon.dat";
		$garray = file($fileurl);
		$num1 = explode("|",$garray[0]);
		$num2 = explode("|",$garray[1]);
		$num3 = explode("|",$garray[2]);
		$num4 = explode("|",$garray[3]);
		$num1[$user_today]=$num1[$user_today]+$pvdaynum;
		$num2[$user_today]=$num2[$user_today]+$ipdaynum;
		$num3[$user_today]=$num3[$user_today]+$pvdaynum;
		$num4[$user_today]=$num4[$user_today]+$ipdaynum;
		$num1 = implode("|", $num1);
		$num2 = implode("|", $num2);
		$num3 = implode("|", $num3);
		$num4 = implode("|", $num4);
		$fp = @fopen($fileurl,"w");
		flock($fp,LOCK_EX);
		fwrite($fp,$num1);
		fwrite($fp,$num2);
		fwrite($fp,$num3);
		fwrite($fp,$num4);
		flock($fp,LOCK_UN);
		fclose($fp);
	}

	function pvip_year($daturl,$pvdaynum,$ipdaynum,$user_month){
		$fileurl=$daturl."/pvip_ye.dat";
		$garray = file($fileurl);
		$num1 = explode("|",$garray[0]);
		$num2 = explode("|",$garray[1]);
		$num3 = explode("|",$garray[2]);
		$num4 = explode("|",$garray[3]);
		$num1[$user_month]=$num1[$user_month]+$pvdaynum;
		$num2[$user_month]=$num2[$user_month]+$ipdaynum;
		$num3[$user_month]=$num3[$user_month]+$pvdaynum;
		$num4[$user_month]=$num4[$user_month]+$ipdaynum;
		$num1 = implode("|", $num1);
		$num2 = implode("|", $num2);
		$num3 = implode("|", $num3);
		$num4 = implode("|", $num4);
		$fp = @fopen($fileurl,"w");
		flock($fp,LOCK_EX);
		fwrite($fp,$num1);
		fwrite($fp,$num2);
		fwrite($fp,$num3);
		fwrite($fp,$num4);
		flock($fp,LOCK_UN);
		fclose($fp);
	}

	function filego($daturl,$filename2){
		$filego=$filename2;
		$fileurl=$daturl."/file_go.dat";
		if (!file_exists($fileurl)) {/*判断文件是否存在*/
			$this->make_file($fileurl,'');
		}
		$fromyn="";
		$garray = file($fileurl);
		$cog=count($garray);
		for($i=0; $i<$cog; $i++) {
			$larray = explode("|",$garray[$i]);
			if($filego==$larray[1]){
				$larray[0] = $larray[0]+1;
				$larray[0] = sprintf("%08d",$larray[0]);
				$garray[$i] = implode("|",$larray);
				$fromyn="1";
			}
		}
		if($fromyn=="1"){
			$list=implode("",$garray);
			$fp = @fopen($fileurl,"w");
			flock($fp,LOCK_EX);
			fwrite($fp,$list);
			flock($fp,LOCK_UN);
			fclose($fp);
		}
		if($fromyn=="" && $filego != ""){/*如果没有当前页面的记录，则新添加一条信息*/
			$num="00000001";
			$filego=array($num,$filego);
			$larray = implode("|",$filego)."|\n";
			$fp = @fopen($fileurl,"a+");
			fwrite($fp,$larray);
			fclose($fp);
		}
	}

	function filefm($daturl,$user_ad){
		$filefm = str_replace("http://", "", $user_ad);
		//		$filefm = explode("/",$filefm);
		//		$filefm = $filefm[0];
		$fileurl=$daturl."/file_fm.dat";
		if (!file_exists($fileurl)) {/*判断文件是否存在*/
			$this->make_file($fileurl,"");
		}
		$fp = @fopen($fileurl,"r");
		$garray = @fread($fp,filesize($fileurl));
		fclose($fp);
		$fromyn="";
		$fromyn2="";
		if(ereg($filefm,$garray)){$fromyn="1";}else{$fromyn="";}
		if($fromyn=="1"){
			$garray = file($fileurl);
			$cog=count($garray);
			for($i=0; $i<$cog; $i++) {
				$larray = explode("|",$garray[$i]);
				if($filefm==$larray[1]){
					$larray[0]=$larray[0]+1;
					$larray[0]=sprintf("%08d",$larray[0]);
					$garray[$i] = implode("|",$larray);
					$fromyn2="1";
				}
			}
			$list=implode("",$garray);
			$fp = @fopen($fileurl,"w");
			flock($fp,LOCK_EX);
			fwrite($fp,$list);
			flock($fp,LOCK_UN);
			fclose($fp);
		}
		if($fromyn=="" or $fromyn2==""){
			$num="00000001";
			$filefm=array($num,$filefm,$user_ad);
			$larray = implode("|",$filefm)."|\n";
			$fp = @fopen($fileurl,"a+");
			fwrite($fp,$larray);
			fclose($fp);
		}
	}

	function newday($daturl){
		$fileurl=$daturl."/day_why.dat";
		$day=date("j");
		$fp = @fopen($fileurl,"w");
		fwrite($fp,$day);
		fclose($fp);
	}

	function newmonth($daturl){
		$fileurl=$daturl."/day_mon.dat";
		$day=date("n");
		$fp = @fopen($fileurl,"w");
		fwrite($fp,$day);
		fclose($fp);
	}

	function newyear($daturl){
		$fileurl=$daturl."/day_ye.dat";
		$day=date("Y");
		$fp = @fopen($fileurl,"w");
		fwrite($fp,$day);
		fclose($fp);
	}

	function top_day($daturl,$pvdaynum,$ipdaynum){
		$fileurl=$daturl."/day_top.dat";
		if (!file_exists($fileurl)) {
			$listnum = "$pvdaynum|$ipdaynum";
			$fp = @fopen($fileurl,"w");
		}else {
			$filegarray = file($fileurl);
			$garray = explode("|",$filegarray[0]);
			if($pvdaynum>$garray[0]){$garray[0]=$pvdaynum;}
			if($ipdaynum>$garray[1]){$garray[1]=$ipdaynum;}
			$listnum=implode("|",$garray);
			$fp = fopen($fileurl,"w");
		}
		fwrite($fp,$listnum);
		fclose($fp);
	}

	function copy_today($daturl){
		$fileurl1=$daturl."/file_fm.dat";
		$fileurl1a=$daturl."/file_fma.dat";
		$fileurl2=$daturl."/file_go.dat";
		$fileurl2a=$daturl."/file_goa.dat";
		copy ($fileurl1,$fileurl1a);
		copy ($fileurl2,$fileurl2a);
	}

	function top10($file1,$file2){
		if (!file_exists($file1)) {
			$this->make_file($file1,'\r\n');
		}else{
			if (!file_exists($file2)) {
				$this->make_file($file2,'\r\n');
			}
			$garray1 = file($file1);
			rsort($garray1);
			$fp1 = @fopen($file2,"r");
			$concent = @fread($fp1,filesize($file2));
			fclose($fp1);

			for($i=0; $i<10; $i++) {
				$larray = explode("|",$garray1[$i]);
				if(!@ereg($larray[1],$concent)){
					$fp = @fopen($file2,"a+");
					fwrite($fp,$garray1[$i]);
					fclose($fp);
				}else{
					$garray2 = file($file2);
					$cog=count($garray2);
					for($j=0; $j<$cog; $j++) {
						$larray2 = explode("|",$garray2[$j]);
						if($larray[1]==$larray2[1]){
							if($larray[0]>$larray2[0]){
								$larray2[0]=$larray[0];
								$garray2[$j] = implode("|",$larray2);
							}
						}
					}
					$list2=implode("",$garray2);
					$fp2 = @fopen($file2,"w");
					fwrite($fp2,$list2);
					fclose($fp2);
				}
			}
			$garray3 = file($file2);
			rsort($garray3);
			$fp3 = @fopen($file2,"w+");
			for($m=0; $m<10; $m++) {
				fwrite($fp3,$garray3[$m]);
			}
			fclose($fp3);
		}
	}

	function ippass($daturl,$user_ip){/*浏览该页面的IP，判断文件中是否已经保存，如果没有保存则新加*/
		$fileurl=$daturl."/ip_all.dat";
		if (!file_exists($fileurl)) {/*判断文件是否存在*/
			$this->ipallnew($daturl);
		}
		$fp = @fopen($fileurl,"r");
		$garray = @fread($fp,filesize($fileurl));
		fclose($fp);
		$ippass1="";
		$ippass2="";
		if(ereg($user_ip,$garray)){$ippass1="1";}
		if($ippass1==""){
			$user_ip2 = $user_ip.'|'.'1'."\r\n";
			$fp = @fopen($fileurl,"a+");
			fwrite($fp,$user_ip2);
			fclose($fp);
			$ippass2="1";
		}
		/*如果存在，则增加数量*/
		if ($ippass1=="1"){
			$garray = file($fileurl);
			$cog=count($garray);
			for($i=0; $i<$cog; $i++) {
				$larray = explode("|",$garray[$i]);
				if($user_ip==$larray[0]){
					$larray[1]=$larray[1]+1;
					$larray[1].="\r\n";
					$garray[$i] = implode("|",$larray);
				}
			}
			$list = implode("",$garray);
			$fp = @fopen($fileurl,"w");
			flock($fp,LOCK_EX);
			fwrite($fp,$list);
			flock($fp,LOCK_UN);
			fclose($fp);
		}
		return $ippass2;
	}

	function pvall($daturl){
		$fileurl=$daturl."/pv.dat";
		$garray = file($fileurl);
		$larray = explode("|",$garray[0]);
		for($i=0; $i<24; $i++){
			$pvnum=$pvnum+$larray[$i];
		}
		return $pvnum;
	}

	function ipall($daturl){
		$fileurl=$daturl."/ip.dat";
		$garray = file($fileurl);
		$larray = explode("|",$garray[0]);
		for($i=0; $i<24; $i++){
			$ipnum=$ipnum+$larray[$i];
		}
		return $ipnum;
	}

	function pvnew($daturl){
		$fileurl=$daturl."/pv.dat";
		$num="0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|"."\r\n";
		$fp = @fopen($fileurl,"w+");
		fwrite($fp,$num);
		fclose($fp);
	}

	function ipnew($daturl){
		$fileurl=$daturl."/ip.dat";
		$num="0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|"."\r\n";
		$fp = @fopen($fileurl,"w+");
		fwrite($fp,$num);
		fclose($fp);
	}

	function pvipnew($daturl){
		$fileurl=$daturl."/pvip.dat";
		$num="0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|"."\r\n";
		$num.="0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|"."\r\n";
		$fp = @fopen($fileurl,"w+");
		fwrite($fp,$num);
		fclose($fp);
	}

	function ipallnew($daturl){
		$fileurl=$daturl."/ip_all.dat";
		$num="";
		$fp = @fopen($fileurl,"w+");
		fwrite($fp,$num);
		fclose($fp);
	}

	function fromnew($daturl){
		$fileurl=$daturl."/file_fm.dat";
		$num="";
		$fp = @fopen($fileurl,"w+");
		fwrite($fp,$num);
		fclose($fp);
	}

	function fromnew2($daturl){
		$fileurl=$daturl."/from.dat";
		$num="";
		$fp = @fopen($fileurl,"w+");
		fwrite($fp,$num);
		fclose($fp);
	}

	function gonew($daturl){
		$fileurl=$daturl."/file_go.dat";
		$num="";
		$fp = @fopen($fileurl,"w+");
		fwrite($fp,$num);
		fclose($fp);
	}

	function keynew($daturl){
		$fileurl=$daturl."/file_key.dat";
		$num="";
		$fp = @fopen($fileurl,"w+");
		fwrite($fp,$num);
		fclose($fp);
	}

	function todayadd($daturl){
		$fileurl=$daturl."/day2.dat";
		$fp    = @fopen($fileurl,"r+");
		$number = fgets($fp,8);
		$number +=1;
		rewind($fp);
		fputs($fp,$number);
		fclose($fp);
	}

	function monthnew($daturl){
		$fileurl=$daturl."/pvip_mon.dat";
		if (!file_exists($fileurl)) {/*如果文件不存在*/
			$num="0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|"."\r\n";
			$fp = @fopen($fileurl,"w+");

			fwrite($fp,$num);
			fwrite($fp,$num);
			fwrite($fp,$num);
			fwrite($fp,$num);
		}else {
			$garray = file($fileurl);
			$num="0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|"."\r\n";
			$fp = @fopen($fileurl,"w+");

			fwrite($fp,$num);
			fwrite($fp,$num);
			fwrite($fp,$garray[2]);
			fwrite($fp,$garray[3]);
		}
		fclose($fp);
	}

	function yearnew($daturl){
		$fileurl=$daturl."/pvip_ye.dat";
		if (!file_exists($fileurl)){
			$num="0|0|0|0|0|0|0|0|0|0|0|0|0|"."\r\n";
			$fp = @fopen($fileurl,"w+");

			fwrite($fp,$num);
			fwrite($fp,$num);
			fwrite($fp,$num);
			fwrite($fp,$num);
		}else{
			$garray = file($fileurl);
			$num="0|0|0|0|0|0|0|0|0|0|0|0|0|"."\r\n";
			$fp = @fopen($fileurl,"w+");

			fwrite($fp,$num);
			fwrite($fp,$num);
			fwrite($fp,$garray[2]);
			fwrite($fp,$garray[3]);
		}
		fclose($fp);
	}

	function forkey($user_ad){
		if(ereg(".google.",$user_ad)){$comefen="q=";$comepass=1;$comelei="UTF-8";}
		if(ereg(".yahoo.",$user_ad)){$comefen="p=";$comepass=1;$comelei="UTF-8";}
		if(ereg(".msn.",$user_ad)){$comefen="q=";$comepass=1;$comelei="UTF-8";}
		if(ereg(".alltheweb.",$user_ad)){$comefen="q=";$comepass=1;$comelei="UTF-8";}
		if(ereg(".baidu.",$user_ad)){$comefen="wd=";$comepass=1;}
		if(ereg(".3721.",$user_ad)){$comefen="p=";$comepass=1;}
		if(ereg(".sohu.",$user_ad)){$comefen="query=";$comepass=1;}
		if(ereg(".163.",$user_ad)){$comefen="q=";$comepass=1;}
		if(ereg(".sina.",$user_ad)){$comefen="searchkey=";$comepass=1;}
		if(ereg(".tom.",$user_ad)){$comefen="word=";$comepass=1;}
		if(ereg(".zhongsou.",$user_ad)){$comefen="word=";$comepass=1;}
		if(ereg(".yisou.",$user_ad)){$comefen="p=";$comepass=1;}
		if(ereg(".sogou.",$user_ad)){$comefen="query=";$comepass=1;}
		if(ereg(".qq.",$user_ad)){$comefen="word=";$comepass=1;}
		if(ereg(".onseek.",$user_ad)){$comefen="term=";$comepass=1;}
		if(ereg(".lycos.",$user_ad)){$comefen="query=";$comepass=1;}
		if(ereg(".aol.",$user_ad)){$comefen="query=";$comepass=1;}

		if($comepass=="1"){
			$comekey = explode($comefen,$user_ad);
			$comekey = explode("&",$comekey[1]);
			$comekey = explode("&",$comekey[0]);
			$comekey[0] = urldecode($comekey[0]);
			$s = $comekey[0];
			if($comelei!="UTF-8"){
				$s = Common::nc_change_charset($s,'gbk_to_utf8');
			}
		}
		if(ereg("%u",$s)){$s="";}
		return $s;
	}

	function keyadd($daturl,$s,$user_ad){
		$fileurl=$daturl."/file_key.dat";
		if (!file_exists($fileurl)) {/*判断文件是否存在*/
			$this->keynew($daturl);
		}
		$fp = @fopen($fileurl,"r");
		$garray = @fread($fp,filesize($fileurl));
		fclose($fp);
		$fromyn="";
		$fromyn2="";
		if(ereg($s,$garray)){$fromyn="1";}else{$fromyn="";}
		if($fromyn=="1"){
			$garray = file($fileurl);
			$cog=count($garray);
			for($i=0; $i<$cog; $i++) {
				$larray = explode("|",$garray[$i]);
				if($s==$larray[1]){
					$larray[0]=$larray[0]+1;
					$larray[0]=sprintf("%08d",$larray[0]);
					$garray[$i] = implode("|",$larray);
					$fromyn2="1";
				}
			}
			$list=implode("",$garray);
			$fp = @fopen($fileurl,"w");
			flock($fp,LOCK_EX);
			fwrite($fp,$list);
			flock($fp,LOCK_UN);
			fclose($fp);
		}
		if($fromyn=="" or $fromyn2==""){
			$num="1";
			$s = trim($s);
			$num=sprintf("%08d",$num);
			$filefm=array($num,"$s",$user_ad);
			$larray = implode("|",$filefm)."|\n";
			$fp = fopen($fileurl,"a+");
			fwrite($fp,$larray);
			fclose($fp);
		}
	}

	/**
	 * 检测当天文件夹是否存在
	 */
	function check_dir($daturl){
		/*判断配置信息文件,day1.dat起始时间，day2.dat统计天数 */
		if (!file_exists($daturl.'/day1.dat')) {
			$this->make_file($daturl.'/day1.dat',date("Y-m-d H:i:s"));
		}
		if (!file_exists($daturl.'/day2.dat')) {
			$this->make_file($daturl.'/day2.dat','0');
		}
		if (!file_exists($daturl.'/'.date('Y')) || !file_exists($daturl.'/'.date('Y').'/'.'day_ye.dat') || !file_exists($daturl.'/'.date('Y').'/'.'pvip_ye.dat')){/*判断当年年份文件夹是否存在*/
			if ($this->make_ye_dir($daturl)){
				if ($this->make_mon_dir($daturl)) {
					$this->make_today_dir($daturl);
					return true;
				}
			}
		}elseif (!file_exists($daturl.'/'.date('Y').'/'.date('n')) || !file_exists($daturl.'/'.date('Y').'/'.date('n').'/'.'day_mon.dat') || !file_exists($daturl.'/'.date('Y').'/'.date('n').'/'.'pvip_mon.dat')){/*判断当月月份文件夹是否存在*/
			if ($this->make_mon_dir($daturl)) {
				$this->make_today_dir($daturl);
				return true;
			}
		}elseif (!file_exists($daturl.'/'.date('Y').'/'.date('n').'/'.date('j'))){/*判断当天文件夹是否存在*/
			$this->make_today_dir($daturl);
			return true;
		}
		return false;
	}

	/**
	 * 建立年份文件夹
	 */
	function make_ye_dir($daturl){
		@mkdir($daturl.'/'.date('Y'),0777);
		$this->newyear($daturl.'/'.date('Y'));/*建立day_ye.dat*/
		$this->yearnew($daturl.'/'.date('Y'));/*建立pvip_ye.dat*/
		return true;
	}

	/**
	 * 建立月份文件夹
	 */
	function make_mon_dir($daturl){
		@mkdir($daturl.'/'.date('Y').'/'.date('n'),0777);
		$this->newmonth($daturl.'/'.date('Y').'/'.date('n'));/*建立day_mon.dat*/
		$this->monthnew($daturl.'/'.date('Y').'/'.date('n'));/*建立pvip_mon.dat*/
		return true;
	}

	/**
	 * 建立当天文件夹
	 */
	function make_today_dir($daturl){
		@mkdir($daturl.'/'.date('Y').'/'.date('n').'/'.date('j'),0777);
		return true;
	}

	/**
	 * 建立文件
	 */
	function make_file($fileurl,$file_content){
		$fp = @fopen($fileurl,'w');
		@fwrite($fp,"$file_content");
		@fclose($fp);
		@chmod($fileurl,0777);
		return true;
	}

	/**
	 * 取最大PV和IP，记录数量，发生时间(unix时间戳)
	 */
	function pvip_top($daturl,$daturl_old){
		/*取前一天数据*/
		$fp = @fopen($daturl_old.'/day_top.dat','r');
		$array_old = @fread($fp,filesize($daturl_old.'/day_top.dat'));
		fclose($fp);
		$array = explode('|',$array_old);
		if (!file_exists($daturl.'/pvip_top.dat')){/*如果不存在，则建立文件，并记录当天为最大PV和IP*/

			$line = $array[0].'|'.(time()-24*60*60)."\r\n";/*最大PV量，发生时间*/
			$line2 = $array[1].'|'.(time()-24*60*60)."\r\n";/*最大IP量，发生时间*/

			$fp = @fopen($daturl.'/pvip_top.dat','w+');
			fwrite($fp,$line);
			fwrite($fp,$line2);
			fclose($fp);
		}else {/*如果存在，则与判断大小，如果比pvip.top.dat大，则更新文件*/
			$garray = file($daturl.'/pvip_top.dat');
			$array1 = explode('|',$garray[0]);/*PV*/
			$array2 = explode('|',$garray[1]);/*PV*/
			/*比较*/
			if ($array1[0]<$array[0]){/*pv*/
				$line = $array[0].'|'.(time()-24*60*60)."\r\n";/*最大PV量，发生时间*/
			}else {
				$line = $garray[0];/*最大PV量，发生时间*/
			}
			if ($array2[0]<$array[1]){/*ip*/
				$line2 = $array[1].'|'.(time()-24*60*60)."\r\n";/*最大ip量，发生时间*/
			}else {
				$line2 = $garray[1];/*最大ip量，发生时间*/
			}
			$fp = fopen($daturl.'/pvip_top.dat','w+');
			fwrite($fp,$line);
			fwrite($fp,$line2);
			fclose($fp);
		}
	}

	/**
	 * 客户端信息（操作系统）
	 */
	function getOS()
	{
		$agent=$_SERVER['HTTP_USER_AGENT'];
		$os=false;
		if(eregi('win',$agent)&&strpos($agent,'95')){
			$os='Windows 95';
		}else if(eregi('win 9x',$agent)&&strpos($agent,'4.90')){
			$os='Windows ME';
		}else if(eregi('win',$agent)&&ereg('98',$agent)){
			$os='Windows 98';
		}else if(eregi('win',$agent)&&eregi('nt 5.0',$agent)){
			$os='Windows 2000';
		}else if(eregi('win',$agent)&&eregi('nt 5.1',$agent)){
			$os='Windows XP';
		}else if(eregi('win',$agent)&&eregi('nt',$agent)){
			$os='Windows NT';
		}else if(eregi('win',$agent)&&ereg('32',$agent)){
			$os='Windows 32';
		}else if(eregi('linux',$agent)){
			$os='Linux';
		}else if(eregi('unix',$agent)){
			$os='Unix';
		}else if(eregi('sun',$agent)&&eregi('os',$agent)){
			$os='SunOS';
		}else if(eregi('ibm',$agent)&&eregi('os',$agent)){
			$os='IBM OS/2';
		}else if(eregi('Mac',$agent)&&eregi('PC',$agent)){
			$os='Macintosh';
		}else if(eregi('PowerPC',$agent)){
			$os='PowerPC';
		}else if(eregi('AIX',$agent)){
			$os='AIX';
		}else if(eregi('HPUX',$agent)){
			$os='HPUX';
		}else if(eregi('NetBSD',$agent)){
			$os='NetBSD';
		}else if(eregi('BSD',$agent)){
			$os='BSD';
		}else if(eregi('OSF1',$agent)){
			$os='OSF1';
		}else if(eregi('IRIX',$agent)){
			$os='IRIX';
		}else if(eregi('FreeBSD',$agent)){
			$os='FreeBSD';
		}else if(eregi('teleport',$agent)){
			$os='teleport';
		}else if(eregi('flashget',$agent)){
			$os='flashget';
		}else if(eregi('webzip',$agent)){
			$os='webzip';
		}else if(eregi('offline',$agent)){
			$os='offline';
		}else{
			$os='Unknow';
		}
		return $os;
	}

	/**
	 * 客户端信息（浏览器）
	 */
	function getBrowse()
	{
		global $_SERVER;
		$Agent=$_SERVER['HTTP_USER_AGENT'];
		$browser='';
		$Browsers=array('Lynx','MOSAIC','AOL','Opera','JAVA','MacWeb','WebExplorer','OmniWeb');
		for($i=0;$i<=7;$i++){
			if(strpos($Agent,$Browsers[$i]))
			{
				$browser=$Browsers[$i];
				$browserver='';
			}
		}
		if(ereg('Mozilla',$Agent)&&!ereg('MSIE',$Agent)){
			$temp=explode('(',$Agent);
			$Part=$temp[0];
			$temp=explode('/',$Part);
			$browserver=$temp[1];
			$browserver=preg_replace('/([d.]+)/','',$browserver);//在$browserver中搜索([d.]+)模式的匹配项并替换为1
			$browserver=$browserver;
			$browser='Netscape Navigator';
		}
		if(ereg('Mozilla',$Agent)&&ereg('Opera',$Agent)){
			$temp=explode('(',$Agent);
			$Part=$temp[1];
			$temp=explode(')',$Part);
			$browserver=$temp[1];
			$temp=explode('',$browserver);
			$browserver=$temp[2];
			$browserver=preg_replace('/([d.]+)/','',$browserver);
			$browserver=$browserver;
			$browserver='Opera';
		}

		if(ereg('Mozilla', $Agent) && ereg('MSIE', $Agent)){
			$temp = explode('(', $Agent);
			$Part = $temp[1];
			$temp = explode(';', $Part);
			$Part = $temp[1];
			$temp = explode(' ', $Part);
			$browserver = $temp[2];
			$browserver = preg_replace('/([d.]+)/','',$browserver);
			$browserver = $browserver;
			$browser = 'Internet Explorer';
		}

		if($browser!=''){
			$browseinfo=$browser.''.$browserver;
		}else{
			$browseinfo=false;
		}
		return $browseinfo;
	}


	/**
	 * 统计客户端信息（操作系统）
	 */
	function fileos($daturl){
		if (!file_exists($daturl.'/file_os.dat')) {
			$this->make_file($daturl.'/file_os.dat',"");
		}
		$OS = $this->getOS();/*取客户端信息*/
		/*当日统计*/
		$fileurl = $daturl.'/file_os.dat';
		$fp = @fopen($fileurl,"r");
		$garray = @fread($fp,filesize($fileurl));
		fclose($fp);
		$fromyn="";
		$fromyn2="";
		if(ereg($OS,$garray)){$fromyn="1";}else{$fromyn="";}
		if($fromyn=="1"){
			$garray = file($fileurl);
			$cog=count($garray);
			for($i=0; $i<$cog; $i++) {
				$larray = explode("|",$garray[$i]);
				if($OS==$larray[1]){
					$larray[0]=$larray[0]+1;
					$larray[0]=sprintf("%08d",$larray[0]);
					$garray[$i] = implode("|",$larray);
					$fromyn2="1";
				}
			}
			$list=implode("",$garray);
			$fp = fopen($fileurl,"w");
			flock($fp,LOCK_EX);
			fwrite($fp,$list);
			flock($fp,LOCK_UN);
			@fclose($fp);
		}
		if($fromyn=="" or $fromyn2==""){
			$num="1";
			$filefm=array($num,$OS);
			$larray = implode("|",$filefm)."|\n";
			$fp = fopen($fileurl,"a+");
			fwrite($fp,$larray);
			@fclose($fp);
		}
		/*累计统计*/
		$fileurl = "..".$this->_configinfo[stats][datapath].'/all_os.dat';
		$fp = @fopen($fileurl,"r");
		$garray = @fread($fp,filesize($fileurl));
		@fclose($fp);
		$fromyn="";
		$fromyn2="";
		if(ereg($OS,$garray)){$fromyn="1";}else{$fromyn="";}
		if($fromyn=="1"){
			$garray = file($fileurl);
			$cog=count($garray);
			for($i=0; $i<$cog; $i++) {
				$larray = explode("|",$garray[$i]);
				if($OS==$larray[1]){
					$larray[0]=$larray[0]+1;
					$larray[0]=sprintf("%08d",$larray[0]);
					$garray[$i] = implode("|",$larray);
					$fromyn2="1";
				}
			}
			$list=implode("",$garray);
			$fp = fopen($fileurl,"w");
			flock($fp,LOCK_EX);
			fwrite($fp,$list);
			flock($fp,LOCK_UN);
			@fclose($fp);
		}
		if($fromyn=="" or $fromyn2==""){
			$num="1";
			$filefm=array($num,$OS);
			$larray = implode("|",$filefm)."|\n";
			$fp = fopen($fileurl,"a+");
			fwrite($fp,$larray);
			@fclose($fp);
		}
		return true;
	}

	/**
	 * 统计客户端信息（浏览器）
	 */
	function filebrowse($daturl){
		if (!file_exists($daturl.'/file_browse.dat')) {
			$this->make_file($daturl.'/file_browse.dat',"");
		}
		$browse = $this->getBrowse();/*取客户端信息*/
		//当日统计
		$fileurl = $daturl.'/file_browse.dat';
		$fp = @fopen($fileurl,"r");
		$garray = @fread($fp,filesize($fileurl));
		fclose($fp);
		$fromyn="";
		$fromyn2="";
		if(ereg($browse,$garray)){$fromyn="1";}else{$fromyn="";}
		if($fromyn=="1"){
			$garray = file($fileurl);
			$cog=count($garray);
			for($i=0; $i<$cog; $i++) {
				$larray = explode("|",$garray[$i]);
				if($browse==$larray[1]){
					$larray[0]=$larray[0]+1;
					$larray[0]=sprintf("%08d",$larray[0]);
					$garray[$i] = implode("|",$larray);
					$fromyn2="1";
				}
			}
			$list=implode("",$garray);
			$fp = fopen($fileurl,"w");
			flock($fp,LOCK_EX);
			fwrite($fp,$list);
			flock($fp,LOCK_UN);
			fclose($fp);
		}
		if($fromyn=="" or $fromyn2==""){
			$num="1";
			$filefm=array($num,$browse);
			$larray = implode("|",$filefm)."|\n";
			$fp = fopen($fileurl,"a+");
			fwrite($fp,$larray);
			fclose($fp);
		}

		//累计统计
		$fileurl = "..".$this->_configinfo[stats][datapath].'/all_browse.dat';
		$fp = @fopen($fileurl,"r");
		$garray = @fread($fp,filesize($fileurl));
		fclose($fp);
		$fromyn="";
		$fromyn2="";
		if(ereg($browse,$garray)){$fromyn="1";}else{$fromyn="";}
		if($fromyn=="1"){
			$garray = file($fileurl);
			$cog=count($garray);
			for($i=0; $i<$cog; $i++) {
				$larray = explode("|",$garray[$i]);
				if($browse==$larray[1]){
					$larray[0]=$larray[0]+1;
					$larray[0]=sprintf("%08d",$larray[0]);
					$garray[$i] = implode("|",$larray);
					$fromyn2="1";
				}
			}
			$list=implode("",$garray);
			$fp = fopen($fileurl,"w");
			flock($fp,LOCK_EX);
			fwrite($fp,$list);
			flock($fp,LOCK_UN);
			fclose($fp);
		}
		if($fromyn=="" or $fromyn2==""){
			$num="1";
			$filefm=array($num,$browse);
			$larray = implode("|",$filefm)."|\n";
			$fp = fopen($fileurl,"a+");
			fwrite($fp,$larray);
			fclose($fp);
		}
		return true;
	}

	/**
	 * 客户端分辨率
	 */
	function file_screen($daturl,$screen_width,$screen_height){
		/*判断是否已经记录了该cookie的统计*/
		$str = $this->getCookies('statics_sign');
		if ($str == '1'){
			return true;
		}

		if (!file_exists($daturl.'/file_screen.dat')) {
			$this->make_file($daturl.'/file_screen.dat',"");
		}
		/*分辨率格式 宽x高*/
		$screen = $screen_width.'x'.$screen_height;
		//当日统计
		$fileurl = $daturl.'/file_screen.dat';
		$fp = @fopen($fileurl,"r");
		$garray = @fread($fp,filesize($fileurl));
		fclose($fp);
		$fromyn="";
		$fromyn2="";
		if(ereg($screen,$garray)){$fromyn="1";}else{$fromyn="";}
		if($fromyn=="1"){
			$garray = file($fileurl);
			$cog=count($garray);
			for($i=0; $i<$cog; $i++) {
				$larray = explode("|",$garray[$i]);
				/*如果存在相同项，则数量加1*/
				if($screen==$larray[1]){
					$larray[0]=$larray[0]+1;
					$larray[0]=sprintf("%08d",$larray[0]);
					$garray[$i] = implode("|",$larray);
					$fromyn2="1";
				}
			}
			$list=implode("",$garray);
			$fp = fopen($fileurl,"w");
			flock($fp,LOCK_EX);
			fwrite($fp,$list);
			flock($fp,LOCK_UN);
			fclose($fp);
		}
		if($fromyn=="" or $fromyn2==""){
			$num="1";
			$filefm=array($num,$screen);
			$larray = implode("|",$filefm)."|\n";
			$fp = fopen($fileurl,"a+");
			fwrite($fp,$larray);
			fclose($fp);
		}

		/*写入COOKIE中*/
		$this->setCookies("statics_sign", '1',$this->cookie_expire_time);

		//累计统计
		$fileurl = "..".$this->_configinfo[stats][datapath].'/all_screen.dat';
		if (!file_exists($fileurl)) {
			$this->make_file($fileurl,"");
		}

		$fp = @fopen($fileurl,"r");
		$garray = @fread($fp,filesize($fileurl));
		fclose($fp);
		$fromyn="";
		$fromyn2="";
		if(ereg($screen,$garray)){$fromyn="1";}else{$fromyn="";}
		if($fromyn=="1"){
			$garray = file($fileurl);
			$cog=count($garray);
			for($i=0; $i<$cog; $i++) {
				$larray = explode("|",$garray[$i]);
				if($screen==$larray[1]){
					$larray[0]=$larray[0]+1;
					$larray[0]=sprintf("%08d",$larray[0]);
					$garray[$i] = implode("|",$larray);
					$fromyn2="1";
				}
			}
			$list=implode("",$garray);
			$fp = fopen($fileurl,"w");
			flock($fp,LOCK_EX);
			fwrite($fp,$list);
			flock($fp,LOCK_UN);
			fclose($fp);
		}
		if($fromyn=="" or $fromyn2==""){
			$num="1";
			$filefm=array($num,$screen);
			$larray = implode("|",$filefm)."|\n";
			$fp = fopen($fileurl,"a+");
			fwrite($fp,$larray);
			fclose($fp);
		}
		return true;
	}

	//取IP地址，主要是为了兼容IIS和APACHE服务器的设置问题
	function get_ip(){
		if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown")) {
			$ip = getenv("HTTP_CLIENT_IP");
		}elseif (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown")){
			$ip = getenv("HTTP_X_FORWARDED_FOR");
		}elseif (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown")){
			$ip = getenv("REMOTE_ADDR");
		}else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown")){
			$ip = $_SERVER['REMOTE_ADDR'];
		}else {
			$ip = "unknown";
		}
		return $ip;
	}

	function main(){
		$user_time = date("G");/*小时，24 小时格式，没有前导零*/
		$user_time2 = date("G:i:s");/*24 小时格式没有前导零，有前导零的分钟数，秒数有前导零*/
		$user_ip = $this->get_ip();/*取客户端IP*/
		$user_ad = Common::unescape($this->_input['user_ad'],$this->_configinfo['websit']['ncharset']);/*来源页面*/
		$filename2 = urldecode($this->_input['filename2']);/*当前页面*/
		if($user_ad == ""){
			$user_ad = $this->_configinfo[websit][site_url];
		}
		$daturl = "../".$this->_configinfo[stats][datapath];
		$dir_flag = $this->check_dir($daturl);/*检测文件夹,没有则建立,如果返回true则为新建立*/
		$daturl_2 = $daturl;
		$daturl = $daturl.'/'.date('Y').'/'.date('n').'/'.date('j');/*重新制定文件路径*/
		$fileurl = $daturl."/day_why.dat";/*当天的日期，日*/
		if (!file_exists($fileurl)) {
			$this->make_file($fileurl,date('j'));/*建立*/
		}
		$fday1 = fopen($fileurl,"r");
		$user_today = fgets($fday1,4);
		fclose($fday1);
		$fileurl2=$daturl_2.'/'.date('Y').'/'.date('n')."/day_mon.dat";/*当天的日期，月*/
		$fday2 = fopen($fileurl2,"r");
		$user_month = fgets($fday2,4);
		fclose($fday2);
		$fileurl3=$daturl_2.'/'.date('Y')."/day_ye.dat";/*当天的日期，年*/
		$fday3 = fopen($fileurl3, "r");
		$user_year = fgets($fday3, 6);
		fclose($fday3);
		$day = date("j");
		$month = date("n");
		$year = date("Y");
		if (true != $dir_flag){/*已经存在文件夹*/
			$dayok="0";
		}else{/*新建文件夹*/
			$dayok="1";
		}
		if($user_month == $month){
			$monthok="0";
		}else{
			$monthok="1";
		}
		if($user_year == $year){
			$yearok="0";
		}else{
			$yearok="1";
		}

		$this->pv($daturl,$user_time);/*访问量统计*/
		$this->from($daturl,$user_time2,$user_ip,$filename2,$user_ad);/*当前页来源*/
		$this->filego($daturl,$filename2);/*记录当前页面的访问数量*/
		$this->filefm($daturl,$user_ad);/*记录来源页的访问数量*/
		$s=$this->forkey($user_ad);/*搜索引擎到达当前页面的关键字*/
		if($s!=""){
			$this->keyadd($daturl,$s,$user_ad);/*记录搜索关键字*/
		}
		$ippass2 = $this->ippass($daturl,$user_ip);
		if($ippass2=="1"){
			$this->ip($daturl,$user_time);
		}
		$this->fileos($daturl);/*统计客户端信息（操作系统）*/
		$this->filebrowse($daturl);/*统计客户端信息（浏览器）*/
		$this->file_screen($daturl,$this->_input['screen_width'],$this->_input['screen_height']);/*统计客户端信息（分辨率）*/
		/*取上一天的时间*/
		$last_year = date('Y',(time()-24*60*60));
		$last_mon = date('n',(time()-24*60*60));
		$last_day = date('j',(time()-24*60*60));

		if($dayok=="1" && file_exists($daturl_2.'/'.$last_year.'/'.$last_mon.'/'.$last_day)){/*如果为新建文件夹的话，则进行上一天的记录总结*/

			$daturl_old = $daturl_2.'/'.$last_year.'/'.$last_mon.'/'.$last_day;/*上一天的文件路径*/
			$this->pvip($daturl_old);/*把记录上一天的访问量和IP记录到上一天的pvip.dat中*/
			$pvdaynum = $this->pvall($daturl_old);/*一天的访问量*/
			$ipdaynum = $this->ipall($daturl_old);/*一天的IP量*/
			$this->pvip_month($daturl_2.'/'.$last_year.'/'.$last_mon,$pvdaynum,$ipdaynum,$last_day);/*统计该月的PV和IP数*/
			$this->pvip_year($daturl_2.'/'.$last_year,$pvdaynum,$ipdaynum,$last_mon);/*统计该年的PV和IP数*/
			$this->top_day($daturl_old,$pvdaynum,$ipdaynum);/*记录一天的访问量和IP总数*/
			$this->todayadd($daturl_2);/*今天的访问量*/
			$this->copy_today($daturl_old);/*备份上一天的数据*/
			$file1=$daturl_old."/file_fm.dat";
			$file2=$daturl_old."/fmtop10.dat";
			$this->top10($file1,$file2);/*统计来源页面访问量前10位*/
			$file1=$daturl_old."/file_go.dat";
			$file2=$daturl_old."/gotop10.dat";
			$this->top10($file1,$file2);/*统计当前页面访问量前10位*/
			$file1=$daturl_old."/file_key.dat";
			$file2=$daturl_old."/keytop10.dat";
			$this->top10($file1,$file2);/*统计到达当前页面搜索网站前10位*/

			$this->pvip_top($daturl_2,$daturl_old);/*记录最大PV和IP出现时间，次数*/
		}
		echo true;exit;
	}
}

$statics = new Statics();
$statics->main();
unset($statics);

?>