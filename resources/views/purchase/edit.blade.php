<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.4.min.js"></script>  
<script>
$(document).ready(function() {
	$('#tab_taxes_detail').DataTable({
		responsive: false,
		paging: false,
		searching: false,
		ordering: false,
		info: false,
		autoWidth: true,
		sDom: 'lfrtip'
	});
});
</script>

<!-- Solved by Mukesh [Buglist row number: 588] -->
<style>
	.table-condensed {
		font-size: 14px;
	}
	.table-condensed th{
		font-size: 12px;
	}

	.select2-container { width: 100% !important; }
</style>
@extends('layouts.app')
@section('content')

<!-- page content -->
	<div class="right_col" role="main">
		<div class="page-title">
			<div class="nav_menu">
				<nav>
					<div class="nav toggle">
						<a id="menu_toggle"><i class="fa fa-bars"></i><span class="titleup">&nbsp; {{ trans('app.Purchase')}}</span></a>
					</div>
					@include('dashboard.profile')
				</nav>
			</div>
		</div>
		<div class="x_content">
			<ul class="nav nav-tabs bar_tabs" role="tablist">
				@can('purchase_view')
					<li role="presentation" class=""><a href="{!! url('/purchase/list')!!}"><span class="visible-xs"></span><i class="fa fa-list fa-lg">&nbsp;</i> {{ trans('app.Purchase List')}}</a></li>
				@endcan
				@can('purchase_edit')
					<li role="presentation" class="active"><a href="{!! url('/purchase/list/edit/'.$purchase->id)!!}"><span class="visible-xs"></span><i class="fa fa-plus-circle fa-lg">&nbsp;</i><b>{{ trans('app.Edit Purchase')}}</b></a></li>
				@endcan
			</ul>
		</div>
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_content">
						<form id="purchaseEdit-Form" action="update/{{$purchase->id}}"  method="post" enctype="multipart/form-data"  class="form-horizontal upperform">
							<div class="form-group">
								<div class="">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Purchase No')}} <label class="color-danger">*</label></label>
									<div class="col-md-4 col-sm-4 col-xs-12">
									
										<input type="text" id="p_no" name="p_no"  class="form-control" value="{{$purchase->purchase_no}}" readonly>
									</div>
								</div>

								<div class="my-form-group">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="last-name">{{ trans('app.Purchase Date')}} <label class="color-danger">*</label></label>
									<div class="col-md-4 col-sm-4 col-xs-12 input-group date datepicker">										
										<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
										<input type="text" id="pur_date" name="p_date" autocomplete="off" value="{{date(getDateFormat(),strtotime($purchase->date))}}"class="form-control purchaseDate" placeholder="<?php echo getDateFormat();?>" required onkeypress="return false;" />
									</div>
								</div>
							</div>

							<div class="form-group mobileNumberDivPurchasePage" style="margin-top: 15px;">
								<div class="my-form-group">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="last-name">{{ trans('app.Supplier Name')}} <label class="color-danger">*</label></label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<select class="form-control col-md-7 col-xs-12 select_supplier_auto_search" name="s_name" id="supplier_select" url="{!! url('purchase/add/getrecord')!!}" required>
										  <option value="">{{ trans('app.select supplier')}}</option>
										  @if(!empty($supplier))
											@foreach ($supplier as $suppliers)
												<option value="{{ $suppliers->id }}" <?php if($suppliers->id == $purchase->supplier_id){echo"selected";}?>>{{ $suppliers->company_name }}</option>
											@endforeach
										@endif
										</select>
									</div>
								</div>

								<div class="">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Mobile No')}} <label class="color-danger">*</label></label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<input type="text" id="mobile" name="mobile" value="{{$purchase->mobile}}"  class="form-control" placeholder="{{ trans('app.Enter Mobile No')}}" readonly>
									</div>
								</div>
							</div>

							<div class="form-group" style="margin-top: 20px;">
								<div class="">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="last-name">
									{{ trans('app.Email')}} <label class="color-danger">*</label></label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<input type="text" id="email" name="email" class="form-control" value="{{$purchase->email}}" placeholder="{{ trans('app.Enter Email')}}" readonly>
									</div>
								</div>
								<div class="">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="last-name">{{ trans('app.Billing Address')}} <label class="color-danger">*</label></label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<textarea  id="address" name="address" class="form-control"  readonly>{{$purchase->address}}</textarea>
									</div>
								</div>
							</div>

							<div class="form-group" style="margin-top: 20px;">
								<div class="my-form-group">
	                              	<label class="control-label col-md-2 col-sm-2 col-xs-12" for="branch">{{ trans('app.Branch')}} <label class="color-danger">*</label></label>
	                              
	                              	<div class="col-md-4 col-sm-4 col-xs-12">
	                                	<select class="form-control  select_branch" name="branch">
	                                  	@foreach ($branchDatas as $branchData)
											<option value="{{ $branchData->id }}" <?php if($purchase->branch_id==$branchData->id){ echo "selected"; }?>>{{$branchData->branch_name }}</option>
										@endforeach
	                                	</select>
	                              	</div>
	                            </div>
							</div>

							<div class="col-md-12 col-xs-12 col-sm-12 form-group" style="margin-top:20px;">
								<div class="col-md-10 col-sm-8 col-xs-8 header">
									<h4><b>{{ trans('app.Purchase Details')}}</b></h4>
								</div>
								<div class="col-md-2 col-sm-4 col-xs-4">
									<button type="button" id="add_new_product" class="btn btn-default " url="{!! url('purchase/add/getproductname')!!}" style="margin:5px 0px;">{{ trans('app.Add New')}} </button>
								</div>
							</div>
							<div class="col-md-12 col-xs-12 col-sm-12 form-group">
								<table class="table table-bordered adddatatable" id="tab_taxes_detail" align="center" style="font-size:14px;" width="100%">
									<thead>
										<tr>
											<!-- <th class="actionre">{{ trans('app.Category') }}</th> -->
											<th class="actionre">{{ trans('app.Manufacturer Name')}}</th>
											<th class="actionre">{{ trans('app.Product Name')}}</th>
											<th class="actionre">{{ trans('app.Quantity')}}</th>
											<th class="actionre" style="width:10%;">{{ trans('app.Price')}} (<?php echo getCurrencySymbols(); ?>)</th>
											<th class="actionre" style="width:13%;">{{ trans('app.Amount')}} (<?php echo getCurrencySymbols(); ?>)</th>
											<th class="actionre">{{ trans('app.Action')}}</th>
										</tr>
									</thead>
									<tbody>
									<?php $row_id = 0;?>
									@foreach($stock as $stocks)
										<tr id="row_id_<?php echo $row_id;?>">
											<!-- <td>
												<select class="form-control select_categorytype" name="product[category_id][]"
												row_did="{{ $row_id }}" style="width:100%;" data-id="{{ $row_id }}" required>
													<option value="0" <?php if($stocks->category == 0){ echo"selected";} ?> >{{ trans('app.Vehicle')}}</option>
													<option value="1" <?php if($stocks->category == 1){ echo"selected";} ?>>{{ trans('app.Part')}}</option>
												</select>
											</td> -->
											<td class="my-form-group">
												<select class="form-control select_producttype" name="product[Manufacturer_id][]" m_url="{!! url('/purchase/producttype/name') !!}" man_sel_url="{!! url('purchase/getfirstproductdata')!!}" row_id="{{ $row_id }}"
												row_did="{{ $row_id }}" style="width:100%;" data-id="{{ $row_id }}" required>
													<!-- <option value="">-{{ trans('app.Select item')}}-</option> -->
													@if(!empty($Select_product))
													@foreach ($Select_product as $Select_products)
													 <option value="{{ $Select_products->id }}"<?php if($Select_products->id == getproducttyid($stocks->product_id)){ echo"selected";} ?> >{{ $Select_products->type }}</option>
													@endforeach
													@endif
												</select>
											</td>
											<td class="my-form-group">
											<input type="hidden" name="product[tr_id][]" value="<?php echo $stocks->id;?>" class="" form-control" data-id ="<?php echo $row_id;?>"  id="<?php echo $row_id;?>"> 
												<select name="product[product_id][]" class="form-control  productid select_productname_<?php echo $row_id;?>"  url="{!! url('purchase/add/getproduct')!!}" row_did="<?php echo $row_id;?>" data-id="<?php echo $row_id;?>" style="width:100%;" required="required">
													<!-- <option value="">{{ trans('app.Select Product')}}</option> -->
													@if(!empty($product))
														@foreach($product as $products)
															<option value="{{ $products->id }}" <?php if($products->id == $stocks->product_id){ echo"selected";} ?> >{{$products->name}}</option>
														@endforeach
													@endif
												</select>
											</td>
											<td>
												<input type="number" name="product[qty][]" url="{!! url('purchase/add/getqty')!!}" class="quantity form-control qty qty_<?php echo $row_id;?>" id="qty_<?php echo $row_id;?>" row_id="<?php echo $row_id;?>" value="{{$stocks->qty}}" maxlength="8" style="width: 50%;">
												<span class="qty_<?php echo $row_id;?>">{{getProductcode($stocks->product_id)}}</span>
											</td>
											<td>
												<!-- <input type="text" name="product[price][]" class="product form-control prices price_<?php echo $row_id;?>" value="{{$stocks->price}}" id="price_<?php echo $row_id;?>" style="width:100%;"  readonly="true"> -->
												<input type="text" name="product[price][]" class="product form-control prices price_<?php echo $row_id;?>" value="{{$stocks->price}}" id="price_<?php echo $row_id;?>" row_id="<?php echo $row_id;?>" style="width:100%;">
											</td>
											<td>
												<input type="text" name="product[total_price][]" class="product form-control total_price total_price_<?php echo $row_id;?>"  value="{{$stocks->total_amount}}"  id="total_price_<?php echo $row_id;?>" style="width:100%;" readonly="true">
											</td>
											<td align="center">
												<span class="product_delete" data-id="<?php echo $row_id;?>" 
												pid="<?php echo $stocks->id;?>" url="{!! url('purchase/deleteproduct')!!}" ><i class="fa fa-trash fa-2x"></i></span>

											</td>
										</tr>
										<?php 
										$row_id++;?>
									@endforeach
									</tbody>
								</table>
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
									$userid = $purchase->id;
									$datavalue = getCustomDataPurchase($tbl_custom,$userid);

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
															$getRadioValue = getRadioLabelValueForUpdateForAllModules($tbl_custom_field->form_name ,$purchase->id, $tbl_custom_field->id);

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
													$getCheckboxValue = getCheckboxLabelValueForUpdateForAllModules($tbl_custom_field->form_name, $purchase->id, $tbl_custom_field->id);
												?>
												<div class="required_checkbox_parent_div_{{$tbl_custom_field->id}}" style="margin-top: 5px;">
												@foreach($checkboxLabelArrayList as $k => $val)
													<input type="{{$tbl_custom_field->type}}" name="custom[{{$tbl_custom_field->id}}][]" value="{{$val}}" isRequire="{{$required}}" fieldNameIs="{{ $tbl_custom_field->label }}" custm_isd="{{$tbl_custom_field->id}}" class="checkbox_{{$tbl_custom_field->id}} required_checkbox_{{$tbl_custom_field->id}} checkbox_simple_class common_value_is_{{$myCounts}} common_simple_class" rows_id="{{$myCounts}}"

													<?php
													 	if($val == getCheckboxValForAllModule($tbl_custom_field->form_name, $purchase->id, $tbl_custom_field->id,$val)) 
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
								 
								  <div class="form-group" style="margin-top:25px;">
									<div class="col-md-12 col-sm-12 col-xs-12 text-center">
									  <a class="btn btn-primary" href="{{ URL::previous() }}">{{ trans('app.Cancel')}}</a>
									  <button type="submit" class="btn btn-success updatePurchaseButton">{{ trans('app.Update')}}</button>
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

	$('body').on('change','.select_producttype',function()
	{			
		var row_id = $(this).attr('row_did');
		var m_id = $(this).val();
		var url = $(this).attr('m_url');
		
		$.ajax({
			type:'GET',
			url: url,
			data:{ m_id:m_id },
			success:function(response){				
				$('.select_productname_'+row_id).html(response);
			}
		});
	});
	

	$(function()
	{
		$('#supplier_select').change(function()
		{
			var supplier_id = $(this).val();
			var url = $(this).attr('url');

			var msg1 = "{{ trans('app.An error occurred :')}}";
				
			$.ajax({
				type: 'GET',
				url: url,
				data : {supplier_id:supplier_id},
				success: function (response)
				{	
					var res_supplier = jQuery.parseJSON(response);
					$('#mobile').attr('value',res_supplier.mobile_no);
					$('#email').attr('value',res_supplier.email);
					$('#address').text(res_supplier.address);
				},
				beforeSend:function()
				{
					$('#mobile').attr('value','Loading..');
					$('#email').attr('value','Loading..');
					$('#address').attr('value','Loading..');
				},
				error: function(e) 
				{
					alert(msg1 + " " + e.responseText);
					console.log(e);
				}
			});
		});
	});


	$("#add_new_product").click(function()
	{		
		var row_id = $("#tab_taxes_detail > tbody > tr").length;
		var url = $(this).attr('url');
		var msg2 = "{{ trans('app.An error occurred :')}}";
		$.ajax({
            type: 'GET',
            url: url,
            data : {row_id:row_id},
            success: function (response)
            {	
				//$("#tab_taxes_detail > tbody").append(response.html);
				$('#tab_taxes_detail').DataTable().row.add($(response.html)).draw();
				return false;
			},
            error: function(e) {
                alert(msg2 + " " + e.responseText);
                console.log(e);
            }
       	});
	});
	

	$('body').on('click','.product_delete',function()
	{	
		var procuctid = $(this).attr('pid');		
		var row_id = $(this).attr('data-id');		
		var url = $(this).attr('url');
        
		$.ajax({
            type: 'GET',
            url: url,
            data : {procuctid:procuctid},
            success: function (response)
            {	
            	$('table#tab_taxes_detail tr#row_id_'+row_id).remove();	
			},
            error: function(e) 
            {
            }
       	});
    });
	

	$('body').on('change','.productid','.qty',function()
	{		
		var row_id = $(this).attr('row_did');
		var p_id = $(this).val();
		var qty= $('.qty_'+row_id).val();			
		var price= $('.price_'+row_id).val();		
		var url = $(this).attr('url');
		
		$.ajax({
            type: 'GET',
            url: url,
            data : {p_id:p_id},
            success: function (response)
            {	
				var json_obj = jQuery.parseJSON(response);
				var price = json_obj['price'];
				var total_price =  price * qty;
				
				$('.price_'+row_id).val(price);				
				$('.total_price_'+row_id).val(total_price);
				var product_no = json_obj['product_no'];
				$('.qty_'+row_id).html(product_no);
			},
			error: function(e) 
			{
            
            }
       	});
	});


 	$('body').on('change','.qty',function()
 	{
		var row_id = $(this).attr('row_id');
		var p_id = $('.select_productname_'+row_id).val();
		var priceVal = $('.price_'+row_id).val();
		var msg3 = "{{ trans('app.First select product name')}}";
		
		if(p_id == '')
		{
			alert(msg3);
			$('.qty_'+row_id).val('1');
		}
		else if(this.value == ""){
			$('.qty_'+row_id).val('1');
			$('.total_price_'+row_id).val(priceVal * 1);
		}
		else
		{
			if (/\D/g.test(this.value))
			{
				$('.qty_'+row_id).val('1');
				$('.total_price_'+row_id).val(priceVal * 1);
			}
			else
			{
				var qty= $('.qty_'+row_id).val();
				var price= $('.price_'+row_id).val();
				var url = $(this).attr('url');
				
				$.ajax({
					type: 'GET',
					url: url,
					data : {qty:qty,price:price},
					success: function (response)
					{	
						total_price =  price * qty;
						$('.total_price_'+row_id).val(total_price);
					},
					beforeSend:function()
					{
					
					},
					error: function(e) 
					{
					
					}
				});
			}
		}
    });


    $('.datepicker').datetimepicker({
        format: "<?php echo getDatepicker(); ?>",
		autoclose: 1,
		minView: 2,
    });


    /*Using Slect2 make auto searchable dropdown for supplier select*/
   	// Initialize select2
   	$(".select_supplier_auto_search").select2();

	/*Price field should editable and editable price should change the Total-Amount (on-time editable price )*/
  	$('body').on('change','.prices',function()
  	{
     	var row_id = $(this).attr('row_id');
     	var qty = $('.qty_'+row_id).val();
     	var price = $('.price_'+row_id).val();
     	var total_price =  price * qty;

     	if (price == 0 || price == null) {
        	$('.price_'+row_id).val("");
        	$('.price_'+row_id).attr('required', true);
     	}
     	else
     	{
        	$('.price_'+row_id).val(price);
        	$('.total_price_'+row_id).val(total_price);
     	}             
  	});


	/*Select product type time chages all value of selected product*/
  	$('body').on('change','.select_producttype',function(){

  		var row_id = $(this).attr('row_id');
  		var selected_option_value = $(this,':selected').val();      		
  		var url = $(this).attr('man_sel_url');

  		$.ajax({
  			type: "GET",
  			url: url,
  			data:{productTypeId:selected_option_value},
  			success: function(response){
  				//alert(response.success +"----" + response.data +"-----"+response.product_number);
  				if (response.success == 'yes') {
  					$('.price_'+row_id).val(response.data);
  					$('.total_price_'+row_id).val(response.data);
  					$('.qty_'+row_id).val(1);
  					$('.qty_'+row_id).text(response.product_number);
  				}
  			}
  		});     
  	});
   	

	/*Key up time price field should value with 1*/
	$('body').on('keyup','.prices',function(){
	 
		var row_id = $(this).attr('row_id');		
        var price = $('.price_'+row_id).val();
		
		if(price == '')
		{
			$('.price_'+row_id).val(1);
		}
		else
		{
			if (/\D/g.test(this.value))
			{
			    $('.price_'+row_id).val(1);
			}
		}
	});


	/*If date field have value then error msg and has error class remove*/
	$('body').on('change','.purchaseDate',function(){

		var pDateValue = $(this).val();

		if (pDateValue != null) {
			$('#pur_date-error').css({"display":"none"});
		}

		if (pDateValue != null) {
			$(this).parent().parent().removeClass('has-error');
		}
	});


	/*If select box have value then error msg and has error class remove*/
	$('#supplier_select').on('change',function(){

		var supplierValue = $('select[name=s_name]').val();
		
		if (supplierValue != null) {
			$('#supplier_select-error').css({"display":"none"});
		}

		if (supplierValue != null) {
			$(this).parent().parent().removeClass('has-error');
		}
	});


	/*Custom Field manually validation*/
	var msg1 = "{{ trans('app.field is required')}}";
	var msg2 = "{{ trans('app.Only blank space not allowed')}}";
	var msg3 = "{{ trans('app.Special symbols are not allowed.')}}";
	var msg4 = "{{ trans('app.At first position only alphabets are allowed.')}}";

	/*Form submit time check validation for Custom Fields */
	$('body').on('click','.updatePurchaseButton',function(e){
		$('#purchaseEdit-Form input, #purchaseEdit-Form select, #purchaseEdit-Form textarea').each(

		    function(index)
		    {  
		        var input = $(this);

		        if (input.attr('name') == "p_date" || input.attr('name') == "s_name") {
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
});
</script>


<!-- Form field validation -->
{!! JsValidator::formRequest('App\Http\Requests\PurchaseAddEditFormRequest', '#purchaseEdit-Form'); !!}
<script type="text/javascript" src="{{ asset('public/vendor/jsvalidation/js/jsvalidation.js') }}"></script>

@endsection