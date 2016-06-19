<?php
	require_once('conf.php');
	session_start();
	
	$POSTlogin = null;
	$POSTpass = null;
	
	if (isset($_POST['login'])) $POSTlogin = $_POST['login'];
	if (isset($_POST['pass'])) $POSTpass = $_POST['pass'];
?>
<html>
<head>
	<meta charset="UTF-8">
</head>
<body>
<?php
	if ($POSTlogin != null && $POSTpass != null)
		if ($POSTlogin == $login && $POSTpass == $pass)
		{
			$_SESSION['login'] = true;
			//header ('Location: ../');  // перенаправление на нужную страницу
		}
		else {
			echo "Логин и пароль не подходят";
		}
	if (isset($_SESSION['login'])) echo "<a href='../' >Ура! Нажми чтобы войти.</a><br><br>";
?>
	<form action="" method="POST">
		<input type="text" name="login" placeholder="Логин" />
		<input type="password" name="pass" placeholder="Пароль" />
		<button type="submit">Вход</button>
	</form>
</body>
</html>