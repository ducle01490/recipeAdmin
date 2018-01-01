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
              <h3 class="box-title">Cập nhật đơn hàng của: {{$order->name}} - SĐT: {{$order->phone}} - Địa chỉ: {{$order->address}}</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="POST" action="{{route('post_update_order', $order->id)}}">
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
                  <label for="note">Ghi chú: </label>
                  <textarea class="form-control" name="note" id="note" placeholder="Ghi chú" >{{$order->adminNote}}</textarea>
                </div>
                <div class="form-group">
                  <label for="serving">Cập nhật trạng thái: </label>
                  <select class="form-control" name="status" id="status">
                    <option value="0" {{($order->status == 0? 'selected':'')}}>Mới</option>
                    <option value="1" {{($order->status == 1? 'selected':'')}}>Đã giao hàng</option>
                    <option value="2" {{($order->status == 2? 'selected':'')}}>Huỷ</option>
                  </select>
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
</section>

        

@endsection
