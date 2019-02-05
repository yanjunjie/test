<form class="form-horizontal frmContent" id="branchForm" method="post">
<div class="text-right">
    <button style="margin-bottom: 5px;" type="button" class="btn btn-info btn-xs">Print</button>
    <div class="clearfix"></div>
</div>
    <table class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th>BRANCH</th>
            <th>RANK</th>
            <th>SANCTION</th>
            <th>BORNE</th>
            <th>(+)/(-)</th>
            <th>RAMARKS</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($branch as $key=>$row) { ?>
            <tr>
                <td rowspan="<?php echo ($row->TOTAL_RANK + 1); ?>"><?php echo $row->BRANCH_NAME;?></td>
            </tr>

            <?php foreach ($branchRank  as $row2):
                if($row->BRANCH_ID == $row2->BRANCH_ID):?>
                <tr>
                    <td><?php echo $row2->RANK_NAME; ?></td>
                    <td><?php echo $row2->sanction; ?></td>
                    <td><?php echo $row2->borne; ?></td>
                    <td><?php echo ($row2->borne - $row2->sanction);?></td>
                    <td>&nbsp;</td>
                </tr>
            <?php endif; endforeach; } ?>

        </tbody>
    </table>

    <div class="form-actions text-center">
        <input type="button" class="btn btn-success btn-sm " id="formSave" value="Save">
        <input type="button" class="btn btn-danger btn-sm " id="formDelete" value="Delete">
    </div>
    <br><br>
</form>


<script type="text/javascript" language="javascript">
    $(document).on("click", "#formDelete", function () {
        if (confirm('Are you want to Delete?')) {
            var data = $("#branchForm").serialize();
            //console.log(data);
            $.ajax({
                type: "POST",
                data: data,
                url: "<?php echo site_url('othersInfo/BranchAndRankWiseSection/deleteBranchAndRank'); ?>",
                success: function (data) {
                    $(".msg").html(data);
                    window.location.replace('<?php echo site_url('othersInfo/BranchAndRankWiseSection/index'); ?>');
                }
            });
        } else {
            return false;
        }
    });


        $(document).on("click", "#formSave", function () {
        if (confirm('Are you want to Save?')) {
            var data = $("#branchForm").serialize();
            //console.log(data);
            $.ajax({
                type: "POST",
                data: data,
                url: "<?php echo site_url('othersInfo/BranchAndRankWiseSection/saveBranchAndRank'); ?>",
                success: function (data) {
                    $(".msg").html(data);
                   window.location.replace('<?php echo site_url('othersInfo/BranchAndRankWiseSection/index'); ?>');
                }
            });
        } else {
            return false;
        }
    });


/*    $('#dataTable').removeAttr('width').DataTable( {
        "scrollX": true,
        "scrollX": true,
        "bPaginate": false,
        "bFilter": false,
        "bInfo": false,
        "columnDefs": [
            { width: '100px', targets: 0 },
            { width: '100px', targets: 1 },
            { width: '100px', targets: 2 },
            { width: '80px', targets: 3 },
            { width: '100px', targets: 5 },
            { width: '90px', targets: 8 },
            { width: '100px', targets: 9 },
        ],
        "fixedColumns": true

    } );*/


</script>