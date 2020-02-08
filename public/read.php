<?php session_start();
//	var_dump($_SESSION['login_user']);
?>

<?php if(null === $_SESSION['login_user']): ?>
	<a href="login.php">ログイン</a>
	<a href="register.php">会員登録</a>
<?php else:?>
	<a href="logout.php">ログアウト</a>
	<a href="profile.php">マイページ</a>
<?php endif; ?>	
<?php if(empty($_SESSION['login_user'])): ?>
	この掲示板はログインしてないと投稿できないので上からログインするか会員登録してください
<?php endif; ?>
<hr>
<?php
//接続$dbh = PDO()
$dbh2 = new  PDO('mysql:host=database-1.chequt3mp7ws.us-east-1.rds.amazonaws.com;dbname=bord','admin','t38byuao20');

//行の中身をアイコン画像と共に取得
$sth=$dbh2->prepare(
	'SELECT x.name, x.body, x.created_at, x.filename, y.profile_image_file FROM bord.bbs as x LEFT OUTER JOIN user.login as y ON x.name = y.name'
);

$sth->execute();
$rows = $sth->fetchAll();


foreach($rows as $row):
?>
<div>
	<span><?php if($row['name']) {echo $row['name'];} else{echo "名無し殿";} ?>
	(投稿日時: <?php echo $row['created_at']; ?>)
	</span>
	
	<div>
	<?php if(!empty($row['profile_image_file'])): ?>
		<img src="/static/profile_images/<?php echo $row['profile_image_file']; ?>" height="50px">
	<?php endif; ?>

	<p><?php echo $row['body']; ?></p>
	<?php if(!empty($row['filename'])): ?>
	<p> <img src="/static/images/<?php echo $row['filename']?>" height="200px"></p>
	<?php endif; ?>
</div>
<hr>

<?php endforeach; ?>

<?php if(!empty($_SESSION['login_user'])): ?>
<form method="POST" action="write.php" enctype="multipart/form-data">
	<div>
	名前:<?php echo($_SESSION['login_user']) ?><br>
	</div>
	<div>
	添付画像：<input type="file" name="image"><br>
	</div>
	<div>
	 <textarea name="body" rows="5" cols="100" required ></textarea>
	</div>
	<input type="submit" value="投稿者">
</form>
<?php endif; ?>



