<!DOCTYPE html>
<html lang="ru">

<head>

	<meta charset="utf-8">

	<title><?php echo $page; ?></title>
	<meta name="description" content="">

	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<meta property="og:image" content="path/to/image.jpg">
	<link rel="shortcut icon" href="img/favicon/favicon.ico" type="image/x-icon">
	<link rel="apple-touch-icon" href="img/favicon/apple-touch-icon.png">
	<link rel="apple-touch-icon" sizes="72x72" href="img/favicon/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="114x114" href="img/favicon/apple-touch-icon-114x114.png">

	<!-- Chrome, Firefox OS and Opera -->
	<meta name="theme-color" content="#000">
	<!-- Windows Phone -->
	<meta name="msapplication-navbutton-color" content="#000">
	<!-- iOS Safari -->
	<meta name="apple-mobile-web-app-status-bar-style" content="#000">

	<link rel="stylesheet" href="css/main.css">
	<link rel="stylesheet" href="css/libs.min.css">

</head>

<body class="noscript">

<?php if(isset($_COOKIE["logged"])){
			include("db.php");
			$curator = $_COOKIE["logged"];
?>
	<div class="top-bar">
		<?php
			$name = mysqli_query($con, "SELECT u_name FROM users WHERE id='$curator'");
			$name = mysqli_fetch_array($name);
			$full = explode(' ', $name["u_name"]); echo $full[0]." ".mb_substr($full[1], 0, 1, "utf-8").". ".mb_substr($full[2], 0, 1, "utf-8").".";
		?>
		<div class="settings-btn"></div>
		<ul class="settings">
			<li><a href="profile.php">Настройки</a></li>
			<li><a href="exit.php" class="exit">Выйти</a></li>
		</ul>
	</div>
<?php } ?>