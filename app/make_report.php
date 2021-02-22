<?php
	include("db.php");

	require_once("phpExcel/PHPExcel.php");
	require_once("phpExcel/PHPExcel/Writer/Excel5.php");

	$xls = new PHPExcel();
	// Устанавливаем индекс активного листа
	$xls->setActiveSheetIndex(0);
	// Получаем активный лист
	$sheet = $xls->getActiveSheet();
	// Подписываем лист
	$sheet->setTitle("Отчёт");

	$sid = $_GET["sid"];
	$query = mysqli_query($con, "SELECT * FROM students WHERE id='$sid'");
	$query = mysqli_fetch_array($query);

	$name = $query["s_name"];

	$sheet->getColumnDimension('A')->setWidth(37,40);

	//Объединение ячеек
	$sheet->mergeCells("A1:J1");
	$sheet->mergeCells("A2:J2");
	$sheet->getStyle("A1:A2")->applyFromArray(
	    array(
	        'fill' => array(
	            'type' => PHPExcel_Style_Fill::FILL_SOLID,
	            'color' => array('rgb' => '2b2a28')
	        ),
		      'alignment' => array(
		          'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		      )                  
	    )
	);	
	$sheet->getStyle("A1")->applyFromArray(
	    array(
					'font'  => array(
					    'bold'  => true,
					    'color' => array('rgb' => 'FFFFFF'),
					    'size'  => 14,
					    'name'  => 'Tahoma'
					)                 
	    )
	);	
	$sheet->getStyle("A2")->applyFromArray(
	    array(
					'font'  => array(
					    'bold'  => true,
					    'color' => array('rgb' => 'ec876c'),
					    'size'  => 11,
					    'name'  => 'Tahoma'
					)                 
	    )
	);		
	$sheet->getRowDimension('1')->setRowHeight(34,5);
	$sheet->getRowDimension('2')->setRowHeight(23,25);
	$sheet->setCellValue("A1", $name);
	$sheet->setCellValue("A2", "Группа: ".$_COOKIE["group"]);

  $style = array(
      'alignment' => array(
          'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
      )
  );

  $sheet->mergeCells("A4:A5");
  $sheet->mergeCells("J4:J5");
  $sheet->setCellValue("A4", "Предметы");
  $sheet->mergeCells("B4:I4");
  $sheet->setCellValue("B4", "Семестры");
  $sheet->setCellValue("B5", "1");
  $sheet->setCellValue("C5", "2");
  $sheet->setCellValue("D5", "3");
  $sheet->setCellValue("E5", "4");
  $sheet->setCellValue("F5", "5");
  $sheet->setCellValue("G5", "6");
  $sheet->setCellValue("H5", "7");
	$sheet->setCellValue("I5", "8");
	$sheet->setCellValue("J4", "Диплом");

	$sheet->getStyle('A4:J5')->applyFromArray(
	    array(
	        'fill' => array(
	            'type' => PHPExcel_Style_Fill::FILL_SOLID,
	            'color' => array('rgb' => 'E7E6E6')
	        )
	    )
	);	

	$sheet->getStyle("A4:J5")->getFont()->setBold(true);

  //Выравнивание
  $sheet->getStyle("A4:J5")->applyFromArray($style);
  $sheet->getStyle("B6:J100")->applyFromArray($style);
  $sheet->getStyle("A6:A100")->getAlignment()->setWrapText(true);
  $sheet->getStyle("A1:J100")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
  $sheet->getStyle("A2")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
  $sheet->getStyle("A4")->applyFromArray($style);

  //Вывод оценок по предметам
  $query = mysqli_query($con, "SELECT * FROM marks WHERE s_id = '$sid'");
  $row_num = 6;
  while($row = mysqli_fetch_array($query)) {
  	$sub_id = $row["sub_id"];
  	$sub = mysqli_query($con, "SELECT sub_name FROM subjects WHERE id='$sub_id'");
  	$sub = mysqli_fetch_array($sub);
  	$sub = $sub["sub_name"];

  	$sheet->setCellValueByColumnAndRow(0, $row_num, $sub);

  	for($k=1; $k <= 8; $k++) $sheet->setCellValueByColumnAndRow($k, $row_num, $row["s".$k] == "0" ? "" : $row["s".$k]);

  	$sheet->setCellValueByColumnAndRow(9, $row_num, $row["diploma"] == "0" ? "" : $row["diploma"]);
  	$row_num++;
  }

	$sheet->getStyle("A4:J".($row_num-1))->applyFromArray(
	    array(
	        'borders' => array(
	            'allborders' => array(
	                'style' => PHPExcel_Style_Border::BORDER_THIN,
	                'color' => array('rgb' => '595959')
	            )
	        )
	    )
	);

  //Курсовая
  $query = mysqli_query($con, "SELECT * FROM works WHERE w_student='$sid'");
  if(mysqli_num_rows($query) != 0){
  $sheet->mergeCells("A".($row_num+1).":B".($row_num+1));

	$sheet->getStyle('A'.($row_num+1).":B".($row_num+2))->applyFromArray(
	    array(
	        'borders' => array(
	            'allborders' => array(
	                'style' => PHPExcel_Style_Border::BORDER_THIN,
	                'color' => array('rgb' => '595959')
	            )
	        ),
		      'alignment' => array(
		          'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		      )	          
	    )
	);

	$sheet->getStyle('A'.($row_num+1))->applyFromArray(
	    array(
	        'fill' => array(
	            'type' => PHPExcel_Style_Fill::FILL_SOLID,
	            'color' => array('rgb' => 'E7E6E6')
	        )
	    )
	);		

	$sheet->getStyle("A".($row_num+1))->getFont()->setBold(true);   	
  	$row_num++;
  	$sheet->setCellValueByColumnAndRow(0, $row_num, "Курсовая работа");
  	$query = mysqli_fetch_array($query);
  	$row_num++;
  	$sheet->setCellValueByColumnAndRow(0, $row_num, $query["w_name"]);
  	$sheet->setCellValueByColumnAndRow(1, $row_num, $query["w_mark"]);
  }  

  //Приказы
  $query = mysqli_query($con, "SELECT * FROM orders WHERE o_student='$sid'");
  if(mysqli_num_rows($query) != 0){
		$sheet->getStyle('A'.($row_num+2))->applyFromArray(
		    array(
		        'fill' => array(
		            'type' => PHPExcel_Style_Fill::FILL_SOLID,
		            'color' => array('rgb' => 'E7E6E6')
		        ),
		        'borders' => array(
		            'allborders' => array(
		                'style' => PHPExcel_Style_Border::BORDER_THIN,
		                'color' => array('rgb' => '595959')
		            )
		        ),
			      'alignment' => array(
			          'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			      )	                
		    )
		);

		$sheet->getStyle("A".($row_num+2))->getFont()->setBold(true);   	
  	$row_num = $row_num + 2;
  	$sheet->setCellValueByColumnAndRow(0, $row_num, "Приказы");
  	while($row = mysqli_fetch_array($query)){
  		$row_num++;
  		$sheet->setCellValueByColumnAndRow(0, $row_num, $row["o_name"]." от ".date('d.m.Y', strtotime($row["o_date"])));
			$sheet->getStyle('A'.$row_num)->applyFromArray(
			    array(
			        'borders' => array(
			            'allborders' => array(
			                'style' => PHPExcel_Style_Border::BORDER_THIN,
			                'color' => array('rgb' => '595959')
			            )
			        )            
			    )
			);  		
  	}
  }

  //Дипломная
  $query = mysqli_query($con, "SELECT * FROM diploma WHERE d_student='$sid'");
  if(mysqli_num_rows($query) != 0){
		$sheet->getStyle('A'.($row_num+2))->applyFromArray(
		    array(
		        'fill' => array(
		            'type' => PHPExcel_Style_Fill::FILL_SOLID,
		            'color' => array('rgb' => 'E7E6E6')
		        ),
		        'borders' => array(
		            'allborders' => array(
		                'style' => PHPExcel_Style_Border::BORDER_THIN,
		                'color' => array('rgb' => '595959')
		            )
		        ),
			      'alignment' => array(
			          'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			      )	                
		    )
		);

		$sheet->getStyle('B'.($row_num+2))->applyFromArray(
		    array(
		        'borders' => array(
		            'allborders' => array(
		                'style' => PHPExcel_Style_Border::BORDER_THIN,
		                'color' => array('rgb' => '595959')
		            )
		        )                
		    )
		);	

		$sheet->getStyle("A".($row_num+2))->getFont()->setBold(true);   	
  	$row_num = $row_num + 2;
  	$query = mysqli_fetch_array($query);
  	$sheet->setCellValueByColumnAndRow(0, $row_num, "Дипломная работа");
  	$sheet->setCellValueByColumnAndRow(1, $row_num, $query["d_mark"]);
  }  

  foreach (range('B', 'I') as $char) $sheet->getColumnDimension($char)->setWidth(3,5);

  //Сохранение
	$name = substr($name, 0, strrpos($name, ' '));
	$name = $name." ".$_COOKIE["group"];
	$objWriter = new PHPExcel_Writer_Excel5($xls);
	header('Content-type: application/vnd.ms-excel');
	header('Content-Disposition: attachment; filename='.$name.'.xls');
	$objWriter->save('php://output');
	mysqli_close($con);
?>