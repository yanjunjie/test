 //Datatable
    $(document).ready(function() {
        $('.dataTables').DataTable({
            //Options
            "processing": true,  // Show processing
            "serverSide": true,  // Server side processing
            "pageLength": 5,    // 5 rows per page
            "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]], //Select Box
            
            //Load data for the table's content
            "ajax":{
                url :  '<?= route("dataProcessing"); ?>',
                type : "POST",
                dataType: 'json',
                data:{"_token":"<?= csrf_token(); ?>"}
            },
            
            //Style
            "aoColumnDefs": [
                { "sWidth": "20%", "aTargets": 0 }, //<- start from zero
                { "sWidth": "10%", "aTargets": 1 },
                { "sWidth": "10%", "aTargets": 2 },
            ],
            
            //Columns
            "columns": [
                {'data':'title'},
                {'data':'id'},
                {"data":"action","searchable":false,"orderable":false}
            ],
        });

        $( ".dataTables_length select option:first" ).attr("selected","selected");
        //Delete confirmation
        $(window).load(function () {
            $(".confirmDel").on("click",function () {
                if (confirm('Are you sure to delete?')) {
                    return true;
                }else{
                    return false;
                }
            });
        });
        //OR
        function confirmDel(){
            if (confirm('Are you sure to delete?')) {
                return true;
            }else{
                return false;
            }
        }
    });

//
