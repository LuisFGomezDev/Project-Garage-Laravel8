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
						<a id="menu_toggle"><i class="fa fa-bars"></i><span class="titleup">&nbsp; {{ trans('app.Quotation')}}</span></a>
					</div>
					@include('dashboard.profile')
				</nav>
			</div>
		</div>
		<div class="x_content">
			<ul class="nav nav-tabs bar_tabs" role="tablist">
				@can('service_view')
					<li role="presentation" class=""><a href="{!! url('/quotation/list')!!}"><span class="visible-xs"></span> <i class="fa fa-list fa-lg">&nbsp;</i>{{ trans('app.Quotation List')}}</a></li>
				@endcan
				@can('service_edit')
					<li role="presentation" class="active"><a href="{!! url('/quotation/list/edit/'.$service->id )!!}"><span class="visible-xs"></span><i class="fa fa-pencil-square-o" aria-hidden="true">&nbsp;</i><b>{{ trans('app.Edit Quotation')}}</b></a></li>
				@endcan
			</ul>
		</div>
            
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_content">
						<form id="QuotationEdit-Form" method="post" action="update/{{ $service->id }}" enctype="multipart/form-data"  class="form-horizontal upperform">

							<div class="form-group">
								<div class="my-form-group">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Quotation Number')}} <label class="color-danger">*</label></label>
									<div class="col-md-4 col-sm-4 col-xs-12">									
										<input type="text"  name="jobno"  class="form-control" value="{{ getQuotationNumber($service->job_no) }}" placeholder="{{ trans('app.Enter Job No')}}" readonly>
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
										<input type="text" name="title" placeholder="{{ trans('app.Enter Title')}}" maxlength="30" value="{{ $service->title }}" class="form-control titalQuotation">
									</div>
								</div>

								<!-- <div class="my-form-group">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="last-name">{{ trans('app.Assign To')}} <label class="color-danger">*</label></label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<select id="AssigneTo" name="AssigneTo"  class="form-control" required>
											<option value="">{{ trans('app.Select Assign To')}}</option>
											@if(!empty($employee))
											@foreach($employee as $employees)
											<option value="{{ $employees->id }}" <?php if($employees->id==$service->assign_to){ echo"selected";}?>> {{ $employees->name }}</option>	
											@endforeach
											@endif
										</select>
									</div>
								</div> -->

								<div class="my-form-group">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Repair Category')}} <label class="color-danger">*</label></label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<select name="repair_cat"  class="form-control" required>
											<option value="">{{ trans('app.-- Select Repair Category--')}}</option>
											<option value="breakdown" <?php if($service->service_category=='breakdown') { echo 'selected'; } ?> >{{ trans('app.Breakdown') }}</option>
											<option value="booked vehicle" <?php if($service->service_category=='booked vehicle') { echo 'selected'; } ?>>{{ trans('app.Booked Vehicle') }}</option>	
											<option value="repeat job" <?php if($service->service_category=='repeat job') { echo 'selected'; } ?>>{{ trans('app.Repeat Job') }}</option>	
											<option value="customer waiting" <?php if($service->service_category=='customer waiting') { echo 'selected'; } ?>>{{ trans('app.Customer Waiting') }}</option>	
										</select>
									</div>
								</div>
							</div>
						  
							<div class="form-group" style="margin-top: 15px;">								
								<div class="">
									<label class="control-label col-md-2 col-sm-2 col-xs-12">{{ trans('app.Service Type')}} <label class="color-danger">*</label></label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<label class="radio-inline">
											<input type="radio" name="service_type" id="free"  value="free" required <?php if($service->service_type=='free') { echo 'checked'; } ?>>{{ trans('app.Free')}}</label>
										<label class="radio-inline">
											<input type="radio" name="service_type" id="paid"  value="paid" required <?php if($service->service_type=='paid') { echo 'checked'; } ?>> {{ trans('app.Paid')}}</label>
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
								<div class="">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Details')}}</label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<textarea name="details"  class="form-control details" maxlength="100">{{ $service->detail }}</textarea> 
									</div>
								</div>

								<!-- MOt Test Checkbox Start-->							
								<div class="">
									<label class="control-label col-md-2 col-sm-2 col-xs-12 motTextLabel" for="" >{{ trans('app.MOT Test') }}</label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<input type="checkbox" name="motTestStatusCheckbox" id="motTestStatusCheckbox" <?php if($service->mot_status==1) { echo 'checked'; } ?> style="height:20px; width:20px; margin-right:5px; position: relative; top: 1px; margin-bottom: 12px;">
									</div>
								</div>							
							<!-- MOt Test Checkbox End-->								 	
							</div>
							
							<!-- <div class="form-group" style="margin-top: 15px;">
								 <div class="">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="reg_no">{{ trans('app.Registration No.')}}</label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<input type="text" name="reg_no" id="reg_no" placeholder="{{ trans('app.Enter Registration Number') }}" class="form-control" maxlength="15" value="{{ $regi_no }}">
									</div>
								</div> 							
							</div> -->


						<!-- Wash Bay Feature -->						
							<div class="form-group">
								<div class="">
									<label class="control-label col-md-2 col-sm-2 col-xs-12 washbayLabel" for="washbay">{{ trans('app.Wash Bay')}} <label class="text-danger"></label></label>
									<div class="col-md-4 col-sm-4 col-xs-12 washbayInputDiv">
										<input type="checkbox" name="washbay" id="washBay" class="washBayCheckbox" <?php echo ($washbayPrice) ? 'checked' : ''; ?>  style="height:20px; width:20px; margin-right:5px; position: relative; top: 6px; margin-bottom: 12px;" >
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
						
							<div class="form-group" style="margin-top: 15px;">
								<!-- Tax field start -->
								@if(!empty($tax))
									<div class="">
										<label class="control-label col-md-2 col-sm-2 col-xs-12" for="cus_name">{{ trans('app.Tax') }}</label>
										<div class="col-md-4 col-sm-4 col-xs-12">
											<table>
												<tbody>
												<?php $edit_tax = explode(", ",$service->tax_id); ?>
													@foreach($tax as $taxes)
													<tr>
														<td>
															<input type="checkbox" id="tax" class="checkbox-inline check_tax sele_tax myCheckbox" name="Tax[]" value="<?php 
															echo $taxes->id;?>" taxrate="{{$taxes->tax}}" taxName="{{$taxes->taxname}}" style="height:20px; width:20px; margin-right:5px; position: relative; top: 6px; margin-bottom: 12px;" <?php if(in_array($taxes->id,$edit_tax)) { echo 'checked'; } ?>>
															<?php 
															echo $taxes->taxname.'&nbsp'.$taxes->tax; ?>%
														</td>
													</tr>
													@endforeach
												</tbody>
											</table>
										</div>
									</div>
								@endif
							<!-- New Tax field End-->

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
						


					<!-- ************* MOT Module Starting ************* -->
							<br/><br/>
							<div class="col-md-12 col-sm-12 col-xs-12 motMainParts" style="display: none">
								<div class="col-md-9 col-sm-8 col-xs-8">
									<h3>{{ trans('app.MOT Test') }}</h3>
								</div>
							</div>

							<div class="col-md-12 col-xs-12 col-sm-12 panel-group motMainPart-1" style="display: none">
								<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="panel-title">
											<a data-toggle="collapse" href="#collapse2" class="observation_Plus2" style="color:#5A738E"><i class=" glyphicon glyphicon-plus"></i> {{ trans('app.MOT Test View') }}</a>
										</h4>
									</div>
									<div id="collapse2" class="panel-collapse collapse">
										<div class="panel-body">

										<!-- Step:1 Starting -->
											<div class=" col-md-12 col-xs-12 col-sm-12 panel-group pGroup">
												<div class="panel panel-default">
													<div class="panel-heading pHeading">
														<h4 class="panel-title">
															<a data-toggle="collapse" href="#collapse3" class="observation_Plus3" style="color:#5A738E"><i class="plus-minus glyphicon glyphicon-plus"></i> {{ trans('app.Step 1: Fill MOT Details') }}</a>
														</h4>
													</div>
													<div id="collapse3" class="panel-collapse collapse">
														<div class="panel-body">
															<div class=" col-md-12 col-xs-12 col-sm-12 panel-group pGroupInsideStep1">

																<div class="row text-center">
																	<div class="col-md-3">
																		<h5 class="boldFont">{{ trans('app.OK = Satisfactory') }}</h5>
																	</div>
																	<div class="col-md-3">
																		<h5 class="boldFont">{{ trans('app.X = Safety Item Defact') }}</h5>
																	</div>
																	<div class="col-md-3">
																		<h5 class="boldFont">{{ trans('app.R = Repair Required') }}</h5>
																	</div>
																	<div class="col-md-3">
																		<h5 class="boldFont">{{ trans('app.NA = Not Applicable') }}</h5>
																	</div>
																</div>

													<!-- Inside Cab  Starting -->
																<div class="panel panel-default">
																	<div class="panel-heading pHeadingInsideStep1">
																		<h4 class="panel-title">
																			<a data-toggle="collapse" href="#collapse5" class="observation_Plus3" style="color:#5A738E"><i class="plus-minus glyphicon glyphicon-plus"></i> {{ trans('app.Inside Cab') }}</a>
																		</h4>
																	</div>
																	<div id="collapse5" class="panel-collapse collapse">
																		<div class="panel-body">
																			
																			
												@php 
													$a = $b = '';
													$count = count($inspection_points_library_data);
													$count = $count/2;
												@endphp	
									
										
								@foreach($inspection_points_library_data as $key => $inspection_library)
							
										@if($inspection_library->inspection_type == 1)
													@if(!empty($mot_inspections_answers))
														@if( $key % 2 != 1 )
														<?php 
																$a .= "<tr>
																	<td>$inspection_library->code</td>
																	<td>$inspection_library->point</td>
																	<td>
																	<select name=inspection[$inspection_library->id] data-id='$inspection_library->id' class='common'  id='$inspection_library->code'>																		
															    		<option value='ok'". ($mot_inspections_answers[$inspection_library->code] == 'ok' ? 'selected' : '') .">OK</option>
															    		<option value='x'". ($mot_inspections_answers[$inspection_library->code] == 'x' ? 'selected' : '') .">X</option>
															    		<option value='r'". ($mot_inspections_answers[$inspection_library->code] == 'r'? 'selected' : '') .">R</option>
															    		<option value='na'". ($mot_inspections_answers[$inspection_library->code] == 'na' ? 'selected' : '') .">NA</option>
															  		</select>
															  		</td></tr>";
															?>								
														@else
															<?php 
																$b .= "<tr>
																	<td>$inspection_library->code</td>
																	<td>$inspection_library->point</td>
																	<td>
																	<select name=inspection[$inspection_library->id] data-id='$inspection_library->id' class='common' id='$inspection_library->code'>
															    	<option value='ok'". ($mot_inspections_answers[$inspection_library->code] == 'ok' ? 'selected' : '') .">OK</option>
															    		<option value='x'". ($mot_inspections_answers[$inspection_library->code] == 'x' ? 'selected' : '') .">X</option>
															    		<option value='r'". ($mot_inspections_answers[$inspection_library->code] == 'r'? 'selected' : '') .">R</option>
															    		<option value='na'". ($mot_inspections_answers[$inspection_library->code] == 'na' ? 'selected' : '') .">NA</option>
															  		</select>
															  		</td>
															  		</tr>"; 
															?>
														@endif

													@else
														@if( $key % 2 != 1 )
															<?php 
																	$a .= "<tr>
																		<td>$inspection_library->code</td>
																		<td>$inspection_library->point</td>
																		<td>
																		<select name=inspection[$inspection_library->id] data-id='$inspection_library->id' class='common'  id='$inspection_library->code'>
																    		<option value='ok'>OK</option>
																    		<option value='x'>X</option>
																    		<option value='r'>R</option>
																    		<option value='na'>NA</option>
																  		</select>
																  		</td></tr>"; 
																?>								
															@else
																<?php 
																	$b .= "<tr>
																		<td>$inspection_library->code</td>
																		<td>$inspection_library->point</td>
																		<td>
																		<select name=inspection[$inspection_library->id] data-id='$inspection_library->id' class='common' id='$inspection_library->code'>
																    	<option value='ok'>OK</option>
																    	<option value='x'>X</option>
																    	<option value='r'>R</option>
																    	<option value='na'>NA</option>
																  		</select>
																  		</td>
																  		</tr>"; 
																?>
															@endif
													@endif
										@endif
								@endforeach
								
																				
																			<div class="col-md-6">
																				<table class="table">
																					<thead class="thead-dark">
																					<tr>
																						<th><b>{{ trans('app.Code') }}</b></th>
																						<th><b>{{ trans('app.Inspection Details') }}</b></th>
																						<th><b>{{ trans('app.Answer') }}</b></th>
																					</tr>
																					</thead>
																					<?php echo $a; ?>
																				</table>
																			</div>
																			<div class="col-md-6">
																				<table class="table">
																					<thead class="thead-dark smallDisplayTheadHiddenInsideCab">
																					<tr>
																						<th><b>{{ trans('app.Code') }}</b></th>
																						<th><b>{{ trans('app.Inspection Details') }}</b></th>
																						<th><b>{{ trans('app.Answer') }}</b></th>
																					</tr>
																					</thead>
																					<?php echo $b; ?>
																				</table>
																			</div>
								
																			
																		</div>
																	</div>
																</div>
													<!-- Inside Cab  Ending -->

															</div>

												<!-- Ground Level and Under Vehicle  Starting -->
															<div class=" col-md-12 col-xs-12 col-sm-12 panel-group pGroupInsideStep1">
																<div class="panel panel-default">
																	<div class="panel-heading pHeadingInsideStep1">
																		<h4 class="panel-title">
																			<a data-toggle="collapse" href="#collapse6" class="observation_Plus3" style="color:#5A738E"><i class="plus-minus glyphicon glyphicon-plus"></i> {{ trans('app.Ground Level and Under Vehicle') }}</a>
																		</h4>
																	</div>
																	<div id="collapse6" class="panel-collapse collapse">
																		<div class="panel-body">
												@php 
													$a = $b = '';
													$count = count($inspection_points_library_data);
													$count = $count/2;
												@endphp	
											
								@foreach($inspection_points_library_data as $key => $inspection_library)
									
										@if($inspection_library->inspection_type == 2)
													@if(!empty($mot_inspections_answers))
														@if( $key % 2 != 0 )
															<?php 
																$a .= "<tr>
																	<td>$inspection_library->code</td>
																	<td>$inspection_library->point</td>
																	<td>
																	<select name=inspection[$inspection_library->id] data-id='$inspection_library->id' class='common'  id='$inspection_library->code'>
															    		<option value='ok'". ($mot_inspections_answers[$inspection_library->code] == 'ok' ? 'selected' : '') .">OK</option>
															    		<option value='x'". ($mot_inspections_answers[$inspection_library->code] == 'x' ? 'selected' : '') .">X</option>
															    		<option value='r'". ($mot_inspections_answers[$inspection_library->code] == 'r'? 'selected' : '') .">R</option>
															    		<option value='na'". ($mot_inspections_answers[$inspection_library->code] == 'na' ? 'selected' : '') .">NA</option>
															  		</select>
															  		</td></tr>"; 
															?>								
														@else
															<?php 
																$b .= "<tr>
																	<td>$inspection_library->code</td>
																	<td>$inspection_library->point</td>
																	<td>
																	<select name=inspection[$inspection_library->id] data-id='$inspection_library->id' class='common'  id='$inspection_library->code'>
															    	<option value='ok'". ($mot_inspections_answers[$inspection_library->code] == 'ok' ? 'selected' : '') .">OK</option>
															    		<option value='x'". ($mot_inspections_answers[$inspection_library->code] == 'x' ? 'selected' : '') .">X</option>
															    		<option value='r'". ($mot_inspections_answers[$inspection_library->code] == 'r'? 'selected' : '') .">R</option>
															    		<option value='na'". ($mot_inspections_answers[$inspection_library->code] == 'na' ? 'selected' : '') .">NA</option>
															  		</select>
															  		</td>
															  		</tr>"; 
															?>
														@endif
													@else
														@if( $key % 2 != 0 )
																<?php 
																	$a .= "<tr>
																		<td>$inspection_library->code</td>
																		<td>$inspection_library->point</td>
																		<td>
																		<select name=inspection[$inspection_library->id] data-id='$inspection_library->id' class='common'  id='$inspection_library->code'>
																    		<option value='ok'>OK</option>
																    		<option value='x'>X</option>
																    		<option value='r'>R</option>
																    		<option value='na'>NA</option>
																  		</select>
																  		</td></tr>"; 
																?>								
															@else
																<?php 
																	$b .= "<tr>
																		<td>$inspection_library->code</td>
																		<td>$inspection_library->point</td>
																		<td>
																		<select name=inspection[$inspection_library->id] data-id='$inspection_library->id' class='common'  id='$inspection_library->code'>
																    	<option value='ok'>OK</option>
																    	<option value='x'>X</option>
																    	<option value='r'>R</option>
																    	<option value='na'>NA</option>
																  		</select>
																  		</td>
																  		</tr>"; 
																?>
															@endif
													@endif
										@endif
								@endforeach
								

																			<div class="col-md-6">
																				<table class="table">
																					<thead class="thead-dark">
																					<tr>
																						<th><b>{{ trans('app.Code') }}</b></th>
																						<th><b>{{ trans('app.Inspection Details') }}</b></th>
																						<th><b>{{ trans('app.Answer') }}</b></th>
																					</tr>
																				</thead>
																					<?php echo $a; ?>
																				</table>
																			</div>
																			<div class="col-md-6">
																				<table class="table">
																					<thead class="thead-dark smallDisplayTheadHiddenGroundLevel">
																					<tr>
																						<th><b>{{ trans('app.Code') }}</b></th>
																						<th><b>{{ trans('app.Inspection Details') }}</b></th>
																						<th><b>{{ trans('app.Answer') }}</b></th>
																					</tr>
																					</thead>
																					<?php echo $b; ?>
																				</table>
																			</div>


																		</div>
																	</div>
																</div>
															</div>
												<!-- Ground Level and Under Vehicle Ending -->

														</div>
													</div>
												</div>
											</div>
									<!-- Step 1: Ending -->

									<!-- Step 2: Show Filled MOT Details Starting -->
											<div class=" col-md-12 col-xs-12 col-sm-12 panel-group pGroup">
												<div class="panel panel-default">
													<div class="panel-heading pHeading">
														<h4 class="panel-title">
															<a data-toggle="collapse" href="#collapse4" class="observation_Plus3" style="color:#5A738E"><i class="plus-minus glyphicon glyphicon-plus"></i> {{ trans('app.Step 2: Show Filled MOT Details') }}</a>
														</h4>
													</div>
													<div id="collapse4" class="panel-collapse collapse">
														<div class="panel-body">
															
															<table class="table">
																<thead class="thead-dark">
																	<tr>
																		<th><b>{{ trans('app.Code') }}</b></th>
																		<th><b>{{ trans('app.Inspection Details') }}</b></th>
																		<th><b>{{ trans('app.Answer') }}</b></th>
																	<tr>
																</thead>			
												@if(!empty($mot_inspections_answers))			
													@foreach($inspection_points_library_data as $key => $value)	
															<thead>
																@if($mot_inspections_answers[$value->code] == 'x' || $mot_inspections_answers[$value->code] == 'r')
																<tr style="" id="tr_{{$value->id}}">
																	<td id=""> 
																		{{ $value->id }} 
																	</td>
																	<td id=""> 
																		{{ $value->point }} 
																	</td>
																	<td id="row_{{$value->id}}" class="text-uppercase"> {{ $mot_inspections_answers[$value->code] }} </td>
																</tr>
																@else
																<tr style="display: none;" id="tr_{{$value->id}}">
																	<td id=""> 
																		{{ $value->id }} 
																	</td>
																	<td id=""> 
																		{{ $value->point }} 
																	</td>
																	<td id="row_{{$value->id}}" class="text-uppercase">  </td>
																</tr>
																@endif
															</thead>
													@endforeach
												@else
													@foreach($inspection_points_library_data as $key => $value)	
														<thead>
															<tr style="display: none;" id="tr_{{$value->id}}">
																<td id=""> 
																	{{ $value->id }} 
																</td>
																<td id=""> 
																	{{ $value->point }} 
																</td>
																<td id="row_{{$value->id}}" class="text-uppercase">  </td>
															</tr>
														</thead>
													@endforeach
												@endif		
															</table>
															
														</div>
													</div>
												</div>
											</div>
							<!--Step 2: Show Filled MOT Details Ending -->

										</div>
									</div>
								</div>
							</div>
							
					<!-- ************* MOT Module Ending ************* -->

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
																	<label><input type="{{$tbl_custom_field->type}}"  name="custom[{{$tbl_custom_field->id}}]" value="{{$k}}"    <?php
																			//$formName = "product";
																			$getRadioValue = getRadioLabelValueForUpdateForAllModules($tbl_custom_field->form_name ,$service->id, $tbl_custom_field->id);

																	 	if($k == $getRadioValue) { echo "checked"; }?> 

																	> {{ $val }}<label> &nbsp;
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
																	<label><input type="{{$tbl_custom_field->type}}" name="custom[{{$tbl_custom_field->id}}][]" value="{{$val}}" isRequire="{{$required}}" fieldNameIs="{{ $tbl_custom_field->label }}" custm_isd="{{$tbl_custom_field->id}}" class="checkbox_{{$tbl_custom_field->id}} required_checkbox_{{$tbl_custom_field->id}} checkbox_simple_class common_value_is_{{$myCounts}} common_simple_class" rows_id="{{$myCounts}}"

																	<?php
																	 	if($val == getCheckboxValForAllModule($tbl_custom_field->form_name, $service->id, $tbl_custom_field->id,$val)) 
																	 			{ echo "checked"; }
																	 	?>
																	> {{ $val }}<label> &nbsp;
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
									<button type="submit" class="btn btn-success updateQuotationButton">{{ trans('app.Update')}}</button>
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
$(document).ready(function () 
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


	/*MOT main Accordian fade in out*/
	var i = 0;
	$('.observation_Plus2').click(function(){
		i = i+1;
		if(i%2!=0){
				$(this).parent().find(".glyphicon-plus:first").removeClass("glyphicon-plus").addClass("glyphicon-minus");
				
		}else{
			$(this).parent().find(".glyphicon-minus:first").removeClass("glyphicon-minus").addClass("glyphicon-plus");
		}
	});


	/*This for Step:1 and Step:1 Accordion of MoT View*/
	$(function() {
	  	function toggleIcon(e) {
	      	$(e.target)
	          	.prev('.pHeading')
	          	.find(".plus-minus")
	          	.toggleClass('glyphicon-plus glyphicon-minus');
	  	}
	  	$('.pGroup').on('hidden.bs.collapse', toggleIcon);
	  	$('.pGroup').on('shown.bs.collapse', toggleIcon);
	});

	
	/*This for InsideCab and GroundLevelUnderVehicle Accordion*/
	$(function() {
	  	function toggleIcon(e) {
	      	$(e.target)
	          	.prev('.pHeadingInsideStep1')
	          	.find(".plus-minus")
	          	.toggleClass('glyphicon-plus glyphicon-minus');
	  	}
	  	$('.pGroupInsideStep1').on('hidden.bs.collapse', toggleIcon);
	  	$('.pGroupInsideStep1').on('shown.bs.collapse', toggleIcon);
	});	



	/*If MOT check box is checked then show all MOT details otherwise not*/

  	if($('input[name="motTestStatusCheckbox"]').is(':checked'))
	{
		$('.motMainPart').css({"display":""});
		$('.motMainPart-1').css({"display":""});
	}
	else
	{
		$('.motMainPart').css({"display":"none"});
		$('.motMainPart-1').css({"display":"none"});
	}



	$('body').on('click', '#motTestStatusCheckbox', function(){

      	if($('input[name="motTestStatusCheckbox"]').is(':checked'))
		{
			$('.motMainPart').css({"display":""});
			$('.motMainPart-1').css({"display":""});
		}
		else
		{
			$('.motMainPart').css({"display":"none"});
			$('.motMainPart-1').css({"display":"none"});
		}
   	});


	/*For display data from 'InsideCab  And Ground Level Under Vehicle' accordion to Step:2 Accordion*/
	$('.common').change(function(e) {

        var selectBoxValue = $(this,':selected').val();
        var id = $(this).attr('data-id');

        if (selectBoxValue == "r" || selectBoxValue == "x") {
        	$('#tr_'+id).css("display","");
        	$('#row_'+id).html(selectBoxValue);
        } 
        else 
        {
        	$('#tr_'+id).css("display","none");
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

	$('body').on('keyup', '.titalQuotation', function(){

      	var titalQuotation = $(this).val();

      	if (!titalQuotation.replace(/\s/g, '').length) {
         	$(this).val("");
      	}
   	});

   	$('body').on('keyup', '.details', function(){

      	var details = $(this).val();

      	if (!details.replace(/\s/g, '').length) {
         	$(this).val("");
      	}
   	});


	/*Custom Field manually validation*/
	var msg31 = "{{ trans('app.field is required')}}";
	var msg32 = "{{ trans('app.Only blank space not allowed')}}";
	var msg33 = "{{ trans('app.Special symbols are not allowed.')}}";
	var msg34 = "{{ trans('app.At first position only alphabets are allowed.')}}";

	/*Form submit time check validation for Custom Fields */
	$('body').on('click','.updateQuotationButton',function(e){
		$('#QuotationEdit-Form input, #QuotationEdit-Form select, #QuotationEdit-Form textarea').each(

		    function(index)
		    {  
		        var input = $(this);

		        if (input.attr('name') == "Customername" || input.attr('name') == "vehicalname" || input.attr('name') == "date" || input.attr('name') == "repair_cat" || input.attr('name') == "service_type") 
		        {
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
				    		$('#common_error_span_'+rowid).text(labelName + " : " + msg31);
				    		$('#common_error_span_'+rowid).css({"display":""});
							$('.error_customfield_main_div_'+rowid).addClass('has-error');
			        		e.preventDefault();
			        		return false;
			        	}
			        	else if (!input.val().replace(/\s/g, '').length) 
			        	{
				    		$('.common_value_is_'+rowid).val("");
				    		$('#common_error_span_'+rowid).text(labelName + " : " + msg32);
				    		$('#common_error_span_'+rowid).css({"display":""});
							$('.error_customfield_main_div_'+rowid).addClass('has-error');
			        		e.preventDefault();	
			        		return false;
			        	}
			        	else if(!input.val().match(/^[a-zA-Z\u0621-\u064A\u00C0-\u017F\u0600-\u06FF\u0750-\u077F\uFB50-\uFDFF\uFE70-\uFEFF\u2E80-\u2FD5\u3190-\u319f\u3400-\u4DBF\u4E00-\u9FCC\uF900-\uFAAD\u0900-\u097F][a-zA-Z0-9\u0621-\u064A\u00C0-\u017F\u0600-\u06FF\u0750-\u077F\uFB50-\uFDFF\uFE70-\uFEFF\u2E80-\u2FD5\u3190-\u319f\u3400-\u4DBF\u4E00-\u9FCC\uF900-\uFAAD\u0900-\u097F\s\.\-\_]*$/))
			        	{
			        		$('.common_value_is_'+rowid).val("");
				    		$('#common_error_span_'+rowid).text(labelName + " : " + msg33);
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
							$('#common_error_span_'+rowid).text(labelName + " : " + msg31);
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
				    		$('#common_error_span_'+rowid).text(labelName + " : " + msg31);
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
				$('#washbay_error_span').text(washbay_trans + " " + msg31);
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
		    		$('#common_error_span_'+rowid).text(labelName + " : " + msg31);
		    		$('#common_error_span_'+rowid).css({"display":""});
					$('.error_customfield_main_div_'+rowid).addClass('has-error');
		    	}
		    	else if (valueIs.match(/^\s+/))
		    	{
		    		$('.common_value_is_'+rowid).val("");
		    		$('#common_error_span_'+rowid).text(labelName + " : " + msg34);
		    		$('#common_error_span_'+rowid).css({"display":""});
					$('.error_customfield_main_div_'+rowid).addClass('has-error');
		    	}
		    	else if(!valueIs.match(/^[a-zA-Z\u0621-\u064A\u00C0-\u017F\u0600-\u06FF\u0750-\u077F\uFB50-\uFDFF\uFE70-\uFEFF\u2E80-\u2FD5\u3190-\u319f\u3400-\u4DBF\u4E00-\u9FCC\uF900-\uFAAD\u0900-\u097F][a-zA-Z0-9\u0621-\u064A\u00C0-\u017F\u0600-\u06FF\u0750-\u077F\uFB50-\uFDFF\uFE70-\uFEFF\u2E80-\u2FD5\u3190-\u319f\u3400-\u4DBF\u4E00-\u9FCC\uF900-\uFAAD\u0900-\u097F\s\.\-\_]*$/))
		    	{
		    		$('.common_value_is_'+rowid).val("");
		    		$('#common_error_span_'+rowid).text(labelName + " : " + msg33);
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
		    		$('#common_error_span_'+rowid).text(labelName + " : " + msg31);
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
			    		$('#common_error_span_'+rowid).text(labelName + " : " + msg34);
			    		$('#common_error_span_'+rowid).css({"display":""});
						$('.error_customfield_main_div_'+rowid).addClass('has-error');
			    	}
			    	else if(!valueIs.match(/^[a-zA-Z\u0621-\u064A\u00C0-\u017F\u0600-\u06FF\u0750-\u077F\uFB50-\uFDFF\uFE70-\uFEFF\u2E80-\u2FD5\u3190-\u319f\u3400-\u4DBF\u4E00-\u9FCC\uF900-\uFAAD\u0900-\u097F][a-zA-Z0-9\u0621-\u064A\u00C0-\u017F\u0600-\u06FF\u0750-\u077F\uFB50-\uFDFF\uFE70-\uFEFF\u2E80-\u2FD5\u3190-\u319f\u3400-\u4DBF\u4E00-\u9FCC\uF900-\uFAAD\u0900-\u097F\s\.\-\_]*$/))
			    	{
			    		$('.common_value_is_'+rowid).val("");
			    		$('#common_error_span_'+rowid).text(labelName + " : " + msg33);
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
	    		$('#common_error_span_'+rowid).text(labelName + " : " + msg31);
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
				$('#common_error_span_'+rowid).text(labelName + " : " + msg31);
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
			$('#washbay_error_span').text(washbay_trans + " " + msg31);
			$('#washbay_error_span').css({"display":""});
        }
    });

});
</script>

<!-- Form field validation -->
{!! JsValidator::formRequest('App\Http\Requests\StoreQuotationAddEditFormRequest', '#QuotationEdit-Form'); !!}
<script type="text/javascript" src="{{ asset('public/vendor/jsvalidation/js/jsvalidation.js') }}"></script>

@endsection