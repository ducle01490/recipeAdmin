@extends('layouts.master')

@section('content')

<section class="content">
 <div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title">Danh sách thực đơn</h3>

        <div class="box-tools">


          <div class="input-group input-group-sm" style="width: 300px;">
            <div class="input-group-btn" style="padding-right: 20px;">
              <a class="btn btn-sm btn-success" href="{{route('create_menu')}}">Tạo bài viết</a>
            </div>
            <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">
            <div class="input-group-btn">
              <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
            </div>
          </div>

          <div class="box-tools">

          </div>

        </div>
      </div>
      <!-- /.box-header -->
      <div class="box-body table-responsive no-padding">
        <p>
  <!--       <div class="row">
          <div class="col-md-12 text-center">
          <div class="btn-group">
            <a href="{{route('get_list_menus', "2")}}" type="button" class="btn {{$serving==2?'btn-success':'btn-default'}}">Thực đơn cho 2 người</a>
            <a href="{{route('get_list_menus', "7")}}" type="button" class="btn {{$serving==7?'btn-success':'btn-default'}}">Thực đơn cho 7 người</a>
          </div>
        </div>
        </div> -->
      </p>

        <table class="table table-hover table-striped table-bordered">
          <thead>
            <tr>
              <th>ID</th>
              <th>Tiêu đề</th>
              <th>Ảnh thumb</th>
              <th>Nguyên liệu</th>
              <th>Tiến hành</th>
              <th>Video</th>
              <th>Giá</th>
              <th>Trạng thái</th>
              <th>Cập nhật</th>
              <th>Ngày publish</th>
              <th></th>
            </tr>
          </thead>
          @foreach($menuItems as $menuItem)
          <tr id="row-{{$menuItem->id}}">
            <td>{{$menuItem->id}}</td>
            <td class="title">{{$menuItem->title}}</td>
            <td><img class="image" src="{{$menuItem->thumb}}" style="height: 90px; width: auto;"></img></td>
            <td>
              {!!substr($menuItem->ingredient, 0, strpos($menuItem->ingredient, '</li>'))!!}...
            </td>
            <td>
              {!!substr($menuItem->preparation, 0, strpos($menuItem->preparation, '</li>'))!!}...
            </td>
            <td><a href="{{$menuItem->video}}" target="_blank">{{$menuItem->video}}</a></td>
            <td>{{number_format($menuItem->price, 0, ',', '.')}} VNĐ</td>
            <td>
              @if($menuItem->status == 1)
              <span class="text-green">Publish</span>
              @else
              <span class="text-yellow">Unpublish</span>
              @endif
            </td>
            <td>
              @if($menuItem->status == 0)
              <a href="{{route("update_menu_status", array("recipeId" => $menuItem->id, "status" => 1))}}" class="btn btn-xs btn-danger">Publish</a>
              @else
              <a href="{{route("update_menu_status", array("recipeId" => $menuItem->id, "status" => 0))}}" class="btn btn-xs btn-warning">Unpublish</a>
              @endif
            </td>
            <td>{{$menuItem->publishDate}}</td>
            <td>
              <a href="{{route('post_update_menu', $menuItem->id)}}" class="btn btn-xs btn-primary">Update</a>
              <button class="btn btn-xs btn-danger" id="delete" data-toggle="modal" data-target="#confirm-delete">Delete</button>
            </td>
          </tr>
          @endforeach
        </table>
      </div>
      <!-- /.box-body -->

      <div class="box-footer clearfix">
        {{ $menuItems->links() }}
      </div>
      <!-- /.box-footer -->
    </div>
    <!-- /.box -->
  </div>
</div>

<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        Xoá item 
      </div>
      <div class="modal-body">
        Bạn có chắc chắn xoá không?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <a class="btn btn-danger btn-ok">Delete</a>
      </div>
    </div>
  </div>
</div>

</section>

@endsection
