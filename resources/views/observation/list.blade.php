@extends('layouts.app')
@section('content')
<script src="{{ URL::asset('vendors/jquery/dist/jquery.min.js') }}"></script>
<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="nav_menu">
        <nav>
          <div class="nav toggle">
            <a id="menu_toggle"><i class="fa fa-bars"></i><span class="titleup">&nbsp; {{ trans('app.Observation')}}</span></a>
          </div>
          @include('dashboard.profile')
        </nav>
      </div>
    </div>
    @if(session('message'))
    <div class="row massage">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="checkbox checkbox-success checkbox-circle">
          <label for="checkbox-10 colo_success"> {{trans('app.Successfully Submitted')}}  </label>
        </div>
      </div>
    </div>
    @endif

    <input type="hidden" name="msgUpdate" class="msgUpdate" value="{{trans('app.Successfully Updated')}}">
    <input type="hidden" name="msgDelete" class="msgDelete" value="{{trans('app.Successfully Deleted')}}">

    <div class="row" >
      <div class="col-md-12 col-sm-12 col-xs-12" >
        <div class="x_content">
          <ul class="nav nav-tabs bar_tabs tabconatent" role="tablist">
            @can('observationlibrary_view')
              <li role="presentation" class="active suppo_llng_li floattab"><a href="{!! url('/observation/list')!!}"><span class="visible-xs"></span><i class="fa fa-list fa-lg">&nbsp;</i><b>{{ trans('app.Observation List')}}</b></a></li>
            @endcan
            @can('observationlibrary_add')
              <li role="presentation" class="suppo_llng_li_add floattab"><a href="{!! url('/observation/add')!!}"><span class="visible-xs"></span><i class="fa fa-plus-circle fa-lg">&nbsp;</i>{{ trans('app.Add Observation')}}</a></li>
            @endcan
          </ul>
        </div>
        <div class="x_panel table_up_div">
          <div class="panel-heading addpoint">
            @if(!empty($check_data))
            @foreach($check_data as $check_datas)
            <div class="panel-group" id="accordion1">
              <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                      <a data-toggle="collapse" data-parent="#accordion1" href="#collapseTwo-<?php echo $check_datas->vehicle_id ?>" class="emailacordin">
                        <i class="plus-minus glyphicon glyphicon-plus"> </i> 
                        @if($check_datas->vehicle_id == '0')
                        {{ 'General' }}
                        @else
                        {{ getVehicleName($check_datas->vehicle_id) }} </a> 
                        @endif
                      </a>
                    </h4>
                </div>
                <div id="collapseTwo-<?php echo $check_datas->vehicle_id ?>" class="panel-collapse collapse inplus">
                    <div class="panel-body">
                        <!-- Here we insert another nested accordion -->
                        <div class="panel-group" id="accordion2">
                            <div class="panel panel-default">
                                <?php
                                    $vehiclepopints = Getvehiclecheckpoint($check_datas->vehicle_id); 
                                       
                                    foreach($vehiclepopints as $vehiclepopintss)
                                    {                                             
                                      ?>
                                      <div class="panel-heading">
                                          <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion2" href="#collapseInnerTwo-<?php echo $vehiclepopintss->id ?>" class="emailacordin plsmins<?php echo $vehiclepopintss->id ?>"><i class="plus-minus glyphicon glyphicon-plus"> </i>{{ $vehiclepopintss->checkout_point}} </a> 
                                          </a>
                                          </h4>
                                      </div>
                                      <div id="collapseInnerTwo-<?php echo $vehiclepopintss->id ?>" class="panel-collapse collapse inplus">
                                        <div class="panel-body">
                                          <div class="form-group">
                                             <table class="table table-striped">
                                                <thead>
                                                   <tr>
                                                      <td><b>#</b></td>
                                                      <td><b>{{ trans('app.Checkpoints')}}</b></td>
                                                      @canany(['observationlibrary_edit','observationlibrary_delete'])
                                                        <td><b>{{ trans('app.Action')}}</b></td>
                                                      @endcanany
                                                   </tr>
                                                </thead>
                                                <tbody>
                                                   <?php
                                                      $i = 1;   
                                                      $subcategory = getCheckPointSubCategory($vehiclepopintss->checkout_point,$check_datas->vehicle_id); 
                                                        if(!empty($subcategory))
                                                        {
                                                        foreach($subcategory as $subcategorys)
                                                        { 
                                                          ?>
                                                          <tr class="id{{ $subcategorys->checkout_point }}">
                                                            <td><?php echo $i++; ?></td>
                                                            <td class="row{{ $subcategorys->checkout_point }}">
                                                            <?php echo $subcategorys->checkout_point.'<br>'; ?>
                                                            </td>
                                                            @canany(['observationlibrary_edit','observationlibrary_delete'])
                                                              <td>
                                                                @can('observationlibrary_edit')
                                                                  <button type="button" class="btn btn-round btn-success btn_edit" data-toggle="modal" data-target="#updateform" edit_id="{{ $subcategorys->id }}" > {{ trans('app.Edit')}} </button></a>
                                                                @endcan
                                                                @can('observationlibrary_delete')
                                                                  <a url="{{ url('/observation/deleteuser/') }}"> <button type="button" id="setMarginOfDeleteBtn" class="btn btn-round btn-danger btn_del dgr1" data-id="{{ $subcategorys->id }}" >{{ trans('app.Delete')}}</button></a>
                                                                @endcan
                                                              </td>
                                                            @endcanany
                                                          </tr>
                                                          <?php   
                                                        }
                                                      }
                                                      ?>
                                                </tbody>
                                             </table>
                                          </div>
                                       </div>
                                    </div>

                                    <script>
                                      $(document).ready(function(){
                                        var i = 0;
                                        $('.plsmins{{$vehiclepopintss->id}}').click(function(){
                                          i = i+1;
                                          if(i%2!=0){
                                            $(this).parent().find(".glyphicon-plus:first").removeClass("glyphicon-plus").addClass("glyphicon-minus");
                                          }else{
                                            $(this).parent().find(".glyphicon-minus:first").removeClass("glyphicon-minus").addClass("glyphicon-plus");
                                          }
                                        });
                                      });
                                    </script>

                                    <?php
                                      }
                                    ?>
                                 </div>
                              </div>
                              <!-- Inner accordion ends here -->
                           </div>
                        </div>
                     </div>
                  </div>
                  @endforeach
                  @endif
               </div>
            </div>
         </div>
      </div>
   </div>
