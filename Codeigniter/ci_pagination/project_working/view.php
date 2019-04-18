<!DOCTYPE html>
<html>
    <head>
        <title>Publicity</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- Bootstrap -->
        <link rel="stylesheet" media="screen" href="<?php echo base_url(); ?>publicity/css/bootstrap.min.css">
        <link rel="stylesheet" media="screen" href="<?php echo base_url(); ?>publicity/css/bootstrap-theme.min.css">

        <!-- Bootstrap Admin Theme -->
        <link rel="stylesheet" media="screen" href="<?php echo base_url(); ?>publicity/css/bootstrap-admin-theme.css">
        <link rel="stylesheet" media="screen" href="<?php echo base_url(); ?>publicity/css/bootstrap-admin-theme-change-size.css">

        <!-- Datatables -->
        <link rel="stylesheet" media="screen" href="<?php echo base_url(); ?>publicity/css/DT_bootstrap.css">

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
           <script type="text/javascript" src="js/html5shiv.js"></script>
           <script type="text/javascript" src="js/respond.min.js"></script>
        <![endif]-->
    </head>
<body>
    <section class="publicity_area">
        <div class="container">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="text-muted bootstrap-admin-box-title">Houses For Rent</div>
                </div>
                <div class="bootstrap-admin-panel-content">
                    <div id="example_wrapper" class="dataTables_wrapper form-inline" role="grid">
                    
                        <!--Search and Nubmer of records-->
                        <div class="row">
                            <div class="col-md-6">
                                <div id="example_length" class="dataTables_length">
                                    <!-- <label>
                                    <select size="1" name="example_length" aria-controls="example">
                                        <option value="10" selected="selected">10</option>
                                        <option value="25">25</option><option value="50">50</option>
                                        <option value="100">100</option>
                                    </select> records per page</label> -->

                                    <?php 
                                        echo form_open('publicity/index');
                                        $options = array(
                                                         '10' => '10',
                                                         '20' => '20',
                                                         '30' => '30',
                                                         '40' => '40');
                                        echo form_dropdown('sel',$options,'');
                                        echo form_submit('submit','submit',"class='btn btn-default'");
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="dataTables_filter" id="example_filter" style="float:right; margin-bottom: 5px;">
                                    <form class="form-inline" action="<?php echo base_url('publicity/search_publicity') ?>" method="post">
                                      <div class="form-group">
                                        <input type="text" name="search_publicity" class="form-control" id="search_publicity" placeholder="Search">
                                      </div>
                                      <button type="submit" class="btn btn-info">Search</button>
                                    </form>
                                    <div class="search_result">
                                        <?php echo $publicity_search_msg; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--End Search and Nubmer of records-->
                        
                        <div class="row">
                            <div class="col-md-12">
                                
                                <table class="table table-striped table-bordered" id="example">
                                    <thead>
                                        <tr>
                                            <th>House Details</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($result as $key => $value):?>
                                        <tr>
                                            <td><?php echo $value->lnd_email; ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                    
                            </div>
                        </div>
                        
                        <!--pagination-->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="dataTables_info" id="example_info"><?php echo "Displaying $result_start to $result_end of $total"; ?> entries</div>
                            </div>
                            <div class="col-md-6">
                                <div class="dataTables_paginate paging_bootstrap">
                                    <?php echo $pagination;?>
                                </div>
                            </div>
                        </div>
                        <!--End pagination-->        
                    </div>
                </div>
            </div>
        </div>
    </section>

     <script type="text/javascript" src="http://code.jquery.com/jquery-2.0.3.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>publicity/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>publicity/js/twitter-bootstrap-hover-dropdown.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>publicity/js/bootstrap-admin-theme-change-size.js"></script>



</body>
</html>