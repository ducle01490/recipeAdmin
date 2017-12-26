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

<section class="content">
   <div class="row">
    <div class="col-xs-12">
          <!-- general form elements -->
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Tạo bài viết</h3>
              @if(isset($message))
                <h4>{{$message}}</h4>
              @endif
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="POST" action="{{route('post_add_recipe')}}">
            	<input name="_token" type="hidden" value="{{ csrf_token() }}"/>
              <div class="box-body">
                <div class="form-group">
                  <label for="title">Tiêu đề: </label>
                  <input type="text" class="form-control" name="title" id="title" placeholder="Title" required>
                </div>
                <div class="form-group">
                  <label for="thumb">Ảnh đại diện: </label>
                  <div class="row">
                  <div class="col-xs-8">
                    <input type="url" class="form-control" name="thumb" id="thumb" placeholder="Link ảnh đại diện" required>
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
                  <input type="url" class="form-control" name="video" id="video" placeholder="Video link" required>
                </div>

                <div class="form-group">
                	<div style="padding-bottom: 6px;">
	                	<label for="ingredient">Chuẩn bị: </label>
		          	</div>
	                <textarea id="ingredient" class="form-control" style="height: 250px" name="ingredient">
	                </textarea>
              	</div>

              	<div class="form-group">
					       <div style="padding-bottom: 6px;">
	                	<label for="ingredient">Các bước tiến hành: </label>
		          	</div>

	                <textarea id="preparation" class="form-control" style="height: 250px" name="preparation">
	                </textarea>
              	</div>

              	<div class="form-group">
              		<label for="price">Giá dự kiến: (VNĐ)</label>
	                <input type="number" class="form-control" name="price" id="price">
              	</div>


              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-success">Thêm</button>
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

<script type="text/javascript">

  $(document).ready(function(){
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    $("#ingredient").wysihtml5();
    $("#preparation").wysihtml5();

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
