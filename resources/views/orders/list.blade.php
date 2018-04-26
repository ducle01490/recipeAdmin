@extends('layouts.master')

@section('content')

<section class="content">
 <div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title">Danh sách thực đơn</h3>
        <div class="box-tools">
          <div class="input-group input-group-sm" style="width: 150px;">
            <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

            <div class="input-group-btn">
              <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
            </div>
          </div>
        </div>
      </div>
      <!-- /.box-header -->
      <div class="box-body table-responsive no-padding">
        <table class="table table-hover table-striped table-bordered">
          <thead>
            <tr>
              <th>ID</th>
              <th>Khách hàng</th>
              <th>Điện thoại</th>
              <th>Địa chỉ</th>
              <th>Số lượng</th>
              <th>Hàng</th>
              <th>Loại</th>
              <th>Ghi chú (Khách hàng)</th>
              <th>Ghi chú (Admin)</th>
              <th>Tổng tiền</th>
              <th>Trạng thái</th>
              <th></th>
            </tr>
          </thead>
          @foreach($orders as $order)
          <tr>
            <td>{{$order->id}}</td>
            <td>{{$order->name}}</td>
            <td>{{$order->phone}}</td>
            <td>{{$order->address}}</td>
            <td><b>{{$order->quantity}}</b>
              @if($order->quantity == 1)
                - (2 serving)
              @else
                - (4 serving)
              @endif
            </td>
            <td><a href="#">{{$order->title}}</a></td>
            <td>
              @if($order->productType == 0)
              <span class="text-green">Thực đơn ngày</span>
              @else
              <span class="text-aqua">Món ăn</span>
              @endif
            </td>

            <td>{{$order->userNote}}</td>
            <td>{{$order->adminNote}}</td>
            <td>{{number_format($order->price * $order->quantity, 0, ',', '.')}} đ</td>
            <td>
              @if($order->status == 0)
              <span class="text-orange">Mới</span>
              @elseif($order->status == 1)
              <span class="text-green">Đã giao hàng</span>
              @elseif($order->status == 2)
              <span class="text-red">Bị huỷ</span>
              @endif
            </td>
            <td>
              <a href="{{route('post_update_order', $order->id)}}" class="btn btn-xs btn-primary">Cập nhật</a>
            </td>
          </tr>
          @endforeach
        </table>
      </div>
      <!-- /.box-body -->
      <div class="box-footer clearfix">
        {{ $orders->links() }}
      </div>

    </div>
    <!-- /.box -->
  </div>
</div>
</section>

@endsection
