<?php
session_start();
//データベース接続
$dbh = new PDO('mysql:host=database-1.chequt3mp7ws.us-east-1.rds.amazonaws.com;dbname=bord','admin','t38byuao20');
$image_path = null;

//画像設定

//var_dump($_SESSION['login_user']);

?>
<h1>マイページ</h1>
<div>
<?php echo($_SESSION['login_user']) ?>さんいらっしゃい
</div>
<div>
アイコンを設定する
<form method="POST" action="image_setting.php" enctype="multipart/form-data">
	<input type="file" name="image"><br>
	<input type="submit" value="設定する">
</form> 
</div>
<?php 
//行の中身を取得
$sth=$dbh->prepare('SELECT name, body, created_at, filename FROM bbs ORDER BY id ASC');
$sth->execute();
$rows = $sth->fetchALL();

?>
<a href="read.php">トップへ戻る</a>
<hr>
<?php 
foreach($rows as $row):
?>
<div>
<?php if($row['name'] === $_SESSION['login_user']) : ?>
	<span><?php echo($_SESSION['login_user']); ?></span>
	(登校日：<?php echo $row['created_at']; ?>)
	<p><?php echo $row['body']; ?></p>
	<?php if(!empty($row['filename'])) : ?>
		<p><img src="/static/images/<?php echo $row['filename'] ?>" height="200px"></p>
	<?php endif; ?>
<?php endif; ?>
</div>
<?php endforeach; ?>

