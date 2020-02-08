<?php
session_start();
//データベース接続
$dbh = new PDO('mysql:host=database-1.chequt3mp7ws.us-east-1.rds.amazonaws.com;dbname=user','admin','t38byuao20');

$image_path = null;
 //アイコン情報を取得
$sth=$dbh->prepare('SELECT profile_image_file FROM login WHERE name = ?');
$params = [];	
$params[] = $_SESSION['login_user'];
$sth->execute($params);

$pro_rows = $sth->fetchAll();

?>
<h1>マイページ</h1>
<div>
<?php echo($_SESSION['login_user']) ?>さんいらっしゃい
</div>

<?php foreach($pro_rows as $row): ?>
<div>

<?php if(!empty($row['profile_image_file'])) { ?>
	<p> <img src="/static/profile_images/<?php echo $row['profile_image_file']; ?>" height="100px"></p>
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
//の中身を取得i
$dbh2 = new PDO('mysql:host=database-1.chequt3mp7ws.us-east-1.rds.amazonaws.com;dbname=bord','admin','t38byuao20');

//掲示板情報とアイコン情報を取得
$sth=$dbh2->prepare(
	'SELECT x.name, x.body, x.created_at, x.filename, y.profile_image_file
	FROM bord.bbs as x 
	LEFT OUTER JOIN user.login as y ON x.name = y.name');
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

	<div>
	<p> <img src="/static/profile_images/<?php echo $row['profile_image_file']; ?>" height="50px"></p>
	</div>

	<p><?php echo $row['body']; ?></p>
	<?php if(!empty($row['filename'])) : ?>
		<p><img src="/static/images/<?php echo $row['filename'] ?>" height="200px"></p>
	<?php endif; ?>
<?php endif; ?>
</div>
<?php endforeach; ?>

