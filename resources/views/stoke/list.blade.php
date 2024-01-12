@extends('layouts.app')
@section('content')
	
	<!-- page content -->
    <div class="right_col" role="main">
		<div id="stockview" class="modal fade" role="dialog">
			<div class="modal-dialog modal-lg">
    <!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header"> 
						<a href=""><button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button></a>
						<h4 id="myLargeModalLabel" class="modal-title">{{ trans('app.Stock')}}</h4>
					</div>
					<div class="modal-body">
	
					</div>
				</div>
			</div>
		</div>
        <div class="">
			<div class="page-title">
				<div class="nav_menu">
					<nav>
						<div class="nav toggle">
							<a id="menu_toggle"><i class="fa fa-bars"></i><span class="titleup">&nbsp; {{ trans('app.Stock')}}</span></a>
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
					<label for="checkbox-10 colo_success">  {{session('message')}} </label>
                </div>
			</div>
		</div>
		@endif
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_content">
					<ul class="nav nav-tabs bar_tabs" role="tablist">
						@can('stock_view')
							<li role="presentation" class="active"><a href="{!! url('/stoke/list')!!}"><span class="visible-xs"></span><i class="fa fa-list fa-lg">&nbsp;</i><b> {{ trans('app.Stock List')}}</b></a></li>
						@endcan
						@can('purchase_add')
							<li role="presentation" class=""><a href="{!! url('/purchase/add')!!}"><span class="visible-xs"></span><i class="fa fa-plus-circle fa-lg">&nbsp;</i> {{ trans('app.Add Stock')}}</a></li>
						@endcan
					</ul>
				</div>
				<div class="x_panel bgr">
                    <table id="datatable" class="table table-striped jambo_table" style="margin-top:20px;">
						<thead>
							<tr>
								<th>#</th>
								<th>{{ trans('app.Image')}}</th> 
								<th>{{ trans('app.Product Number')}}</th>
								<th>{{ trans('app.Manufacturer Name')}}</th>
								<th>{{ trans('app.Product Name')}}</th>
								<th>{{ trans('app.Quantity')}}</th>
								<th>{{ trans('app.Unit Of Measurement')}}</th>
								<th>{{ trans('app.Action')}}</th>
							</tr>
						</thead>
						<tbody>
							<?php $i=1;?>
							@foreach($stock as $stocks)
							<tr>
								<td>{{ $i }}</td>
								<td>
									<img src="{{ url('public/product/'.$stocks->product_image) }}"  width="50px" height ="50px" class="img-circle" ></td>
								<td>{{ $stocks->product_no }}</td>
								<td>{{ getProductName($stocks->product_type_id) }}</td>
								<td>{{ getProduct($stocks->product_id) }}</td>
								<td>{{getStockCurrent($stocks->product_id)}}</td>
								<td>{{getUnitMeasurement($stocks->product_id)}}</td>
								<td> 
									@can('stock_view')
										<button type="button" data-toggle="modal" data-target="#stockview" stockid="{{ $stocks->id }}" url="{!! url('/stoke/list/stockview') !!}" class="btn btn-round btn-info stocksave">{{ trans('app.View')}}</button>
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
$(document).ready(function() 
{
    $('#datatable').DataTable( {
		responsive: true,
        "language": {
			
			 "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/<?php echo getLanguageChange(); 
			?>.json"
        }
    });


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



	$('body').on('click', '.stocksave', function() 
	{  
	  	
	  	$('.modal-body').html("");	   
       	var stockid = $(this).attr("stockid");
		var url = $(this).attr('url');		
		var msg10 = "{{ trans('app.An error occurred :')}}";

       	$.ajax({
       		type: 'GET',
       		url: url,	
       		data : {stockid:stockid},
       		success: function (data)
       		{            
       			$('.modal-body').html(data.html);
       		},
   			beforeSend:function()
   			{
				$(".modal-body").html("<center><h2 class=text-muted><b>Loading...</b></h2></center>");
			},
			error: function(e) 
			{
       			alert(msg10 + " " + e.responseText);
       			console.log(e);	
       		}
       	});
    });   
});
</script>

@endsection