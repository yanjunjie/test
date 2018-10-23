<select name="DEGREE_ID" id="DEGREE_ID" data-placeholder="Choose Degree" class="chosen-select form-control" tabindex="4">
    <option value="" selected disabled>-Select-</option>
    <option value="<?php echo $result->DEGREE_ID; ?>" <?php echo  set_select("DEGREE_ID", "$result->DEGREE_ID"); ?> ><?php echo $result->DEGREE_NAME; ?></option>
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
