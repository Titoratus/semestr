<?php
	include("db.php");

	require_once("phpExcel/PHPExcel.php");
	require_once("phpExcel/PHPExcel/Writer/Excel5.php");

	$xls = new PHPExcel();
	// Устанавливаем индекс активного листа
	$xls->setActiveSheetIndex(0);
	// Получаем активный лист
	$sheet = $xls->getActiveSheet();

	$cur = $_COOKIE["logged"];
	$sem = $_GET["sem"];

	$sheet->setTitle("Успеваемость за ".$sem." семестр");

	$sheet->getColumnDimension("B")->setWidth(50);
	$sheet->getColumnDimension("A")->setWidth(5);

	$sheet->setCellValue("A1", "№ п/п");
	$sheet->setCellValue("B1", "ФИО студента");


	$query = mysqli_query($con, "SELECT subs_curators.*, subjects.*
													     FROM subs_curators
													     INNER JOIN subjects ON subs_curators.sub_id=subjects.id");

	$row = 1;

	//Все студенты текущего куратора
	$studs = mysqli_query($con, "SELECT * FROM students ORDER BY s_name ASC");

	//Полный вывод студентов в строку
	while ($stud = mysqli_fetch_array($studs)) {
		$row++;
		$sheet->setCellValue("A".$row, ($row-1));
		$sheet->setCellValue("B".$row, $stud["s_name"]);
	}
	$maxRow = $row;
	$row = 1;
	$col = "B";

	//Все предметы текущего куратора
	while ($data = mysqli_fetch_array($query)) {
		$col++;
		$sheet->getStyle($col."1")->getAlignment()->setTextRotation(90);
		$sheet->setCellValue($col."1", $data["sub_name"]);

		$sub = $data["id"];
		$studs = mysqli_query($con, "SELECT * FROM students ORDER BY s_name ASC");

		//Все студенты текущего куратора
		while ($stud = mysqli_fetch_array($studs)) {
			$row++;
			$s_id = $stud["id"];
			$hasSub = mysqli_query($con, "SELECT * FROM marks WHERE sub_id='$sub' AND s_id='$s_id'");

			//Если у студента есть оценки по предмету
			if (mysqli_num_rows($hasSub) != 0) {
				$hasSub = mysqli_fetch_array($hasSub);
				if ($hasSub["s".$sem] != 0) $sheet->setCellValue($col.$row, $hasSub["s".$sem]);
			}
			
		}
		$row = 1;

	}

	$sheet->getStyle("A1:".$col."80")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	$sheet->getStyle("A1:".$col."80")->applyFromArray(
	    array(
		      'alignment' => array(
		          'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		      )	                
	    )
	);

	$sheet->getStyle("B2:B80")->applyFromArray(
	    array(
		      'alignment' => array(
		          'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
		      )	                
	    )
	);	

	$sheet->getStyle("A1:".$col.$maxRow)->applyFromArray(
	    array(
	        'borders' => array(
	            'allborders' => array(
	                'style' => PHPExcel_Style_Border::BORDER_THIN,
	                'color' => array('rgb' => '595959')
	            )
	        )
	    )
	);

	foreach(range('C', $col) as $columnID) {
	   $sheet->getColumnDimension($columnID)->setWidth(4);
	}

	$sheet->getStyle("A1:".$col."1")->getAlignment()->setWrapText(true);

  //Сохранение
	$name = "Успеваемость за ".$sem." семестр";
	$objWriter = new PHPExcel_Writer_Excel5($xls);
	header('Content-type: application/vnd.ms-excel');
	header('Content-Disposition: attachment; filename='.$name.'.xls');
	$objWriter->save('php://output');

	mysqli_close($con);
?>