</div>



<!-- Modal for edit category -->
<div id="updateform" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">{{ trans('app.Edit Chekpoint')}}</h4>
            </div>
            <div class="modal-body">
            
            </div>
         
            <div class="modal-footer" style="border-top:none; text-align: center;">
                <button  class="btn btn-success submit_edit">{{ trans('app.Update')}}</button>
            </div>
        </div>
    </div>
</div>


<script src="{{ URL::asset('vendors/jquery/dist/jquery.min.js') }}"></script>

<script>
$(document).ready(function()
{
    $('.btn_del').click(function(){
    
        var url =  "<?php echo url('/deleteuser'); ?>";
        var id = $(this).attr('data-id');
        var deleteMsg = $('.msgDelete').val();

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
            }, 
            function(){
   
                $.ajax({
                    type:'get',
                    url:url,
                    data:{id:id},
         
                    success:function(data){
                      $('.cancel').trigger( "click" );
                      if (data != null)
                      {
                          alert(deleteMsg);
                          window.location.href = '{{ url('observation/list')}}';
                      }
                    },
                });              
            });
      });



      $('.btn_edit').click(function(){
   
          var url = "<?php echo url('/editcheckpoin'); ?>"
          var id = $(this).attr('edit_id');

          var msg5 = "{{ trans('app.Somthing went wrong')}}";
   
          $.ajax({ 
              type:'GET',
              url:url,
              data:{ id:id },
              
              success:function(response)
              {      
                $('.modal-body').html(response.html);
              },
              error:function()
              {
                  alert(msg5);
              }
          });     
      });


   
      $('body').on('click','.submit_edit',function(){
   
          var url = "<?php echo url('/submitnewname'); ?>"
          var id = $('.check_point_id').val();
          var subpoints = $("input[name='checkpoint[]']")
                 .map(function(){return $(this).val();}).get(); 
           
          var updateMsg = $('.msgUpdate').val();
          var checkpointValue = $('#sub_ch').val();
          var regexs = /^[a-zA-Z0-9\u0621-\u064A\u00C0-\u017F\u0600-\u06FF\u0750-\u077F\uFB50-\uFDFF\uFE70-\uFEFF\u2E80-\u2FD5\u3190-\u319f\u3400-\u4DBF\u4E00-\u9FCC\uF900-\uFAAD\u0900-\u097F\s]*$/;
          
          if (checkpointValue == null || checkpointValue == "") {
              $('.chekpoint_sub').val("");
              $('#checkpoints_edit_error1').css({"display":""});
              $('.form_group_error').addClass('has-error');
              $('#checkpoints_edit_error').css({"display":"none"});
          }
          else if (!regexs.test(checkpointValue)) {
              //$('.chekpoint_sub').val("");
              $('#checkpoints_edit_error').css({"display":""});
              $('.form_group_error').addClass('has-error');
              $('#checkpoints_edit_error1').css({"display":"none"});
          }
          else{

              $('#checkpoints_edit_error').css({"display":"none"});
              $('.form_group_error').removeClass('has-error');
              $('#checkpoints_edit_error1').css({"display":"none"});

              $('.modal').modal('hide');

              $.ajax({ 
                  type:'GET', 
                  url:url,
                  data:{ id:id,subpoints:subpoints},
                  success:function(response)
                  {        
                      if (response == 1) 
                      {
                          alert(updateMsg);
                          window.location.href = '{{ url('observation/list')}}';                  
                      }
                  },
              });
          }          
      });

    var max_fields = 20; //maximum input boxes allowed
    var wrapper = $(".items"); //Fields wrapper
    var add_button = $(".add_field_button"); //Add button ID      
    var x = 1; //initlal text box count
    $('body').on('click','.add_field_button',function(e){
     
       //$(add_button).click(function(e){ //on add input button click
       
       e.preventDefault();
       if(x < max_fields){ //max input box allowed
       x++; 
       $(wrapper).append('<div class="form-group"><label class="control-label col-md-4 col-sm-3 col-xs-12">{{ trans('app.Check Point') }}<label class="" style="color: #a94442;">&nbsp;&nbsp;*</label></label>' +
       '<input class="form-control col-md-7 col-xs-12" idid="chek_pt" type="text" placeholder="{{ trans('app.Enter Checkpoint Name')}}" name="checkpoint[]" required="true" style="width:48% !important;"/>' + '&nbsp;&nbsp;'+'<a href="#" class="remove_field"><i class="fa fa-times" style="margin-top:10px !important;"></a></div>'); 
       }
    });
    
    $(wrapper).on("click",".remove_field", function(e){ 
      e.preventDefault(); $(this).parent('div').remove(); x--;
    });

   
    $(function() {
    
      function toggleIcon(e) {
          $(e.target)
             .prev('.panel-heading')
             .find(".plus-minus")
             .toggleClass('glyphicon-plus glyphicon-minus');
      }
      $('.panel-group').on('hidden.bs.collapse', toggleIcon);
      $('.panel-group').on('shown.bs.collapse', toggleIcon);    
    });


  /*$(document).ready(function(){
      
      $('.submit_edit').click(function(){

          var editValue = $('.chekpoint_sub').val();

          alert(editValue);
          if (!editValue.replace(/\s/g, '').length) {
              $('.chekpoint_sub').val("");
          }

      });
  });*/

      $('body').on('keyup', '#sub_ch', function(){

          var editValue = $(this).val();
          var regexs = /^[a-zA-Z0-9\u0621-\u064A\u00C0-\u017F\u0600-\u06FF\u0750-\u077F\uFB50-\uFDFF\uFE70-\uFEFF\u2E80-\u2FD5\u3190-\u319f\u3400-\u4DBF\u4E00-\u9FCC\uF900-\uFAAD\u0900-\u097F\s]*$/;

          //alert(editValue);
          if (!editValue.replace(/\s/g, '').length) {
              $(this).val("");
              $('#checkpoints_edit_error1').css({"display":""});
              $('.form_group_error').addClass('has-error');
              $('#checkpoints_edit_error').css({"display":"none"});
          }
          else if (!regexs.test(editValue)) {
              //$('.chekpoint_sub').val("");
              $('#checkpoints_edit_error').css({"display":""});
              $('.form_group_error').addClass('has-error');
              $('#checkpoints_edit_error1').css({"display":"none"});
          }
          else if (regexs.test(editValue)) {
              $('#checkpoints_edit_error').css({"display":"none"});
              $('.form_group_error').removeClass('has-error');
              $('#checkpoints_edit_error1').css({"display":"none"});
          }

      });
});
</script> 
@endsection