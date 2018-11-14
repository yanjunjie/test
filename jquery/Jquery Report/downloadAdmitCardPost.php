<div id="printablediv">

  <style media="screen,print">
  table>thead>tr>th{
    padding-left:5px!important;
  }
  table>tr>th{
    padding-left:5px!important;
  }
  table>tbody>tr>td{
    padding-left:5px!important;
  }
  table>tbody>tr>th{
    padding-left:5px!important;
  }
  table.customTable{
    text-transform: uppercase;
  }


  </style>
<div class="panel panel-default">
  <table class="table table-bordered customTable" border="1" width="100%" rules="all" border="1">
    <tr>
      <th colspan="3"><center><img src="<?php echo base_url('upload/organization/logo/').$orgInfo->LOGO; ?>" height="70px" alt="">  <h3 style="font-weight:bold"> <?php echo $orgInfo->ORG_NAME; ?> (<?php echo $orgInfo->ABBR;?>)</h3></center></th>
    </tr>
    <tr>
      <th colspan="3"><center> <h3 style="color:green;font-weight:bold">Admit Card</h3>  </center></th>
    </tr>
    <tr>
      <th align="left" width="30%">Exam Title</th>
      <td width="50%"><?php echo $examInfo->PROGRAM_NAME.', '.$semester.' exam, '.$examInfo->EXAM_YEAR; ?></td>
      <td rowspan="8">
        <img src="<?php echo base_url('upload/student/photo/'.$studentInfo->PHOTO)?>" class="img-responsive pull-right" style="height:233px!important;width:auto" alt="">
      </td>
    </tr>
      <tr>
        <th align="left">Name</th>
        <td><?php echo $studentInfo->FULL_NAME_EN; ?></td>
      </tr>
      <tr>
        <th align="left">Registration No</th>
        <td><?php echo $studentInfo->REGISTRATION_NO; ?></td>
      </tr>
      <tr>
        <th align="left">Date of Birth</th>
        <td><?php echo date('d-M-Y', strtotime($studentInfo->DATH_OF_BIRTH)); ?></td>
      </tr>
      <tr>
        <th align="left">Program</th>
        <td><?php echo $studentInfo->PROGRAM_NAME; ?></td>
      </tr>
      <tr>
        <th align="left">Session</th>
        <td><?php echo $studentInfo->SESSION_NAME ?></td>
      </tr>
      <tr>
        <th align="left">Semester</th>
        <td><?php echo $semester; ?></td>
      </tr>
      <tr>
        <th align="left">Type of Examinee</th>
        <td>
            <?php
              if($studentInfo->IS_REGULAR==1)
              {
                echo "Regular";
              }
              else
              {
                echo "Irregular";
              }
             ?>
        </td>
      </tr>

  </table>
  <table class="table table-bordered" width="100%" border="1" rules="all" border="1">
    <thead>
      <tr>
        <th width="20%">Exam Date</th>
        <th width="12%">Course Code</th>
        <th width="">Course Title</th>
        <th width="15%">Start From</th>
        <th width="15%">End To</th>
      </tr>
      <tbody>
        <?php foreach($examCourse as $row){
      ?>
        <tr>
          <td align="left"><?php echo  date('D, d-M-Y', strtotime($row->EXAM_DT)); ?></td>
          <td align="left"><?php echo $row->COURSE_CODE; ?></td>
          <td align="left"><?php echo $row->COURSE_TITLE; ?></td>
          <td align="left"><?php echo date('h:i A', strtotime($row->START_TIME));// $row->; ?></td>
          <td align="left"><?php echo  date('h:i A', strtotime($row->END_TIME)); ?></td>
        </tr>
        <?php
          }
        ?>
        <tr>
          <td colspan="5">

            <p><b>Instruction: </b>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>
          </td>
        </tr>
      </tbody>
    </thead>
  </table>
  <table class="table table-bordered" width="100%" >
    <tr style="">
      <td width="50%">
        <span style="float:left; text-transform:uppercase;">
          <img src="<?php echo base_url('upload/student/signature/'.$studentInfo->SIGNATURE_PHOTO)?>" class="" style="max-height:50px!important;width:auto" alt=""><br>

      </td>
      <td>

      </td>
    </tr>
    <tr style="">
      <td width="50%">
        <span style="float:left; text-transform:uppercase;">

          _______________________<br>
          <?php echo $studentInfo->FULL_NAME_EN; ?>
        </span>
      </td>
      <td>
        <span style="float:right;text-transform:uppercase;">
          ___________________<br>
          Signature of COE </span>
      </td>
    </tr>
  </table>
</div>
</div>
<button type="button" value="Print" class="btn btn-primary printButton centered">Print</button>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script>
    $(document).on("click", ".printButton", function () {
        Popup($(".printablediv").html());
    });
    function Popup(data)
    {
        var currentdate = new Date();
        var datetime = "File: " + currentdate.getDate() + ""
            + (currentdate.getMonth()+1)  + ""
            + currentdate.getFullYear() + ""
            + currentdate.getHours() + ""
            + currentdate.getMinutes() + ""
            + currentdate.getSeconds();

        var mywindow = window.open('',datetime, 'height=800,width=1024');
        mywindow.document.write('<html><head><title>'+datetime+'</title>');
        /*optional stylesheet*/ //mywindow.document.write('<link rel="stylesheet" href="main.css" type="text/css" />');
        mywindow.document.write('</head><body >');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');
        mywindow.print();
        mywindow.close();

        return true;
    }
</script>