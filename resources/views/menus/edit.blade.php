@extends('layouts.master')

@section('content')

<style type="text/css">
.modal.modal-wide .modal-dialog {
 width: 90%;
}
.modal-wide .modal-body {
 overflow-y: auto;
}

</style>

<link rel="stylesheet" href="{{asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}">
<link rel="stylesheet" href="{{asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">

<section class="content">
 <div class="row">
  <div class="col-xs-12">
    <!-- general form elements -->
    <div class="box box-success">
      <div class="box-header with-border">
        <h3 class="box-title">Sửa bài viết</h3>
      </div>
      <!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="POST" action="{{route('post_update_menu', $menuItem->id)}}">
              <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
              <div class="box-body">
                @if (session('flash_notice'))
                  <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    {{Session::get('flash_notice')}}
                  </div>
                @endif

                @if (session('flash_error'))
                  <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    {{Session::get('flash_error')}}
                  </div>
                @endif
                <div class="form-group">
                  <label for="title">Tiêu đề: </label>
                  <input type="text" class="form-control" name="title" id="title" placeholder="Title" value="{{old('title')?old('title'):$menuItem->title}}" required>
                </div>
                <div class="form-group">
                  <label for="serving">Món ăn dành cho bao nhiêu khẩu phần ăn: </label>
                  <input type="text" class="form-control" name="serving" id="serving" placeholder="Servings" value="{{old('serving')?old('serving'):$menuItem->serving}}" required>
                </div>
                <div class="form-group">
                  <label for="thumb">Ảnh đại diện: </label>
                  <div class="row">
                  <div class="col-xs-8">
                    <input type="url" class="form-control" name="thumb" id="thumb" placeholder="Link ảnh đại diện" value="{{old('thumb')?old('thumb'):$menuItem->thumb}}" required>
                  </div>
                  <div class="col-xs-1">
                    <label class="form-control center" style="border: none;">-Hoặc-</label>
                  </div>
                  <div class="col-xs-3">
                    <button class="btn btn-primary form-control" data-toggle="modal" data-target="#modal-upload">Upload ảnh</button>
                  </div>
                  </div>
                </div>

                <div class="form-group">
                  <label for="title">Video link: </label>
                  <input type="url" class="form-control" name="video" id="video" placeholder="Video link" value="{{old('video')?old('video'):$menuItem->video}}" required>
                </div>

                <div class="form-group">
                  <div style="padding-bottom: 6px;">
                    <label for="ingredient">Chuẩn bị: </label>
                </div>
                  <textarea id="ingredient" class="form-control" style="height: 250px" name="ingredient">{{old('ingredient')?old('ingredient'):$menuItem->ingredient}}
                  </textarea>
                </div>

                <div class="form-group">
                 <div style="padding-bottom: 6px;">
                    <label for="preparation">Các bước tiến hành: </label>
                </div>

                  <textarea id="preparation" class="form-control" style="height: 250px" name="preparation">
                  {{old('preparation')?old('preparation'):$menuItem->preparation}}</textarea>
                </div>

                <div class="form-group">
                  <label for="price">Giá dự kiến: (VNĐ)</label>
                  <input type="number" class="form-control" name="price" id="price" value="{{old('price')?old('price'):$menuItem->price}}">
                </div>

                <div class="form-group">
                  <label for="status">Có Publish bài viết này không?</label>
                  <select class="form-control" name="status" id="status">
                    <option value="0" <?php if(old('status')) {if(old('status') == 0){echo 'selected';}} elseif($menuItem->status == 0){echo 'selected';} ?>>Chưa publish</option>
                    <option value="1" <?php if(old('status')) {if(old('status') == 1){echo 'selected';}} elseif($menuItem->status == 1){echo 'selected';} ?>>Publish luôn</option>
                  </select>
                </div>

        <div class="form-group">
          <label>Ngày bán:</label>
          <div class="input-group date">
            <div class="input-group-addon">
              <i class="fa fa-calendar"></i>
            </div>
            <input type="text" class="form-control pull-right" id="publishDate" name="publishDate" value="{{old('publishDate')?old('publishDate'):$menuItem->publishDate}}">
          </div>
          <!-- /.input group -->
        </div>

              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Cập nhật</button>
              </div>
            </form>
  </div>
  <!-- /.box -->
</div>
</div>

<div class="modal fade" id="modal-upload">
  <div class="modal-dialog">
    <form method='post' action='' enctype="multipart/form-data">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Upload ảnh: </h4>
          </div>
          <div class="modal-body">
            <div id='preview'></div>
            <input type="file" name="file" id="file" accept="image/*">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
            <input type="button" class="btn btn-primary" id="upload" value="Upload"></input>
          </div>
        </div>
      </form>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->
</section>



@endsection

@section('script')

<script src="{{asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}}"></script>
<script src="{{asset('bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>

<script type="text/javascript">

  $(document).ready(function(){
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    $("#ingredient").wysihtml5();
    $("#preparation").wysihtml5();
    $('#publishDate').datepicker({
      autoclose: true
    })

    $('#upload').click(function(){

      var fd = new FormData();
      var files = $('#file')[0].files[0];
      fd.append('file',files);
    // AJAX request
    $.ajax({
      url: '/image-upload',
      type: 'POST',
      data: fd,
      contentType: false,
      processData: false,
      success: function(response){
        if(response != 0){
          // Show image preview
          $('#thumb').val(response['data']);
          $('#preview').append("<img src='http://localhost:8888/"+response['data']+"' width='100' height='100' style='display: inline-block;'>");
        }else{
          alert('File not uploaded!');
        }
      }
    });
  });
  });
</script>

@endsection
