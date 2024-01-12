@extends('layouts.app')
@section('content')

<!-- page content -->
    <div class="right_col" role="main">
        <div class="">
			<div class="page-title">
				<div class="nav_menu">
					<nav>
						<div class="nav toggle">
							<a id="menu_toggle"><i class="fa fa-bars"></i><span class="titleup">&nbsp; {{ trans('app.Branch')}}</span></a>
						</div>
						@include('dashboard.profile')
					</nav>
				</div>
			</div>
        </div>
		@if(session('message'))
			<div class="row massage">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="checkbox checkbox-success checkbox-circle">
						@if(session('message') == 'Successfully Submitted')
							<label for="checkbox-10 colo_success"> {{trans('app.Successfully Submitted')}}  </label>
						@elseif(session('message')=='Successfully Updated')
							<label for="checkbox-10 colo_success"> {{ trans('app.Successfully Updated')}}  </label>
						@elseif(session('message')=='Successfully Deleted')
							<label for="checkbox-10 colo_success"> {{ trans('app.Successfully Deleted')}}  </label>
						@endif
					</div>
				</div>
			</div>
		@endif

        <div class="row" >
			<div class="col-md-12 col-sm-12 col-xs-12" >
				<div class="x_content">
					<ul class="nav nav-tabs bar_tabs" role="tablist">
						@can('branch_view')
							<li role="presentation" class="active"><a href="{!! url('/branch/list')!!}"><span class="visible-xs"></span><i class="fa fa-list fa-lg">&nbsp;</i><b>{{ trans('app.Branch List')}}</b></a></li>
						@endcan
						
						@can('branch_add')
							<li role="presentation" class=""><a href="{!! url('/branch/add')!!}"><span class="visible-xs"></span><i class="fa fa-plus-circle fa-lg">&nbsp;</i> {{ trans('app.Add Branch')}}</a></li>
						@endcan
					</ul>
				</div>
				<div class="x_panel">
					<table id="datatable" class="table table-striped  jambo_table" style="margin-top:20px;" >
						<thead>											
							<tr>
								<th>#</th>
								<th>{{ trans('app.Image')}}</th>
								<th>{{ trans('app.Branch Name')}}</th>
								<th>{{ trans('app.Contact Number')}}</th>
								<th>{{ trans('app.Email')}}</th>
								<th>{{ trans('app.Address')}}</th>
								<!-- <th>{{ trans('app.Enable Branch')}}</th> -->
								
								@if(getUserRoleFromUserTable(Auth::User()->id) != 'Customer')
									<th>{{ trans('app.Action')}}</th>
								@endif

								@if(getUserRoleFromUserTable(Auth::User()->id) == 'Customer')
									@if(Gate::allows('branch_add') || Gate::allows('branch_edit') || Gate::allows('branch_delete') || Gate::allows('branch_view'))
										<th>{{ trans('app.Action')}}</th>
									@endif
								@endif
							</tr>
						
						</thead>
						<tbody>
							<?php $i = 1; ?>   
						@foreach($branchDatas as $branchData)
							<tr>
								<td>{{ $i }}</td>
								<td><img src="{{ URL::asset('public/img/branch/'.$branchData->branch_image) }}"  width="50px" height="50px" class="img-circle"></td>

								<td>{{ $branchData->branch_name }}</td>
								<td>{{ $branchData->contact_number }}</td>
								<td>{{ $branchData->branch_email }}</td>
								<td>{{ $branchData->branch_address }}</td>
								<!-- <td>{{ $branchData->branch_status }}</td> -->
								
								<td>
									@can('branch_view')
										<a href="{!! url('/branch/view/'.$branchData->id) !!}"><button type="button" class="btn btn-round btn-info">{{ trans('app.View')}}</button></a>
									@endcan

									@can('branch_edit')
										<a href="{!! url('/branch/edit/'.$branchData->id) !!}" ><button type="button" class="btn btn-round btn-success editBtnCss">{{ trans('app.Edit')}}</button></a>
									@endcan

									@can('branch_delete')
										<a url="{!! url('/branch/delete/'.$branchData->id) !!}" class="sa-warning"><button type="button" id="deleteBtnCss" class="btn btn-round btn-danger">{{ trans('app.Delete')}}</button></a>
									@endcan
								</td>
							</tr>
							<?php $i++; ?>
						@endforeach
						</tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<!-- /page content -->


<!-- Scripts starting -->
<script src="{{ URL::asset('vendors/jquery/dist/jquery.min.js') }}"></script>
<script>
	$(document).ready(function() {
	    $('#datatable').DataTable( {
			responsive: true,
	        "language": {
				
					"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/<?php echo getLanguageChange(); 
				?>.json"
	        }
	    });


	    /******* Delete Employee ******/
	    $('body').on('click', '.sa-warning', function() 
	    {
		  	var url =$(this).attr('url');
		  	var msg1 = "{{ trans('app.Are You Sure?')}}";
		    var msg2 = "{{ trans('app.You will not be able to recover this data afterwards!')}}";
		    var msg3 = "{{ trans('app.Cancel')}}";
		    var msg4 = "{{ trans('app.Yes, delete!')}}";
		  
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
	        }, function(){
				window.location.href = url;
	        });
    	});

	});
</script>
      
@endsection