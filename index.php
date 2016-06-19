<html>
<head>
	<meta charset="UTF-8">
	<title>Money</title>
	<link rel="stylesheet" type="text/css" href="css/style.css" /> 
	<link rel="stylesheet" type="text/css" href="js/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
</head>
<body>
<?php
	include('lib/printFunc.php');
	error_reporting(E_ALL | E_STRICT);
	ini_set('display_errors', 'On');
	
	if (!empty($_POST['endAdmin'])) unset($_SESSION['login']);
	
	$printFunc = new \Money\printFunc;
?>

	<div id='vverh'>Наверх</div>

	<div id='content'>
		<?php $printFunc->printAll();?>
		
		<div class='hidden' id='formEditText'>
			<div class='postFunc' >
				<textarea id="tdText" name='tdText'></textarea>
				<input type='hidden' name='idTrTd' value='1' />
				<button type='submit' name='updateTd' onclick='postFunc($(this));'>Сохранить</button>
			</div>
			<div class='tenb'></div>
		</div>
	</div>
	
	<div id="footer">
		<p class="title">Условия оплаты и заказа.</p>

		<p class="text">Предоплата на карту СБ, Оплата по Безналичному расчету ( +7 проц )</p>
		<p class="text">Склад находится в городе Санкт-Петербург . </p>
		<p class="text">Стоимость рассчитаем по запросу.</p>
		<p class="text">При отправке почтой : почтовые расходы по тарифам почты +50руб.</p>
		<p class="text">Заказы от 3000 рублей доставляются на адрес , либо до терминала транспортной компании</p>
		<p class="text">Бесплатно.</p>
		<p class="text">По умолчанию почтой отправляем заказной бандеролью без оценки. В случае другой отправки - доплата за отправку за счет покупателя. </p>
		<p class="text">Заказы можно присылать сразу на почту venshop@yandex.ru , romanov_avangard@mail.ru</p>
		<p class="text">Либо по телефону  (812) 642-34-04 . ( 921 ) 941 36 28</p>

	</div>
	
	<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
	<script type="text/javascript" src="js/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
	<script type="text/javascript" src="js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
	<script type="text/javascript" src='js/tinymce/tinymce.min.js'></script>
	<script type="text/javascript" src="js/ajaxupload.3.5.js"></script>
	<?php if (isset($_SESSION['login'])) echo "<script type='text/javascript' src='js/scriptAdm.js'></script>"; ?>
	<script type="text/javascript" src="js/script.js"></script>
</body>
</html>