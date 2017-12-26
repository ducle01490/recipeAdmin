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
                  <input type="file" id="thumb" name="thumb" accept="image/*" required>
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
	                	<label for="ingredient">Tiến hành: </label>
		          	</div>

	                <textarea id="preparation" class="form-control" style="height: 250px" name="preparation">
	                </textarea>
              	</div>

              	<div class="form-group">
              		<label for="price">Giá dự kiến</label>
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

  <div class="modal modal-wide fade" id="my_modal">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Thêm nội dung cho mục: </h4>
              </div>
              <div class="modal-body">
                <textarea id="my_textarea"></textarea>
              </div>	
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
</section>

        

@endsection

@section('script')

<script src="{{asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}}"></script>

<script type="text/javascript" src="https://unpkg.com/ccxt"></script>



<script>
	console.log (ccxt.exchanges) // print all available exchanges


  $(function () {
    //Add text editor
    $("#ingredient").wysihtml5();
    $("#preparation").wysihtml5();
  });

</script>

@endsection
