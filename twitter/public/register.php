<?php
if($_GET['error'] === "1"){
	print("中身が空のがあるぞ");
}

if($_GET['error'] === "2"){
	print("パスワードが一致しません");
}


?>
<h1>会員登録ページ</h1>
<form method="POST" action="register_fin.php">
	ユーザー名:<input name="name" maxlength = "32"><br>
	パスワード:<input name="pw" type="password" maxlength=""><br>
	パスワード確認:<input name="pw2" type="password"><br>
	<button>登録</button>
</form>
