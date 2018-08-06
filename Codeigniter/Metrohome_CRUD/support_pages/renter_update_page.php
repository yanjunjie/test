<style>
	#renterUpdateForm .form-group{
		/* margin-right: 0px;
		margin-left: 0px; */
	}
    .form-horizontal .form-group {
        margin-right: 0px;
        margin-left: -15px;
    }
</style>
<div class="panel panel-default">
	<div class="panel-body">
		<form id="renterUpdateForm" action="<?php echo base_url('super_admin/updateRenter'); ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
            <input type="hidden" name="renter_id" value="<?php echo isset($renterData[0]->renter_id)?$renterData[0]->renter_id:''; ?>">
			<!-- Image Upload -->
			<div class="col-md-4">
                <div class="row">
                    <?php if(isset($renterData[0]->renter_photo)) : ?>
                    <img id="renter_photo_preview" src="<?php echo base_url(). 'uploads/' . $renterData[0]->renter_photo; ?>" alt="আপনার ছবি দিন" class="img-thumbnail" width="150">
                    <?php else: ?>
                    <img id="renter_photo_preview" src="<?php echo base_url();?>backend_assets/img/UserAltPhoto.png" alt="আপনার ছবি দিন" class="img-thumbnail" width="150">
                    <?php endif; ?>
                    <div class="form-group"><br>
                        <div class="col-md-12">
                            <label>আপনার ছবি দিন</label> <?php echo form_error('renter_photo', '<span class="error">', '</span>'); ?>
                            <input type="file" id="renter_photo" name="renter_photo" >
                        </div>
                    </div>
                </div>
            </div>
            <!--End Image Upload -->

            <div class="col-md-8">
                <div class="form-group">
                	<label for="renter_division">বিভাগঃ</label>
                    <select name="renter_division" id="renter_division" class="form-control">
                        <option>আপনার বিভাগ নির্বাচন করুন</option>
                        <option value="<?php echo $renterData[0]->renter_division; ?>" selected="selected"><?php echo $renterData[0]->renter_division; ?></option>
                        <option value="Dhaka">Dhaka</option>
                        <option value="Chittagong">Chittagong</option>
                        <option value="Rajshahi">Rajshahi</option>
                        <option value="Barisal">Barisal</option>
                        <option value="Khulna">Khulna</option>
                        <option value="Sylhet">Sylhet</option>
                        <option value="Rangpur">Rangpur</option>
                        <option value="Mymensingh">Mymensingh</option>
                    </select>
                </div>
                <div class="form-group">
                	<label for="renter_district">জেলাঃ</label>
                    <input value="<?php echo $renterData[0]->renter_district; ?>" id="renter_district" type="text" name="renter_district" class="form-control" placeholder="জেলা">
                </div>
                <div class="form-group">
                	<label for="renter_police_station">থানাঃ</label>
                    <input value="<?php echo $renterData[0]->renter_police_station; ?>" type="text" name="renter_police_station" id="renter_police_station" class="form-control" placeholder="থানাঃ">
                </div>
            </div> <hr/>

            <div class="col-md-12">
                <div class="form-group">
                	<label for="renter_flat_floor_no">ফ্ল্যাটঃ</label>
                    <input value="<?php echo $renterData[0]->renter_flat_floor_no; ?>" type="text" name="renter_flat_floor_no" id="renter_flat_floor_no" class="form-control" placeholder="ফ্ল্যাট / তলাঃ">
                </div>
                <div class="form-group">
                	<label for="renter_holding_no">বাড়ী / হোল্ডিং নম্বরঃ</label>
                    <input value="<?php echo $renterData[0]->renter_holding_no; ?>" type="text" name="renter_holding_no" id="renter_holding_no" class="form-control" placeholder="বাড়ী / হোল্ডিং নম্বরঃ">
                </div>
                <div class="form-group">
                	<label for="renter_road_no">রাস্তাঃ</label>
                    <input value="<?php echo $renterData[0]->renter_road_no; ?>" type="text" name="renter_road_no" class="form-control" id="renter_road_no" placeholder="রাস্তাঃ">
                </div>
                <div class="form-group">
                	<label for="renter_road_no">এলাকাঃ</label>
                    <input value="<?php echo $renterData[0]->renter_locality; ?>" type="text" name="renter_locality" class="form-control" placeholder="এলাকাঃ">
                </div>
                <div class="form-group">
                	<label for="renter_road_no">পোস্ট কোডঃ</label>
                    <input value="<?php echo $renterData[0]->renter_postcode; ?>" type="text" name="renter_postcode" class="form-control" placeholder="পোস্ট কোডঃ">
                </div>
        		<div class="form-group">
	        		<label for="renter_name">ভাড়াটিয়া নামঃ</label>
	                <input value="<?php echo $renterData[0]->renter_fullname; ?>" type="text" name="renter_name" id="renter_name" class="form-control" placeholder="ভাড়াটিয়া নামঃ" required="required">
	                <p class="help-block">i.e Md. Masudul Islam</p>
	            </div>
	            <div class="form-group">
                	<label for="renter_road_no">পিতার নামঃ</label>
	                <input value="<?php echo $renterData[0]->renter_father_name; ?>" type="text" name="renter_father_name" class="form-control" placeholder="পিতার নামঃ">
	            </div>
	            <div class="form-group">
                	<label for="renter_road_no">জন্ম তারিখঃ</label>
	                

	                <div class='input-group date datetimepicker' id='datetimepicker'>
					    <input value="<?php echo date("d/m/Y", strtotime($renterData[0]->renter_birth_date)); ?>" type="text" name="renter_birth_date" class="form-control datetimepicker" placeholder="জন্ম তারিখঃ">

					    <span class="input-group-addon">
					        <span class="glyphicon glyphicon-calendar"></span>
					    </span>
					</div>
	            </div>
	            <div class="form-group">
                	<label for="renter_maritial_status">বৈবাহিক অবস্থাঃ</label>
                    <select name="renter_maritial_status" id="renter_maritial_status" class="form-control">
                        <option>আপনার বৈবাহিক অবস্থাঃ নির্বাচন করুন</option>
                        <option selected="selected" value="<?php echo $renterData[0]->renter_maritial_status; ?>"><?php echo $renterData[0]->renter_maritial_status; ?></option>
                        <option value="Married">Married</option>
                        <option value="Unmarried">Unmarried</option>
                        <option value="Divorced">Divorced</option>
                    </select>
	            </div>
	            <div class="form-group">
                	<label for="renter_road_no">স্থায়ী ঠিকানাঃ</label>
	                <textarea name="renter_permanent_add" class="form-control" placeholder="স্থায়ী ঠিকানাঃ" rows="1" required="required"><?php echo $renterData[0]->renter_permanent_add; ?> </textarea>
	            </div>
	            <div class="form-group">
                	<label for="renter_road_no">পেশা ও প্রতিষ্ঠান / কর্মস্থলের ঠিকানাঃ</label>
	                <textarea name="renter_profession_institute" class="form-control" placeholder="পেশা ও প্রতিষ্ঠান / কর্মস্থলের ঠিকানাঃ" rows="1"><?php echo $renterData[0]->renter_profession_institute; ?></textarea>
	            </div>

	            <div class="form-group">
                	<label for="renter_road_no">ধর্মঃ</label>
	                <select name="renter_religion" class="form-control">
	                    <option disabled>আপনার ধর্ম নির্বাচন করুনঃ</option> 
	                    <option selected="selected"><?php echo $renterData[0]->renter_religion; ?></option>
	                    <option>Islam</option>
	                    <option>Hinduism</option>
	                    <option>Buddhism</option>
	                    <option>Christian</option>
	                    <option>Others</option>
	                </select>
	            </div>

	            <div class="form-group">
                	<label for="renter_road_no">বর্তমান শিক্ষাগত যোগ্যতাঃ</label>
	                <input value="<?php echo $renterData[0]->renter_educational_status; ?>" type="text" name="renter_educational_status" class="form-control" placeholder="বর্তমান শিক্ষাগত যোগ্যতাঃ">
	            </div>
	            <div class="form-group">
                	<label for="renter_road_no">মোবাইল নম্বরঃ</label>
	                <input value="<?php echo $renterData[0]->renter_phone; ?>" type="text" name="renter_phone" class="form-control" placeholder="মোবাইল নম্বরঃ" required="required">
	            </div>
	            <div class="form-group">
                	<label for="renter_road_no">ই-মেইল আইডিঃ</label>
	                <p id="renter_emailMsg" class="help-block"></p>
	                <input value="<?php echo $renterData[0]->renter_email; ?>" type="text" id="renter_email" name="renter_email" class="form-control" placeholder="ই-মেইল আইডিঃ">
	            </div>
	            <div class="form-group">
                	<label for="renter_road_no">জাতীয় পরিচয়পত্র নম্বরঃ</label>
	                <p id="renter_nidMsg" class="help-block"></p>
	                <input value="<?php echo $renterData[0]->renter_nid; ?>" type="text" id="renter_nid" name="renter_nid" class="form-control" placeholder="জাতীয় পরিচয়পত্র নম্বরঃ " required="required">
	            </div>
	            <div class="form-group">
                	<label for="renter_road_no">পাসপোর্ট নম্বর (যদি থাকে)</label>
	                <p id="renter_passportMsg" class="help-block"></p>
	                <input value="<?php echo $renterData[0]->renter_passport; ?>" type="text" id="renter_passport" name="renter_passport" class="form-control" placeholder="পাসপোর্ট নম্বর (যদি থাকে)">
	            </div>

	            <div class="form-group">
	                <div>জরুরী যোগাযোগঃ</div>
	                <div class="col-md-6">
	                    <div class="form-group">
                	<label for="renter_road_no">(ক) নামঃ</label>
	                        <input value="<?php echo $renterData[0]->renter_emergency_name; ?>" type="text" name="renter_emergency_name" class="form-control" placeholder="(ক) নামঃ">
	                    </div>
	                    <div class="form-group">
                	<label for="renter_road_no">(খ) সম্পর্কঃ</label>
	                        <input value="<?php echo $renterData[0]->renter_emergency_relation; ?>" type="text" name="renter_emergency_relation" class="form-control" placeholder="(খ) সম্পর্কঃ">
	                    </div>
	                </div>
	                <div class="col-md-6">
	                    <div class="form-group">
                	<label for="renter_road_no">(গ) ঠিকানাঃ</label>
	                        <textarea name="renter_emergency_address" class="form-control" placeholder="(গ) ঠিকানাঃ" rows="1"><?php echo $renterData[0]->renter_emergency_address; ?></textarea>
	                    </div>
	                    <div class="form-group">
                	<label for="renter_road_no">(ঘ) মোবাইল নম্বরঃ</label>
	                        <input value="<?php echo $renterData[0]->renter_emergency_phone; ?>" type="text" name="renter_emergency_phone" class="form-control" placeholder="(ঘ) মোবাইল নম্বরঃ">
	                    </div>
	                </div>
	            </div>

	            <div class="panel panel-default">
	                <div class="panel-heading">
	                    পরিবার / মেসের সঙ্গীয় সদস্যদের বিবরণঃ
	                </div>
	                <div class="panel-body">
	                    <div class="table-responsive">
	                        <table id="member-add-table" class="table table-striped table-bordered table-hover">
	                            <thead>
	                            <tr>
	                                <th>ক্রঃ নং</th>
	                                <th>নাম</th>
	                                <th>বয়স</th>
	                                <th>পেশা</th>
	                                <th colspan="2">মোবাইল নম্বর</th>
	                            </tr>
	                            </thead>
	                            <tbody>
                                <?php $i=0; foreach ($renterFamilyMData as $key1 => $renterFamilyMDataRow) : ?>
	                            <tr>
	                                <td><?php echo ++$i;?></td>
	                                <td><input value="<?php echo $renterFamilyMDataRow->family_member_name;?>" type="text" name="family_member_name[]" required="required"></td>
	                                <td><input  value="<?php echo $renterFamilyMDataRow->family_member_age;?>" type="text" name="family_member_age[]" required="required"></td>
	                                <td><input  value="<?php echo $renterFamilyMDataRow->family_member_job;?>" type="text" name="family_member_job[]" required="required"></td>
	                                <td colspan="2"><input  value="<?php echo $renterFamilyMDataRow->family_member_phone;?>" type="text" name="family_member_phone[]"></td>
	                            </tr>
                                <?php endforeach;?>

                                </tbody>
	                        </table>
	                        <button type="button" id="addMember" class="btn btn-primary pull-right">সদস্য যুক্ত করুন</button>
	                    </div>
	                </div>
	            </div>

	            <div class="form-group">
                    <input type="hidden" name="homeworker_id" value="<?php echo isset($renterHomeWrkData[0]->homeworker_id)?$renterHomeWrkData[0]->homeworker_id:''; ?>">
	                <div class="col-md-6">
	                    <div class="form-group">
                	<label for="renter_road_no">গৃহকর্মীর নামঃ</label>
	                        <input value="<?php echo $renterHomeWrkData[0]->homeworker_name; ?>" type="text" name="homeworker_name" class="form-control" placeholder="গৃহকর্মীর নামঃ">
	                    </div>
	                    <div class="form-group">
                	<label for="renter_road_no">মোবাইল নম্বরঃ</label>
	                        <input value="<?php echo $renterHomeWrkData[0]->homeworker_phone; ?>" type="text" name="homeworker_phone" class="form-control" placeholder="মোবাইল নম্বরঃ">
	                    </div>
	                </div>
	                <div class="col-md-6">
	                    <div class="form-group">
                	<label for="renter_road_no">জাতীয় পরিচয়পত্র নম্বরঃ</label>
	                        <input value="<?php echo $renterHomeWrkData[0]->homeworker_nid; ?>" type="text" name="homeworker_nid" class="form-control" placeholder="জাতীয় পরিচয়পত্র নম্বরঃ">
	                    </div>
	                    <div class="form-group">
                	<label for="renter_road_no">স্থায়ী ঠিকানাঃ</label>
	                        <textarea name="homeworker_permanent_add" class="form-control" placeholder="স্থায়ী ঠিকানাঃ" rows="1"><?php echo $renterHomeWrkData[0]->homeworker_permanent_add; ?></textarea>
	                    </div>
	                </div>
	            </div> <hr/>

	            <div class="form-group">
                    <input type="hidden" name="driver_id" value="<?php echo isset($renterDriverData[0]->driver_id)?$renterDriverData[0]->driver_id:''; ?>">
	                <div class="col-md-6">
	                    <div class="form-group">
                	<label for="renter_road_no">ড্রাইভারের নামঃ</label>
	                        <input value="<?php echo $renterDriverData[0]->driver_name; ?>" type="text" name="driver_name" class="form-control" placeholder="ড্রাইভারের নামঃ">
	                    </div>
	                    <div class="form-group">
                	<label for="renter_road_no">মোবাইল নম্বরঃ</label>
	                        <input value="<?php echo $renterDriverData[0]->driver_phone; ?>" type="text" name="driver_phone" class="form-control" placeholder="মোবাইল নম্বরঃ">
	                    </div>
	                </div>
	                <div class="col-md-6">
	                    <div class="form-group">
                	<label for="renter_road_no">জাতীয় পরিচয়পত্র নম্বরঃ</label>
	                        <input value="<?php echo $renterDriverData[0]->driver_nid; ?>" type="text" name="driver_nid" class="form-control" placeholder="জাতীয় পরিচয়পত্র নম্বরঃ">
	                    </div>
	                    <div class="form-group">
                	<label for="renter_road_no">স্থায়ী ঠিকানাঃ</label>
	                        <textarea name="driver_permanent_add" class="form-control" placeholder="স্থায়ী ঠিকানাঃ" rows="1"><?php echo $renterDriverData[0]->driver_permanent_add; ?> </textarea>
	                    </div>
	                </div>
	            </div> <hr/>

	            <div class="form-group">
	                <div class="col-md-6">
	                    <div class="form-group">
                	<label for="renter_road_no">পূর্ববর্তী বাড়িওয়ালার নামঃ</label>
	                        <input value="<?php echo $renterData[0]->renter_previous_landlord_name; ?>" type="text" name="renter_previous_landlord_name" class="form-control" placeholder="পূর্ববর্তী বাড়িওয়ালার নামঃ">
	                    </div>
	                </div>
	                <div class="col-md-6">
	                    <div class="form-group">
                	<label for="renter_road_no">মোবাইল নম্বরঃ</label>
	                        <input value="<?php echo $renterData[0]->renter_previous_landlord_phone; ?>" type="text" name="renter_previous_landlord_phone" class="form-control" placeholder="মোবাইল নম্বরঃ">
	                    </div>
	                </div>

	                <div class="col-md-12">
	                    <div class="form-group">
                	<label for="renter_road_no">ঠিকানাঃ</label>
	                        <textarea name="renter_previous_landlord_permanent_add" class="form-control" placeholder="ঠিকানাঃ" rows="1"><?php echo $renterData[0]->renter_previous_landlord_permanent_add; ?> </textarea>
	                    </div>
	                </div>
	            </div> <hr/>

	            <div class="form-group">
                	<label for="renter_road_no">পূর্ববর্তী বাসা ছাড়ার কারণঃ</label>
	                <textarea name="renter_prvious_leave_reason" class="form-control" placeholder="পূর্ববর্তী বাসা ছাড়ার কারণঃ" rows="1"><?php echo $renterData[0]->renter_prvious_leave_reason; ?> </textarea>
	            </div>

	            <div class="form-group">
	                <div class="col-md-6">
	                    <div class="form-group">
                	<label for="renter_road_no">বর্তমান বাড়িওয়ালার নামঃ</label>
	                        <input value="<?php echo $renterData[0]->renter_present_landlord_name; ?>" type="text" name="renter_present_landlord_name" class="form-control" placeholder="বর্তমান বাড়িওয়ালার নামঃ" />
	                    </div>
	                </div>
	                <div class="col-md-6">
	                    <div class="form-group">
                			<label for="renter_road_no">মোবাইল নম্বরঃ</label>
	                        <input value="<?php echo $renterData[0]->renter_present_landlord_phone; ?>" type="text" name="renter_present_landlord_phone" class="form-control" placeholder="মোবাইল নম্বরঃ" />
	                    </div>
	                </div>
	            </div>

	            <div class="form-group">
                	<label for="renter_road_no">বর্তমান বাড়িতে কোন তারিখ থেকে বসবাসরতঃ</label>
	                <input value="<?php echo date("d/m/Y", strtotime($renterData[0]->renter_present_start_date)); ?>" type="text" name="renter_present_start_date" class="form-control datetimepicker" placeholder="বর্তমান বাড়িতে কোন তারিখ থেকে বসবাসরতঃ" />
	            </div>

				<div class="form-group" style="margin-top: 30px;">
				    <button type="reset" data-dismiss="modal" class="btn btn-default">Cancel</button>
				    <button type="submit" id="renter_update_form_submit" class="btn btn-primary">Update</button>
				</div>
        	</div>
		</form>
	</div>
</div>