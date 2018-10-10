<div class="ibox float-e-margins">
    <div class="ibox-title">
        <div class="col-md-9"><b>Accommodation</b></div>
    </div>    
    <form id="resident_application_form" class="form-horizontal" action="" method="post" enctype="multipart/form-data">
        <div class="ibox-content">
            <div class="form-group">
                <label class="col-lg-2 control-label">Application For</label>

                <div class="col-lg-4">
                    <select name="APPLICATION_TYPE" class="form-control">
                        <option value="">--Select--</option>
                        <option value="A">Seat Allocation</option>
                        <option value="C">Seat Cancellation</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-2 control-label">Reason</label>
                <div class="col-lg-4"> 
                    <textarea name="REASON_OF_ALLOCATION" class="form-control"> </textarea>               
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-2 control-label"></label>
                <div class="col-lg-4"> 
                  <p> <input type="checkbox" name="TERMS" value="1"> I accept <a title="Resident Policy" href="#" data-action="student/residentPolicy" class="openModal">terms and conditions.</a> </p>                 
              </div>
          </div>
          
          <div class="form-group">
            <div class="col-lg-offset-2 col-lg-10">
                <input type="button" class="btn btn-primary btn-sm fSubmit" data-action="student/saveResidentApplicant" data-su-action="student/residentApplication"  value="Submit" >
                <input type="reset" class="btn btn-default btn-sm" value="Reset">
                <span class="loadingImg"></span>
            </div>
        </div>
        <div class="clearfix"></div>

    </form>

</div>  
</div>  

