@extends('layouts.app')
@section('content')

<style>
	.select2-container { width: 100% !important; }
</style>

<!-- page content -->
<div class="right_col" role="main">
    <div class="page-title">
        <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i><span class="titleup">&nbsp {{ trans('app.Product')}}</span></a>
              </div>
                  @include('dashboard.profile')
            </nav>
          </div>
    </div>
	<div class="x_content">
        <ul class="nav nav-tabs bar_tabs" role="tablist">
        	@can('product_view')
				<li role="presentation" class=""><a href="{!! url('/product/list')!!}"><span class="visible-xs"></span><i class="fa fa-list fa-lg">&nbsp;</i> {{ trans('app.Product List')}}</a></li>
			@endcan
			
			@can('product_add')
				<li role="presentation" class="active"><a href="{!! url('/product/add')!!}"><span class="visible-xs"></span><i class="fa fa-plus-circle fa-lg">&nbsp;</i><b>{{ trans('app.Add Product')}}</b></a></li>
			@endcan
		</ul>
	</div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_content">
                   <form id="productAdd-Form" method="post" action="{{ url('/product/store') }}" enctype="multipart/form-data"  class="form-horizontal upperform productAddForm">
                       	<div class="form-group">							
							<div class="">
								<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Product Number')}} <label class="color-danger">*</label></label>
								<div class="col-md-4 col-sm-4 col-xs-12">
								
									<input type="text" id="p_no" name="p_no"  class="form-control" value="{{$code}}" placeholder="{{ trans('app.Enter Product No')}}" readonly>
								</div>
							</div>

							<div class="my-form-group">
								<label class="control-label col-md-2 col-sm-2 col-xs-12" for="last-name">{{ trans('app.Product Date')}} <label class="color-danger">*</label></label>
								<div class="col-md-4 col-sm-4 col-xs-12 input-group date datepicker">
									<span class="input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
									<input type="text" id="p_date" name="p_date" autocomplete="off" class="form-control productDate" value="{{ old('p_date') }}" placeholder="<?php echo getDatepicker();?>" onkeypress="return false;">
								</div>
							</div>						
                      	</div>

                       	<div class="form-group">
							<div class="my-form-group">
								<label class="control-label col-md-2 col-sm-2 col-xs-12" for="last-name">{{ trans('app.Name')}} <label class="color-danger">*</label></label>
								<div class="col-md-4 col-sm-4 col-xs-12">
									<input type="text" id="name" name="name" class="form-control" placeholder="{{ trans('app.Enter Product Name')}}" value="{{ old('name') }}" maxlength="30" required>
								</div>
							</div>

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

						<div class="form-group">
							<div class="">
								<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Manufacturer Name')}}</label>
								<div class="col-md-2 col-sm-2 col-xs-12">
									<select id="p_type" name="p_type"  class="form-control product_type_data">
										<option value="">--{{ trans('app.Select Manufacturing Name')}}--</option>
											@if(!empty($product))
												@foreach($product as $products)
													<option value="{{ $products->id }}">{{ $products->type }}</option>
												@endforeach
											@endif
									</select>
								</div>
								<div class="col-md-2 col-sm-2 col-xs-12 addremove">
									<button type="button" data-target="#responsive-modal" data-toggle="modal" class="btn btn-default">{{ trans('app.Add Or Remove')}}</button>
								</div>
							</div>

							<div class="{{ $errors->has('price') ? ' has-error' : '' }} my-form-group">
								<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Price')}} (<?php echo getCurrencySymbols(); ?>) <label class="color-danger">*</label></label>
								<div class="col-md-4 col-sm-4 col-xs-12">
									<input type="text" id="price" name="price"  class="form-control" placeholder="{{ trans('app.Enter Product Price')}}" value="{{ old('price') }}" maxlength="10" required>
									 @if ($errors->has('price'))
								   <span class="help-block">
									   <strong>{{ $errors->first('price') }}</strong>
								   </span>
								 @endif
								</div>
							</div>
						</div>

						<div class="form-group">
						    <div class="">
								<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Color Name')}}</label>
								<div class="col-md-2 col-sm-2 col-xs-12">
									<select id="color_type" name="color"  class="form-control color_name_data">
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

							<div class="">
								<label class="control-label col-md-2 col-sm-2 col-xs-12" for="last-name">{{ trans('app.Warranty')}}</label>
								<div class="col-md-4 col-sm-4 col-xs-12">
									<input type="text" id="warranty" name="warranty" class="form-control" placeholder="{{ trans('app.Enter Product Warranty')}}" value="{{ old('warranty') }}" maxlength="20">
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="my-form-group">
								<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Unit Of Measurement')}} <label class="color-danger">*</label></label>
								<div class="col-md-2 col-sm-2 col-xs-12">
									<select  name="unit"  class="form-control unit_product_data" required>
										<option value="">{{ trans('app.-- Select Unit --')}}</option>
										@foreach($unitproduct as $tbl_product_unit)
											<option value="{{$tbl_product_unit->id}}">{{$tbl_product_unit->name}}
										@endforeach
										</option>
									</select>
								</div>
								<div class="col-md-2 col-sm-2 col-xs-12 addremove">
									<button type="button" data-target="#responsive-modal-unit" data-toggle="modal" class="btn btn-default">{{ trans('app.Add Or Remove')}}</button>
								</div>
							</div>

							<div class="my-form-group">
								<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Supplier')}} <label class="color-danger">*</label></label>
								<div class="col-md-4 col-sm-4 col-xs-12">
									<select  id="sup_id" name="sup_id"  class="form-control select_supplier_auto_search supplierDataFill">
									<option value="">{{ trans('app.-- Select Supplier --')}}</option>
									@if(!empty($supplier))
										@foreach ($supplier as $suppliers)
											<option value="{{ $suppliers->id }}">{{ $suppliers->company_name }}</option>
										@endforeach
									@endif
									</select>
								</div>
							</div>
						</div>

						<div class="form-group">														
							<div class="my-form-group">
								<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Product Image')}} </label>
								<div class="col-md-4 col-sm-4 col-xs-12">
									<input type="file" id="input-file-max-fs"  name="image"  class="form-control dropify" data-max-file-size="5M">
									<div class="dropify-preview">
										<span class="dropify-render"></span>
											<div class="dropify-infos">
												<div class="dropify-infos-inner">
													<p class="dropify-filename">
														<span class="file-icon"></span> 
														<span class="dropify-filename-inner"></span>
													</p>
												</div>
											</div>
									</div>
								</div>
							</div>							
						</div>
						
						<!-- <div class="form-group categoryMainDiv">
							<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
								<label class="control-label col-md-4 col-sm-4 col-xs-12"> {{ trans('app.Category') }} <label class="color-danger">*</label></label>
								<div class="col-md-8 col-sm-8 col-xs-12 gender">
									<input type="radio" name="category" value="0" checked="" required>{{ trans('app.Vehicle') }}
									<input type="radio" name="category" value="1"> {{ trans('app.Part') }}
								</div>
							</div>
						</div> -->

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
                          		<button type="submit" class="btn btn-success productSubmitButton">{{ trans('app.Submit')}}</button>
                        	</div>
                      	</div>
                    </form>
                </div>
				

				<!-- product type Add or Remove Model-->	
				 <div class="col-md-6">
							<div id="responsive-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
								<div class="modal-dialog">
								<div class="modal-content">
								  <div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
									<h4 class="modal-title">{{ trans('app.Manufacturer Name')}}</h4>
								  </div>
								  <div class="modal-body">
								   <form class="form-horizontal" action="" method="">
										<table class="table producttype"  align="center" style="width:40em">
										<thead>
										<tr>
											<td class="text-center"><strong>{{ trans('app.Manufacturer Name')}}</strong></td>
											<td class="text-center"><strong>{{ trans('app.Action')}}</strong></td>
										</tr>
										</thead>
										<tbody>
										@foreach ($product as $products)
										<tr class="del-{{$products->id }} data_of_type" >
										<td class="text-center ">{{ $products->type }}</td>
										<td class="text-center">
										<button type="button" productid="{{ $products->id }}" deleteproduct="{!! url('prodcttypedelete') !!}" class="btn btn-danger btn-xs deleteproducted">X</button>
										</td>
										</tr>
										@endforeach
										</tbody>
										</table>
										 <div class="col-md-8 form-group data_popup">
											<label>{{ trans('app.Manufacturer Name')}}: <span class="text-danger">*</span></label>
												<input type="text" class="form-control product_type" name="product_type"  placeholder="{{ trans('app.Manufacturer Name')}}" maxlength="30" />
										</div>
										<div class="col-md-4 form-group data_popup" style="margin-top:24px;">
												<button type="button" class="btn btn-success addtype" producturl="{!! url('/product_type_add') !!}">{{ trans('app.Submit')}}</button>
										</div>
									</form>
								</div>
							  </div>
							</div>
						</div>
				</div>

				<!-- Color Add or Remove Model-->
					<div class="col-md-6">
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
										@foreach ($color as $colors)
										<tr class="del-{{$colors->id }} data_color_name" >
										<td class="text-center ">{{ $colors->color }}</td>
										<td class="text-center">
										
										<button type="button" id="{{ $colors->id }}" deletecolor="{!! url('colortypedelete') !!}" class="btn btn-danger btn-xs deletecolors">X</button>
										</td>
										</tr>
										@endforeach
										</tbody>
										</table>
										 <div class="col-md-8 form-group data_popup">
											<label>{{ trans('app.Color Name')}}: <span class="text-danger">*</span></label>
												<input type="text" class="form-control c_name" name="c_name"  placeholder="{{ trans('app.Enter color name')}}" maxlength="20" />
										</div>
										<div class="col-md-4 form-group data_popup" style="margin-top:24px;">
												<button type="button" class="btn btn-success addcolor" colorurl="{!! url('/color_name_add') !!}">{{ trans('app.Submit')}}</button>
										</div>
									</form>
								</div>
								</div>
							 </div>
		                    </div>
					</div>
					
					<!-- Unit Add or Remove Model-->
					<div class="col-md-6">
							<div id="responsive-modal-unit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
								<div class="modal-dialog">
								<div class="modal-content">
								  <div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
									<h4 class="modal-title">{{ trans('app.Unit Of Measurement')}}</h4>
								  </div>
								   <div class="modal-body">
								   <form class="form-horizontal" action="" method="" >
										<table class="table unitproductname"  align="center" style="width:40em">
										<thead>
										<tr>
											<td class="text-center"><strong>{{ trans('app.Unit Name')}}</strong></td>
											<td class="text-center"><strong>{{ trans('app.Action')}}</strong></td>
										</tr>
										</thead>
										<tbody>
										@foreach ($unitproduct as $unitproducts)
										<tr class="delete-{{$unitproducts->id }} data_unit_name" >
										<td class="text-center ">{{ $unitproducts->name }}</td>
										<td class="text-center">
										<button type="button" unitid="{{ $unitproducts->id }}" u_url="{!! url('product/unitdelete') !!}" class="btn btn-danger btn-xs unitdelete">X</button>
										</td>
										</tr>
										@endforeach
										</tbody>
										</table>
										<div class="form-group" style="margin-top:20px;">
											<div class="col-md-10 form-group data_popup">
												<label>{{ trans('app.Unit Of Measurement')}}: <span class="text-danger">*</span></label>
												<input type="text" class="form-control u_name" name="unit_measurement"  placeholder="{{ trans('app.Enter Unit Of Measurement')}}" maxlength="30" />
											</div>
											<div class="col-md-2 form-group data_popup" style="margin-top:24px;">
												<button type="button" class="btn btn-success addunit" uniturl="{!! url('product/unit') !!}">{{ trans('app.Submit')}}</button>
											</div>
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
<!-- /page content -->



