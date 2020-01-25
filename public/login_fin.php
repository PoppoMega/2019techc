<?php
//接続

$dbh = new PDO('mysql:host=database-1.chequt3mp7ws.us-east-1.rds.amazonaws.com;dbname=user','admin','t38byuao20');
//フォームで投げられたのを取ってくる
$name = filter_input(INPUT_POST, 'name');
$pw = filter_input(INPUT_POST, 'pw');

//var_dump($user,$pw);
//どちらかが空だった場合突っ返す
if('' === $name || '' === $pw ){
	header('Location: login.php');
}
//ユーザーネームを比
$stmt = $dbh->prepare('SELECT * FROM login WHERE name = ?');
$params = [];
$params[] = $name;

$stmt->execute($params);

$rows = $stmt->fetchAll();
/*ーザーIDも取得
$select_id = $dbh->prepare('SELECT id FROM login WHERE name = ?');
$select_id->execute($params);
$id = $select_id;
//var_dump($id);
//var_dump($stmt);
//exit();
 */
//$id = null;
//データベースに登録しているものと比較
foreach($rows as $row){
	$password_hash = $row['password'];

	//成功した場合
	if(password_verify($pw, $password_hash)){
		session_start();
		session_regenerate_id(true);
		$_SESSION['login_user'] = $name;
		header("HTTP/1.1 302 Found");
		header("Location: ./read.php");
	//	var_dump($_SESSION['login_user']);
		return;
	}
	header("HTTP/1.1 302 Found");
	header("Location: ./login.php");
}
?>
