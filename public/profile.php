<?php
session_start();
//データベース接続
$dbh = new PDO('mysql:host=database-1.chequt3mp7ws.us-east-1.rds.amazonaws.com;dbname=user','admin','t38byuao20');

$image_path = null;

//$sth=$dbh->prepare('SELECT name, body, created_at, filename FROM bbs ORDER BY id ASC');
 //アイコン情報を取得
$sth=$dbh->prepare('SELECT filename FROM login WHERE name = ?');
$params = [];	
$params[] = $_SESSION['login_user'];
$sth->execute($params);

$pro_rows = $sth->fetchAll();
//var_dump($pro_rows);
//var_dump($_SESSION['login_user']);

?>
<h1>マイページ</h1>
<div>
<?php echo($_SESSION['login_user']) ?>さんいらっしゃい
</div>

<?php foreach($pro_rows as $row): ?>
<div>

<?php if(!empty($row['filename'])) { ?>
	<p> <img src="/static/profile_images/<?php echo $row['filename']; ?>" height="50px"></p>
<?php } ?>
</div>
<?php endforeach; ?>
<div>
アイコンを設定する
<form method="POST" action="image_setting.php" enctype="multipart/form-data">
	<input type="file" name="image"><br>
	<input type="submit" value="設定する">
</form> 
</div>
<?php 
//行の中身を取得i
$dbh2 = new PDO('mysql:host=database-1.chequt3mp7ws.us-east-1.rds.amazonaws.com;dbname=bord','admin','t38byuao20');

//掲示板情報を取得
$sth=$dbh2->prepare('SELECT name, body, created_at, filename FROM bbs ORDER BY id ASC');
$sth->execute();
$rows = $sth->fetchALL();
//var_dump($rows);

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

	<?php foreach($pro_rows as $row2): ?>
	<div>
	<?php if(!empty($row2['filename'])) { ?>
	<p> <img src="/static/profile_images/<?php echo $row2['filename']; ?>" height="20px"></p>
	<?php } ?>
	</div>
	<?php endforeach; ?>

	<p><?php echo $row['body']; ?></p>
	<?php if(!empty($row['filename'])) : ?>
		<p><img src="/static/images/<?php echo $row['filename'] ?>" height="200px"></p>
	<?php endif; ?>
<?php endif; ?>
</div>
<?php endforeach; ?>

