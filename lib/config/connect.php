<?php
	namespace Money;

	class connect 
	{		
		//конструктор
		public function __construct() 
		{
			if (!isset($_SESSION['start'])) session_start();
			$_SESSION['start'] = true;
		}
		
		//подключение к бд
		private function connect() 
		{
			$host = 'localhost';
			$user = 'root'; $pass = '040292'; $db = 'money'; //$port = '3306';
			//$user = 'a1immaqw_money'; $pass = '1CEP0qaD'; $db = 'a1immaqw_money';
			//ini_set('mysqli.default-port', $port);
			$link = mysqli_connect($host,$user,$pass,$db);			
			mysqli_set_charset($link,'utf8');
			if (mysqli_connect_errno()) die('Ошибка соединения: '.mysqli_connect_error());
			else return $link;
		}
		
		//запрос по бд vk1
		public function toSql($sql)
		{
			$link = $this->connect();
			$res = mysqli_query($link, $sql);
			mysqli_close($link);
			return $res?$res:die("ошибка запроса");
		}
		
		//вывод селекта
		public function sqlSelect($sql)
		{
			$res = $this->toSql($sql);
			
			$arrRes = array();
			
			if ($res)
			{
				while($row = mysqli_fetch_assoc($res))
				{
					$arrRes[] = $row;
				}
				mysqli_free_result($res);
			}
			return $arrRes;
		}
		
		public function clearString($string){
			return htmlspecialchars(stripslashes($string));
		}
	}
