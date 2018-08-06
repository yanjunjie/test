<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Dashboard
        <!--<small>Control panel</small>-->
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url('assets/template/');?>#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Ship Building</li>
    </ol>
</section>
<hr>

<div class="projectsCreateArea">
    <!--Alert List-->
    <?php if($alert = $this->session->userdata('success_alert')): ?>
        <div class="alert alert-success alert-dismissable fade in">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Success!</strong> <?php echo $alert; $this->session->unset_userdata('success_alert');?>
        </div>
    <?php endif; ?>

    <?php if($alert = $this->session->userdata('failure_alert')): ?>
        <div class="alert alert-danger alert-dismissable fade in">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Failure!</strong> <?php echo $alert; $this->session->unset_userdata('failure_alert');?>
        </div>
    <?php endif; ?>
    <!--End Alert List-->

    <!--Modal-->
    <?php $this->load->view('back/galleryUpdateModalPage');?>
    <!--End Modal-->

    <?php if (isset($tbl_shipbuilding_update)): ?>

    <div class="projectsUpdate">
        <form action="<?php echo base_url('back/shipBuildingUpdate');?>" class="form-horizontal" enctype="multipart/form-data" method="post">

            <input type="hidden" name="id" value="<?php echo $tbl_shipbuilding_update->id; ?>">

            <div class="form-group">
                <label for="shipbuilding_title" class="col-sm-2 control-label">Ship Building Title</label>
                <div class="col-sm-8">
                    <input value="<?php echo $tbl_shipbuilding_update->shipbuilding_title; ?>" name="shipbuilding_title" id="shipbuilding_title" class="form-control" placeholder="Ship Building Title">
                </div>
            </div>

            <div class="form-group">
                <label for="shipbuilding_picname" class="col-sm-2 control-label">Short Description</label>
                <div class="col-sm-8">
                    <textarea name="shipbuilding_picname" id="shipbuilding_picname" class="form-control editor" placeholder="Short Description"><?php echo $tbl_shipbuilding_update->shipbuilding_picname; ?></textarea>
                </div>
            </div>

            <div class="form-group">
                <label for="shipbuilding_details" class="col-sm-2 control-label">Ship Building Details</label>
                <div class="col-sm-8">
                    <textarea name="shipbuilding_details" id="shipbuilding_details" class="form-control editor" placeholder="Ship Building Details"><?php echo $tbl_shipbuilding_update->shipbuilding_details; ?></textarea>
                </div>
            </div>

            <div class="form-group">
                <label for="shipbuilding_pic" class="col-sm-2 control-label">Image</label>
                <div class="col-sm-8">
                    <input value="<?php echo $tbl_shipbuilding_update->shipbuilding_pic; ?>" type="file" name="shipbuilding_pic" class="form-control" id="shipbuilding_pic" placeholder="Ship Building Pic">
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-8">
                    <button type="submit" class="btn btn-info pull-right">Update</button>
                </div>
            </div>

        </form>
    </div>

    <?php else: ?>

    <div class="projectsCreate">
        <form action="<?php echo base_url('back/shipBuildingSave');?>" class="form-horizontal" enctype="multipart/form-data" method="post">

            <div class="form-group">
                <label for="shipbuilding_title" class="col-sm-2 control-label">Ship Building Title</label>
                <div class="col-sm-8">
                    <input name="shipbuilding_title" id="shipbuilding_title" class="form-control" placeholder="Ship Building Title">
                </div>
            </div>

           <!-- <div class="form-group">
                <label for="project_type" class="col-sm-2 control-label">Project Type</label>
                <div class="col-sm-8">
                    <select name="project_type" id="project_type" class="form-control">
                        <option disabled value="">Choose One</option>
                        <option value="on">On Going Projects</option>
                        <option value="off">Project Archives</option>
                    </select>
                </div>
            </div>-->

            <div class="form-group">
                <label for="shipbuilding_picname" class="col-sm-2 control-label">Short Description</label>
                <div class="col-sm-8">
                    <textarea name="shipbuilding_picname" id="shipbuilding_picname" class="form-control editor" placeholder="Short Description"></textarea>
                </div>
            </div>

            <div class="form-group">
                <label for="shipbuilding_details" class="col-sm-2 control-label">Ship Building Details</label>
                <div class="col-sm-8">
                    <textarea name="shipbuilding_details" id="shipbuilding_details" class="form-control editor" placeholder="Ship Building Details"></textarea>
                </div>
            </div>

            <div class="form-group">
                <label for="shipbuilding_pic" class="col-sm-2 control-label">Image</label>
                <div class="col-sm-8">
                    <input type="file" name="shipbuilding_pic" class="form-control" id="shipbuilding_pic" placeholder="Ship Building Pic">
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-8">
                    <button type="submit" class="btn btn-info pull-right">Save</button>
                </div>
            </div>

        </form>
    </div>

    <?php endif; ?>

    <br>
    <br>
    <!--Tender List View-->
    <div class="TenderListView">
        <?php if (isset($tbl_shipbuilding_all)):?>
            <fieldset>
                <legend>Projects<span style="padding-left:5px;color:#00CC00;"></span> </legend>
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th style="width:5%">SL</th>
                        <th>Project Title</th>
                        <th>Project Type</th>
                        <th>Short Description</th>
                        <th>Photo</th>
                        <th style="width:10%;">`Action</th>

                    </tr>
                    </thead>
                    <tbody>
                    <?php $i=1; foreach ($tbl_shipbuilding_all as $key1=>$value1): ?>
                        <tr>
                            <td><?php echo $i;?></td>
                            <td><?php echo $value1->shipbuilding_title;?></td>
                            <td><?php echo $value1->shipbuilding_picname;?></td>
                            <td><img width="70" src="<?php echo base_url('uploads/shipBuilding/').$value1->shipbuilding_pic; ?>" alt=""></td>

                            <td style="text-align: center;"><a href="<?php echo base_url('back/shipBuildingCreate/').$value1->id; ?>" class="btn btn-warning" data-id="<?php echo $value1->id;?>" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>

                        </tr>
                    <?php $i++; endforeach; ?>
                    </tbody>
                </table>
            </fieldset>
        <?php endif;?>
    </div>
    <!--End Tender List View-->
</div>
