@extends('layouts.app')
@section('content')
<style>
.first_width,.second_width{width:82%;}
.table{margin-bottom:0px;}
.all{width:42%;}
</style>

<!-- page content -->		
	<div class="right_col" role="main">
		<div class="">
			<div class="page-title">
				<div class="nav_menu">
					<nav>
						<div class="nav toggle">
							<a id="menu_toggle"><i class="fa fa-bars"></i><span class="titleup">&nbsp; {{ trans('app.Vehicle Sale')}}</span></a>
						</div>
						@include('dashboard.profile')
					</nav>
				</div>
				@if(session('message'))
				<div class="row massage">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="checkbox checkbox-success checkbox-circle">
							<input id="checkbox-10" type="checkbox" checked="">
							<label for="checkbox-10 colo_success">  {{session('message')}} </label>
						</div>
					</div>
				</div>
				@endif
			</div>

			<div class="x_content">
			   <ul class="nav nav-tabs bar_tabs" role="tablist">
			   		@can('sales_view')
						<li role="presentation" class=""><a href="{!! url('/sales/list')!!}"><span class="visible-xs"><i class="ti-info-alt"></i></span> <i class="fa fa-list fa-lg">&nbsp;</i>{{ trans('app.List Of Vehicle Sale')}}</span></a></li>
					@endcan
					@can('sales_add')
						<li role="presentation" class="active"><a href="{!! url('/sales/add')!!}"><span class="visible-xs"></span> <i class="fa fa-plus-circle fa-lg">&nbsp;</i><b>{{ trans('app.Add Vehicle Sale')}}</b></span></a></li>
					@endcan
				</ul>
			</div>
	  
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_content">
							<form id="vehicleSalesAddForm" method="post" action="{!! url('sales/store') !!}" enctype="multipart/form-data"  class="form-horizontal upperform salesAddForm">

								<div class="form-group">
									<div class="my-form-group">
										<label class="control-label col-md-2 col-sm-2 col-xs-12" for="last-name">{{ trans('app.Bill No')}} <label class="color-danger">*</label></label>
										<div class="col-md-4 col-sm-4 col-xs-12">
											<input type="text" id="bill_no" name="bill_no" class="form-control" value="{{ $code }}" readonly>
										</div>
									</div>

									<div class="my-form-group">
										<label class="control-label col-md-2 col-sm-2 col-xs-12" for="last-name">{{ trans('app.Sales Date')}} <label class="color-danger">*</label></label>
										<div class="col-md-4 col-sm-4 col-xs-12 input-group date datepicker">
											<span class="input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
											<input type="text" id="sales_date" name="date" autocomplete="off" class="form-control salesDate" placeholder="<?php echo getDatepicker();?>" onkeypress="return false;" required>
										</div>
									</div>
								</div>
					
								<div class="form-group">
									<div class="my-form-group">
										<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Customer Name')}} <label class="color-danger">*</label></label>
										<div class="col-md-4 col-sm-4 col-xs-12">
											<select class="form-control select_customer_auto_search customer_name" name="cus_name" id="supplier_select" required>
												<option value="">{{ trans('app.Select Customer')}}</option>
												@if(!empty($customer))
													@foreach($customer as $customers)
														<option value="{{ $customers->id }}">{{ $customers->name.' '.$customers->lastname }}</option>
													@endforeach
												@endif
											</select>
										</div>
									</div>
									<!-- <div class="has-feedback {{ $errors->has('qty') ? ' has-error' : '' }}">
										<label class="control-label col-md-2 col-sm-2 col-xs-12" for="last-name">{{ trans('app.Quantity')}} <label class="text-danger">*</label></label>
										<div class="col-md-4 col-sm-4 col-xs-12">
											<input type="text" id="qty" name="qty"  class="form-control" maxlength="5" min="0" url="{!! url('sales/add/getqty')!!}" value="1" required>
											@if ($errors->has('qty'))
												<span class="help-block">
													<strong>{{ $errors->first('qty') }}</strong>
												</span>
											@endif
										</div>
									</div> -->

									<div class="my-form-group">
										<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Salesman')}} <label class="color-danger">*</label></label>
										<div class="col-md-4 col-sm-4 col-xs-12">
											<select class="form-control" name="salesmanname" required>
												<option value="">{{ trans('app.Select Name')}}</option>
												@if(!empty($employee))
													@foreach($employee as $employees)
														<option value="{{ $employees->id }}">{{ $employees->name.' '.$employees->lastname }}</option>
													@endforeach
												@endif
											</select>
										</div>
									</div>
								</div>
					
								<div class="form-group">
									<div class="my-form-group">
										<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Select Vehicle Brand')}} <label class="color-danger">*</label></label>
										<div class="col-md-4 col-sm-4 col-xs-12">
											<select class="form-control veh_brand" name="vehi_bra_name" id="vehi_bra_name" bran_url="{!! url('sales/add/getmodel_name')!!}" required>
												<option value="">{{ trans('app.Select Vehicle Brand')}}</option>
												@if(!empty($brand))
													@foreach($brand as $brands)
													<option value="{{ $brands->id }}">{{ $brands->vehicle_brand }}</option>
													@endforeach
												@endif
											</select>
										</div>
									</div>

									<div class="">
										<label class="control-label col-md-2 col-sm-2 col-xs-12" for="last-name">{{ trans('app.Chassis')}} </label>
										<div class="col-md-4 col-sm-4 col-xs-12">
											<select id="chassis_num" name="chassis"  class="form-control"  url="{!! url('sales/add/getqty')!!}" >
											
												<option value=""> {{ trans('app.Select Chassis Number') }} </option>
												<!-- Opiton Shows from controller -->
												
											</select>
										</div>
									</div>
									
								</div>
					
								<div class="form-group">
									<div class="my-form-group">
										<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Select Model')}} <label class="color-danger">*</label></label>
										<div class="col-md-4 col-sm-4 col-xs-12">
											<select class="form-control selectmodel" name="vehicale_name" id="vehicale_select" url="{!! url('sales/add/getrecord')!!}" chasisurl="{!! url('sales/add/getchasis') !!}" required>
												<option value="">{{ trans('app.Select Model')}}</option>
												
												<!-- Option Shows from Controller -->

											</select>
										</div>
									</div>

									<div class="has-feedback {{ $errors->has('price') ? ' has-error' : '' }} my-form-group">
										<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Price')}} (<?php echo getCurrencySymbols(); ?>) <label class="color-danger">*</label></label>
										<div class="col-md-4 col-sm-4 col-xs-12">
										
											<input type="text" id="price" name="price"  class="form-control" maxlength="10" id="price" readonly>
											@if ($errors->has('price'))
												<span class="help-block">
													<strong>{{ $errors->first('price') }}</strong>
												</span>
											@endif
										</div>
									</div>									
								</div>
								
								<div class="form-group">
									<div class="my-form-group">
										<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Color')}} <label class="color-danger">*</label></label>
										<div class="col-md-2 col-sm-2 col-xs-12">
											<select id="color_type" name="color"  class="form-control color_name_data" required>
												<option value="">{{ trans('app.-- Select Color --')}}</option>
													@if(!empty($color))
														@foreach($color as $colors)
															<option value="{{ $colors->id }}">{{ $colors->color }}</option>
														@endforeach
													@endif
											</select>
										</div>
										<div class="col-md-2 col-sm-2 col-xs-12 addremove">
											<button type="button" data-target="#responsive-modal-color" data-toggle="modal" class="btn btn-default">{{ trans('app.Add Or Remove')}}</button>
										</div>
									</div>
									
									<div class="my-form-group">
										<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Total Price')}} (<?php echo getCurrencySymbols(); ?>) <label class="color-danger">*</label></label>
										<div class="col-md-4 col-sm-4 col-xs-12">
										
											<input type="text" id="total_price" name="total_price"   class="form-control" value="0" readonly>
										</div>
									</div>
								</div>

								<div class="form-group">
									<div class="my-form-group">
		                              	<label class="control-label col-md-2 col-sm-2 col-xs-12" for="branch">{{ trans('app.Branch')}} <label class="color-danger">*</label></label>
		                              
		                              	<div class="col-md-4 col-sm-4 col-xs-12">
		                                	<select class="form-control  select_branch" name="branch">
		                                  	@foreach ($branchDatas as $branchData)
		                                    	<option value="{{ $branchData->id }}">{{$branchData->branch_name }}</option>
		                                  	@endforeach
		                                	</select>
		                              	</div>
		                            </div>	
								</div>

								<div class="form-group" style="margin-top:20px;">
									<div class="col-md-12">
									<h2 style="margin-left:10px;">{{ trans('app.Number of Services')}}</h2>
									</div>
								</div>
								  
								<div class="form-group">
									<div class="my-form-group">
										<label class="control-label col-md-2 col-sm-2 col-xs-12" for="last-name">{{ trans('app.Interval')}} <label class="color-danger">*</label></label>
										<div class="col-md-4 col-sm-4 col-xs-12">
											<select name="interval" id="interval" class="form-control" required > 
												<option value="">{{ trans('app.Number of Interval')}}</option>
												<option value="1">{{ trans('app.1 Month')}}</option>
												<option value="2">{{ trans('app.2 Month')}}</option>
												<option value="3">{{ trans('app.3 Month')}}</option>
											</select>
										</div>
										
									</div>
									
									<div class="">
										<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Date Gap')}}</label>
										<div class="col-md-4 col-sm-4 col-xs-12">
											<select name="date_gape" id="date_gape" class="form-control"> 
												<option value="0">{{ trans('app.1 Day')}}</option>
												<option value="3">{{ trans('app.3 Day')}}</option>
												<option value="5">{{ trans('app.5 Day')}}</option>
												<option value="10">{{ trans('app.10 Day')}}</option>
											</select>
										</div>
									</div>
								</div>
								
								<div class="form-group">
									<div class="my-form-group">
										<label class="control-label col-md-2 col-sm-2 col-xs-12" for="last-name">{{ trans('app.Number of Services')}} <label class="color-danger">*</label></label>
										<div class="col-md-4 col-sm-4 col-xs-12">
											<select name="no_of_services" id="no_of_service" class="form-control no_of_service" url="{!! url('sales/add/getservices')!!}" required> 
												<option value="" >{{ trans('app.Number of Services')}} </option>
												<option value="1">1</option>
												<option value="2">2</option>
												<option value="3">3</option>
												<option value="4">4</option>
												<option value="5">5</option>
												<option value="6">6</option>
												<option value="7">7</option>
												<option value="8">8</option>
												<option value="9">9</option>
												<option value="10">10</option>
												<option value="11">11</option>
												<option value="12">12</option>
											</select>
										</div>
									</div>

									<div class="my-form-group">
										<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Assign To')}} <label class="color-danger">*</label></label>
										<div class="col-md-4 col-sm-4 col-xs-12">
											<select class="form-control" name="assigne_to" id="assigne_to" required>
												<option value="">{{ trans('app.Select Name')}}</option>
												@if(!empty($employee))
													@foreach($employee as $employees)
														<option value="{{ $employees->id }}">{{ $employees->name.' '.$employees->lastname }}</option>
													@endforeach
												@endif
											</select>
										</div>
									</div>
								</div>

								<div class="form-group">
									<div class="" id="load_service_data">
									
									</div>
								</div>

							<!-- Start Custom Field, (If register in Custom Field Module)  -->
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
												$required="required";
												$red="*";
											}else{
												$required="";
												$red="";
											}

											$subDivCount++;
										?>
										@if($myCounts%2 == 0)
										<div class="col-md-12 col-sm-6 col-xs-12">
										@endif
											<div class="form-group col-md-6 col-sm-6 col-xs-12 error_customfield_main_div_{{$myCounts}}">
											
												<label class="control-label col-md-4 col-sm-4 col-xs-12" for="account-no">{{$tbl_custom_field->label}} <label class="color-danger">{{$red}}</label></label>
												<div class="col-md-8 col-sm-8 col-xs-12">
												@if($tbl_custom_field->type == 'textarea')
													<textarea  name="custom[{{$tbl_custom_field->id}}]" class="form-control textarea_{{$tbl_custom_field->id}} textarea_simple_class common_simple_class common_value_is_{{$myCounts}}" placeholder="{{ trans('app.Enter')}} {{$tbl_custom_field->label}}" maxlength="100" isRequire="{{$required}}" type="textarea" fieldNameIs="{{ $tbl_custom_field->label }}" rows_id="{{$myCounts}}" {{$required}}></textarea>

													<span id="common_error_span_{{$myCounts}}" class="help-block error-help-block color-danger" style="display: none"></span>
												@elseif($tbl_custom_field->type == 'radio')
													
													<?php
														$radioLabelArrayList = getRadiolabelsList($tbl_custom_field->id)
													?>
													@if(!empty($radioLabelArrayList))
														<div style="margin-top: 5px;">
														@foreach($radioLabelArrayList as $k => $val)
															<input type="{{$tbl_custom_field->type}}"  name="custom[{{$tbl_custom_field->id}}]" value="{{$k}}" <?php if($k == 0) {echo "checked"; } ?>>{{$val}} &nbsp;
														@endforeach	
														</div>								
													@endif
												@elseif($tbl_custom_field->type == 'checkbox')
													
													<?php
														$checkboxLabelArrayList = getCheckboxLabelsList($tbl_custom_field->id);
														$cnt = 0;
													?>

													@if(!empty($checkboxLabelArrayList))
														<div class="required_checkbox_parent_div_{{$tbl_custom_field->id}}" style="margin-top: 5px;">
														@foreach($checkboxLabelArrayList as $k => $val)
															<input type="{{$tbl_custom_field->type}}" name="custom[{{$tbl_custom_field->id}}][]" value="{{$val}}" isRequire="{{$required}}" fieldNameIs="{{ $tbl_custom_field->label }}" custm_isd="{{$tbl_custom_field->id}}" class="checkbox_{{$tbl_custom_field->id}} required_checkbox_{{$tbl_custom_field->id}} checkbox_simple_class common_value_is_{{$myCounts}} common_simple_class" rows_id="{{$myCounts}}" > {{ $val }} &nbsp;
														<?php $cnt++; ?>
														@endforeach
														<span id="common_error_span_{{$myCounts}}" class="help-block error-help-block color-danger" style="display: none"></span>
														</div>
														<input type="hidden" name="checkboxCount" value="{{$cnt}}">
													@endif											
												@elseif($tbl_custom_field->type == 'textbox')
													<input type="{{$tbl_custom_field->type}}"  name="custom[{{$tbl_custom_field->id}}]"  class="form-control textDate_{{$tbl_custom_field->id}} textdate_simple_class common_value_is_{{$myCounts}} common_simple_class" placeholder="{{ trans('app.Enter')}} {{$tbl_custom_field->label}}" maxlength="30" isRequire="{{$required}}" fieldNameIs="{{ $tbl_custom_field->label }}" rows_id="{{$myCounts}}" {{ $required }}>

													<span id="common_error_span_{{$myCounts}}" class="help-block error-help-block color-danger" style="display:none"></span>
												@elseif($tbl_custom_field->type == 'date')
													<input type="{{$tbl_custom_field->type}}"  name="custom[{{$tbl_custom_field->id}}]"  class="form-control textDate_{{$tbl_custom_field->id}} date_simple_class common_value_is_{{$myCounts}} common_simple_class" placeholder="{{ trans('app.Enter')}} {{$tbl_custom_field->label}}" maxlength="30" isRequire="{{$required}}" fieldNameIs="{{ $tbl_custom_field->label }}" rows_id="{{$myCounts}}" {{ $required }} onkeydown="return false">

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
							<!-- End Custom Field -->

								<input type="hidden" name="_token" value="{{csrf_token()}}">
				 
								<div class="form-group">
									<div class="col-md-12 col-sm-12 col-xs-12 text-center">
										<a class="btn btn-primary" href="{{ URL::previous() }}">{{ trans('app.Cancel')}}</a>
										<button type="submit" class="btn btn-success salesAddSubmitButton">{{ trans('app.Submit')}}</button>
									</div>
								</div>

							</form>
						</div>
						
					 <!-- Color Add or Remove Model-->
							<div class="col-md-6 col-sm-12 col-xs-12">
								<div id="responsive-modal-color" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
												<h4 class="modal-title">{{ trans('app.Color')}}</h4>
											</div>
											<div class="modal-body">
												<form class="form-horizontal" action="" method="">
													<table class="table colornametype"  align="center" style="width:40em">
														<thead>
														<tr>
															<td class="text-center"><strong>{{ trans('app.Color Name')}}</strong></td>
															<td class="text-center"><strong>{{ trans('app.Action')}}</strong></td>
														</tr>
														</thead>
														<tbody>
														@if(!empty($color))
															@foreach ($color as $colors)
															<tr class="del-{{$colors->id }} data_color_name" >
															<td class="text-center ">{{ $colors->color }}</td>
															<td class="text-center">
															
															<button type="button" colorid="{{ $colors->id }}" deletecolor="{!! url('sales/colortypedelete') !!}" class="btn btn-danger btn-xs colordelete">X</button>
															</td>
															</tr>
															@endforeach
														@endif
														</tbody>
													</table>
													
													<div class="col-md-8 form-group data_popup">
														<label>{{ trans('app.Color Name')}}: <span class="text-danger">*</span></label>
														<input type="text" class="form-control c_name" name="c_name" maxlength="30"  placeholder="{{ trans('app.Enter color name')}}" />
													</div>
													
													<div class="col-md-4 form-group data_popup" style="margin-top:24px;">
															<button type="button" class="btn btn-success addcolor" colorurl="{!! url('sales/color_name_add') !!}">{{ trans('app.Submit')}}</button>
													</div>
												</form>
											</div>
										</div>
									</div>
								</div>
							</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<!-- /page content -->


