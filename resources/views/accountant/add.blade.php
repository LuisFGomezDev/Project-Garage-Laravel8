@extends('layouts.app')
@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<!-- page content -->
	<div class="right_col" role="main" style="background-color: #e6e6e6;">
		<div class="">
            <div class="page-title">
              	<div class="nav_menu">
            		<nav>
              			<div class="nav toggle">
                			<a id="menu_toggle"><i class="fa fa-bars"></i><span class="titleup">&nbsp; {{ trans('app.Accountant')}}</span></a>
              			</div>
               			@include('dashboard.profile')
            		</nav>
          		</div>
        	</div>
        </div>
		
		<div class="x_content">
			<ul class="nav nav-tabs bar_tabs tabconatent" role="tablist">
			 	@can('accountant_view')
			 		<li role="presentation" class=""><a href="{!! url('/accountant/list')!!}"><span class="visible-xs"></span><i class="fa fa-list fa-lg ">&nbsp;</i> {{ trans('app.Accountant List') }}</a></li>
			 	@endcan

			 	@can('accountant_add')
			 		<li role="presentation" class="active"><a href="{!! url('/accountant/add')!!}"><span class="visible-xs"></span><i class="fa fa-plus-circle fa-lg">&nbsp;</i> <b>{{ trans('app.Add Accountant') }}</b></a></li>
			 	@endcan
            </ul>
		</div>
        
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                   	<div class="x_content">
                    	<form id="accountant_add_form" action="{!! url('/accountant/store')!!}" method="post" enctype="multipart/form-data" data-parsley-validate class="form-horizontal form-label-left input_mask accountantAddForm">
            				
            				<div class="col-md-12 col-xs-12 col-sm-12 space">
            					<h4><b>{{ trans('app.Personal Information')}}</b></h4>
            					<p class="col-md-12 col-xs-12 col-sm-12 ln_solid"></p>
            				</div>
                        
                        	<div class="col-md-12 col-sm-6 col-xs-12">     
                         		<div class="col-md-6 col-sm-6 col-xs-12 form-group my-form-group has-feedback {{ $errors->has('firstname') ? ' has-error' : '' }}">
                          		
                          			<label class="control-label col-md-4 col-sm-4 col-xs-12" for="firstname">{{ trans('app.First Name') }} <label class="color-danger">*</label></label>
                          			
                          			<div class="col-md-8 col-sm-8 col-xs-12">
                            			<input type="text" id="firstname" name="firstname"  class="form-control" value="{{ old('firstname') }}" placeholder="{{ trans('app.Enter First Name')}}" maxlength="50">
                            
                            			
                            			@if ($errors->has('firstname'))
                             				<span class="help-block">
                               					<strong>{{ $errors->first('firstname') }}</strong>
                             				</span>
                           				@endif
                        			</div>
                      			</div>

                      			<div class="col-md-6 col-sm-6 col-xs-12 form-group my-form-group has-feedback {{ $errors->has('lastname') ? ' has-error' : '' }}">
                        			<label class="control-label col-md-4 col-sm-4 col-xs-12" for="lastname">{{ trans('app.Last Name') }} <label class="color-danger">*</label></label>
                        			
                        			<div class="col-md-8 col-sm-8 col-xs-12">
                          				<input type="text" id="lastname" name="lastname" placeholder="{{ trans('app.Enter Last Name')}}" value="{{ old('lastname') }}" class="form-control" maxlength="50">
                        			</div>
                      			</div>
                    		</div>
          
                  			<div class="col-md-12 col-sm-6 col-xs-12">  
                    			<div class="col-md-6 col-sm-6 col-xs-12 form-group my-form-group has-feedback {{ $errors->has('displayname') ? ' has-error' : '' }}">
                        			<label class="control-label col-md-4 col-sm-4 col-xs-12" for="displayname">{{ trans('app.Display Name')}} </label>

                                	<div class="col-md-8 col-sm-8 col-xs-12">
                                  		<input type="text"  name="displayname" id="displayname" placeholder="{{ trans('app.Enter Display Name')}}" maxlength="25" value="{{ old('displayname') }}" class="form-control ">
                        			</div>
                      			</div>

                       			<div class="col-md-6 col-sm-6 col-xs-12 form-group my-form-group has-feedback">
                        			<label class="control-label col-md-4 col-sm-4 col-xs-12"> {{ trans('app.Gender')}} <label class="color-danger">*</label></label>
                        			
                        			<div class="col-md-8 col-sm-8 col-xs-12 gender">
                              			<input type="radio"  name="gender" value="0" checked>{{ trans('app.Male')}} 
                      
                              			<input type="radio" name="gender" value="1" > {{ trans('app.Female')}}
                        			</div>
                      			</div>
                    		</div>

                    		<div class="col-md-12 col-sm-6 col-xs-12">  
                      			<div class="col-md-6 col-sm-6 col-xs-12 form-group {{ $errors->has('dob') ? ' has-error' : '' }}">
                          			<label class="control-label col-md-4 col-sm-4 col-xs-12">{{ trans('app.Date Of Birth')}}</label>
                          			
                          			<div class="col-md-8 col-sm-8 col-xs-12 input-group date datepicker">
                            			<span class="input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                              			<input type="text" id="date_of_birth" autocomplete="off" class="form-control" placeholder="<?php echo getDatepicker();?>" name="dob" value="{{ old('dob') }}"  onkeypress="return false;">                             
                              			<!-- @if ($errors->has('dob'))
                                			<span class="help-block">
                                  				<strong style="">{{ $errors->first('dob') }}</strong>
                                			</span>
                              			@endif -->
                          			</div>                      
                      			</div>

                      			<div class="col-md-6 col-sm-6 col-xs-12 form-group my-form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
                          			<label class="control-label col-md-4 col-sm-4 col-xs-12" for="email">{{ trans('app.Email') }} <label class="color-danger">*</label></label>
                          			
                          			<div class="col-md-8 col-sm-8 col-xs-12">
                            			<input type="email"  name="email" placeholder="{{ trans('app.Enter Email')}}" value="{{ old('email') }}" maxlength="50" class="form-control ">
                             			
                             			@if ($errors->has('email'))
                             			<span class="help-block">
                               				<strong>{{ $errors->first('email') }}</strong>
                             			</span>
                             			@endif
                          			</div>
                        		</div>
                    		</div>

                   			<div class="col-md-12 col-sm-6 col-xs-12">  
                      			<div class="col-md-6 col-sm-6 col-xs-12 form-group my-form-group has-feedback {{ $errors->has('password') ? ' has-error' : '' }}">
                        			<label class="control-label col-md-4 col-sm-4 col-xs-12" for="password">{{ trans('app.Password') }} <label class="color-danger">*</label></label>
                        			
                        			<div class="col-md-8 col-sm-8 col-xs-12">
                          				<input type="password"  name="password" placeholder="{{ trans('app.Enter Password')}}" maxlength="20" class="form-control col-md-7 col-xs-12">
                           				
                           				@if ($errors->has('password'))
                           					<span class="help-block">
                             					<strong>{{ $errors->first('password') }}</strong>
                           					</span>
                           				@endif
                        			</div>
                      			</div>

                     			<div class="col-md-6 col-sm-6 col-xs-12 form-group my-form-group has-feedback {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                        			<label class="control-label col-md-4 col-sm-4 col-xs-12 currency" style="" for="password_confirmation">{{ trans('app.Confirm Password') }} <label class="color-danger">*</label></label>
                        
                        			<div class="col-md-8 col-sm-8 col-xs-12">
                         				<input type="password"  name="password_confirmation" placeholder="{{ trans('app.Enter Confirm Password')}}" class="form-control col-md-7 col-xs-12" maxlength="20">
                         				
                         				@if ($errors->has('password_confirmation'))
                         					<span class="help-block">
	                            				<strong>{{ $errors->first('password_confirmation') }}</strong>
                         					</span>
                       					@endif
                      				</div>
                     			</div>
                    		</div>
            
                  			<div class="col-md-12 col-sm-6 col-xs-12">  
                    			<div class="col-md-6 col-sm-6 col-xs-12 form-group my-form-group has-feedback {{ $errors->has('mobile') ? ' has-error' : '' }}">
                        
                        			<label class="control-label col-md-4 col-sm-4 col-xs-12" for="mobile">{{ trans('app.Mobile No') }} <label class="color-danger" >*</label></label>
                        			
                        			<div class="col-md-8 col-sm-8 col-xs-12">
                          				<input type="text"  name="mobile" placeholder="{{ trans('app.Enter Mobile No')}}" value="{{ old('mobile') }}" maxlength="16" minlength="6" class="form-control">
                          				
                          				@if ($errors->has('mobile'))
                           					<span class="help-block">
                             					<strong>{{ $errors->first('mobile') }}</strong>
                           					</span>
                         				@endif
                        			</div>
                      			</div>
            
                      			<div class="col-md-6 col-sm-6 col-xs-12 form-group my-form-group has-feedback {{ $errors->has('landlineno') ? ' has-error' : '' }}">
                        			<label class="control-label col-md-4 col-sm-4 col-xs-12" for="landlineno">{{ trans('app.Landline No') }} <label class="color-danger"></label></label>
                        
                        			<div class="col-md-8 col-sm-8 col-xs-12">
                          				<input type="text" id="landlineno" name="landlineno" placeholder="{{ trans('app.Enter LandLine No')}}" maxlength="16" minlength="6" value="{{ old('landlineno') }}" class="form-control">
                          
                          				@if ($errors->has('landlineno'))
                           					<span class="help-block">
                             					<strong>{{ $errors->first('landlineno') }}</strong>
                           					</span>
                           				@endif
                        			</div>
                      			</div>
                    		</div>

                     		<div class="col-md-12 col-sm-6 col-xs-12">  
                         		<div class="col-md-6 col-sm-6 col-xs-12 form-group my-form-group has-feedback {{ $errors->has('image') ? ' has-error' : '' }}">
                          			
                          			<label class="control-label col-md-4 col-sm-4 col-xs-12" for="image">{{ trans('app.Image')}}</label>
                        			
                        			<div class="col-md-8 col-sm-8 col-xs-12">
                          				<input type="file" id="image" name="image"  class="form-control chooseImage">

                          				<img src="#" id="imagePreview" alt="User Image" class="imageHideShow" style="width: 20%; display: none; padding-top: 8px;">
                          
			                            <!-- @if ($errors->has('image'))
			                             <span class="help-block">
			                               <strong>{{ $errors->first('image') }}</strong>
			                             </span>
			                            @endif -->
                        			</div>
                      			</div>

                            <div class="col-md-6 col-sm-6 col-xs-12 form-group my-form-group has-feedback">
                              <label class="control-label col-md-4 col-sm-4 col-xs-12" for="branch">{{ trans('app.Branch')}} <label class="color-danger">*</label></label>
                              
                              <div class="col-md-8 col-sm-8 col-xs-12">
                                <select class="form-control  select_branch" name="branch">
                                  @foreach ($branchDatas as $branchData)
                                    <option value="{{ $branchData->id }}">{{$branchData->branch_name }}</option>
                                  @endforeach
                                </select>
                              </div>
                            </div>
                   			</div> 
            
                    		<div class="col-md-12 col-xs-12 col-sm-12 space">
                      			<h4><b>{{ trans('app.Address')}}</b></h4>
                      			<p class="col-md-12 col-xs-12 col-sm-12 ln_solid"></p>
                    		</div>

                    		<div class="col-md-12 col-sm-6 col-xs-12">                     
                      			<div class="col-md-6 col-sm-6 col-xs-12 form-group my-form-group has-feedback">
                        			<label class="control-label col-md-4 col-sm-4 col-xs-12" for="country_id">{{ trans('app.Country')}} <label class="color-danger">*</label></label>
                        
                        			<div class="col-md-8 col-sm-8 col-xs-12">
                          				<select class="form-control  select_country" name="country_id" countryurl="{!! url('/getstatefromcountry') !!}">
                            				<option value="">{{ trans('app.Select Country')}}</option>
                              				@foreach ($country as $countrys)
                              					<option value="{{ $countrys->id }}">{{$countrys->name }}</option>
                              				@endforeach
                          				</select>
                        			</div>
                      			</div>
            
                       			<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                        			<label class="control-label col-md-4 col-sm-4 col-xs-12" for="state_id">{{ trans('app.State') }}</label>
                         			
                         			<div class="col-md-8 col-sm-8 col-xs-12">
                          				<select class="form-control  state_of_country" name="state_id" stateurl="{!! url('/getcityfromstate') !!}">
                          				</select>
                        			</div>
                      			</div>
                    		</div>

                    		<div class="col-md-12 col-sm-6 col-xs-12">                      
                       			<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                        			<label class="control-label col-md-4 col-sm-4 col-xs-12" for="city">{{ trans('app.Town/City')}}</label>
                         			
                         			<div class="col-md-8 col-sm-8 col-xs-12">
                          				<select class="form-control  city_of_state" name="city"  >
                          				</select>
                        			</div>
                      			</div>
                   
                      			<div class="col-md-6 col-sm-6 col-xs-12 form-group my-form-group has-feedback">
                        			<label class="control-label col-md-4 col-sm-4 col-xs-12" for="address">{{ trans('app.Address') }} <label class="color-danger">*</label></label>
                        			<div class="col-md-8 col-sm-8 col-xs-12">
                          				<textarea id="address" name="address" class="form-control addressTextarea" maxlength="100">{{ old('address') }}</textarea>
                        			</div>
                      			</div>
                    		</div>

                      	<!-- Custom field data  -->
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
                    <!-- Custom field data -->
                      
                      	<input type="hidden" name="_token" value="{{csrf_token()}}">
                      
                      	<div class="form-group col-md-12 col-sm-12 col-xs-12">
                        	<div class="col-md-12 col-sm-12 col-xs-12 text-center">
                          		<a class="btn btn-primary" href="{{ URL::previous() }}">{{ trans('app.Cancel')}}</a>
                          		<button type="submit" class="btn btn-success accountantAddSubmitButton">{{ trans('app.Submit')}}</button>
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
		$('.select_country').change(function(){
			countryid = $(this).val();
			var url = $(this).attr('countryurl');
			$.ajax({
				type:'GET',
				url: url,
				data:{ countryid:countryid },
				success:function(response){
					$('.state_of_country').html(response);
				}
			});
		});
		
		
		$('body').on('change','.state_of_country',function(){
			stateid = $(this).val();
			
			var url = $(this).attr('stateurl');
			$.ajax({
				type:'GET',
				url: url,
				data:{ stateid:stateid },
				success:function(response){
					$('.city_of_state').html(response);
				}
			});
		});


		$('.datepicker').datetimepicker({
      		format: "<?php echo getDatepicker(); ?>",
		  	autoclose: 1,
		  	minView: 2,
		  	endDate: new Date(),
  		});


		/*If any white space for companyname, firstname, lastname and addresstext are then make empty value of these all field*/
	    $('body').on('keyup', '.addressTextarea', function(){

	      var addressValue = $(this).val();

	      if (!addressValue.replace(/\s/g, '').length) {
	         $(this).val("");
	      }
	    });

	    $('body').on('keyup', '#firstname', function(){

	        var firstName = $(this).val();

	        if (!firstName.replace(/\s/g, '').length) {
	          $(this).val("");
	        }
	    });

	    $('body').on('keyup', '#lastname', function(){

	        var lastName = $(this).val();

	        if (!lastName.replace(/\s/g, '').length) {
	          $(this).val("");
	        }
	    });

	    $('body').on('keyup', '#displayname', function(){

	        var displayName = $(this).val();

	        if (!displayName.replace(/\s/g, '').length) {
	          $(this).val("");
	        }
	    });


	    $('body').on('change','.chooseImage',function(){
	        var imageName = $(this).val();
	        var imageExtension = /(\.jpg|\.jpeg|\.png)$/i;

	        if (imageExtension.test(imageName)) {
	          $('.imageHideShow').css({"display":""});
	        }
	        else {
	          $('.imageHideShow').css({"display":"none"});
	        }     
	    });


	/********** Custom Field manually validation ***********/
	var msg1 = "{{ trans('app.field is required')}}";
  	var msg2 = "{{ trans('app.Only blank space not allowed')}}";
  	var msg3 = "{{ trans('app.Special symbols are not allowed.')}}";
  	var msg4 = "{{ trans('app.At first position only alphabets are allowed.')}}";

  	/*Form submit time check validation for Custom Fields */
  	$('body').on('click','.accountantAddSubmitButton',function(e)
  	{
    	$('#accountant_add_form input, #accountant_add_form select, #accountant_add_form textarea').each(

	        function(index)
	        {  
	            var input = $(this);

	            if (input.attr('name') == "firstname" || input.attr('name') == "lastname" || input.attr('name') == "email"  || input.attr('name') == "password" || input.attr('name') == "password_confirmation" || input.attr('name') == "mobile" || input.attr('name') == "country_id" || input.attr('name') == "address")
	            {
              		if (input.val() == "") {
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
                				$('.error_customfield_main_div_'+ids).removeClass('has-error');
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
	$('body').on('keyup','.common_simple_class',function()
	{
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
  	$('body').on('click','.checkbox_simple_class',function()
  	{
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


	$('body').on('change','.date_simple_class',function()
	{
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

    $("#image").change(function(){
        readUrl(this);
        $("#imagePreview").css("display","block");
    });
});

  /*For image preview at selected image*/
  function readUrl(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#imagePreview').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

<!-- For form field validate -->
{!! JsValidator::formRequest('App\Http\Requests\AccountantAddEditFormRequest', '#accountant_add_form'); !!}
<script type="text/javascript" src="{{ asset('public/vendor/jsvalidation/js/jsvalidation.js') }}"></script>


<!-- Form submit at a time only one -->
<script type="text/javascript">
    /*$(document).ready(function () {
        $('.accountantAddSubmitButton').removeAttr('disabled'); //re-enable on document ready
    });
    $('.accountantAddForm').submit(function () {
        $('.accountantAddSubmitButton').attr('disabled', 'disabled'); //disable on any form submit
    });

    $('.accountantAddForm').bind('invalid-form.validate', function () {
      $('.accountantAddSubmitButton').removeAttr('disabled'); //re-enable on form invalidation
    });*/
</script>

@endsection