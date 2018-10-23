<select required="required" name="PROGRAM_ID" id="PROGRAM_ID" data-placeholder="Choose Program" class="chosen-select form-control" tabindex="4">
    <option value="" selected disabled>-Select-</option>
    <?php foreach($result as $ky=>$row2) {?>
        <option value="<?php echo $row2->PROGRAM_ID; ?>" <?php echo  set_select("PROGRAM_ID", "$row2->PROGRAM_ID"); ?> ><?php echo $row2->PROGRAM_NAME; ?></option>
    <?php } ?>
</select>

<script>
    var config = {
        '.chosen-select'           : {allow_single_deselect:true},
        '.chosen-select-deselect'  : {allow_single_deselect:true},
        '.chosen-select-no-single' : {disable_search_threshold:10},
        '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
        '.chosen-select-width'     : {width:"95%"}
    }
    for (var selector in config) {
        $(selector).chosen(config[selector]);
    }
</script>
