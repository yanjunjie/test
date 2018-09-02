<script type="text/javascript">
$(document).ready(function(){
  var pmId=$("input.pmId").val();
  if(pmId>0)
  {
    var urlTail='?section='+pmId;
  }
  else
  {
    var urlTail='';
  }
    var source_data  = $('.common_table').data('source')+urlTail;

    // begin second table
    oTable2 = $('.common_table').dataTable({
        "processing": true,
        "serverSide": true,
        "searching": true,
        "searchable": false,
        "pagingType": "full_numbers",
        'pageLength': 50,
        "aLengthMenu": [
            [50, 100,150],
            [50, 100,150] // change per page values here
        ],
        // Load data for the table's content from an Ajax source
        "ajax": {

            //"type": "GET",
            "url": source_data,
        },
        //Set column definition initialisation properties.
        "columnDefs": [
            {"targets": [0],"orderable": true},
            {"targets": [ -1 ], "orderable": true},
            {"targets": [ -2 ], "orderable": true}
        ]
    });
});
</script>

<script type="text/javascript">
$(document).ready(function(){
  var pmId=$("input.pmId").val();
  if(pmId>0)
  {
    var urlTail='?section='+pmId;
  }
  else
  {
    var urlTail='';
  }
    var source_data  = $('.other_leave_application').data('source')+urlTail;
    // begin second table
    oTable2 = $('.other_leave_application').dataTable({
        "processing": true,
        "serverSide": true,
        "searching": true,
        "searchable": false,
        "pagingType": "full_numbers",
        'pageLength': 10,
        "aLengthMenu": [
            [10, 20, 50,100],
            [10, 20, 50,100] // change per page values here
        ],
        // Load data for the table's content from an Ajax source
        "ajax": {

            //"type": "GET",
            "url": source_data,
        },
        //Set column definition initialisation properties.
        "columnDefs": [
            {"targets": [0],"orderable": true},
            {"targets": [ -1 ], "orderable": true},
            {"targets": [ -2 ], "orderable": true}
        ]
    });
});
</script>

<script type="text/javascript">
$(document).ready(function(){
    var source_data  = $('.leave_Application_History').data('source');
    // begin second table
    oTable2 = $('.leave_Application_History').dataTable({
        "processing": true,
        "serverSide": true,
        "searching": true,
        "searchable": false,
        "pagingType": "full_numbers",
        'pageLength': 10,
        "aLengthMenu": [
            [10, 20, 50,100],
            [10, 20, 50,100] // change per page values here
        ],
        // Load data for the table's content from an Ajax source
        "ajax": {

            //"type": "GET",
            "url": source_data,
        },
        //Set column definition initialisation properties.
        "columnDefs": [
            {"targets": [0],"orderable": true},
            {"targets": [ -1 ], "orderable": true},
            {"targets": [ -2 ], "orderable": true}
        ]
    });
});
</script>

<script type="text/javascript">
$(document).ready(function(){
    var source_data  = $('.searchEmployeeByDept').data('source');
    // begin second table
    oTable2 = $('.searchEmployeeByDept').dataTable({
        "processing": true,
        "serverSide": true,
        "searching": true,
        "searchable": false,
        "pagingType": "full_numbers",
        'pageLength': 20,
        "aLengthMenu": [
            [20, 50,100],
            [20, 50,100] // change per page values here
        ],
        // Load data for the table's content from an Ajax source
        "ajax": {

            //"type": "GET",
            "url": source_data,
        },
        //Set column definition initialisation properties.
        "columnDefs": [
            {"targets": [0],"orderable": true},
            {"targets": [ -1 ], "orderable": true},
            {"targets": [ -2 ], "orderable": true}
        ]
    });
});
</script>

<script type="text/javascript">
$(document).ready(function(){
    var source_data  = $('.common_table_another').data('source');
    // begin second table
    oTable2 = $('.common_table_another').dataTable({
        "processing": true,
        "serverSide": true,
        "searching": true,
        "searchable": false,
        "pagingType": "full_numbers",
        'pageLength': 10,
        "aLengthMenu": [
            [10, 20, 50,100],
            [10, 20, 50,100] // change per page values here
        ],
        // Load data for the table's content from an Ajax source
        "ajax": {

            //"type": "GET",
            "url": source_data,
        },
        //Set column definition initialisation properties.
        "columnDefs": [
            {"targets": [0],"orderable": true},
            {"targets": [ -1 ], "orderable": true},
            {"targets": [ -2 ], "orderable": true}
        ]
    });
});
</script>

