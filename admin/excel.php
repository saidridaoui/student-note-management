<?php
include("../include/db.php");

if(isset($_POST['btnExport'])){
	$dataTable = mysql_query("SELECT * FROM etudiant");
	$rowTable = mysql_num_rows($dataTable);

	if($rowTable > 0){
		$file = "export/".strtotime(now).".csv";
		$openFile = fopen($file, "w");

		$allData = mysql_fetch_assoc($dataTable);
		$line = 0;
		foreach ($allData as $name => $value) {
			$line++;
			if($line<3){
				$label .= $name.",";
			}else{
				$label .= $name."\n";
			}
		}

		$dataTable2 = mysql_query("SELECT * FROM etudiant");
		while($allData2 = mysql_fetch_assoc($dataTable2)){
			$dataValue .= $allData2["ID"].",".$allData2["NAME"].",".$allData2["ANNEE"]."\n";
		}
		fputs($openFile,$label . $dataValue);
		header("location: ".$file);
	}
}


?>