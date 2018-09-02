//Insert
<select name="tender_status" id="tender_status" class="form-control selectpicker" title="Choose one">
    <option value="A" class="special">Publushed</option>
    <option value="B" class="special">Unpublished</option>
</select>

//Update
<table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th>Tender no</th>
                <th>Tender Name</th>
                <!--<th>Published Date</th>-->
                <th>Tender Selling Start From</th>
                <th>Tender Type</th>
                <th>Date of Submission</th>
                <th>Tender Specification</th>
                <th>Tender Notice</th>
                <th colspan="2">Action</th>

            </tr>
        </thead>
        <tbody>
            <?php $i=1; foreach ($AllTenderList as $key=>$TenderList): ?>
            <tr>
                <td><?php echo $TenderList->tender_id;?></td>
                <td><?php echo $TenderList->tender_name;?></td>
                <!--<td><?php /*echo date('d/m/Y', strtotime($TenderList->tender_date));*/?></td>-->
                <td><?php echo date('d/m/Y', strtotime($TenderList->tender_closing_date));?></td>
                <td><?php echo $TenderList->tender_type;?></td>
                <td><?php echo date("d/m/Y", strtotime($TenderList->tender_submission_date)) ;?></td>
                <td style="text-align: center;">
                    <?php if ($TenderList->tender_specification):?>
                        <a class="btn btn-xs btn-primary" target="_blank" href="<?php echo base_url('uploads/tender/specification/'.$TenderList->tender_specification);?>">Download</a>
                    <?php endif;?>
                </td>
                <td style="text-align: center;">
                    <?php if ($TenderList->tender_notice):?>
                        <a class="btn btn-xs btn-primary" target="_blank" href="<?php echo base_url('uploads/tender/notice/'.$TenderList->tender_notice);?>">Download</a>
                    <?php endif;?>
                </td>
                <td><button type="button" class="btn btn-warning tenderUpdate" data-id="<?php echo $TenderList->id;?>" data-toggle="modal" data-target="#tenderUpdate"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></td>
                <?php if ($TenderList->tender_status=='A'):?>
                <td><button data-id="<?php echo $TenderList->id;?>" data-value="B" type="button" class="btn btn-success TenderStatus">Published</button></td>
                <?php else: ?>
                <td><button data-id="<?php echo $TenderList->id;?>" data-value="A" type="button" class="btn btn-danger TenderStatus">Unpublished</button></td>
                <?php endif;?>
            </tr>
            <?php $i++; endforeach; ?>
        </tbody>
    </table>
