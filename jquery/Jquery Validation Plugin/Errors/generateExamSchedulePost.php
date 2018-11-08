<?php
  if($getCoursesByPidSidSid)
  {
    ?>
    <div class="col-md-12">
      <table class="table">
        <thead>
          <tr>
            <th width="5%"> <input type="checkbox" class="checkAll" name="allCkeck" value=""> All </th>
            <th width="5%">Sl</th>
            <th width="30%">Course Name</th>
            <th>Start Time</th>
            <th>End Time</th>
            <th>Exam Date</th>
            <th width="12%">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php $i=1;
          foreach($getCoursesByPidSidSid as $row)
          {
            /*$checked="";
            if($row->EXIST!=0)
            {
              $checked="checked";
            }*/
            ?>

            <tr>
                <td> <input type="checkbox" class="" name="COURSE_ID[]" value="<?php echo $row->COURSE_ID; ?>"></td>
                <td><?php echo $i++; ?></td>
                <td><?php echo $row->COURSE_TITLE; ?></td>
                <td>
                  <div class='input-group date time_picker'>
                      <input value="<?php echo  set_value("START_TIME"); ?>" name="START_TIME[<?php echo $row->COURSE_ID; ?>]" type='text' class="form-control" />
                      <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-time"></span>
                                </span>
                  </div>
                  <span class="red"><?php echo form_error('START_TIME'); ?></span>
                </td>
                <td>
                    <div class='input-group date time_picker'>
                        <input value="<?php echo  set_value("END_TIME"); ?>" name="END_TIME[<?php echo $row->COURSE_ID; ?>]" type='text' class="form-control" />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-time"></span>
                        </span>
                    </div>
                    <span class="red"><?php echo form_error('END_TIME'); ?></span>
                </td>
                <td>
                  <div class='input-group date date_picker' style="margin-bottom: 11px;">
                      <input class="form-control" value="<?php echo  set_value("EXAM_DT"); ?>" name="EXAM_DT[<?php echo $row->COURSE_ID; ?>]" type='text' placeholder="Exam Date">
                      <span class="input-group-addon">
                          <span class="glyphicon glyphicon-calendar"></span>
                      </span>
                  </div>
                </td>
                <td>
                    <button type="button" class="btn btn-success btn-xs" title="Click For Edit" style="margin: 0; font-size: 11px; padding: 1px 3px; color: #fff; font-weight: 600; line-height: 1.3;">
                        Update
                    </button>
                    <button type="button" class="btn btn-danger btn-xs" title="Click For Delete" style="margin: 0; font-size: 11px; padding: 1px 3px; color: #fff; font-weight: 600; line-height: 1.3;">
                        Delete
                    </button>
                </td>
            </tr>

            <?php
          }
           ?>
        </tbody>
      </table>
    </div>
    <?php
  }
  else
  {
      echo '<h3 class="text-danger text-center">No data found !!</h3>';
  }
?>
<script type="text/javascript">
$(".checkAll").click(function(){
  $('input:checkbox').not(this).prop('checked', this.checked);
})

$(function () {
    $('.date_picker').datetimepicker({
        format: 'DD-MM-YYYY'
    });
    $('.time_picker').datetimepicker({
        format: 'LT'
        //format: 'HH:mm:ss'
    });

});

var config = {
    '.chosen-select'           : {},
    '.chosen-select-deselect'  : {allow_single_deselect:true},
    '.chosen-select-no-single' : {disable_search_threshold:10},
    '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
    '.chosen-select-width'     : {width:"95%"}
}
for (var selector in config) {
    $(selector).chosen(config[selector]);
}

</script>