<!-- Scripts starting --> 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="{{ URL::asset('vendors/moment/min/moment.min.js') }}"></script>
<script src="{{ URL::asset('vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ URL::asset('vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>

<script>
$(document).ready(function()
{
	$('.datepicker').datetimepicker({
		format: "<?php echo getDatepicker(); ?>",
		autoclose: 1,
		minView: 2,
	});

	//Basic
    $('.dropify').dropify();

    // Translated
    $('.dropify-fr').dropify({
        messages: {
            default: 'Glissez-déposez un fichier ici ou cliquez',
            replace: 'Glissez-déposez un fichier ou cliquez pour remplacer',
            remove:  'Supprimer',
            error:   'Désolé, le fichier trop volumineux'
        }
    });

    // Used events
    var drEvent = $('#input-file-events').dropify();

    drEvent.on('dropify.beforeClear', function(event, element){
        return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
    });

    drEvent.on('dropify.afterClear', function(event, element){
        alert('File deleted');
    });

    drEvent.on('dropify.errors', function(event, element){
        console.log('Has Errors');
    });

    var drDestroy = $('#input-file-to-destroy').dropify();
    drDestroy = drDestroy.data('dropify')
    $('#toggleDropify').on('click', function(e){
        e.preventDefault();
        if (drDestroy.isDropified()) {
            drDestroy.destroy();
        } else {
            drDestroy.init();
        }
    });


    var msg17 = "{{ trans('app.Please enter only alphanumeric data')}}";
    var msg18 = "{{ trans('app.Only blank space not allowed')}}";
    var msg19 = "{{ trans('app.This Record is Duplicate')}}";
    var msg20 = "{{ trans('app.An error occurred :')}}";

	/*color add  model*/
	$('.addcolor').click(function()
	{	
		var c_name = $('.c_name').val();
		var url = $(this).attr('colorurl');

		var msg16 = "{{ trans('app.Please enter color name')}}";
	    
		function define_variable()
		{
			return {
				addcolor_value: $('.c_name').val(),
				addcolor_pattern: /^[a-zA-Z0-9\u0621-\u064A\u00C0-\u017F\u0600-\u06FF\u0750-\u077F\uFB50-\uFDFF\uFE70-\uFEFF\u2E80-\u2FD5\u3190-\u319f\u3400-\u4DBF\u4E00-\u9FCC\uF900-\uFAAD\u0900-\u097F\s]+$/,
				addcolor_pattern2: /^[a-zA-Z0-9\u0621-\u064A\u00C0-\u017F\u0600-\u06FF\u0750-\u077F\uFB50-\uFDFF\uFE70-\uFEFF\u2E80-\u2FD5\u3190-\u319f\u3400-\u4DBF\u4E00-\u9FCC\uF900-\uFAAD\u0900-\u097F\s]*$/
			};
		}
		
		var call_var_addcoloradd = define_variable();		 

        if(c_name == ""){
            swal(msg16);
        }
        else if (!call_var_addcoloradd.addcolor_pattern.test(call_var_addcoloradd.addcolor_value))
		{
			$('.c_name').val("");
			swal(msg17);
		}
        else if(!c_name.replace(/\s/g, '').length){
			$('.c_name').val("");
        	swal(msg18);
	    }
	    else if (!call_var_addcoloradd.addcolor_pattern2.test(call_var_addcoloradd.addcolor_value)){
			$('.c_name').val("");
        	swal(msg34);
		}
        else
        {
			$.ajax({
		    	type: 'GET',
				url: url,
				data : {c_name:c_name},

				//Form submit at a time only one for addColorModel
	   			beforeSend : function () {
	 				$(".addcolor").prop('disabled', true);
	 			},
				
				success: function(data)
				{
				   	var newd = $.trim(data);
			        var classname = 'del-'+newd;

					if(data == '01')
					{
						swal(msg19);
					}
					else
					{
						$('.colornametype').append('<tr class="'+classname+' data_color_name"><td class="text-center">'+c_name+'</td><td class="text-center"><button type="button" id='+data+' deletecolor="{!! url('colortypedelete') !!}" class="btn btn-danger btn-xs deletecolors">X</button></a></td><tr>');
							
						$('.color_name_data').append('<option value='+data+'>'+c_name+'</option>');
							
						$('.c_name').val('');
					}

					//Form submit at a time only one for addColorModel
					$(".addcolor").prop('disabled', false);
					return false;
				},
				error: function(e) {
             			alert(mag20 + ' ' + e.responseText);
                		console.log(e);
            	}	  
	        });
		}
    });


	var msg1 = "{{ trans('app.Are You Sure?')}}";
    var msg2 = "{{ trans('app.You will not be able to recover this data afterwards!')}}";
    var msg3 = "{{ trans('app.Cancel')}}";
    var msg4 = "{{ trans('app.Yes, delete!')}}";
    var msg5 = "{{ trans('app.Done!')}}";
    var msg6 = "{{ trans('app.It was succesfully deleted!')}}";
    var msg7 = "{{ trans('app.Cancelled')}}";
    var msg8 = "{{ trans('app.Your data is safe')}}";

	/*color Delete  model*/
	$('body').on('click','.deletecolors',function()
	{
		var colorid = $(this).attr('id');
		var url = $(this).attr('deletecolor');

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
			if (isConfirm) {
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
			}else{
				swal(msg7, msg8, "error");
			} 
		})
	});


	/*Product type add add  model*/
	$('.addtype').click(function()
	{		
		var product_type = $('.product_type').val();
		var url = $(this).attr('producturl');

		var msg21 = "{{ trans('app.Please enter product type')}}";
	    /*var msg22 = "{{ trans('app.Please enter only alphanumeric data')}}";
	    var msg23 = "{{ trans('app.Only blank space not allowed')}}";
	    var msg24 = "{{ trans('app.This Record is Duplicate')}}";*/
	    //var msg25 = "{{ trans('app.An error occurred :')}}";
		
		function define_variable()
		{
			return {
				product_type_value: $('.product_type').val(),
				product_type_pattern: /^[a-zA-Z0-9\u0621-\u064A\u00C0-\u017F\u0600-\u06FF\u0750-\u077F\uFB50-\uFDFF\uFE70-\uFEFF\u2E80-\u2FD5\u3190-\u319f\u3400-\u4DBF\u4E00-\u9FCC\uF900-\uFAAD\u0900-\u097F\s]+$/,
				product_type_pattern2: /^[a-zA-Z0-9\u0621-\u064A\u00C0-\u017F\u0600-\u06FF\u0750-\u077F\uFB50-\uFDFF\uFE70-\uFEFF\u2E80-\u2FD5\u3190-\u319f\u3400-\u4DBF\u4E00-\u9FCC\uF900-\uFAAD\u0900-\u097F\s]*$/
			};
		}
		
		var call_var_product_typeadd = define_variable();		 

        if(product_type == ""){
            swal(msg21);
        }
        else if (!call_var_product_typeadd.product_type_pattern.test(call_var_product_typeadd.product_type_value))
		{
			$('.product_type').val("");
			swal(msg17);
		}
        else if(!product_type.replace(/\s/g, '').length){
			$('.product_type').val("");
        	swal(msg18);
	    }
	    else if (!call_var_product_typeadd.product_type_pattern2.test(call_var_product_typeadd.product_type_value)){
			$('.product_type').val("");
        	swal(msg34);
		}
        else
        {
            $.ajax({                       
                type: 'GET',
				url: url,
				data : {product_type:product_type},

				//Form submit at a time only one for addProductType(Manufacture Name)
	   			beforeSend : function () {
	 				$(".addtype").prop('disabled', true);
	 			},
				success:function(data)			 
                {
					var newd = $.trim(data);
				    var classname = 'del-'+newd;
							   
					if(data == '01')
					{
						swal(msg19);
					}
					else
					{
						$('.producttype').append('<tr class="'+classname+' data_of_type"><td class="text-center">'+product_type+'</td><td class="text-center"><button type="button" productid='+data+' deleteproduct="{!! url('prodcttypedelete') !!}" class="btn btn-danger btn-xs deleteproducted">X</button></a></td><tr>');
								
						$('.product_type_data').append('<option value='+data+'>'+product_type+'</option>');
									
						$('.product_type').val('');
					}

					//Form submit at a time only one for addProductType(Manufacture Name)
					$(".addtype").prop('disabled', false);
					return false;
				},                   	
                error: function(e) 
                {
                 	alert(msg20 + " " + e.responseText);
                    console.log(e);
                }
       		});            
        }		
	});


	/*Product Type Delete  model*/
	$('body').on('click','.deleteproducted',function()
	{
		var ptypeid = $(this).attr('productid');
		var url = $(this).attr('deleteproduct');
					
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
        function(isConfirm){
			if (isConfirm) 
			{				
				$.ajax({
					type:'GET',
					url:url,
					data:{ptypeid:ptypeid},
					success: function () {
						$('.del-'+ptypeid).remove();
						$(".product_type_data option[value="+ptypeid+"]").remove();
						 
						swal(msg5, msg6,"success");
					}
				});
			}else{
				swal(msg7, msg8, "error");
			} 
		})		
	});


	/*Unit add  model*/
	$('.addunit').click(function()
	{		
		var unit_measurement = $('.u_name').val();		
		var url = $(this).attr('uniturl');

		var msg9 = "{{ trans('app.Please enter unit of measurement')}}";

		function define_variable()
		{
			return {
				unit_measurement_value: $('.u_name').val(),
				unit_measurement_pattern: /^[a-zA-Z0-9\u0621-\u064A\u00C0-\u017F\u0600-\u06FF\u0750-\u077F\uFB50-\uFDFF\uFE70-\uFEFF\u2E80-\u2FD5\u3190-\u319f\u3400-\u4DBF\u4E00-\u9FCC\uF900-\uFAAD\u0900-\u097F\s]+$/,
				unit_measurement_pattern2: /^[a-zA-Z0-9\u0621-\u064A\u00C0-\u017F\u0600-\u06FF\u0750-\u077F\uFB50-\uFDFF\uFE70-\uFEFF\u2E80-\u2FD5\u3190-\u319f\u3400-\u4DBF\u4E00-\u9FCC\uF900-\uFAAD\u0900-\u097F\s]*$/
			};
		}

		var call_var_unit_measurementadd = define_variable();		 

        if(unit_measurement == ""){
            swal(msg9);
        }
        else if (!call_var_unit_measurementadd.unit_measurement_pattern.test(call_var_unit_measurementadd.unit_measurement_value))
		{
			$('.u_name').val("");
			swal(msg17);
		}
        else if(!unit_measurement.replace(/\s/g, '').length){
			$('.u_name').val("");
        	swal(msg18);
	    }
	    else if (!call_var_unit_measurementadd.unit_measurement_pattern2.test(call_var_unit_measurementadd.unit_measurement_value)){
			$('.u_name').val("");
        	swal(msg34);
	    }
        else
        {
			$.ajax({			    	
		    	type: 'GET',
				url: url,
				data : {unit_measurement:unit_measurement},

				//Form submit at a time only one for addUnitModel
  				beforeSend : function () {
 					$(".addunit").prop('disabled', true);
 				},
				success:function(data)
				{
				   	var newd = $.trim(data);
			        var deleteclass = 'delete-'+newd;
			           
					if(data == '01')
					{
						swal(msg19);
					}
					else
					{
						$('.unitproductname').append('<tr class="'+deleteclass+' data_unit_name"><td class="text-center">'+unit_measurement+'</td><td class="text-center"><button type="button" unitid='+data+' u_url="{!! url('product/unitdelete') !!}" class="btn btn-danger btn-xs unitdelete">X</button></a></td></tr>');
							
						$('.unit_product_data').append('<option value='+data+'>'+unit_measurement+'</option>');
							
						$('.u_name').val('');	
					}

					//Form submit at a time only one for addUnitModel
					$(".addunit").prop('disabled', false);
					return false;         
				},				
				error: function(e) {
             		alert(msg20 + ' ' + e.responseText);
                	console.log(e);
            	}  
	        });
		}
	});

   
   	$('body').on('click','.unitdelete',function()
   	{     	
		var unitid = $(this).attr('unitid');
		var url = $(this).attr('u_url');

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
					data:{unitid:unitid},
					success:function(data){
				
						$('.delete-'+unitid).remove();
						$(".unit_product_data option[value="+unitid+"]").remove();
						swal(msg5, msg6,"success");
					}
					});
			}else{
				swal(msg7, msg8, "error");
			} 
		})
	});

   	/*Using Slect2 make auto searchable dropdown for supplier select*/
   	// Initialize select2
   	$(".select_supplier_auto_search").select2();


	/*If date field have value then error msg and has error class remove*/
	$('body').on('change','.productDate',function()
	{
		var outDateValue = $(this).val();

		if (outDateValue != null) {
			$('#p_date-error').css({"display":"none"});
		}

		if (outDateValue != null) {
			$(this).parent().parent().removeClass('has-error');
		}
	});

	
	/*If select box have value then error msg and has error class remove*/
	$('#sup_id').on('change',function(){

		var supplierValue = $('select[name=sup_id]').val();
		
		if (supplierValue != null) {
			$('#sup_id-error').css({"display":"none"});
		}

		if (supplierValue != null) {
			$(this).parent().parent().removeClass('has-error');
		}
	});

	
	/*If any white space then is is not allowed it*/
   	$('body').on('keyup', '.product_type', function(){

      	var product_typeValue = $(this).val();

      	if (!product_typeValue.replace(/\s/g, '').length) {
         	$(this).val("");
      	}
   	});
   	
   	$('body').on('keyup', '.c_name', function(){

      	var c_nameValue = $(this).val();

      	if (!c_nameValue.replace(/\s/g, '').length) {
         	$(this).val("");
      	}
   	});
   	
   	$('body').on('keyup', '.u_name', function(){

      	var u_nameValue = $(this).val();

      	if (!u_nameValue.replace(/\s/g, '').length) {
         	$(this).val("");
      	}
   	});


	/*Custom Field manually validation*/
	var msg31 = "{{ trans('app.field is required')}}";
	var msg32 = "{{ trans('app.Only blank space not allowed')}}";
	var msg33 = "{{ trans('app.Special symbols are not allowed.')}}";
	var msg34 = "{{ trans('app.At first position only alphabets are allowed.')}}";

	/*Form submit time check validation for Custom Fields */
	$('body').on('click','.productSubmitButton',function(e){
		$('#productAdd-Form input, #productAdd-Form select, #productAdd-Form textarea').each(

		    function(index)
		    {  
		        var input = $(this);
		      
		        if (input.attr('name') == "p_date" || input.attr('name') == "name" || input.attr('name') == "price" || input.attr('name') == "unit"  || input.attr('name') == "sup_id") {
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
{!! JsValidator::formRequest('App\Http\Requests\ProductAddEditFormRequest', '#productAdd-Form'); !!}
<script type="text/javascript" src="{{ asset('public/vendor/jsvalidation/js/jsvalidation.js') }}"></script>


<!-- Form submit at a time only one -->
<script type="text/javascript">
    /*$(document).ready(function () {
        $('.productSubmitButton').removeAttr('disabled'); //re-enable on document ready
    });
    $('.productAddForm').submit(function () {
        $('.productSubmitButton').attr('disabled', 'disabled'); //disable on any form submit
    });

    $('.productAddForm').bind('invalid-form.validate', function () {
      $('.productSubmitButton').removeAttr('disabled'); //re-enable on form invalidation
    });*/
</script>

@endsection