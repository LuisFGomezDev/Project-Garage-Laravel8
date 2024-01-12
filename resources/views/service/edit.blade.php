@extends('layouts.app')
@section('content')
<style>
.bootstrap-datetimepicker-widget table td span {
    width: 0px!important;
}
.table-condensed>tbody>tr>td {
    padding: 3px;
}
</style>

<!-- page content -->
	<div class="right_col" role="main">
		<div class="page-title">
			<div class="nav_menu">
				<nav>
					<div class="nav toggle">
						<a id="menu_toggle"><i class="fa fa-bars"></i><span class="titleup">&nbsp {{ trans('app.Service')}}</span></a>
					</div>
					@include('dashboard.profile')
				</nav>
			</div>
		</div>
		<div class="x_content">
			<ul class="nav nav-tabs bar_tabs" role="tablist">
				@can('service_view')
					<li role="presentation" class=""><a href="{!! url('/service/list')!!}"><span class="visible-xs"></span> <i class="fa fa-list fa-lg">&nbsp;</i>{{ trans('app.Services List')}}</a></li>
				@endcan
				@can('service_edit')
					<li role="presentation" class="active"><a href="{!! url('/service/list/edit/'.$service->id )!!}"><span class="visible-xs"></span><i class="fa fa-pencil-square-o" aria-hidden="true">&nbsp;</i><b>{{ trans('app.Edit Services')}}</b></a></li>
				@endcan
			</ul>
		</div>
            
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_content">
						<form id="ServiceEdit-Form" method="post" action="update/{{ $service->id }}" enctype="multipart/form-data"  class="form-horizontal upperform">

							<div class="form-group">
								<div class="my-form-group">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Jobcard Number')}} <label class="color-danger">*</label></label>
									<div class="col-md-4 col-sm-4 col-xs-12">
									
										<input type="text"  name="jobno"  class="form-control" value="{{ $service->job_no }}" placeholder="{{ trans('app.Enter Job No')}}" readonly>
									</div>
								</div>

								<div class="my-form-group">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Customer Name')}} <label class="color-danger">*</label></label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<select name="Customername" id="sup_id" class="form-control select_customer_auto_search" disabled>
											<option value="">{{ trans('app.Select Select Customer')}}</option>

											@if(!empty($customer))
												@foreach($customer as $customers)
												 <option value="{{ $customers->id}}" <?php if($customers->id==$service->customer_id){echo"selected"; }?>>{{ getCustomerName($customers->id) }}</option>
												@endforeach
											@endif
										</select>
									</div>
								</div>
							</div>
						  
							<div class="form-group" style="margin-top: 20px;">
								<div class="my-form-group">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="last-name">{{ trans('app.Vehicle Name')}} <label class="color-danger">*</label></label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										  <select  name="vehicalname" class="form-control" disabled>
											 <option value="">{{ trans('app.Select vehicle Name')}}</option>
											  @if(!empty($vehical))
													@foreach($vehical as $vehicals)
														<option value="{{ $vehicals->id}}" <?php if($vehicals->id==$service->vehicle_id){ echo"selected"; }?>>{{ $vehicals->modelname }}</option>
													@endforeach
												@endif	
										  </select>
									 </div>
								</div>

								<div class="my-form-group">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="last-name">{{ trans('app.Date')}} <label class="color-danger">*</label></label>
									<div class="col-md-4 col-sm-4 col-xs-12 input-group date datepicker">
										<span class="input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
										<input type="text" id="p_date" name="date" autocomplete="off"
										value="<?php  echo date( getDateFormat().' H:i:s',strtotime($service->service_date)); ?>" class="form-control" placeholder="<?php echo getDatepicker();  echo " hh:mm:ss"?>" onkeypress="return false;" required>
									</div>
								</div>
							</div>
						  
							<div class="form-group" style="margin-top: 15px;">
								<div class="my-form-group">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Title')}} </label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<input type="text" name="title" placeholder="{{ trans('app.Enter Title')}}" maxlength="30" value="{{ $service->title }}" class="form-control">
									</div>
								</div>

								<div class="my-form-group">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="last-name">{{ trans('app.Assign To')}} <label class="color-danger">*</label></label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<select id="AssigneTo" name="AssigneTo"  class="form-control" required>
											<!-- <option value="">{{ trans('app.Select Assign To')}}</option> -->
											@if(!empty($employee))
											@foreach($employee as $employees)
											<option value="{{ $employees->id }}" <?php if($employees->id==$service->assign_to){ echo"selected";}?>> {{ $employees->name }}</option>	
											@endforeach
											@endif
										</select>
									</div>
								</div>
							</div>
						  
							<div class="form-group" style="margin-top: 15px;">
								<div class="my-form-group">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Repair Category')}} <label class="color-danger">*</label></label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<select name="repair_cat"  class="form-control" required>
											<!-- <option value="">{{ trans('app.Select Repair Category')}}</option> -->
											<option value="breakdown" <?php if($service->service_category=='breakdown') { echo 'selected'; } ?> >{{ trans('app.Breakdown') }}</option>
											<option value="booked vehicle" <?php if($service->service_category=='booked vehicle') { echo 'selected'; } ?>>{{ trans('app.Booked Vehicle') }}</option>	
											<option value="repeat job" <?php if($service->service_category=='repeat job') { echo 'selected'; } ?>>{{ trans('app.Repeat Job') }}</option>	
											<option value="customer waiting" <?php if($service->service_category=='customer waiting') { echo 'selected'; } ?>>{{ trans('app.Customer Waiting') }}</option>	
										</select>
									</div>
								</div>

								<div class="">
									<label class="control-label col-md-2 col-sm-2 col-xs-12">{{ trans('app.Service Type')}} <label class="color-danger">*</label></label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<label class="radio-inline">
											<input type="radio" name="service_type" id="free"  value="free" required <?php if($service->service_type=='free') { echo 'checked'; } ?>>{{ trans('app.Free')}}</label>
										<label class="radio-inline">
											<input type="radio" name="service_type" id="paid"  value="paid" required <?php if($service->service_type=='paid') { echo 'checked'; } ?>> {{ trans('app.Paid')}}</label>
									</div>
								</div>
							</div>
						  
							<div class="form-group" style="margin-top: 15px;">
								<div class="">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Details')}}</label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<textarea name="details"  class="form-control" maxlength="100">{{ $service->detail }}</textarea> 
									</div>
								</div>

								<div id="dvCharge" style="display: none" class="has-feedback {{ $errors->has('charge') ? ' has-error' : '' }} my-form-group">
									<label class="control-label col-md-2 col-sm-2 col-xs-12 currency" for="last-name">{{ trans('app.Fix Service Charge')}} (<?php echo getCurrencySymbols(); ?>) <label class="color-danger">*</label></label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<input type="text"  id="charge_required" name="charge" class="form-control fixServiceCharge" placeholder="{{ trans('app.Enter Fix Service Charge')}}" maxlength="8" value="{{ $service->charge }}">
										@if ($errors->has('charge'))
										   <span class="help-block">
											   <strong>{{ $errors->first('charge') }}</strong>
										   </span>
										 @endif
									</div>
								</div> 	
							</div>
							
							<div class="form-group" style="margin-top: 15px;">
								<!-- <div class="">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="reg_no">{{ trans('app.Registration No.')}}</label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<input type="text" name="reg_no" id="reg_no" placeholder="{{ trans('app.Enter Registration Number') }}" class="form-control" maxlength="15" value="{{ $regi_no }}">
									</div>
								</div> -->

							<!-- MOt Test Checkbox Start-->
							@if($service->mot_status == 1)
								<div class="motMainDiv">
									<label class="control-label col-md-2 col-sm-2 col-xs-12 motTextLabel" for="" >{{ trans('app.MOT Test') }}</label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<input type="checkbox" name="motTestStatusCheckbox" id="motTestStatusCheckbox" <?php if($service->mot_status==1) { echo 'checked'; } ?>>
									</div>
								</div>
							@endif
							<!-- MOt Test Checkbox End-->
							</div>

						<!-- Wash Bay Feature -->						
							<div class="form-group">
								<div class="">
									<label class="control-label col-md-2 col-sm-2 col-xs-12 washbayLabel" for="washbay">{{ trans('app.Wash Bay')}} <label class="text-danger"></label></label>
									<div class="col-md-4 col-sm-4 col-xs-12 washbayInputDiv">
										<input type="checkbox" name="washbay" id="washBay" class="washBayCheckbox" <?php echo ($washbayPrice) ? 'checked' : ''; ?> >
									</div>
								</div>

								<div id="washBayCharge" hidden="true" style="" class="has-feedback {{ $errors->has('washBayCharge') ? ' has-error' : '' }}">
									<label class="control-label col-md-2 col-sm-2 col-xs-12 currency" for="washBayCharge">{{ trans('app.Wash Bay Charge')}} (<?php echo getCurrencySymbols(); ?>) <label class="text-danger">*</label></label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<input type="text"  id="washBayCharge_required" name="washBayCharge" class="form-control washbay_charge_textbox"  placeholder="{{ trans('app.Enter Wash Bay Charge')}}"  value="<?php echo ($washbayPrice) ? $washbayPrice : '';  ?>" maxlength="10">
										
										<span id="washbay_error_span" class="help-block error-help-block color-danger" style="display:none"></span>
									</div>
								</div>
							</div>						
					<!-- Wash Bay Feature -->

							<div class="form-group">
								<div class="my-form-group">
	                              	<label class="control-label col-md-2 col-sm-2 col-xs-12" for="branch">{{ trans('app.Branch')}} <label class="color-danger">*</label></label>
	                              
	                              	<div class="col-md-4 col-sm-4 col-xs-12">
	                                	<select class="form-control  select_branch" name="branch">
	                                  	@foreach ($branchDatas as $branchData)
											<option value="{{ $branchData->id }}" <?php if($service->branch_id==$branchData->id){ echo "selected"; }?>>{{$branchData->branch_name }}</option>
										@endforeach
	                                	</select>
	                              	</div>
	                            </div>
	                        </div>

						<!-- Custom Filed data value -->
							@if(!empty($tbl_custom_fields))  
								<div class="col-md-12 col-xs-12 col-sm-12 space">
									<h4><b>{{ trans('app.Custom Fields')}}</b></h4>
									<p class="col-md-12 col-xs-12 col-sm-12 ln_solid"></p>
								</div>
									<?php
										$subDivCount = 0;
									?>
									@foreach($tbl_custom_fields as $myCounts => $tbl_custom_field)
								       <?php 
											if($tbl_custom_field->required == 'yes')
											{
												$required = "required";
												$red = "*";
											}else{
												$required = "";
												$red = "";
											}
											
											$tbl_custom = $tbl_custom_field->id;
											$userid = $service->id;
											$datavalue = getCustomDataService($tbl_custom,$userid);

											$subDivCount++;
										?>
											@if($myCounts%2 == 0)
												<div class="col-md-12 col-sm-6 col-xs-12">
											@endif
												<div class="form-group col-md-6  col-sm-6 col-xs-12 error_customfield_main_div_{{$myCounts}}">
													<label class="control-label col-md-4 col-sm-4 col-xs-12" for="account-no">{{$tbl_custom_field->label}} <label class="color-danger">{{$red}}</label></label>
													<div class="col-md-8 col-sm-8 col-xs-12">
														@if($tbl_custom_field->type == 'textarea')
															<textarea  name="custom[{{$tbl_custom_field->id}}]" class="form-control textarea_{{$tbl_custom_field->id}} textarea_simple_class common_simple_class common_value_is_{{$myCounts}}" placeholder="{{ trans('app.Enter')}} {{$tbl_custom_field->label}}" maxlength="100" isRequire="{{$required}}" type="textarea" fieldNameIs="{{ $tbl_custom_field->label }}" rows_id="{{$myCounts}}" {{$required}}>{{$datavalue}}</textarea>

															<span id="common_error_span_{{$myCounts}}" class="help-block error-help-block color-danger" style="display: none"></span>

														@elseif($tbl_custom_field->type == 'radio')
															<?php
																$radioLabelArrayList = getRadiolabelsList($tbl_custom_field->id)
															?>
															@if(!empty($radioLabelArrayList))
															<div style="margin-top: 5px;">
																@foreach($radioLabelArrayList as $k => $val)
																	<input type="{{$tbl_custom_field->type}}"  name="custom[{{$tbl_custom_field->id}}]" value="{{$k}}"    <?php
																			//$formName = "product";
																			$getRadioValue = getRadioLabelValueForUpdateForAllModules($tbl_custom_field->form_name ,$service->id, $tbl_custom_field->id);

																	 	if($k == $getRadioValue) { echo "checked"; }?> 

																	> {{ $val }} &nbsp;
																@endforeach		
																</div>								
															@endif

														@elseif($tbl_custom_field->type == 'checkbox')
														<?php
																$checkboxLabelArrayList = getCheckboxLabelsList($tbl_custom_field->id)
															?>
															@if(!empty($checkboxLabelArrayList))
																<?php
																	$getCheckboxValue = getCheckboxLabelValueForUpdateForAllModules($tbl_custom_field->form_name, $service->id, $tbl_custom_field->id);
																?>
																<div class="required_checkbox_parent_div_{{$tbl_custom_field->id}}" style="margin-top: 5px;">
																@foreach($checkboxLabelArrayList as $k => $val)
																	<input type="{{$tbl_custom_field->type}}" name="custom[{{$tbl_custom_field->id}}][]" value="{{$val}}" isRequire="{{$required}}" fieldNameIs="{{ $tbl_custom_field->label }}" custm_isd="{{$tbl_custom_field->id}}" class="checkbox_{{$tbl_custom_field->id}} required_checkbox_{{$tbl_custom_field->id}} checkbox_simple_class common_value_is_{{$myCounts}} common_simple_class" rows_id="{{$myCounts}}"

																	<?php
																	 	if($val == getCheckboxValForAllModule($tbl_custom_field->form_name, $service->id, $tbl_custom_field->id,$val)) 
																	 			{ echo "checked"; }
																	 	?>
																	> {{ $val }} &nbsp;
																@endforeach
																	<span id="common_error_span_{{$myCounts}}" class="help-block error-help-block color-danger" style="display: none"></span>
																</div>					
															@endif								
														@elseif($tbl_custom_field->type == 'textbox')
															<input type="{{$tbl_custom_field->type}}" name="custom[{{$tbl_custom_field->id}}]" placeholder="{{ trans('app.Enter')}} {{$tbl_custom_field->label}}" value="{{$datavalue}}" maxlength="30" class="form-control textDate_{{$tbl_custom_field->id}} textdate_simple_class common_value_is_{{$myCounts}} common_simple_class" isRequire="{{$required}}" fieldNameIs="{{ $tbl_custom_field->label }}" rows_id="{{$myCounts}}" {{$required}}>

															<span id="common_error_span_{{$myCounts}}" class="help-block error-help-block color-danger" style="display:none"></span>

														@elseif($tbl_custom_field->type == 'date')
															<input type="{{$tbl_custom_field->type}}" name="custom[{{$tbl_custom_field->id}}]" placeholder="{{ trans('app.Enter')}} {{$tbl_custom_field->label}}" value="{{$datavalue}}" maxlength="30" class="form-control textDate_{{$tbl_custom_field->id}} date_simple_class common_value_is_{{$myCounts}} common_simple_class" isRequire="{{$required}}" fieldNameIs="{{ $tbl_custom_field->label }}" rows_id="{{$myCounts}}" onkeydown="return false" {{$required}}>

															<span id="common_error_span_{{$myCounts}}" class="help-block error-help-block color-danger" style="display:none"></span>
														@endif
													</div>
												</div>
											@if($myCounts%2 != 0)
											</div>
											@endif
									@endforeach
									<?php 
										if ($subDivCount%2 != 0) {
											echo "</div>";
										}
									?>
								@endif					
						<!-- Custom Filed data value End-->

							<input type="hidden" name="_token" value="{{csrf_token()}}">
							<div class="form-group">
								<div class="col-md-12 col-sm-12 col-xs-12 text-center">
									<a class="btn btn-primary" href="{{ URL::previous() }}">{{ trans('app.Cancel')}}</a>
									<button type="submit" class="btn btn-success updateServiceButton">{{ trans('app.Update')}}</button>
								</div>
							</div>

						</form>
					</div>
					
					
				</div>
			</div>
		</div>
           
	</div>
