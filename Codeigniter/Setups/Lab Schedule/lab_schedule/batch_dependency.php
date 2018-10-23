<select name="BATCH_ID" id="BATCH_ID" data-placeholder="Choose Batch" class="chosen-select form-control" tabindex="4">
    <option value="" selected disabled>-Select-</option>
    <?php foreach($result as $ky=>$row2) {?>
        <option value="<?php echo $row2->BATCH_ID; ?>" <?php echo  set_select("BATCH_ID", "$row2->BATCH_ID"); ?> ><?php echo $row2->BATCH_TITLE; ?></option>
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
