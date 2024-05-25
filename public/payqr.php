<?php
ob_start();
session_start();
header("Content-type: text/html; charset=utf-8");
error_reporting(0);
set_time_limit(0);
$datenow=date("Y-m-d");
$transaction_leng=14;
$url_api="http://tmwallet.thaighost.net/apiwallet.php";
//$url_api="https://www.tmweasy.com/apiwallet.php";

//-----------------------------------------config----------------------------------------------------
//ข้อมูล https://www.tmweasy.com ต้องสมัครสมาชิกที่เว็บนี้ก่อนแล้วเอา id มาใส
$tmapi_user="pay21"; // Username
$tmpapi_assword="www888XXX"; // รหัสผ่าน
//ข้อมูลบัญชี

$con_id[1]="";
$con_id[2]="104375";
$ac_code[]="tmpwoktXABBQMDi[pl]FTaDTwuvkLUPi3FXGCMqwME1jnd5o05NckR2suJlM8TnmrrOPwA[pl]zh";
$ac_code[104375]="tmpwoktXABBQMDi[pl]FTaDTwuvkLUK1qcMU3x3sSCuXaGyNpSnKxh[pl]xcVo[sa]zbx9JacCQoHSQWc25clcyWzjP3GVpItjaYQ[tr][tr]";
//config ฐานข้อมูล
$sql_server="localhost";
$sql_user="forge";
$sql_password="0zlm6ovMyXDJFZg5VaDK";
$sql_database="forge";

//ตัวคูณเครดิตร
$mul=1;



//-----------------------------------------config----------------------------------------------------

function tmtopupconnect($tmuser,$tmpassword,$truepassword,$ip,$session,$transactionid,$action,$ref1,$ac_code){
	global $url_api;
	$urlconnect=$url_api."?username=$tmuser&password=$tmpassword&action=$action&tmemail=$trueemail&truepassword=tmpwoktXABBQMDi..&session=$session&transactionid=$transactionid&clientip=$ip&ref1=$ref1&json=1&ac_code=$ac_code";
	$ch = curl_init($urlconnect);
	//curl_setopt($ch, CURLOPT_SSLVERSION,3);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; th; rv:1.9.2.12) Gecko/20101026 Firefox/3.6.12");
	curl_setopt($ch, CURLOPT_HEADER, 0);
	@curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	return $doc=curl_exec($ch);
	return curl_error($ch);
	curl_close($ch);
}
function capchar($ip,$tmuser){
	return md5($tmuser.$ip);
}
function my_ip(){
	if ($_SERVER['HTTP_CLIENT_IP']) {
		$IP = $_SERVER['HTTP_CLIENT_IP'];
	} elseif (preg_match("[0-9]",$_SERVER["HTTP_X_FORWARDED_FOR"] )) {
		$IP = $_SERVER["HTTP_X_FORWARDED_FOR"];
	} else {
		$IP = $_SERVER["REMOTE_ADDR"];
	}
		return $IP;
}


$conn=mysql_connect($sql_server,$sql_user,$sql_password) or die("connect database error!");
mysql_select_db($sql_database) or die("select database error!");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="KeyWords" content="True money,ทรูมันนี่ ,ตัดบัตรทรู ,auto truemoney" />
<META content="Copyright (c) 2010 tmweasy.com All Rights Reserved. tmweasy.com V.1" name=copyright>
<meta name="robots" content="all" />
<meta content='index, follow, all' name='robots'/>
<META Name="Googlebot" Content="index,follow">
<meta name="revisit-after" content="1 days">
<meta name="MSSmartTagsPreventParsing" content="True" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script src="https://www.tmweasy.com/js/img_box.js"></script>
</head>
<body>
<center>
	<h1>ระบบแจ้งโอนผ่าน True money Wallet อัตโนมัติ</h1>
