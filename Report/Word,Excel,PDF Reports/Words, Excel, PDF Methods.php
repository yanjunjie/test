<?php

//Yearly Course Plan


 /**
     * @access      public
     * @param       GET data
     * @author      Emdadul Huq <Emdadul@atilimited.net>
     * @return      Html return
     */
    function htmlPreview(){
        $data['pageTitle'] = 'Yearly Course Plan';
        $data['pageTitle'] = 'Sailor Nominee Roll';
        $headerText = $this->input->get("headerText");
        $footerText = $this->input->get("footerText");

        $data['headerText'] = $this->input->get("headerText");
        $data['footerText'] = $this->input->get("footerText");
        $data['reportTitle'] = $this->input->get("reportTitle");
        $data['reportSubTitle'] = $this->input->get("reportSubTitle");
        $data['reportDate'] = $this->input->get("reportDate");
        

        if (isset($_GET['showGrid'])) {
            $data['showGrid'] = $this->input->get("showGrid");  /*Flag = 0 means Show Grid*/
        }else{
            $data['showGrid'] = 1; /*Flag = 1 means don't show grid*/
        }
        if (isset($_GET['reportDate'])) {
            $reportDate = '{DATE j-m-Y}';  /*Flag = 1 means Show Report Date*/
        }else{
            $reportDate = '';
        }
        $data['coursePlan'] = $this->report->yearlyCoursePlan();
        //echo $this->db->last_query();
        $data['content_view_page'] = 'reportViewPrint/report/course_plan/pdf_yearly_course_plan';        
        $this->template->display($data);
    }

    /**
     * @access      public
     * @param       GET data
     * @author      Emdadul Huq <Emdadul@atilimited.net>
     * @return      PDF File return
     */
    public function genPDF(){
        
        $data['pageTitle'] = 'Yearly Course Plan';
        
        $headerText = $this->input->get("headerText");
        $footerText = $this->input->get("footerText");
        $data['reportTitle'] = $this->input->get("reportTitle");
        $data['reportSubTitle'] = $this->input->get("reportSubTitle");

        if (isset($_GET['showGrid'])) {
            $data['showGrid'] = $this->input->get("showGrid");  /*Flag = 0 means Show Grid*/
        }else{
            $data['showGrid'] = 1; /*Flag = 1 means don't show grid*/
        }
        if (isset($_GET['reportDate'])) {
            $reportDate = '{DATE j-m-Y}';  /*Flag = 1 means Show Report Date*/
        }else{
            $reportDate = '';
        }
        /*Mpdf part start*/
        include('mpdf/mpdf.php');
        $mpdf = new mPDF('utf-8', 'A4');
        $mpdf->SetTitle('Sailor Info:'); /*pdf Page Title*/
        $mpdf->mirrorMargins = 1;
        $mpdf->useOnlyCoreFonts = true;
        $mpdf->setFooter('
        <table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 8pt; color: #000000; font-weight: bold; font-style: italic;"><tr>
        <td width="33%"><span style="font-weight: bold; font-style: italic;">'.$footerText .'</span></td>
        <td width="33%" align="center" style="font-weight: bold; font-style: italic;">{PAGENO}/{nbpg}</td>
        <td width="33%" style="text-align: right; ">'.$reportDate.'</td>
        </tr></table>');

        $mpdf->SetHeader('<div style="vertical-align: bottom; font-family: serif; font-size: 8pt; color: #000000; font-weight: bold; font-style: italic;">'.$headerText.'</div>');
        
        $data['coursePlan'] = $this->report->yearlyCoursePlan();
        $report = $this->load->view('reportViewPrint/report/course_plan/pdf_yearly_course_plan', $data, TRUE);
        
        $mpdf->WriteHTML($report);
        $mpdf->Output();
        exit;
    }
    
    /**
     * @access      public
     * @param       GET data
     * @author      Emdadul Huq <Emdadul@atilimited.net>
     * @return      Word File return
     */
    public function genWord(){
        /*Load library phpword_gen*/
        $this->load->library("phpword_gen");
        $objPHPWord = new PHPWord; /*object create*/
        
        $yearlyCoursePlan = $this->report->yearlyCoursePlan();

        /*Start: attribut of word property*/
        $section = $objPHPWord->createSection(array('pageNumberingStart' => 1));
        
        // Define table style arrays
        $styleTable = array('borderSize'=>6, 'borderColor'=>'006699', 'cellMargin'=>80);
        $styleFirstRow = array('borderBottomSize'=>18, 'borderBottomColor'=>'0000FF', 'bgColor'=>'66BBFF');
        // Define cell style arrays
        $styleCell = array('valign'=>'center');
        $styleCellBTLR = array('valign'=>'center', 'textDirection'=>PHPWord_Style_Cell::TEXT_DIR_BTLR);
        // Define font style for first row
        $fontStyle = array('bold'=>true, 'align'=>'center');
        
        // Add table style
        $objPHPWord->addTableStyle('myOwnTableStyle', $styleTable, $styleFirstRow);
        // Add table
        $table = $section->addTable('myOwnTableStyle');
        // Add row
        $table->addRow(900);
        // Add cells
        $table->addCell(500, $styleCell)->addText('SN', $fontStyle);
        $table->addCell(1000, $styleCell)->addText('Name of institute', $fontStyle);
        $table->addCell(2000, $styleCell)->addText('Name Of Course', $fontStyle);
        $table->addCell(5000, $styleCell)->addText('No. of Candidates', $fontStyle);
        $table->addCell(1500, $styleCell)->addText('Duration', $fontStyle);
        $table->addCell(2000, $styleCell)->addText('Date of Commencement', $fontStyle);
        $table->addCell(4000, $styleCell)->addText('Date of Completion', $fontStyle);


        // Add more rows / cells
        foreach ($yearlyCoursePlan as $key => $row) {
            $table->addRow();
            $table->addCell(2000)->addText($key+1);
            $table->addCell(2000)->addText($row->Name_of_Institute);
            $table->addCell(5000)->addText($row->Name_of_Course);
            $table->addCell(1500)->addText($row->Number_Of_Candidates);
            $table->addCell(2000)->addText($row->Duration);

            $table->addCell(4000)->addText(date('d-M-Y', strtotime($row->Dateofcommencement)));
            $table->addCell(4000)->addText(date('d-M-Y', strtotime($row->Date_Of_Completing)));
        }

        /*end word property*/

        /*Generate word file with two parameter first fileName, second object*/
        $data = $this->phpword_gen->gen_word("yearlyCoursePlan", $objPHPWord);
        echo  json_encode($data);  
        
    }
    /**
     * @access      public
     * @param       GET data
     * @author      Emdadul Huq <Emdadul@atilimited.net>
     * @return      Excel File return
     */
    public function genExcel(){
        $coursePlan = $this->report->yearlyCoursePlan();
        /*load phpexcel_gen*/
        $this->load->library("phpexcel_gen");
        $objPHPExcel = new PHPExcel; /* object create*/

        /*Start: attribut of excel property*/
        $objPHPExcel->getProperties()->setCreator("Bangladesh Navy: Sailor management System")
                             ->setTitle("Recommendation Not Received")
                             ->setSubject("Sailor data");
      
        $objPHPExcel->setActiveSheetIndex(0);
        //set up the style in an array
        $style = array('font' => array('size' => 12,'bold' => true,'color' => array('rgb' => '000000')));

        //apply the style on column A row 1 to Column B row 1
        $objPHPExcel->getActiveSheet()->getStyle('A1:G1')->applyFromArray($style);
        
        for($col = 'A'; $col !== 'G'; $col++) {
            $objPHPExcel->getActiveSheet() ->getColumnDimension($col) ->setAutoSize(true);
        }
        // Add column headers
        $objPHPExcel->getActiveSheet()
                    ->setCellValue('A1', 'SN')
                    ->setCellValue('B1', 'Name of institute')
                    ->setCellValue('C1', 'Name Of Course')
                    ->setCellValue('D1', 'No. of Candidates')
                    ->setCellValue('E1', 'Duration')
                    ->setCellValue('F1', 'Date of Commencement')
                    ->setCellValue('G1', 'Date of Completion')
                    ;
        $tSanc = 0; $tBorne = 0; $gtSanc = 0; $gtBorne = 0;
        //Put each record in a new cell        
        
        foreach ($coursePlan as $key => $row) { 
            $ii = $key + 2;
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$ii, $key+1);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$ii, $row->Name_of_Institute);
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$ii, $row->Name_of_Course);
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$ii, $row->Number_Of_Candidates);
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$ii, $row->Duration);
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$ii, date('d-M-Y', strtotime($row->Dateofcommencement)) );
            $objPHPExcel->getActiveSheet()->setCellValue('G'.$ii, date('d-M-Y', strtotime($row->Date_Of_Completing)) );
        }
        
        
        // Rename worksheet
        //echo date('H:i:s') , " Rename worksheet" , EOL;
        $objPHPExcel->getActiveSheet()->setTitle('yearly Course Plan');
        /*end excle property*/

        /*Generate excel file with two parameter first fileName, second object*/
        $data = $this->phpexcel_gen->gen_excel("yearly_course_plan", $objPHPExcel);
        echo  json_encode($data);  
        
    }



