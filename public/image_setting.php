<?php
session_start();
//echo "あほ　く　さ";
//
if(null !== $_SESSION['login_user']){
	//画像を取得
	//var_dump($_SESSION['login_user']);
	$upload_image = $_FILES['image'];
	$ext = pathinfo($upload_image['name'],PATHINFO_EXTENSION);
	//ファイル名決め	
	$image_filename=uniqid().".".$ext;
	//パス決め
	$image_filepath = '/src/2019techc/public/static/profile_images/'.$image_filename;
	//表示用のパスを設定して突っ込む	
	move_uploaded_file($upload_image['tmp_name'],$image_filepath);
	
	$username = $_SESSION['login_user'];
	
	//DB接続
	$dbh = new PDO('mysql:host=database-1.chequt3mp7ws.us-east-1.rds.amazonaws.com;dbname=user','admin','t38byuao20');
	$image_path = null;
	
	//idを取得
	
	$select_id = $dbh->prepare('SELECT id FROM login WHERE name = (:name)');
	$select_id->execute(array(
		':name' => $_SESSION['login_user'],
	));
	$id = $select_id->fetchAll();
	$user_id = $id[0];
	
//	var_dump($id[0]);
//	var_dump($user_id);
//exit();	
	//画像を入れ込む
	$insert_sth = $dbh->prepare('UPDATE login SET filename=(:filename) WHERE name = (:name)');
	//INSERT
	$insert_sth->execute(array(
		':filename' => $image_filename,
		':name' => $_SESSION['login_user'],
	));
	//処理が完了したので戻す
//	var_dump($insert_sth);
	header("Location: ./profile.php");
}else{
	header("Location: ./profile.php");
}










