<?php
session_start();
if(null !== $_SESSION['login_user']){
//var_dump($_SESSION['login_user']);
//表示用のパスを入れる
$upload_image = $_FILES['image'];
//var_dump($_FILES['image'],$upload_image);
//アップロードに入ってる時のみ処理
if($upload_image['size'] > 0){
	//画像ファイルの時のみ処理
	
	if(!exif_imagetype($upload_image['tmp_name'])){
		print("画像以外はいれるな");
		return;
	}


//拡張しを取得
$ext = pathinfo($upload_image['name'], PATHINFO_EXTENSION);
//ファイル名決め
$image_filename=uniqid(). "." . $ext;
//パス決め
$image_filepath = '/src/2019techc/public/static/images/'.$image_filename;
//ブラウザから表示用のパス設定し突っ込め
move_uploaded_file($upload_image['tmp_name'],$image_filepath);
}


// 必須である投稿本文がない場合は何もせずに閲覧画面に飛ばす
if( empty($_POST['body']) ) { 
  header("HTTP/1.1 302 Found");
  header("Location: ./read.php");
  return;
}
// 接続 ref. https://www.php.net/manual/ja/pdo.connections.php
$dbh = new PDO('mysql:host=database-1.chequt3mp7ws.us-east-1.rds.amazonaws.com;dbname=bord', 'admin', 't38byuao20');
$image_path = null;


/*---ttestdone---*/
// INSERTする
$insert_sth = $dbh->prepare("INSERT INTO bbs (name, body, filename) VALUES (:name, :body, :filename)");
$insert_sth->execute(array(
    ':name' => $_POST['name'],
    ':body' => $_POST['body'],
    ':filename' => $image_filename,
));

// 投稿が完了したので閲覧画面に飛ばす
header("HTTP/1.1 303 See Other");
header("Location: ./read.php");
}else{
header("Location: ./read.php");
}

?>
