<?php
	$api_url="http://tmwallet.thaighost.net/apipp.php";
	$tmweasy_user="pay21";
	$tmweasy_password="www888XXX";

	$con_id="104376"; //conid ที่ได้จากการเปิดใช้งาน Qr Promptpay Api บนเว็บ  tmweasy
	$bbl_accode="tmpwoktXABBQMDi[pl]FTaDTwuvkLUK1qcMU3x3sSCuXaGyNpSnKxh[pl]xcVo[sa]zbx9JacCQoHSQWc25clcyWzjP3GVpItjaYQ[tr][tr]";//accode จากการเข้ารหัส id และ รหัสผ่านธนาคาร ที่  https://www.tmweasy.com/encode.php
	$bbl_account_no="1001770140";//เลขบัญชีธนาคารกรุงเทพ หรือ กสิกร  ใส่เฉพาะตัวเลข
	$prommpay_no="004999095868393";	//เลข ID พร้อมเพย์ ใส่เฉพาะตัวเลขเช่น เบอร์โทร เลขบัตร ปชช *กรณีเชื่อมกับกสิกร สามารถนำเลข e-wallet บนแอปกสิกรมาใส่ได้เลย แล้วกำหนด $prommpay_type เป็น 03   วิธีดูเลข E-Wallet บนแอปกสิกร  https://iot.thaighost.net/e_kbank.php
    // $prommpay_no="010555408444200";
    // $prommpay_no="900000908047";
    $prommpay_type="03";//ประเพทพร้อมเพย์  01 = Mobile No., 02 = ID No./Tax No., 03 = E-Wallet No.
	$prommpay_name="พงศ์สิน พงษ์วชิรินทร์";//ชื่อบัญชี

	$mony_type=0;//0=input , 1 = Select
	$mony_list=array(50,80,100,150,300,500);//list ราคาที่ให้เลือกเติมกรณีเลือก $mony_type เป็น 1

	$mul_credit=1;//ตัวคูณเครดิตร กับยอดเงินที่โอนมา

	//--------------- การเชื่อม ฐานข้อมูล เพื่ออัพเดทเครดิตรให้ลูกค้า----------------
	$database_host="localhost";
	$database_user="forge";
	$database_password="0zlm6ovMyXDJFZg5VaDK";
	$database_db_name="forge";
	$database_type="2";//1 = mysql , 2 = mysqli ,3 = mssql (microsoft sql server) , 4 = Odbc for microsoft sql server , 5 = sqlsrv for microsoft sql server , 6 = pdo_sqlsrv  for microsoft sql server

	$database_table="users";//ตารางที่เต็มข้อมูลลูกค้า หรือ เก็บข้อมูลเครดิตร
	$database_user_field="id";//ฟิวที่ใช้ในการอ้างอิง user เช่น username userid
	$database_point_field="credit";//ฟิวที่ใช้ในการเก็บค่า พ้อย เครดิตร ที่ต้องการให้อัพเดทหลังเต็มเสร็จ
?>
