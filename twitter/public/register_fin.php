<?php
/*---長さや、空だった場合の処理---*/
$error_flag = [];

//データ取得
$params = ['name','pw','pw2'];
$data = [];

foreach($params as $p){
	$data[$p] = (string)@$_POST[$p];
}

//入力していないところがあったら突っ返す
if('' === $data['name'] || '' === $data['pw']){
	header('Location: register.php?error=1');
	exit;
}

//パスワードが一致しない場合、突っ返す
if($data['pw2'] !== $data['pw']){
	header('Location: register.php?error=2');
	exit;
}

$hash_pass = password_hash($data['pw'], PASSWORD_DEFAULT);
//データベース接続
$dbh = new PDO('mysql:host=database-1.chequt3mp7ws.us-east-1.rds.amazonaws.com;dbname=user','admin','t38byuao20');

/*---データベースにインサート---*/
$insert_sth = $dbh->prepare("INSERT INTO login (name, password) VALUES (:name, :password)");
$insert_sth->execute(array(
	':name' => $_POST['name'],
	':password' => $hash_pass,
));
/*---登録が完了したらその旨を伝える。---*/


?>
<p>登録完了</p>
<a href="read.php">トップに戻る</a>