<!-- /page content -->


<!-- Scripts starting -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="{{ URL::asset('vendors/moment/min/moment.min.js') }}"></script>
<script src="{{ URL::asset('vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ URL::asset('vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>

<script>
$(document).ready(function()
{
	/*Datetime picker*/
    $('.datepicker').datetimepicker({
        format: "<?php echo getDatetimepicker(); ?>",
		autoclose:1,
    });


    /*Service type free and paid*/
    $(function() {
        $("input[name='service_type']").html(function () {
            if ($("#paid").is(":checked")) {
                $("#dvCharge").show();
                $("#charge_required").attr('required', true);
            } else {
                $("#dvCharge").hide();
				$("#charge_required").removeAttr('required', false);
            }
        });
		
		$("input[name='service_type']").click(function () {
            if ($("#paid").is(":checked")) {
                $("#dvCharge").show();
                $("#charge_required").attr('required', true);
            } else {
                $("#dvCharge").hide();
				$("#charge_required").removeAttr('required', false);
            }
        });
    });

	/*Using Slect2 make auto searchable dropdown*/
 	//var sendUrl = '{{ url('service/customer_autocomplete_search') }}';
    	
	/*$('.select_customer_auto_search').select2({
    	ajax: {
        	url: sendUrl,
        	dataType: 'json',
        	delay: 250,
        	processResults: function (data) {
            	return {
                	results: $.map(data, function (item) {
                    	return {
                        	text: item.name +" "+ item.lastname,
                        	id: item.id
                    	};
                	})
            	};
        	},
        	cache: true
    	}
	});*/

   	
   	// Initialize select2
   	$(".select_customer_auto_search").select2();


	/*If date field have value then error msg and has error class remove*/
	$('body').on('change','#p_date',function(){

		var pDateValue = $(this).val();

		if (pDateValue != null) {
			$('#p_date-error').css({"display":"none"});
		}

		if (pDateValue != null) {
			$(this).parent().parent().removeClass('has-error');
		}
	});
	

	/*If select box have value then error msg and has error class remove*/
	$('#sup_id').on('change',function(){

		var supplierValue = $('select[name=Customername]').val();
		
		if (supplierValue != null) {
			$('#sup_id-error').css({"display":"none"});
		}

		if (supplierValue != null) {
			$(this).parent().parent().removeClass('has-error');
		}
	});


	/*Inside fix service text box only enter numbers data*/	
	$('.fixServiceCharge').on('keyup', function(){
	 
		var valueIs = $(this).val();

	 	if (/\D/g.test(valueIs))
		{
			$(this).val("");
		}
		else if(valueIs == 0)
		{
			$(this).val("");
		}
	});


	/*Custom Field manually validation*/
	var msg1 = "{{ trans('app.field is required')}}";
	var msg2 = "{{ trans('app.Only blank space not allowed')}}";
	var msg3 = "{{ trans('app.Special symbols are not allowed.')}}";
	var msg4 = "{{ trans('app.At first position only alphabets are allowed.')}}";

	/*Form submit time check validation for Custom Fields */
	$('body').on('click','.updateServiceButton',function(e){
		$('#ServiceEdit-Form input, #ServiceEdit-Form select, #ServiceEdit-Form textarea').each(

		    function(index)
		    {  
		        var input = $(this);

		        if (input.attr('name') == "Customername" || input.attr('name') == "vehicalname" || input.attr('name') == "date" || input.attr('name') == "AssigneTo"  || input.attr('name') == "repair_cat" || input.attr('name') == "service_type") {
		        	if (input.val() == "") {
		        		return true;
		        	}
		        	else{
		        		return true;
		        	}      	
		        }
		        else if (input.attr('isRequire') == 'required')
		        {	
		        	var rowid = (input.attr('rows_id'));
			        var labelName = (input.attr('fieldnameis'));
		        	
		        	if (input.attr('type') == 'textbox' || input.attr('type') == 'textarea')
			        {		  		  
			        	if (input.val() == '' || input.val() == null) 
			        	{		   	
			        		$('.common_value_is_'+rowid).val("");
				    		$('#common_error_span_'+rowid).text(labelName + " : " + msg1);
				    		$('#common_error_span_'+rowid).css({"display":""});
							$('.error_customfield_main_div_'+rowid).addClass('has-error');
			        		e.preventDefault();
			        		return false;
			        	}
			        	else if (!input.val().replace(/\s/g, '').length) 
			        	{
				    		$('.common_value_is_'+rowid).val("");
				    		$('#common_error_span_'+rowid).text(labelName + " : " + msg2);
				    		$('#common_error_span_'+rowid).css({"display":""});
							$('.error_customfield_main_div_'+rowid).addClass('has-error');
			        		e.preventDefault();	
			        		return false;
			        	}
			        	else if(!input.val().match(/^[a-zA-Z\u0621-\u064A\u00C0-\u017F\u0600-\u06FF\u0750-\u077F\uFB50-\uFDFF\uFE70-\uFEFF\u2E80-\u2FD5\u3190-\u319f\u3400-\u4DBF\u4E00-\u9FCC\uF900-\uFAAD\u0900-\u097F][a-zA-Z0-9\u0621-\u064A\u00C0-\u017F\u0600-\u06FF\u0750-\u077F\uFB50-\uFDFF\uFE70-\uFEFF\u2E80-\u2FD5\u3190-\u319f\u3400-\u4DBF\u4E00-\u9FCC\uF900-\uFAAD\u0900-\u097F\s\.\-\_]*$/))
			        	{
			        		$('.common_value_is_'+rowid).val("");
				    		$('#common_error_span_'+rowid).text(labelName + " : " + msg3);
				    		$('#common_error_span_'+rowid).css({"display":""});
							$('.error_customfield_main_div_'+rowid).addClass('has-error');
			        		e.preventDefault();	
			        		return false;
			        	}
			        }
			        else if (input.attr('type') == 'checkbox') 
			        {
			        	var ids = input.attr('custm_isd');
						if($(".required_checkbox_" + ids).is(':checked'))
						{
							$('#common_error_span_'+rowid).css({"display":"none"});
							$('.error_customfield_main_div_'+rowid).removeClass('has-error');
							$('.required_checkbox_parent_div_'+ids).css({"color":""});
							$('.error_customfield_main_div_'+rowid).removeClass('has-error');
						}
						else
						{
							$('#common_error_span_'+rowid).text(labelName + " : " + msg1);
				    		$('#common_error_span_'+rowid).css({"display":""});
				    		$('.error_customfield_main_div_'+rowid).addClass('has-error');
				    		$('.required_checkbox_'+ids).css({"outline":"2px solid #a94442"});
				    		$('.required_checkbox_parent_div_'+ids).css({"color":"#a94442"});
							e.preventDefault();	
							return false;
						}		        	
			        }
			        else if (input.attr('type') == 'date') 
		    		{
		    			if (input.val() == '' || input.val() == null) 
			        	{	
			        		$('.common_value_is_'+rowid).val("");
				    		$('#common_error_span_'+rowid).text(labelName + " : " + msg1);
				    		$('#common_error_span_'+rowid).css({"display":""});
							$('.error_customfield_main_div_'+rowid).addClass('has-error');
							e.preventDefault();	
				        	return false;
			        	}
			        	else
			        	{
			        		$('#common_error_span_'+rowid).css({"display":"none"});
							$('.error_customfield_main_div_'+rowid).removeClass('has-error');	
			        	}
			    	}
		        } 
		        else if (input.attr('isRequire') == "")
		        {
		        	//Nothing to do
		        }
		    }
		);


		/*if washbay checkbox is checked then washbay charge textbox is required*/
		var washbay_trans = "{{ trans('app.Wash Bay Charge')}}";
		var washbay_value = $('#washBayCharge_required').val();

		if ($(".washBayCheckbox").is(':checked') == true) 
		{
			if (washbay_value == "") 
			{
				//alert("is checked true : ");
				$('#washBayCharge').addClass('has-error');
				$('#washbay_error_span').text(washbay_trans + " " + msg1);
				$('#washbay_error_span').css({"display":""});
				e.preventDefault();
			}			
		}
	});


	/*Anykind of input time check for validation for Textbox, Date and Textarea*/
	$('body').on('keyup','.common_simple_class',function(){

		var rowid = $(this).attr('rows_id');		
        var valueIs = $('.common_value_is_'+rowid).val();
        var requireOrNot = $('.common_value_is_'+rowid).attr('isrequire');
        var labelName = $('.common_value_is_'+rowid).attr('fieldnameis');
        var inputTypes = $('.common_value_is_'+rowid).attr('type');
		
		if (requireOrNot != "") 
		{
			if (inputTypes != 'radio' && inputTypes != 'checkbox' && inputTypes != 'date') 
		    {
		    	if (valueIs == "") 
		    	{
		    		$('.common_value_is_'+rowid).val("");
		    		$('#common_error_span_'+rowid).text(labelName + " : " + msg1);
		    		$('#common_error_span_'+rowid).css({"display":""});
					$('.error_customfield_main_div_'+rowid).addClass('has-error');
		    	}
		    	else if (valueIs.match(/^\s+/))
		    	{
		    		$('.common_value_is_'+rowid).val("");
		    		$('#common_error_span_'+rowid).text(labelName + " : " + msg4);
		    		$('#common_error_span_'+rowid).css({"display":""});
					$('.error_customfield_main_div_'+rowid).addClass('has-error');
		    	}
		    	else if(!valueIs.match(/^[a-zA-Z\u0621-\u064A\u00C0-\u017F\u0600-\u06FF\u0750-\u077F\uFB50-\uFDFF\uFE70-\uFEFF\u2E80-\u2FD5\u3190-\u319f\u3400-\u4DBF\u4E00-\u9FCC\uF900-\uFAAD\u0900-\u097F][a-zA-Z0-9\u0621-\u064A\u00C0-\u017F\u0600-\u06FF\u0750-\u077F\uFB50-\uFDFF\uFE70-\uFEFF\u2E80-\u2FD5\u3190-\u319f\u3400-\u4DBF\u4E00-\u9FCC\uF900-\uFAAD\u0900-\u097F\s\.\-\_]*$/))
		    	{
		    		$('.common_value_is_'+rowid).val("");
		    		$('#common_error_span_'+rowid).text(labelName + " : " + msg3);
		    		$('#common_error_span_'+rowid).css({"display":""});
					$('.error_customfield_main_div_'+rowid).addClass('has-error');
		    	}
		    	else
		    	{
					$('#common_error_span_'+rowid).css({"display":"none"});
					$('.error_customfield_main_div_'+rowid).removeClass('has-error');
		    	}
		    }
		    else if (inputTypes == 'date')
		    {
		    	if (valueIs != "") 
		    	{
					$('#common_error_span_'+rowid).css({"display":"none"});
					$('.error_customfield_main_div_'+rowid).removeClass('has-error');
		    	}
		    	else
		    	{
		    		$('.common_value_is_'+rowid).val("");
		    		$('#common_error_span_'+rowid).text(labelName + " : " + msg1);
		    		$('#common_error_span_'+rowid).css({"display":""});
					$('.error_customfield_main_div_'+rowid).addClass('has-error');		    		
		    	}
		    }
		    else
		    {
		    	//alert("Yes i am radio and checkbox");
		    }
		}
		else
		{
			if (inputTypes != 'radio' && inputTypes != 'checkbox' && inputTypes != 'date') 
		    {
		    	if (valueIs != "") 
		    	{
		    		if (valueIs.match(/^\s+/))
			    	{
			    		$('.common_value_is_'+rowid).val("");
			    		$('#common_error_span_'+rowid).text(labelName + " : " + msg4);
			    		$('#common_error_span_'+rowid).css({"display":""});
						$('.error_customfield_main_div_'+rowid).addClass('has-error');
			    	}
			    	else if(!valueIs.match(/^[a-zA-Z\u0621-\u064A\u00C0-\u017F\u0600-\u06FF\u0750-\u077F\uFB50-\uFDFF\uFE70-\uFEFF\u2E80-\u2FD5\u3190-\u319f\u3400-\u4DBF\u4E00-\u9FCC\uF900-\uFAAD\u0900-\u097F][a-zA-Z0-9\u0621-\u064A\u00C0-\u017F\u0600-\u06FF\u0750-\u077F\uFB50-\uFDFF\uFE70-\uFEFF\u2E80-\u2FD5\u3190-\u319f\u3400-\u4DBF\u4E00-\u9FCC\uF900-\uFAAD\u0900-\u097F\s\.\-\_]*$/))
			    	{
			    		$('.common_value_is_'+rowid).val("");
			    		$('#common_error_span_'+rowid).text(labelName + " : " + msg3);
			    		$('#common_error_span_'+rowid).css({"display":""});
						$('.error_customfield_main_div_'+rowid).addClass('has-error');
			    	}
			    	else
			    	{
						$('#common_error_span_'+rowid).css({"display":"none"});
						$('.error_customfield_main_div_'+rowid).removeClass('has-error');
			    	}
		    	}
		    	else
		    	{
		    		$('#common_error_span_'+rowid).css({"display":"none"});
					$('.error_customfield_main_div_'+rowid).removeClass('has-error');
		    	}
		    }
		}
	});


	/*For required checkbox checked or not*/
	$('body').on('click','.checkbox_simple_class',function(){

		var rowid = $(this).attr('rows_id');		
        var requireOrNot = $('.common_value_is_'+rowid).attr('isrequire');
        var labelName = $('.common_value_is_'+rowid).attr('fieldnameis');
        var inputTypes = $('.common_value_is_'+rowid).attr('type');
        var custId = $('.common_value_is_'+rowid).attr('custm_isd');

		if (requireOrNot != "") 
		{
			if($(".required_checkbox_" + custId).is(':checked'))
			{				
				$('.required_checkbox_'+custId).css({"outline":""});
				$('.required_checkbox_'+custId).css({"color":""});
				$('#common_error_span_'+rowid).css({"display":"none"});
				$('.required_checkbox_parent_div_'+custId).css({"color":""});
				$('.error_customfield_main_div_'+rowid).removeClass('has-error');
			}
			else
			{
	    		$('#common_error_span_'+rowid).text(labelName + " : " + msg1);
	    		$('.required_checkbox_'+custId).css({"outline":"2px solid #a94442"});
	    		$('.required_checkbox_'+custId).css({"color":"#a94442"});
	    		$('#common_error_span_'+rowid).css({"display":""});
	    		$('.required_checkbox_parent_div_'+custId).css({"color":"#a94442"});
				$('.error_customfield_main_div_'+rowid).addClass('has-error');
			}
		}
	});



	$('body').on('change','.date_simple_class',function(){
		
		var rowid = $(this).attr('rows_id');
		var valueIs = $('.common_value_is_'+rowid).val();
        var requireOrNot = $('.common_value_is_'+rowid).attr('isrequire');
        var labelName = $('.common_value_is_'+rowid).attr('fieldnameis');
        var inputTypes = $('.common_value_is_'+rowid).attr('type');
        var custId = $('.common_value_is_'+rowid).attr('custm_isd');

		if (requireOrNot != "") 
		{
			if (valueIs != "") 
			{
				$('#common_error_span_'+rowid).css({"display":"none"});
				$('.error_customfield_main_div_'+rowid).removeClass('has-error');
			}
			else
			{
				$('#common_error_span_'+rowid).text(labelName + " : " + msg1);
	    		$('#common_error_span_'+rowid).css({"display":""});
				$('.error_customfield_main_div_'+rowid).addClass('has-error');
			}
		}
	});



	/*Wash-bay service charge textbox*/
	var isCheckWashbay = $(".washBayCheckbox").is(':checked');

	if (isCheckWashbay == true)
    {
       	$("#washBayCharge").show();
       	$("#washBayCharge_required").attr('required', true);
    } 
    else 
    {
        $("#washBayCharge").hide();
		$("#washBayCharge_required").removeAttr('required', false);
    }

	$('.washBayCheckbox').click(function () {
	
		if ($("#washBay").is(":checked")) 
    	{
        	$("#washBayCharge").show();
        	$("#washBayCharge_required").attr('required', true);
        } 
        else 
        {
           	$("#washBayCharge").hide();
			$("#washBayCharge_required").removeAttr('required', false);
        }
    });


    $('body').on('keyup','.washbay_charge_textbox',function(){
	
		var washbayVal = $(this).val();
		var numericDataWashbayMsg = "{{ trans('app.Only numeric data allowed.')}}";
		var washbay_trans = "{{ trans('app.Wash Bay Charge')}}";

		if (washbayVal != "") 
    	{
        	if(!washbayVal.match(/^[1-9][0-9]*$/))
	    	{
	    		$(this).val("");
	    		$('#washbay_error_span').text(numericDataWashbayMsg);
				$('#washbay_error_span').css({"display":""});
				$('#washBayCharge').addClass('has-error');
	    	}
	    	else
	    	{
				$('#washbay_error_span').css({"display":"none"});
				$('#washBayCharge').removeClass('has-error');
	    	}
        } 
        else 
        {
           	$('#washBayCharge').addClass('has-error');
			$('#washbay_error_span').text(washbay_trans + " " + msg1);
			$('#washbay_error_span').css({"display":""});
        }
    });

});
</script>

<!-- Form field validation -->
{!! JsValidator::formRequest('App\Http\Requests\ServiceAddEditFormRequest', '#ServiceEdit-Form'); !!}
<script type="text/javascript" src="{{ asset('public/vendor/jsvalidation/js/jsvalidation.js') }}"></script>

@endsection