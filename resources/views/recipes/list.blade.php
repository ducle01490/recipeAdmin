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
                <a class="btn btn-sm btn-success" href="{{route('post_add_recipe')}}">Tạo bài viết</a>
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
        <div class="box-body">
          <table class="table table-hover">
            <tr>
              <th>ID</th>
              <th>Tiêu đề</th>
              <th>Ảnh thumb</th>
              <th>Nguyên liệu</th>
              <th>Tiến hành</th>
              <th>Video</th>
              <th>Giá</th>
              <th>Trạng thái</th>
              <th>Ngày cập nhật</th>
            </tr>
            @foreach($recipes as $recipe)
            <tr>
              <td>{{$recipe->id}}</td>
              <td>{{$recipe->title}}</td>
              <td><img src="{{$recipe->thumb}}" style="height: 90px; width: auto;"></img></td>
              <td>
                {!!substr($recipe->ingredient, 0, strpos($recipe->ingredient, '</li>'))!!}...
              </td>
              <td>
                {!!substr($recipe->preparation, 0, strpos($recipe->preparation, '</li>'))!!}...
              </td>
              <td><a href="{{$recipe->video}}" target="_blank">{{$recipe->video}}</a></td>
              <td>{{number_format($recipe->price, 0, ',', '.')}} VNĐ</td>
              <td>
                @if($recipe->status == 1)
                  <span class="label label-success">Public</span>
                @else
                  <span class="label label-warning">Chưa public</span>
                @endif
              </td>
              <td>{{$recipe->updated_at}}</td>
            </tr>
            @endforeach
          </table>
        </div>
        <!-- /.box-body -->

        <div class="box-footer clearfix">
          {{ $recipes->links() }}
        </div>
        <!-- /.box-footer -->
      </div>
      <!-- /.box -->
    </div>
  </div>
</section>

@endsection
