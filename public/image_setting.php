<?php
session_start();

if(null !== $_SESSION['login_user']){
	//画像を取得
	$upload_image = $_FILES['image'];
	$ext = pathinfo($upload_image['name'],PATHINFO_EXTENSION);
	//ファイル名決め	
	$image_filename=uniqid().".".$ext;
	//パス決め
	$image_filepath = '/src/2019techc/public/static/profile_images/'.$image_filename;
	//表示用のパスを設定して突っ込む	
	move_uploaded_file($upload_image['tmp_name'],$image_filepath);
	//DB接続
	$dbh = new PDO('mysql:host=database-1.chequt3mp7ws.us-east-1.rds.amazonaws.com;dbname=user','admin','t38byuao20');
	$image_path = null;
	
	//画像を入れ込む
	$insert_sth = $dbh->prepare('UPDATE login SET profile_image_file=(:filename) WHERE name = (:name)');
	//INSERT
	$insert_sth->execute(array(
		':filename' => $image_filename,
		':name' => $_SESSION['login_user'],
	));
	//処理が完了したので戻す
	header("Location: ./profile.php");
}else{
	header("Location: ./profile.php");
}










