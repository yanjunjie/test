<form method="post" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <input type="file" name="spreadsheet"/>
    <input type="submit" name="submit" value="Upload" />
</form>

<?php
//uploaded file receiving
if(!empty($_FILES['spreadsheet']['name'])){
    $img_ext = str_replace(" ","-", $_FILES['spreadsheet']['name']);
    //$arrayr = explode('.', $_FILES['spreadsheet']['name']);

    //$extension = end($array);
    $temp_file = $_FILES['spreadsheet']['tmp_name'];
    $destination    ='files/'.uniqid().date('Y-m-d-H-i-s').$img_ext;
    move_uploaded_file($temp_file, $destination);

	require_once 'Classes/PHPExcel.php';
	require_once 'Classes/PHPExcel/IOFactory.php';
	require_once 'Classes/PHPExcel/Calculation.php';
	require_once 'Classes/PHPExcel/Cell.php';

	$objPHPExcel = new PHPExcel();
	// Set properties or metadata
	$objPHPExcel->getProperties()->setCreator("Bablu Ahmed")
    ->setLastModifiedBy("Bablu")
    ->setTitle("Office 2007 XLSX Test Document")
    ->setSubject("Office 2007 XLSX Test Document")
    ->setDescription("Test doc for Office 2007 XLSX, generated by PHPExcel.")
    ->setKeywords("office 2007 openxml php")
    ->setCategory("Test result file");
	$objPHPExcel->getActiveSheet()->setTitle('Jacos Standard File');

	//Read an uploaded excel file without creating excel
    $objPHPExcel = PHPExcel_IOFactory::load($destination);
    $objWorksheet = $objPHPExcel->getActiveSheet();

    //2nd object for new excel sheet or new file
    $objPHPExcel2 = new PHPExcel();
	
    //First Output according to selected column color
    foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
        $worksheetTitle     = $worksheet->getTitle();
        $highestRow         = $worksheet->getHighestRow(); // e.g. 10
        $highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
        $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
        $nrColumns = ord($highestColumn) - 64;

        //echo '<br>Data: <table border="1"><tr>';
        $count = 65;
        for ($row = 1; $row <= $highestRow; ++ $row) {
            //echo '<tr>';
            for ($col = 0; $col < $highestColumnIndex; $col++) {
                $char = chr($count + $col);
                $get_cell_color = $objWorksheet->getStyle($char."1")->getFill()->getStartColor()->getRGB();
                $cell = $worksheet->getCellByColumnAndRow($col, $row);
                $cell_color = $cell->getStyle($char."1")->getFill()->getStartColor()->getRGB();
                $colIndex = PHPExcel_Cell::columnIndexFromString($cell->getColumn());

                if($cell_color == "000000" or $cell_color == "FFFFFF"){
                    continue;
                }
                $val = $cell->getValue();
                $new_all_cells[][] = $val;
                $objPHPExcel2->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $val);
                //echo '<td>' . $val.'</td>';
                //$cell->setValue($val);
                
            }
            //echo '</tr>';
        }
        //echo '</table>';
    }
	
	//Set Title field
    $objPHPExcel2->setActiveSheetIndex()
        ->setCellValue('A1', 'NO')
        ->setCellValue('B1', 'JAN')
        ->setCellValue('C1', '商品名')
        ->setCellValue('D1', '規格')
        ->setCellValue('E1', '発注')
        ->setCellValue('F1', '原価')
        ->setCellValue('G1', '売価')
        ->setCellValue('H1', 'メーカー名')
        ->setCellValue('I1', '発売日');

    //Write or save
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel2, 'Excel2007');
    // If you want to output e.g. a PDF file, simply do:
    //$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'PDF');
    $objWriter->save('SaveFile.xlsx');


    //Read again the uploaded for final output display
    $objPHPExcel3 = PHPExcel_IOFactory::load("SaveFile.xlsx");

    //Final Output2 according to selected column color
    foreach ($objPHPExcel3->getWorksheetIterator() as $worksheet) {
        $worksheetTitle     = $worksheet->getTitle();
        $highestRow         = $worksheet->getHighestRow(); // e.g. 10
        $highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
        $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
        $nrColumns = ord($highestColumn) - 64;

        echo '<table border="1"><tr>';
        for ($row = 1; $row <= $highestRow; ++ $row) {
            echo '<tr>';
            for ($col = 0; $col < $highestColumnIndex; ++ $col) {
                $cell = $worksheet->getCellByColumnAndRow($col, $row);
                $val = $cell->getValue();
                //$dataType = PHPExcel_Cell_DataType::dataTypeForValue($val);
                echo '<td>' . $val.'</td>';
            }
            echo '</tr>';
        }
        echo '</table>';
    }
}else{
    echo "Please upload an excel file";
}
?>