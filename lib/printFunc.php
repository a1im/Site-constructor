<?php
	namespace Money;
	include('sqlFunc.php');
	
	class printFunc extends sqlFunc
	{
		public function printAll()
		{
			
			echo "<p class='titleNews'>Последние новости</p>";
			if (isset($_SESSION['login'])) $this->printFormInsertNews();
			
			echo "<div id='newsRazdel'>";
			$resNews = $this->selectNews(null);
			$countNews = 10;
			foreach($resNews as $rowNews)
			{
				if ($countNews == 0) echo "<p id='allNews' onclick='shiwHiddenNews();'>Показать все новости</p><div id='hiddenNews' class='hidden'>";
				$this->printNews($rowNews);
				$countNews--;
			}
			if ($countNews <= 0) echo "</div>";
			echo "</div>";
			
			$this->printFormPodpiska();
			
			echo "<div id='moneyRazdel'>";
			$res = $this->selectRazdel(null);
			foreach($res as $row)
			{
				$this->printRazdel($row);
			}
			echo "</div>";
			$this->printFormPodpiska();
			if (isset($_SESSION['login'])) $this->printFormInsertRazdel();
			if (isset($_SESSION['login'])) $this->printFormEndAdmin();
		}
		
		public function printRazdel($rowRazdel)
		{
			echo "<div class='razdel'>";
			$resTable = $this->selectTable(null,$rowRazdel['idRazdel']);
			echo "<div class='razdelTables'>";
			foreach($resTable as $rowTable)
			{
				$this->printTable($rowTable);
			}
			echo "</div>";
			if (isset($_SESSION['login'])) $this->printFormDelRazdel($rowRazdel);
			if (isset($_SESSION['login'])) $this->printFormInsertTable($rowRazdel);
			echo "</div>";
		}
		
		public function printNews($rowNews)
		{
			echo "<div class='news'>";
			echo "<font class='data'>".$rowNews['data']."</font> <font class='newsLink' link='".$rowNews['idTrTd']."' onclick='linkTd($(this));'>".$rowNews['name']."</font>";
			if (isset($_SESSION['login'])) $this->printFormDelNews($rowNews);
			echo "</div>";
		}
		
		public function printTable($rowTable)
		{
			$resTrTd = $this->selectTrTd(null,$rowTable['idTable']);
			echo "<div class='razdelTable'>";
			$class = "";
			if ($this->selectTestTableTrTd($rowTable['idTable'])) $class = "<span class='plus'></span>";
			switch($rowTable['paragraf'])
			{
				case 1:	echo "<p class='h1' onclick='shiwHiddenTable($(this));'>$class".$rowTable['name']."</p>"; break;
				case 2: echo "<p class='h2' onclick='shiwHiddenTable($(this));'>$class".$rowTable['name']."</p>"; break;
				case 3: echo "<p class='h3' onclick='shiwHiddenTable($(this));'>$class".$rowTable['name']."</p>"; break;
				case 4: echo "<p class='h4' onclick='shiwHiddenTable($(this));'>$class".$rowTable['name']."</p>"; break;
				default: echo "<p class='h1' onclick='shiwHiddenTable($(this));'>$class".$rowTable['name']."</p>"; break;
			}
			echo "<div class='blkTable hidden'>";
			if (isset($_SESSION['login'])) 
			{
				$this->printFormUpdateTable($rowTable);
				$this->printFormInsertTr($rowTable);
				$this->printFormInsertTd($rowTable);
				//$this->printFormDelTr($rowTable);
				//$this->printFormDelTd($rowTable);
				echo "<br><br>";
			}
			echo "<table class='tableMoney' id='table".$rowTable['idTable']."'>";
			$this->printTrTd($resTrTd);
			echo "</table>";
			if ($rowTable['tableName'] != "") echo "<p class='textPod'>".$rowTable['tableName']."</p>";
			echo "</div>";
			if (isset($_SESSION['login'])) $this->printFormDelTable($rowTable);
			echo "</div>";
		}
		
		public function printTrTd($resTrTd)
		{
			$pred = 0;
			foreach($resTrTd as $rowTrTd) 
			{
				if ($rowTrTd['tr'] == 1)
				{
					if ($pred != $rowTrTd['tr']) { $pred = $rowTrTd['tr']; echo "<tr>"; }
					if (isset($_SESSION['login'])) 
					{
						echo "<th>";
						if ($rowTrTd['td'] == 1) $this->printFormDelTr($rowTrTd);
						$this->printFormDelTd($rowTrTd);
						echo "<p class='idTd'>".$rowTrTd['idTrTd']."</p>";
						echo "<div class='tdBlk' onclick='shiwEditText($(this));'>";
						echo "<div class='tdClass' id='td".$rowTrTd['idTrTd']."'>".$rowTrTd['text']."</div>";
						echo "<input type='hidden' name='idTrTd' value='".$rowTrTd['idTrTd']."' />";
						echo "</div>";
					} else echo "<th id='td".$rowTrTd['idTrTd']."'>".$rowTrTd['text'];
					echo "</th>";
				}
				else {
					if ($pred != $rowTrTd['tr']) { $pred = $rowTrTd['tr']; echo "</tr><tr>"; }
					if (isset($_SESSION['login'])) 
					{	
						echo "<td>";
						if ($rowTrTd['td'] == 1) $this->printFormDelTr($rowTrTd);
						echo "<p class='idTd'>".$rowTrTd['idTrTd']."</p>";
						echo "<div class='tdBlk' onclick='shiwEditText($(this));'>";
						echo "<div class='tdClass' id='td".$rowTrTd['idTrTd']."'>".$rowTrTd['text']."</div>";
						echo "<input type='hidden' name='idTrTd' value='".$rowTrTd['idTrTd']."' />";
						echo "</div>";
					} else echo "<td id='td".$rowTrTd['idTrTd']."'>".$rowTrTd['text'];
					echo "</td>";
				}
			}
		}
		
		
		
		public function printFormDelRazdel($rowRazdel)
		{
			echo "
				<div class='postFunc delRazdel'>
					<input type='hidden' name='idRazdel' value='".$rowRazdel['idRazdel']."' />
					<button type='submit' name='delRazdel' onclick='postFunc($(this));'>Удалить раздел</button>
				</div>
			";
		}

		public function printFormDelTable($rowTable)
		{
			echo "
				<div class='postFunc delTable'>
					<input type='hidden' name='idTable' value='".$rowTable['idTable']."' />
					<button type='submit' name='delTable' onclick='postFunc($(this));'>Удалить таблицу</button>
				</div>
			";
		}
		
		public function printFormDelNews($rowNews)
		{
			echo "
				<div class='postFunc delNews'>
					<input type='hidden' name='idNews' value='".$rowNews['idNews']."' />
					<button type='submit' name='delNews' onclick='postFunc($(this));'>Удалить новость</button>
				</div>
			";
		}
		
		public function printFormDelTr($rowTrTd)
		{
			echo "
				<div class='postFunc TrTd delTr'>
					<input type='hidden' name='tr' value='".$rowTrTd['tr']."' />
					<input type='hidden' name='idTable' value='".$rowTrTd['idTable']."' />
					<button type='submit' name='delTr' onclick='postFunc($(this));'>-</button>
				</div>
			";
		}
		
		public function printFormDelTd($rowTrTd)
		{
			echo "
				<div class='postFunc TrTd delTd'>
					<input type='hidden' name='td' value='".$rowTrTd['td']."' />
					<input type='hidden' name='idTable' value='".$rowTrTd['idTable']."' />
					<button type='submit' name='delTd' onclick='postFunc($(this));'>-</button>
				</div>
			";
		}
		
		public function printFormInsertTable($rowRazdel)
		{
			echo "
				<div class='postFunc insertTable'>
					<input type='name' name='name' placeholder='Заголовок' />
					<label>Размер шрифта 1-4: </label><input type='number' name='paragraf' placeholder='Размер 1-4' value='1' />
					<input type='hidden' name='idRazdel' value='".$rowRazdel['idRazdel']."' />
					<button type='submit' name='insertTable' onclick='postFunc($(this));'>Добавить таблицу</button>
				</div>
			";
		}
		
		public function printFormUpdateTable($rowTable)
		{
			echo "
				<div class='postFunc updateTable'>
					<input type='text' name='name' value='".$rowTable['name']."' placeholder='Заголовок' />
					<label>Текст под таблицей: </label><input type='text' name='tableName' value='".$rowTable['tableName']."' placeholder='Текст под таблицей' />
					<label>Размер шрифта 1-4: </label><input type='number' name='paragraf' placeholder='Размер текста' value='".$rowTable['paragraf']."' />
					<label>Порядковый номер: </label><input type='number' name='indexTable' placeholder='Порядковый номер' value='".$rowTable['indexTable']."' />
					<input type='hidden' name='idTable' value='".$rowTable['idTable']."' />
					<input type='hidden' name='idRazdel' value='".$rowTable['idRazdel']."' />
					<button type='submit' name='updateTable' onclick='postFunc($(this));'>Обновить таблицу</button>
				</div>
			";
		}
		
		public function printFormInsertRazdel()
		{
			echo "
				<div class='postFunc'>
					<button type='submit' name='insertRazdel' onclick='postFunc($(this));'>Вставить раздел</button>
				</div>
			";
		}
		
		public function printFormInsertNews()
		{
			echo "
				<div class='postFunc'>
					<label>id ссылки: </label><input type='number' name='idTrTd' placeholder='id' />
					<label>Титул: </label><input type='text' name='name' placeholder='Титул' />
					<button type='submit' name='insertNews' onclick='postFunc($(this));'>Вставить новость</button>
				</div>
			";
		}
		
		public function printFormInsertTr($rowTable)
		{
			echo "
				<div class='postFunc TrTd insertTr'>
					<input type='hidden' name='idTable' value='".$rowTable['idTable']."' />
					<button type='submit' name='insertTr' onclick='postFunc($(this));'>Добавить строку</button>
				</div>
			";
		}
		
		public function printFormInsertTd($rowTable)
		{
			echo "
				<div class='postFunc TrTd insertTd'>
					<input type='hidden' name='idTable' value='".$rowTable['idTable']."' />
					<button type='submit' name='insertTd' onclick='postFunc($(this));'>Добавить столбец</button>
				</div>
			";
		}
		
		public function printFormEndAdmin()
		{
			echo "
				<form class='postFunc' action='' method='POST'>
					<input type='hidden' name='endAdmin' value='aa' />
					<button type='submit'>Выход</button>
				</form>
			";
		}
		
		public function printFormPodpiska()
		{
			echo "
				<div class='podpiska'>
					<form action='' method='POST'>
						<div class='fleft'>
							<p class='title'>Подписаться на новости: </p>
							<label>Е-mail: </label>
							<input type='email' placeholder='name@mail.ru' />
						</div>
						<button class='fright' type='submit'>Подписаться</button>
					</form>
				</div>
			";
		}
	}
	
	
	$func = isset($_POST['func'])?$_POST['func']:null;
	$idRazdel = isset($_POST['idRazdel'])?$_POST['idRazdel']:null;
	$idTable = isset($_POST['idTable'])?$_POST['idTable']:null;
	$idTrTd = isset($_POST['idTrTd'])?$_POST['idTrTd']:null;
	$idNews = isset($_POST['idNews'])?$_POST['idNews']:null;
	$name = isset($_POST['name'])?$_POST['name']:null;
	$tableName = isset($_POST['tableName'])?$_POST['tableName']:null;
	$paragraf = isset($_POST['paragraf'])?$_POST['paragraf']:null;
	$tdText = isset($_POST['tdText'])?$_POST['tdText']:null;
	$indexTable = isset($_POST['indexTable'])?$_POST['indexTable']:null;
	$tr = isset($_POST['tr'])?$_POST['tr']:null;
	$td = isset($_POST['td'])?$_POST['td']:null;
	
	$printFunc = new printFunc;
	switch($func)
	{
		case 'insertRazdel': 
			$printFunc->insertRazdel();
			$res = $printFunc->selectRazdel(-1);
			$printFunc->printRazdel($res[0]);
			break;
		case 'insertTable': 
			$printFunc->insertTable($idRazdel, $name, $tableName, $paragraf);
			$res = $printFunc->selectTable(1, $idRazdel);
			$printFunc->printTable($res[0]);
			break;
		case 'insertTr': 
			$printFunc->insertTr($idTable);
			$res = $printFunc->selectTrTd(null,$idTable);
			$printFunc->printTrTd($res);
			break;
		case 'insertTd': 
			$printFunc->insertTd($idTable);
			$res = $printFunc->selectTrTd(null,$idTable);
			$printFunc->printTrTd($res);
			break;
		case 'insertNews': 
			$printFunc->insertNews($idTrTd,$name);
			$res = $printFunc->selectNews(1,$idTable);
			$printFunc->printNews($res[0]);
			break;
		case 'updateTable':
			$printFunc->updateTable($idTable, $name, $tableName, $paragraf, $indexTable);
			$res = $printFunc->selectRazdel($idRazdel);
			$printFunc->printRazdel($res[0]);
			break;
		case 'updateTd':
			$printFunc->updateTdText($idTrTd,$tdText);
			break;
		case 'delRazdel':
			$printFunc->delRazdel($idRazdel);
			break;
		case 'delTable':
			$printFunc->delTable($idTable);
			break;
		case 'delNews':
			$printFunc->delNews($idNews);
			break;
		case 'delTr':
			$printFunc->delTr($idTable, $tr);
			$res = $printFunc->selectTrTd(null,$idTable);
			$printFunc->printTrTd($res);
			break;
		case 'delTd':
			$printFunc->delTd($idTable, $td);
			$res = $printFunc->selectTrTd(null,$idTable);
			$printFunc->printTrTd($res);
			break;
	}