<font size="2">
<?php
if($_POST[send]&&$_POST[amount]){
	if(strlen($_POST[transactionid])<$transaction_leng){
		echo "<script>alert('กรุณากรอก เลขที่อ้างอิง ให้ครบ!');location='';</script>";
	}else{
	$returnserver=tmtopupconnect($tmapi_user,$tmpapi_assword,$truepassword,my_ip(),$_POST[session],$_POST[transactionid],"yes",$_POST[ref1],$ac_code[$_POST[conid]]);
	$returnserver=json_decode($returnserver,true);

	if($returnserver[Status]=="check_success"){
		$money_total=$returnserver[Amount]; //จำนวนเงินที่ได้รับ
		$point=$money_total*$mul;
		mysql_query("update users set credit=credit+$point where id='$_POST[ref1]' ");
		echo "<p><h4 style='color:green'>เรียบร้อย</h4></p>
		<p>จำนวนเงิน คือ $money_total บาท ได้รับ $point เครดิตร</p>
		<p>ขอบคุณที่ใช้บริการครับ !  [ ปิดหน้านี้ได้เลย ]</p>";
		//-------------------------------------------------------------------------------------------
	}else{
		$error=$returnserver[Msg];//ค่าผิดพลาด ที่ส่งกลับมา

		//-------------------------------------------------------------------------------------------
		echo "<p><h4>ไม่สำเร็จ </h4></p>
		<p>$error</p>
		<p><a href=''>[กลับไปลองอีกครั้ง]</a> </p>";
		//-------------------------------------------------------------------------------------------
	}
	}
} else{
	$returnserver=tmtopupconnect($tmapi_user,$tmpapi_assword,"","","","","","","");
	$returnserver=json_decode($returnserver,true);
	if($returnserver[Status]=="ready"){
?>
<script>
co=0;
function loading(){
	document.getElementById("formpay").style.display="none";
	document.getElementById("loading").style.display="";
	co=co+1;
	switch(co)
	{
		case 1:
		char_load="โปรดรอสักครู่ ครับ |";
		break;
		case 2:
		char_load="โปรดรอสักครู่ ครับ /";
		break;
		case 3:
		char_load="โปรดรอสักครู่ ครับ -";
		break;
		case 4:
		char_load="โปรดรอสักครู่ ครับ \\";
		co=0;
		break;
	}
	document.getElementById("loadvip").innerHTML=char_load;
	setTimeout("loading()", 100);
}
function gen_transactionid(){
	if(document.getElementById("amount2").value==""){
		amount2="00";
	}else{
		if(document.getElementById("amount2").value.length==1){
			amount2="0"+document.getElementById("amount2").value;
		}else{
			amount2=document.getElementById("amount2").value;
		}

	}
	document.getElementById("transactionid").value=document.forms["tmtopup"]["conid"].value+document.getElementById("day").value+document.getElementById("hour").value+document.getElementById("minute").value+document.getElementById("amount").value+amount2;
	document.forms[0].submit();

}
</script>


	<hr>
	<div align="left">
	<div style="display:none" id="loading" align="center"><img src="https://www.tmweasy.com/images/loadcheck.gif"  >
	<BR><div id="loadvip"></div>
	</div>
	<form method="POST" name="tmtopup" id="formpay">
		<INPUT TYPE="hidden" NAME="send" value="ok">
		<INPUT TYPE="hidden" NAME="transactionid" id="transactionid" value="">
		<table align="center" cellpadding="0" cellspacing="0" width="500">
			<tr ><td bgcolor="fuchsia"colspan="2" align="center"><h1>แจ้งโอนผ่าน ธนาคาร</h></td></tr>
			<tr bgcolor="#00FF40"><td align="center"><h2>Step 1</h2></td><td align="center"><p><b>โอน - เติมยอด ที่ต้องการ เข้าบัญชี </b></p>
			<div style="color:#FF0080">**ควรโอนยอดให้เป็นเศษสตางค์เพื่อไม่ให้ยอดซ้ำกันในเวลาเดียวกัน เพราะถ้าซ้ำกันระบบจะตรวจสอบให้ไม่ได้</div>

			<hr>
			<label>
			<h2><input type="radio" name="conid" value="<?=$con_id[2]?>" checked> <img src="https://www.tmweasy.com/images/kbank.png" height="25"> ธ.กสิกรไทย 1033500986<br>พร้อมเพย์  004999095868401 <img src="https://promptpay.io/004999095868401.png" height="30" border="0" onclick="img_box(this)"> <br> ชื่อบัญชี พงศ์สิน พงษ์วชิรินทร์</h2>
			</label>
			</td></tr>

			<tr bgcolor="#009966"><td rowspan="2" align="center" bgcolor="#009966"><h2>Step 2</h2></td>
			<td align="center"><br><INPUT TYPE="text" NAME="ref1" placeholder="Ref1 Username" value="<?=$_GET[ref1]?>" style="width:95%;height:30px;font-size:20px"></td></tr>

			<tr bgcolor="#009966"><td align="center"><h3 style="color:white;"><br>จำนวนเงิน <input name="amount"  id="amount" placeholder="0" style="width:70px;height:30px;font-size:20px"> บาท
			<input name="amount2"  id="amount2" placeholder="00" style="width:50px;height:30px;font-size:20px" maxlength="2"> สตางค์ <br>
			<br> วันที่ <select name="day" id="day" style="width:50px;height:30px;font-size:20px">
			<?php

					$mmdispay=sprintf("%02d", $mm);
					$today=date("d");
					$yesday=date("d",strtotime("-1 day"));
					$todaycode=date("Ymd");
					$yesdaycode=date("Ymd",strtotime("-1 day"));
					echo "<option value='$todaycode' selected='selected'>$today</option>";
					echo "<option value='$yesdaycode' >$yesday</option>";

			?></select> เวลา <select name="h" id="hour" style="width:50px;height:30px;font-size:20px">
			<?php
				$hh=0;
				$select="";
				while($hh<24){
					if(date("H")==$hh){
						$select='selected="selected"';
					}
					$hhdispay=sprintf("%02d", $hh);
					echo "<option value='$hhdispay' $select>$hhdispay</option>";
					$select="";
					$hh++;
				}
			?></select> ชั่วโมง <select name="m" id="minute" style="width:50px;height:30px;font-size:20px">
			<?php
				$mm=0;
				$select="";
				while($mm<60){
					if(date("i")==$mm){
						$select='selected="selected"';
					}
					$mmdispay=sprintf("%02d", $mm);
					echo "<option value='$mmdispay' $select>$mmdispay</option>";
					$select="";
					$mm++;
				}
			?></select> นาที
			<br></h3>
			<tr bgcolor="#ff0000"><td colspan="2" align="center">
			<input type="button" value="แจ้งโอน" name="send" onClick="this.disabled=1;this.value='รอสักครู่กำลังตรวจสอบ...';loading();gen_transactionid()" style="height:30px;font-size:20px"></td></tr>
		</table>
	</form>
	</div>
<?php
	}else if($returnserver[Status]=="noready"){
		echo "<p><img src='https://www.tmweasy.com/images/busy.png'></p><p><b>กำลังมีผู้ทำรายการอยู่ โปรดรอประมาณ 20 วินาที</b> </p>
		<p><a href='tmwallet.php'>คลิกเพื่อลองใหม่อีกครั้ง</a></p>";
	}else if($returnserver[Status]=="not_connect"){
		echo "<p><img src='https://www.tmweasy.com/images/notcon.png'></p><p><b>ไม่สามารถติดต่อ Server True Money ได้ โปรดรอสักครู่..</b> </p>
		<p><a href='tmwallet.php'>คลิกเพื่อลองใหม่อีกครั้ง</a></p>";
	}else if($returnserver[Status]=="block_ip"){
		echo "<p><img src='https://www.tmweasy.com/images/block_ip.png'></p><p><b>ถูก block ip ชั่วคราว เนื่องจากทำรายการไม่ถูกต้อง เกิน 6 ครั้ง</b> </p>
		<p><a href='tmwallet.php'>คลิกเพื่อลองใหม่อีกครั้ง</a></p>";
	}else{
		echo "<p>ยังไม่พร้อมใช้งาน โปรดติดต่อผู้ดูแลระบบ </p>";
	}
}
?>
<hr>
</body>
</html>
