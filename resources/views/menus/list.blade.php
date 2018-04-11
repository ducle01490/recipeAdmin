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
              <a href="{{route("update_menu_status", array("menuId" => $menuItem->id, "status" => 1))}}" class="btn btn-xs btn-danger">Publish</a>
              @else
              <a href="{{route("update_menu_status", array("menuId" => $menuItem->id, "status" => 0))}}" class="btn btn-xs btn-warning">Unpublish</a>
              @endif
            </td>
            <td>{{$menuItem->publishDate}}</td>
            <td>
              <a href="{{route('post_update_menu', $menuItem->id)}}" class="btn btn-xs btn-primary">Update</a>
              <button class="btn btn-xs btn-danger" id="delete" data-menu-id="{{$menuItem->id}}" data-toggle="modal" data-target="#confirm-delete">Delete</button>
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

<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-menu-id="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" id="deleteTitle">
        Xoá item
      </div>
      <div class="modal-body">
        <img id="deleteImg" src="" style="height: 100px; width: auto;">
        <div>Bạn có chắc chắn xoá không?</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <a class="btn btn-danger btn-ok" id="deleteButton">Delete</a>
      </div>
    </div>
  </div>
</div>

</section>

@endsection

@section('script')

<script type="text/javascript">
  $(document).ready(function(){
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
  //triggered when modal is about to be shown
  $('#confirm-delete').on('show.bs.modal', function(e) {

    //get data-id attribute of the clicked element
    var menuId = $(e.relatedTarget).data('menu-id');
    var title = $("#row-"+menuId + " .title").text();
    var img = $("#row-"+menuId + " .image").attr("src");

    $("#deleteTitle").text("Xoá Item: " + title);
    $("#deleteImg").attr("src", img);
    $("#confirm-delete").attr('data-menu-id', menuId);
  });

  $("#deleteButton").on("click", function(e) {
    var menuId = $("#confirm-delete").attr('data-menu-id');
    console.log("delete: " + menuId);

    // AJAX request
    $.ajax({
      url: '/menus/delete/' + menuId,
      type: 'POST',
      contentType: false,
      processData: false,
      success: function(response){
        if(response != 0){
          // Show image preview
          $('#confirm-delete').modal('hide');
          $("#row-"+response["menuId"]).remove();

          var html = '<div class="alert alert-success alert-dismissible" style="margin: 10px;">'
                + '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'
                + response["messages"]
              + '</div>';

          $("#helper-text").html(html);
        } else{
                    var html = '<div class="alert alert-danger alert-dismissible" style="margin: 10px;">'
                + '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'
                + 'Lỗi xảy ra'
              + '</div>';

          $("#helper-text").html(html);
        }
      }
    });

  })



});
</script>

@endsection
