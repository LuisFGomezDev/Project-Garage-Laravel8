@extends('layouts.app')
@section('content')

<!-- Start page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="nav_menu">
                  <nav>
                      <div class="nav toggle">
                          <a id="menu_toggle"><i class="fa fa-bars"></i><span class="titleup">&nbsp; {{ trans('app.Branch Admin')}}</span></a>
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
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_content">
                    <ul class="nav nav-tabs bar_tabs tabconatent" role="tablist">
                        @can('branchAdmin_view')
                        <li role="presentation" class="active">
                            <a href="{!! url('/branchadmin/list')!!}">
                                <span class="visible-xs"></span><i class="fa fa-list fa-lg">&nbsp;</i><b>{{ trans('app.Branch Admin List') }}</b>
                            </a>
                        </li>
                        @endcan
                        @can('branchAdmin_add')
                        <li role="presentation" class=" setTabAddSupportStaffOnSmallDevice">
                            <a href="{!! url('/branchadmin/add')!!}">
                                <span class="visible-xs"></span><i class="fa fa-plus-circle fa-lg">&nbsp;</i> {{ trans('app.Add Branch Admin') }}
                            </a>
                        </li>
                        @endcan
                    </ul>
                </div>
                <div class="x_panel bgr">
                    <table id="datatable" class="table table-striped jambo_table" style="margin-top:20px;">
                      <thead>
                          <tr>
                              <th>#</th>
                              <th>{{ trans('app.Image')}}</th>
                              <th>{{ trans('app.Branch')}}</th>
                              <th >{{ trans('app.First Name') }}</th>
                              <th>{{ trans('app.Last Name') }}</th>
                              <th>{{ trans('app.Email') }}</th>
                              <th>{{ trans('app.Mobile Number') }}</th>
                              
                            @if(getUserRoleFromUserTable(Auth::User()->id) != 'Customer')
                              <th>{{ trans('app.Action')}}</th> 
                            @elseif(getUserRoleFromUserTable(Auth::User()->id) == 'Customer')
                              @if(Gate::allows('branchAdmin_add') || Gate::allows('branchAdmin_edit') || Gate::allows('branchAdmin_delete'))
                                <th>{{ trans('app.Action')}}</th>
                              @endif
                            @endif
                          </tr>
                      </thead>
                      <tbody>
                          <?php $i=1;?>
                              @foreach($branchadmins as $branchadmin)
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td>
                                        <img src="{{ url('public/branch_admin/'.$branchadmin->image) }}"  width="50px" height="50px" class="img-circle" >
                                    </td>
                                    <td>{{ getBranchName($branchadmin->branch_id) }}</td>
                                    <td>{{ $branchadmin->name }}</td>
                                    <td>{{ $branchadmin->lastname}}</td>
                                    <td>{{ $branchadmin->email }}</td>
                                    <td>{{ $branchadmin->mobile_no }}</td>
                                     
                                  @if(getUserRoleFromUserTable(Auth::User()->id) != 'Customer')
                                    <td>
                                    @if(getUserRoleFromUserTable(Auth::User()->id) == 'admin' ||  getUserRoleFromUserTable(Auth::User()->id) == 'supportstaff' || getUserRoleFromUserTable(Auth::User()->id) == 'accountant' || getUserRoleFromUserTable(Auth::User()->id) == 'employee' || getUserRoleFromUserTable(Auth::User()->id) == 'branch_admin')
                                      @can('branchAdmin_view')
                                        <a href="{!! url('/branchadmin/list/'.$branchadmin->id) !!}"><button type="button" class="btn btn-round btn-info">{{ trans('app.View')}}</button></a>
                                      @endcan
                                      @can('branchAdmin_edit')
                                        <a href="{!! url ('/branchadmin/list/edit/'.$branchadmin->id) !!}"><button type="button" class="btn btn-round btn-success">{{ trans('app.Edit')}}</button></a>
                                      @endcan
                                      @can('branchAdmin_delete')
                                        <a url="{!! url('/branchadmin/list/delete/'.$branchadmin->id)!!}" class="sa-warning"><button type="button" class="btn btn-round btn-danger">{{ trans('app.Delete')}}</button></a>
                                      @endcan
                                      
                                      @if(Auth::User()->id == $branchadmin->id)
                                        @if(!Gate::allows('branchAdmin_edit'))
                                          @can('branchAdmin_owndata')
                                            <a href="{!! url ('/branchadmin/list/edit/'.$branchadmin->id) !!}"><button type="button" class="btn btn-round btn-success">{{ trans('app.Edit')}}</button></a>
                                          @endcan
                                        @endif
                                      @endif
                                    @endif
                                    </td>
                                  @endif

                                  @if(getUserRoleFromUserTable(Auth::User()->id) == 'Customer')
                                    @if(Gate::allows('branchAdmin_add') || Gate::allows('branchAdmin_edit') || Gate::allows('branchAdmin_delete'))
                                    <td>
                                      @can('branchAdmin_view')
                                        <a href="{!! url('/branchadmin/list/'.$branchadmin->id) !!}"><button type="button" class="btn btn-round btn-info">{{ trans('app.View')}}</button></a>
                                      @endcan
                                      @can('branchAdmin_edit')
                                        <a href="{!! url ('/branchadmin/list/edit/'.$branchadmin->id) !!}"><button type="button" class="btn btn-round btn-success">{{ trans('app.Edit')}}</button></a>
                                      @endcan
                                      @can('branchAdmin_delete')
                                        <a url="{!! url('/branchadmin/list/delete/'.$branchadmin->id)!!}" class="sa-warning"><button type="button" class="btn btn-round btn-danger">{{ trans('app.Delete')}}</button></a>
                                      @endcan
                                    </td>
                                    @endif
                                  @endif
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
<!-- language change in user selected -->	
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


      $('body').on('click', '.sa-warning', function() {
  
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