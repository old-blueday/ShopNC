<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml"><HEAD><TITLE>ShopNC综合多用户商城 - 导出信件</TITLE>
<META http-equiv=Content-Type content="text/html; charset=UTF-8">
<STYLE type=text/css>BODY {
	FONT-SIZE: 12px; COLOR: #111111
}
P {
	FONT-SIZE: 12px; COLOR: #111111
}
TH {
	FONT-SIZE: 12px; COLOR: #111111
}
TD {
	FONT-SIZE: 12px; COLOR: #111111
}
INPUT {
	FONT-SIZE: 12px; COLOR: #111111
}
SELECT {
	FONT-SIZE: 12px; COLOR: #111111
}
TEXTAREA {
	FONT-SIZE: 12px; COLOR: #111111
}
BODY {
	PADDING-RIGHT: 10px; PADDING-LEFT: 10px; PADDING-BOTTOM: 15px; MARGIN: 0px; PADDING-TOP: 15px
}
TABLE {
	TEXT-ALIGN: left
}
H1 {
	FONT-SIZE: 16px; TEXT-ALIGN: center
}
H2 {
	PADDING-RIGHT: 0px; PADDING-LEFT: 5px; FONT-SIZE: 13px; PADDING-BOTTOM: 5px; MARGIN: 0px; PADDING-TOP: 5px; BACKGROUND-COLOR: #eee
}
P {
	PADDING-RIGHT: 0px; PADDING-LEFT: 0px; PADDING-BOTTOM: 3px; MARGIN: 15px 0px; PADDING-TOP: 3px
}
HR {
	BORDER-RIGHT: #000000 0px solid; BORDER-TOP: #d1d7dc 1px solid; BORDER-LEFT: #000000 0px solid; BORDER-BOTTOM: #000000 0px solid; HEIGHT: 0px
}
IMG {
	BORDER-TOP-WIDTH: 0px; BORDER-LEFT-WIDTH: 0px; BORDER-BOTTOM-WIDTH: 0px; BORDER-RIGHT-WIDTH: 0px
}
FORM {
	PADDING-RIGHT: 0px; PADDING-LEFT: 0px; PADDING-BOTTOM: 0px; MARGIN: 0px; PADDING-TOP: 0px
}
.B {
	FONT-WEIGHT: bold; FONT-SIZE: 12px
}
.boldFontSize12 {
	FONT-WEIGHT: bold; FONT-SIZE: 12px
}
.C {
	FONT-SIZE: 14px
}
.fontSize14 {
	FONT-SIZE: 14px
}
.CB {
	FONT-WEIGHT: bold; FONT-SIZE: 14px
}
.M {
	FONT-WEIGHT: bold; FONT-SIZE: 14px
}
.L {
	FONT-WEIGHT: bold; FONT-SIZE: 14px
}
.boldFontSize14 {
	FONT-WEIGHT: bold; FONT-SIZE: 14px
}
.D {
	FONT-SIZE: 16px
}
.C1 {
	FONT-SIZE: 16px
}
.fontSize16 {
	FONT-SIZE: 16px
}
.DB {
	FONT-WEIGHT: bold; FONT-SIZE: 16px
}
.boldFontSize16 {
	FONT-WEIGHT: bold; FONT-SIZE: 16px
}
.H {
	COLOR: #ff5500
}
.G {
	COLOR: #666666
}
.EN {
	FONT-FAMILY: Arial
}
.LM {
	LINE-HEIGHT: 120%
}
.LL {
	LINE-HEIGHT: 150%
}
.LG {
	LINE-HEIGHT: 200%
}
.ImgB {
	BORDER-RIGHT: #dddddd 1px solid; BORDER-TOP: #dddddd 1px solid; BORDER-LEFT: #dddddd 1px solid; BORDER-BOTTOM: #dddddd 1px solid
}
A:link {
	COLOR: #0044dd; TEXT-DECORATION: none
}
A:visited {
	COLOR: #0044dd; TEXT-DECORATION: none
}
A:hover {
	COLOR: #ff5500; TEXT-DECORATION: underline
}
A:active {
	COLOR: #ff5500; TEXT-DECORATION: underline
}
A.U:link {
	COLOR: #0044dd; TEXT-DECORATION: underline
}
A.U:visited {
	COLOR: #0044dd; TEXT-DECORATION: underline
}
A.U:hover {
	COLOR: #ff5500; TEXT-DECORATION: underline
}
A.U:active {
	COLOR: #ff5500; TEXT-DECORATION: underline
}
.msg {
	BORDER-RIGHT: #aaa 1px solid; BORDER-TOP: #aaa 1px solid; MARGIN-BOTTOM: 15px; BORDER-LEFT: #aaa 1px solid; BORDER-BOTTOM: #aaa 1px solid
}
.time {
	FLOAT: right; MARGIN: -18px 5px 0px
}
.content {
	PADDING-RIGHT: 10px; PADDING-LEFT: 10px; PADDING-BOTTOM: 10px; FONT: 1em/1.6em arial; OVERFLOW: hidden; COLOR: #222; PADDING-TOP: 10px
}
BLOCKQUOTE {
	BORDER-RIGHT: #ddd 1px dashed; PADDING-RIGHT: 5px; BORDER-TOP: #ddd 1px dashed; PADDING-LEFT: 5px; PADDING-BOTTOM: 5px; MARGIN: 0px 5px 0px 15px; BORDER-LEFT: #ddd 1px dashed; COLOR: #333; PADDING-TOP: 5px; BORDER-BOTTOM: #ddd 1px dashed; BACKGROUND-COLOR: #f9f9f9
}
BLOCKQUOTE P {
	COLOR: #333
}
CITE {
	FONT-WEIGHT: bold; FONT-STYLE: normal
}
.MemberSign {
	BORDER-TOP: #ddd 1px solid; MARGIN-TOP: 10px
}
</STYLE>

<META content="MSHTML 6.00.2900.3199" name=GENERATOR></HEAD>
<BODY>
<H1><?php echo $_SESSION['s_login']['name']; ?>的<?php if ($output['genre'] == 'receive') { ?> 收件夹 <?php } ?><?php if ($output['genre'] == 'send') { ?> 发件夹 <?php } ?> </H1>
<?php if ( is_array( $output['message_array'] ) ) { ?>
	<?php foreach ( $output['message_array'] as $list ) {?>
		<DIV class=msg>
		<H2>
			<?php 
				if ( $list['send_name'] == '0' ) {
					echo "系统";
				} else {
					echo $list['send_name'];
				}
			?>
			:&gt;系统提醒:<?php echo $list['title']; ?>
		</H2>
		<DIV class=time><?php echo $list['send_time']; ?></DIV>
		<DIV class=content><?php echo $list['content']; ?></DIV></DIV>
	<?php } ?>
<?php } ?>
</BODY></HTML>