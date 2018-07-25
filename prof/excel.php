<?php
include("../include/db.php");




if(isset($_POST['btnExport'])){

	$mat_id = $_REQUEST['mat_id'];
	$prof_id = $_REQUEST['prof_id'];
	
	$query = mysql_query("SELECT * FROM matiere WHERE ID = $mat_id");
	$data = mysql_fetch_array($query);
	$annee = $data['ANNEE'];
	$matiere = $data['MATIERE'];


	$dataTable = mysql_query("SELECT * FROM etudiant WHERE ANNEE = $annee");
	$rowTable = mysql_num_rows($dataTable);

	if($rowTable > 0){
		$file = "export/".$matiere.".csv";
		$openFile = fopen($file, "w");

		$allData = mysql_fetch_assoc($dataTable);
		$line = 0;
		foreach ($allData as $name => $value) {
			$line++;
			if($line<3){
				$label .= $name.",";
			}else{
				$label .= $name.",MATIERE, NOTE,\n";
			}
		}

		$dataTable2 = mysql_query("SELECT * FROM etudiant WHERE ANNEE = $annee");
		while($allData2 = mysql_fetch_assoc($dataTable2)){
			$dataValue .= $allData2["ID"].",".$allData2["NAME"].",".$allData2["ANNEE"].",".$matiere.",,\n";
		}
		fputs($openFile,$label . $dataValue);
		header("location: ".$file);
	}
}elseif(isset($_POST['btnImport'])){
    if(!empty($_FILES["excelFile"]["tmp_name"])){

      $fileName = explode(".",$_FILES["excelFile"]["name"]);
      if($fileName[1]=="csv"){
        echo "Processing !!!";

        $file = $_FILES["excelFile"]["tmp_name"];
        $openFile = fopen($file, "r");
		
        $line = 0;
        while($dataFile = fgetcsv($openFile,3000,",")){
          if($line>0){
            $id = $dataFile[0];
            $name = $dataFile[1];
            $annee = $dataFile[2];
            $matiere = $dataFile[3];
            $note = $dataFile[4];
			$dataValue .= $id.",".$name.",".$note.",\n";
			}
			$line++;
			if($matiere){
				$mat_name = $matiere;
			}
		}
		$matiere = $mat_name;
		$query = mysql_query("SELECT * FROM matiere WHERE MATIERE LIKE '$matiere'");
		$data = mysql_fetch_array($query);
		$id = $data['ID'];
		$test = mysql_query("SELECT * FROM note WHERE MATIERE_ID=$id");
		if(!mysql_num_rows($test)){
			mysql_query("INSERT INTO note VALUES ($id, '$matiere')");
		}

    	/*$dir_name=dirname(__FILE__)."/download/";
    	$path=$_FILES['excelFile']['tmp_name'];
		move_uploaded_file($path,$dir_name.$matiere.'.csv');*/
        if($matiere){
			$file_ex = "../notes/".$matiere.".csv";
			$openFile_ex = fopen($file_ex, "w");
			
			$label .= $matiere.",\n\nID,NAME,NOTE,\n";
			fputs($openFile_ex, $label.$dataValue);
        }



	}else{
		echo "You must choose a csv file to import !!!";
	}
	}else{
		echo "You must choose a file !!!";
	}
	header("location: matiere.php");
}


?>