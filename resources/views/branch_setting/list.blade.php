@extends('layouts.app')
@section('content')

<!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
				<div class="nav_menu">
					<nav>
						<div class="nav toggle">
							<a id="menu_toggle"><i class="fa fa-bars"> </i><span class="titleup">&nbsp; {{ trans('app.Branch Setting')}}</span></a>
						</div>
						@include('dashboard.profile')
					</nav>
				</div>				
				
				@if(session('message'))
					<div class="row massage">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="checkbox checkbox-success checkbox-circle">
			                @if(session('message') == 'Successfully Updated')
								<label for="checkbox-10 colo_success"> {{trans('app.Successfully Updated')}}</label>
							@elseif(session('message')=='Data not available')
							   <label for="checkbox-10 colo_success"> {{ trans('app.Data not available')}}</label>
						    @endif
			                </div>
						</div>
					</div>
				@endif
            </div>

			<div class="x_content">
                <ul class="nav nav-tabs bar_tabs tabconatent" role="tablist">					
	                @can('generalsetting_view')
						<li role="presentation" class="suppo_llng_li floattab"><a href="{!! url('setting/general_setting/list')!!}" class="anchor_tag anchr"><span class="visible-xs"></span><i class="fa fa-cogs">&nbsp;</i>{{ trans('app.General Settings')}}</a></li>
					@endcan
					@can('timezone_view')
						<li role="presentation" class="suppo_llng_li_add floattab"><a href="{!! url('setting/timezone/list')!!}" class="anchor_tag anchr"><span class="visible-xs"></span><i class="fa fa-cog i">&nbsp;</i>{{ trans('app.Other Settings')}}</a></li>
					@endcan
				<!-- New Access Rights Starting -->
					@can('accessrights_view')				
						<li role="presentation" class="suppo_llng_li_add floattab"><a href="{!! url('setting/accessrights/show')!!}" class="anchor_tag anchr"><span class="visible-xs"></span><i class="fa fa-universal-access">&nbsp;</i>{{ trans('app.Access Rights')}}</a></li>
					@endcan
				<!-- New Access Rights Ending -->
					
					@can('businesshours_view')
						<li role="presentation" class="suppo_llng_li_add floattab"><a href="{!! url('setting/hours/list')!!}" class="anchor_tag anchr"><span class="visible-xs"></span><i class="fa fa-hourglass-end">&nbsp;</i>{{ trans('app.Business Hours')}}</a></li>
					@endcan

					@can('stripesetting_view')
						<li role="presentation" class="suppo_llng_li_add floattab"><a href="{!! url('setting/stripe/list')!!}" class="anchor_tag anchr"><span class="visible-xs"></span><i class="fa fa-cc-stripe">&nbsp;</i>{{ trans('app.Stripe Settings')}}</a></li>
					@endcan
					
					@can('branchsetting_view')
						<li role="presentation" class="active suppo_llng_li_add floattab"><a href="{!! url('branch_setting/list')!!}" class="anchor_tag anchr"><span class="visible-xs"></span><i class="fa fa-university">&nbsp;</i><b>{{ trans('app.Branch Setting')}}</b></a></li>
					@endcan
				</ul>
			</div>
            <div class="clearfix"></div>
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_content">
						<form id="branch_setting_edit_form" method="post" action="{{ url('branch_setting/store') }}" enctype="multipart/form-data"  class="form-horizontal upperform">
							
							@can('branchsetting_view')
								<div class="col-md-12 col-sm-12 col-xs-12 space">
									<h4><b>{{ trans('app.Branch Setting') }}</b></h4>
									<p class="col-md-12 col-sm-12 col-xs-12 ln_solid"></p>
								</div>
								
								<div class="col-md-12 col-sm-12 col-xs-12 "> 
									<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback my-form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="Country">{{ trans('app.Select Branch')}} <label class="color-danger">*</label>
										</label>
										<div class="col-md-5 col-sm-5 col-xs-12">
											<select class="form-control" name="select_branch" required>
												@if(!empty($branchDatas))
													 @foreach($branchDatas as $branchData)
														<option value="{{$branchData->id}}" <?php if($branchSettingData->branch_id == $branchData->id){echo"selected";} ?>>{{$branchData->branch_name}}</option>
													@endforeach
												@endif
											</select>
										</div>
									</div>
								</div>
							@endcan
							
							<input type="hidden" name="_token" value="{{csrf_token()}}">

							@can('branchsetting_edit')
								<div class="col-md-12 col-xs-12 col-sm-12 form-group space">   
									<div class="col-md-9 col-sm-9 col-xs-12 text-center">
										<a class="btn btn-primary" href="{{ URL::previous() }}">{{ trans('app.Cancel')}}</a>
										<button type="submit" class="btn btn-success btn_success_margin">{{ trans('app.Update')}}</button>
									</div>
								</div>
							@endcan
						</form>	
						</div>						
					</div>
				</div>
            </div>
        </div>
	</div>
<!-- page content end -->

<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.4.min.js"></script>


<!-- Form field validation -->
{!! JsValidator::formRequest('App\Http\Requests\StoreBranchSettingEditFormRequest', '#branch_setting_edit_form'); !!}
<script type="text/javascript" src="{{ asset('public/vendor/jsvalidation/js/jsvalidation.js') }}"></script>


@endsection