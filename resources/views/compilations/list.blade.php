@extends('layouts.master')

@section('content')

<section class="content">
 <div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title">Danh sách món ăn</h3>

        <div class="box-tools">


          <div class="input-group input-group-sm" style="width: 300px;">
            <div class="input-group-btn" style="padding-right: 20px;">
              <a class="btn btn-sm btn-success" href="{{route('post_add_compilation')}}">Tạo bài viết</a>
            </div>
            <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">
            <div class="input-group-btn">
   compilationsbutton type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
            </div>
          </div>

          <div class="box-tools">

          </div>

        </div>
      </div>
      <!-- /.box-header -->
      <div class="box-body table-responsive no-padding">
        <div id="helper-text"></div>
        <table class="table table-hover table-striped table-bordered">
          <thead>
            <tr>
              <th>ID</th>
              <th>Tiêu đề</th>
              <th>Ảnh thumb</th>
              <th>Video</th>
              <th>Trạng thái</th>
              <th>Cập nhật</th>
              <th></th>
            </tr>
          </thead>
          @foreach($compilations as $recipe)
          <tr id="row-{{$recipe->id}}">
            <td>{{$recipe->id}}</td>
            <td class="title">{{$recipe->title}}</td>
            <td><img class="image" src="{{$recipe->thumb}}" style="height: 90px; width: auto;"></img></td>
            <td><a href="{{$recipe->video}}" target="_blank">{{$recipe->video}}</a></td>
            <td>
              @if($recipe->status == 1)
              <span class="text-green">Publish</span>
              @else
              <span class="text-yellow">Unpublish</span>
              @endif
            </td>
            <td>
              @if($recipe->status == 0)
              <a href="{{route("update_recipe_status", array("recipeId" => $recipe->id, "status" => 1))}}" class="btn btn-xs btn-danger">Publish</a>
              @else
              <a href="{{route("update_recipe_status", array("recipeId" => $recipe->id, "status" => 0))}}" class="btn btn-xs btn-warning">Unpublish</a>
              @endif
            </td>
            <td>{{$recipe->updated_at}}</td>
            <td>
              <a href="{{route('post_edit_compilation', $recipe->id)}}" class="btn btn-xs btn-primary">Update</a>
              <button class="btn btn-xs btn-danger" id="delete" data-recipe-id={{$recipe->id}} data-toggle="modal" data-target="#confirm-delete">Delete</button>
            </td>
          </tr>
          @endforeach
        </table>
      </div>
      <!-- /.box-body -->

      <div class="box-footer clearfix">
        {{ $compilations->links() }}
      </div>
      <!-- /.box-footer -->
    </div>
    <!-- /.box -->
  </div>
</div>

<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-recipe-id="-1">
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
    var recipeId = $(e.relatedTarget).data('recipe-id');
    var title = $("#row-"+recipeId + " .title").text();
    var img = $("#row-"+recipeId + " .image").attr("src");

    $("#deleteTitle").text("Xoá Item: " + title);
    $("#deleteImg").attr("src", img);
    $("#confirm-delete").attr('data-recipe-id', recipeId);
  });

  $("#deleteButton").on("click", function(e) {
    var recipeId = $("#confirm-delete").attr('data-recipe-id');
    console.log("delete: " + recipeId);

    // AJAX request
    $.ajax({
      url: '/recipes/delete/' + recipeId,
      type: 'POST',
      contentType: false,
      processData: false,
      success: function(response){
        if(response != 0){
          // Show image preview
          $('#confirm-delete').modal('hide');
          $("#row-"+response["recipeId"]).remove();

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
