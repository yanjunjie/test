<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Dashboard
        <!--<small>Control panel</small>-->
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url('assets/template/');?>#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Certification</li>
    </ol>
</section>
<hr>

<div class="certificationCreatePage">
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

    <?php if (isset($tbl_photogalleryUpdate)): ?>

    <div class="certificationUpdate">
        <form action="<?php echo base_url('back/galleryUpdate');?>" class="form-horizontal" enctype="multipart/form-data" method="post">

            <input type="hidden" name="id" value="<?php echo $tbl_photogalleryUpdate->id; ?>">

            <div class="form-group">
                <label for="gallery_category_id" class="col-sm-2 control-label">Event Name</label>
                <div class="col-sm-8">
                    <select name="gallery_category_id" id="gallery_category_id" class="form-control" title="Choose one">
                        <?php foreach ($galleryCategory as $key=>$value):?>
                            <option value="<?php echo $value->id;?>"><?php echo $value->gallery_cat_name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="pic_title" class="col-sm-2 control-label">Title</label>
                <div class="col-sm-8">
                    <textarea name="pic_title" id="pic_title_id" class="form-control" placeholder="Description"><?php echo $tbl_photogalleryUpdate->pic_title; ?></textarea>
                </div>
            </div>

            <div class="form-group">
                <label for="gallery_image" class="col-sm-2 control-label">Upload Image</label>
                <div class="col-sm-8">
                    <input type="file" value="" name="gallery_image" class="form-control" id="gallery_image" placeholder="Gallery image">
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

    <div class="certificationCreate">
        <form action="<?php echo base_url('back/gallerySave');?>" class="form-horizontal" enctype="multipart/form-data" method="post">
            <div class="form-group">
                <label for="gallery_category_id" class="col-sm-2 control-label">Event Name</label>
                <div class="col-sm-8">
                    <select name="gallery_category_id" id="gallery_category_id" class="form-control" title="Choose one">
                        <?php foreach ($galleryCategory as $key=>$value):?>
                        <option value="<?php echo $value->id;?>"><?php echo $value->gallery_cat_name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="pic_title" class="col-sm-2 control-label">Title</label>
                <div class="col-sm-8">
                    <textarea name="pic_title" id="pic_title_id" class="form-control" placeholder="Description"></textarea>
                </div>
            </div>

            <div class="form-group">
                <label for="gallery_image" class="col-sm-2 control-label">Upload Image</label>
                <div class="col-sm-8">
                    <input type="file" name="gallery_image" class="form-control" id="gallery_image" placeholder="Gallery image">
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
    <div class="certificationView">
        <?php if (isset($tbl_photogallery)):?>
            <fieldset>
                <legend>Photo Gallery<span style="padding-left:5px;color:#00CC00;"></span> </legend>
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th style="width:5%">SL</th>
                        <th>Title</th>
                        <th>Thumbs</th>
                        <th style="width:10%;" colspan="2">Action</th>

                    </tr>
                    </thead>
                    <tbody>
                    <?php $i=1; foreach ($tbl_photogallery as $key=>$atbl_photogallery): ?>
                        <tr>
                            <td><?php echo $i;?></td>
                            <td><?php echo $atbl_photogallery->pic_title;?></td>
                            <td><img width="70" src="<?php echo base_url('uploads/gallery/photo/thumbs/').$atbl_photogallery->gallery_image; ?>" alt=""></td>
                            <td style="text-align: center;"><a href="<?php echo base_url('back/galleryCreate/').$atbl_photogallery->id; ?>" class="btn btn-warning" data-id="<?php echo $atbl_photogallery->id;?>" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>

                        </tr>
                    <?php $i++; endforeach; ?>
                    </tbody>
                </table>
            </fieldset>
        <?php endif;?>
    </div>
    <!--End Tender List View-->
</div>
