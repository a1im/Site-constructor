<?php
	namespace Money;
	include('config/connect.php');
	
	class sqlFunc extends connect
	{
		public function insertRazdel()
		{
			$res = $this->sqlSelect("SELECT (MAX(indexRazdel)+1) as 'index'  FROM razdel;");
			$index = $res[0]['index'];
			if (empty($index)) $index = 1;
			$this->toSql("INSERT INTO razdel(indexRazdel) VALUES('$index');");
		}
		
		public function insertTable($idRazdel, $name, $tableName, $paragraf)
		{
			$res = $this->sqlSelect("SELECT (MAX(indexTable)+1) as 'index' FROM tables WHERE idRazdel=$idRazdel;");
			$index = $res[0]['index'];
			if (empty($index)) $index = 1;
			$this->toSql("INSERT INTO tables(idRazdel,name,tableName,paragraf,indexTable) 
									VALUES('$idRazdel','$name','$tableName','$paragraf','$index');");
		}
		
		public function insertNews($idTrTd, $name)
		{
			$data = date('Y-m-d');
			$this->toSql("INSERT INTO news(idTrTd,data,name,lastname) 
									VALUES('$idTrTd','$data','$name',' ');");
		}
		
		public function insertTr($idTable)
		{
			$res = $this->sqlSelect("SELECT (MAX(tr)+1) as 'maxTr' FROM tabletrtd WHERE idTable=$idTable;");
			$maxTr = $res[0]['maxTr'];
			$countTd = 1;
			if (empty($maxTr)) $maxTr = 1;
			else {
				$res = $this->sqlSelect("SELECT (COUNT(DISTINCT(td))) as 'countTd' FROM tabletrtd WHERE idTable=$idTable");
				$countTd = $res[0]['countTd'];
			}
			for($i=1; $i <= $countTd; $i++)
				$this->toSql("INSERT INTO tabletrtd(idTable,tr,td,text) VALUES('$idTable','$maxTr','$i','');");
		}
		
		public function insertTd($idTable)
		{
			$res = $this->sqlSelect("SELECT (MAX(td)+1) as 'maxTd' FROM tabletrtd WHERE idTable=$idTable;");
			$maxTd = $res[0]['maxTd'];
			$countTr = 0;
			if (empty($maxTd)) $maxTd = 1;
			else {
				$res = $this->sqlSelect("SELECT (COUNT(DISTINCT(tr))) as 'countTr' FROM tabletrtd WHERE idTable=$idTable");
				$countTr = $res[0]['countTr'];
			}
			for($i=1; $i <= $countTr; $i++)
				$this->toSql("INSERT INTO tabletrtd(idTable,tr,td,text) VALUES('$idTable','$i','$maxTd','');");
		}
		
		public function updateTable($idTable, $name, $tableName, $paragraf, $indexTable)
		{
			$res = $this->sqlSelect("SELECT idRazdel, indexTable FROM tables WHERE idTable=$idTable");
			$index = $res[0]['indexTable'];
			$idRazdel = $res[0]['idRazdel'];
			$this->toSql("UPDATE tables SET indexTable=$index WHERE idRazdel=$idRazdel AND indexTable=$indexTable;");
			$this->toSql("UPDATE tables SET name='$name',tableName='$tableName',paragraf=$paragraf,indexTable=$indexTable WHERE idTable=$idTable;");
		}
		
		public function updateTdText($idTrTd,$tdText)
		{
			$this->toSql("UPDATE tabletrtd SET text='$tdText' WHERE idTrTd=$idTrTd;");
		}
		
		public function delRazdel($id)
		{
			$this->toSql("DELETE FROM razdel WHERE idRazdel=$id;");
		}
		
		public function delTable($id)
		{
			$this->toSql("DELETE FROM tables WHERE idTable=$id;");
		}
		
		public function delNews($id)
		{
			$this->toSql("DELETE FROM news WHERE idNews=$id;");
		}
		
		public function delTr($idTable, $tr)
		{
			//$res = $this->sqlSelect("SELECT MAX(tr) as 'maxTr' FROM tabletrtd WHERE idTable=$idTable;");
			//$maxTr = $res[0]['maxTr'];
			//if (!empty($maxTr)) $this->toSql("DELETE FROM tabletrtd WHERE idTable=$idTable AND tr=$maxTr;");
			$this->toSql("DELETE FROM tabletrtd WHERE idTable=$idTable AND tr=$tr;");
			$this->toSql("UPDATE tabletrtd SET tr=tr-1 WHERE idTable=$idTable AND tr>$tr;");
		}
		
		public function delTd($idTable, $td)
		{
			//$res = $this->sqlSelect("SELECT MAX(td) as 'maxTd' FROM tabletrtd WHERE idTable=$idTable;");
			//$maxTd = $res[0]['maxTd'];
			//if (!empty($maxTd)) $this->toSql("DELETE FROM tabletrtd WHERE idTable=$idTable AND td=$maxTd;");
			$this->toSql("DELETE FROM tabletrtd WHERE idTable=$idTable AND td=$td;");
			$this->toSql("UPDATE tabletrtd SET td=td-1 WHERE idTable=$idTable AND td>$td;");
		}
		
		public function selectRazdel($emp)
		{
			if (!empty($emp))
				if ($emp == -1) return $this->sqlSelect("SELECT * FROM razdel ORDER BY idRazdel DESC LIMIT 1;");
				else return $this->sqlSelect("SELECT * FROM razdel WHERE idRazdel=$emp;");
			else return $this->sqlSelect("SELECT * FROM razdel ORDER BY indexRazdel,idRazdel ASC;");
		}
		
		public function selectTable($emp, $id)
		{
			if (!empty($emp)) return $this->sqlSelect("SELECT * FROM tables WHERE idRazdel=$id ORDER BY idTable DESC LIMIT 1;");
			else return $this->sqlSelect("SELECT * FROM tables WHERE idRazdel=$id ORDER BY indexTable,idTable ASC;");
		}
		
		public function selectTrTd($emp, $id)
		{
			if (!empty($emp)) return $this->sqlSelect("SELECT * FROM tabletrtd WHERE idTable=$id ORDER BY idTrTd DESC LIMIT 1;");
			else return $this->sqlSelect("SELECT * FROM tabletrtd WHERE idTable=$id ORDER BY tr,td ASC;");
		}
		
		public function selectTestTableTrTd($id)
		{
			return empty($this->sqlSelect("SELECT * FROM tabletrtd WHERE idTable=$id;"))?false:true;
		}
		
		public function selectNews($emp)
		{
			if (!empty($emp)) return $this->sqlSelect("SELECT * FROM news ORDER BY idNews DESC LIMIT 1;");
			else return $this->sqlSelect("SELECT * FROM news ORDER BY idNews DESC;");
		}
	}
