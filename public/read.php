<?php session_start();
//	var_dump($_SESSION['login_user']);
?>
<a href="register.php">会員登録</a>

<?php if(null === $_SESSION['login_user']): ?>
	<a href="login.php">ログイン</a><br>
<?php else:?>
	<a href="logout.php">ログアウト</a>
	<a href="profile.php">マイページ</a>
<?php endif; ?>	
<?php if(empty($_SESSION['login_user'])): ?>
	この掲示板はログインしてないと投稿できないので上からログインするか会員登録してください
<?php endif; ?>
<hr>
<?php
$dbh = new PDO('mysql:host=database-1.chequt3mp7ws.us-east-1.rds.amazonaws.com;dbname=user','admin','t38byuao20');

//var_dump($_SESSION['login_user']);
//接続$dbh = PDO()
$dbh2 = new  PDO('mysql:host=database-1.chequt3mp7ws.us-east-1.rds.amazonaws.com;dbname=bord','admin','t38byuao20');

//行の中身取得
$sth=$dbh2->prepare('SELECT name, body, created_at, filename FROM bbs ORDER BY id ASC');
$sth->execute();
$rows = $sth->fetchAll();
//アイコン情報を取得
$sth=$dbh->prepare('SELECT filename FROM login WHERE name = ?');
$params = [];
$params[] = $_SESSION['login_user'];
$sth->execute($params);

$pro_rows = $sth->fetchAll();
?>
<?php  foreach($rows as $row): ?>

<div>
	<span><?php if($row['name']) {echo $row['name'];} else{echo "名無し殿";} ?>
	(登校日: <?php echo $row['created_at']; ?>)
	</span>
	
	<?php foreach($pro_rows as $row2): ?>
	<div>
	<?php if(!empty($row2['filename'])) { ?>
		<p> <img src="/static/profile_images/<?php echo $row2['filename']; ?>" height="20px"></p>
	<?php } ?>
	</div>

	<?php endforeach; ?>

	<p><?php echo $row['body']; ?></p>
	<?php if(!empty($row['filename'])) { ?>
	<p> <img src="/static/images/<?php echo $row['filename']?>" height="200px"></p>
	<?php } ?>
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