<!-- Scripts starting -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="{{ URL::asset('vendors/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ URL::asset('vendors/moment/min/moment.min.js') }}"></script>
<script src="{{ URL::asset('vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ URL::asset('vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>

<script>
$(document).ready(function()
{

	/*Function For validate Quantity textbox field Solved by Mukesh [Buglist row number: 586]*/
    $('input[name=qty]').keyup(function(){
        $(this).val($(this).val().replace(/[^\d]/,''));
    });


	$(function()
	{		
		$('#vehicale_select').change(function(){
		
			var vehicale_id = $(this).val();
			var url = $(this).attr('url');
			var qty= $('#qty').val();
			var msg12 = "{{ trans('app.An error occurred :')}}";

			$.ajax({
				type: 'GET',
				url: url,
				data : {vehicale_id:vehicale_id},
			
				success: function (response)
				{	
					var res_cust = jQuery.parseJSON(response);
					var price_dta = res_cust.price;
					$('#price').attr('value',res_cust.price);
						
					total_price =  price_dta * 1;
					$('#total_price').val(total_price);								
				},
				beforeSend:function()
				{
					$('#price').attr('value','Loading...');
				},
				error: function(e) 
				{
					alert(msg12 + " " + e.responseText);
					console.log(e);
				}
			});
		});
		

		$('#vehicale_select').change(function(){
			
			var url = $(this).attr('chasisurl');
			var	modelname = $('option:selected', this).attr('modelname');
			var	vehicle_id = $('option:selected', this).val();
			var msg13 = "{{ trans('app.An error occurred :')}}";

			$.ajax({
				type: 'GET',
				url: url,
				data : {modelname:modelname,vehicle_id:vehicle_id},			
				success: function (response)
				{	
					$('#chassis_num').html(response);
				},
			    beforeSend:function()
				{
					$('#price').attr('value','Loading...');
				},
			    error: function(e) 
				{
					alert(msg13 + " " + e.responseText);
					console.log(e);
				}
			});
		});
	});

		
	$('.veh_brand').change(function(){
		
		var url = $(this).attr('bran_url');
		var brand_name = $(this).val();
		var msg14 = "{{ trans('app.Somthing went wrong')}}";

		$.ajax({
			type : 'GET',
			url : url,
			data : {brand_name:brand_name},				
			success:function(response){					
				$('.modelnm').remove();
				$('.selectmodel').append(response);
			},
			error:function(e){
				alert(msg14 + " : " + e.responseText);
				console.log(e);
			},				
		});			
	});		


 	$('body').on('keyup','#qty',function(){
			
        var qty= $('#qty').val();
		var price= $('#price').val();
		var url = $(this).attr('url');
		var msg11 = "{{ trans('app.An error occurred :')}}";

		$.ajax({
			type: 'GET',
			url: url,
			data : {qty:qty,price:price},
			success: function (response)
			{	
				total_price =  price * 1;
				$('#total_price').val(total_price);
			},
			beforeSend:function()
			{
					
			},
		    error: function(e) 
			{
				alert(msg11 + " " + e.responseText);
				console.log(e);
			}
		});
    });



	$("#no_of_service").change(function(){
		
		var interval=$("#interval").val();
		var date_gape=$("#date_gape").val();
		var no_service=$("#no_of_service").val();
		var url = $(this).attr('url');

		var msg1 = "{{ trans('app.Interval')}}";
		var msg2 = "{{ trans('app.Please select interval!')}}";
		var msg3 = "{{ trans('app.An error occurred :')}}";
		
		if(interval!='' || date_gape!='' || no_service!='')
		{				
			if($("#interval").val() == '')
			{
			  	swal({   
					title: msg1,
					text: msg2
				});
			  
			  	$('#no_of_service').html(
									'<option value="0">No of service </option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option>');
			  	return false;
			}
		 
			if(interval!='' && date_gape!='' && no_service!='') 
			{
		 
				$("#date_gape").change(function(){
					$("#load_service_data").css("display", "none");
					
					$('#no_of_service').html('<option value="0">No of service </option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option>');				  
				});
				
				$("#interval").change(function(){
					$("#load_service_data").css("display", "none");
					
					$('#no_of_service').html('<option value="0">No of service </option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option>');				 
				});
									
				$("#no_of_service").change(function(){
					$("#load_service_data").css("display", "block");
				});
		 
				$.ajax({
                   	type: 'GET',
                  	url: url,
                 	data : {interval:interval,date_gape:date_gape,no_service:no_service},
                 	success: function (response)
                    {
						$("#load_service_data").html(response);
					},
                	error: function(e) 
                	{
               			alert(msg3 + " " + e.responseText);
                		console.log(e);
            		},
					beforeSend:function(){
						$("#load_service_data").html("<center><h3>Loading...</h3></center>");
					}				
				});
			}
		}			
	});



	/*color add  model*/
	$('.addcolor').click(function(){
		
		var c_name = $('.c_name').val();
		var url = $(this).attr('colorurl');

		var msg4 = "{{ trans('app.Please enter color name')}}";
		var msg5 = "{{ trans('app.This Record is Duplicate')}}";
		var msg6 = "{{ trans('app.An error occurred :')}}";
		
		if(c_name == ""){
            swal(msg4);
        }
        else
        {
			$.ajax({
				
			    type: 'GET',
				url: url,
				data : {c_name:c_name},
				success:function(data)
				{
					var newd = $.trim(data);
				    var classname = 'del-'+newd;
					if(data == '01')
					{
						swal(msg5);
					}
					else
					{
						$('.colornametype').append('<tr class="'+classname+' data_color_name"><td class="text-center">'+c_name+'</td><td class="text-center"><button type="button" colorid='+data+' deletecolor="{!! url('sales/colortypedelete') !!}" class="btn btn-danger btn-xs colordelete">X</button></a></td><tr>');
						
						$('.color_name_data').append('<option value='+data+'>'+c_name+'</option>');
						$('.c_name').val('');
					}
				},
				error: function(e) 
				{
                 	alert(msg6 + " " + e.responseText);
                    console.log(e);
                }
            });
		}
    });



	/*color Delete  model*/
	$('body').on('click','.colordelete',function(){
			
		var colorid = $(this).attr('colorid');
		var url = $(this).attr('deletecolor');

		var msg1 = "{{ trans('app.Are You Sure?')}}";
	    var msg2 = "{{ trans('app.You will not be able to recover this data afterwards!')}}";
	    var msg3 = "{{ trans('app.Cancel')}}";
	    var msg4 = "{{ trans('app.Yes, delete!')}}";
	    var msg5 = "{{ trans('app.Done!')}}";
	    var msg6 = "{{ trans('app.It was succesfully deleted!')}}";
	    var msg7 = "{{ trans('app.Cancelled')}}";
	    var msg8 = "{{ trans('app.Your data is safe')}}";

		swal({
			title: msg1,
            text: msg2,   
            type: "warning",   
            showCancelButton: true, 
            cancelButtonText: msg3, 
            cancelButtonColor: "#C1C1C1",
            confirmButtonColor: "#297FCA",   
            confirmButtonText: msg4,   
            closeOnConfirm: false
			},
			function(isConfirm)
			{
				if (isConfirm) 
				{
					$.ajax({
						type:'GET',
						url:url,
						data:{colorid:colorid},
						success:function(data)
						{
							$('.del-'+colorid).remove();
							$(".color_name_data option[value="+colorid+"]").remove();
							swal(msg5, msg6,"success");
						}
					});
				}
				else
				{
					swal(msg7, msg8, "error");
				} 
		})		
	});



	/*datetimepicker*/
    $('.datepicker').datetimepicker({
        format: "<?php echo getDatepicker(); ?>",
		autoclose: 1,
		minView: 2,
    });



	/*Using Slect2 make auto searchable dropdown*/
	/*$(document).ready(function () {
 		
 		var sendUrl = '{{ url('service/customer_autocomplete_search') }}';
    
    	$('.select_customer_auto_search').select2({
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
    	});
	});*/

   	// Initialize select2
   	$(".select_customer_auto_search").select2();



	/*If select box have value then error msg and has error class remove*/
	$('body').on('change','.salesDate',function(){

		var dateValue = $(this).val();

		if (dateValue != null) {
			$('#sales_date-error').css({"display":"none"});
		}

		if (dateValue != null) {
			$(this).parent().parent().removeClass('has-error');
		}
	});


	$('.customer_name').on('change',function(){

		var customerValue = $('select[name=cus_name]').val();
		
		if (customerValue != null) {
			$('#supplier_select-error').css({"display":"none"});
		}

		if (customerValue != null) {
			$(this).parent().parent().removeClass('has-error');
		}
	});


	/*Custom Field manually validation*/
	var msg31 = "{{ trans('app.field is required')}}";
	var msg32 = "{{ trans('app.Only blank space not allowed')}}";
	var msg33 = "{{ trans('app.Special symbols are not allowed.')}}";
	var msg34 = "{{ trans('app.At first position only alphabets are allowed.')}}";

	/*Form submit time check validation for Custom Fields */
	$('body').on('click','.salesAddSubmitButton',function(e){
		$('#vehicleSalesAddForm input, #vehicleSalesAddForm select, #vehicleSalesAddForm textarea').each(

		    function(index)
		    {  
		        var input = $(this);
		      
		        if (input.attr('name') == "date" || input.attr('name') == "cus_name" || input.attr('name') == "salesmanname" || input.attr('name') == "vehi_bra_name"  || input.attr('name') == "vehicale_name" || input.attr('name') == "color" || input.attr('name') == "price") {
		        	if (input.val() == "") 
		        	{
		        		return false;
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
							$('.error_customfield_main_div_'+ids).removeClass('has-error');
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
});
</script>


<!-- Form field validation -->
{!! JsValidator::formRequest('App\Http\Requests\StoreVehicleSaleAddEditFormRequest', '#vehicleSalesAddForm'); !!}
<script type="text/javascript" src="{{ asset('public/vendor/jsvalidation/js/jsvalidation.js') }}"></script>

<!-- Form submit at a time only one -->
<script type="text/javascript">
    /*$(document).ready(function () {
        $('.salesAddSubmitButton').removeAttr('disabled'); //re-enable on document ready
    });
    $('.salesAddForm').submit(function () {
        $('.salesAddSubmitButton').attr('disabled', 'disabled'); //disable on any form submit
    });

    $('.salesAddForm').bind('invalid-form.validate', function () {
      $('.salesAddSubmitButton').removeAttr('disabled'); //re-enable on form invalidation
    });*/
</script>

@endsection