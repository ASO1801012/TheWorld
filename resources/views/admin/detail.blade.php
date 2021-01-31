@extends('librarybasead')
@section('title','詳細')
@section('content')

@if (session('message'))
<div class="alert alert-success">
  {{ session('message') }}
</div>
@endif
<button class="btn btn-info btn-md" onclick="location.href='{{url('/admin/list')}}'"><i class="fa fa-chevron-circle-left"></i> Back</button>
<form action="{{ url('/admin/detail/' . $admin->id ) }}" method="post" enctype="multipart/form-data">
{{ csrf_field() }}
  <table align="center">
    <input type="hidden" name="id" value="{{ $admin->id }}">
    <tr>
      <th>管理者ID</th>
      <td>
        <input type="text" name="number" value="{{$admin->adminsId}}">
        @if($errors->has('number'))
          <br><div class="text-danger">{{$errors->first('number')}}</div>
        @endif
      </td>
    </tr>
    <tr>
      <th>名前</th>
      <td>
        <input type="text" name="name" value="{{$admin->name}}">
        @if($errors->has('name'))
          <br><div class="text-danger">{{$errors->first('name')}}</div>
        @endif
      </td>
    </tr>
    <tr>
      <th>学校名</th>
      <td>
        <select name="school" id="school">
          <option selected disabled>学校を選択</option>
          @foreach($school as $school)
            @if($school->id == $admin->school_id)
              <option value="{{$school->id}}" selected>{{$school->name}}</option>
            @else
              <option value="{{$school->id}}">{{$school->name}}</option>
            @endif
          @endforeach
        </select>
      </td>
    </tr>
    <tr>
      <th>メールアドレス</th>
      <td>
        <input type="text" name="email" value="{{$admin->email}}">
        @if($errors->has('email'))
          <br><div class="text-danger">{{$errors->first('email')}}</div>
        @endif
      </td>
    </tr>
  </table>
  <div style="text-align:center; margin-top:30px;">
    <input type="submit" name="kousin" value="更新" class="btn btn-primary" style="display:inline-block;">
    <input type="submit" name="button" value="削除" class="btn btn-danger" onclick="delete_alert(event);return false;"></a>
  </div>
  </form>


@endsection

@section('script')
<script>
function delete_alert(e){
   if(!window.confirm('本当に削除しますか？')){
      window.alert('キャンセルされました'); 
      return false;
   }
   document.deleteform.submit();
};
</script>

<style>
table{
  width:40%;
}
input[type="text"],select{
  width:90%;
  height:30px;
}
table tr{
  border-bottom: solid 2px white;
  height:70px;
}
table tr:last-child{
  border-bottom: none;
}
table th{
  position: relative;
  background-color: #52c2d0;
  color: white;
  text-align: center;
}
table th:after{
  display: block;
  content: "";
  width: 0px;
  height: 0px;
  position: absolute;
  top:calc(50% - 10px);
  right:-10px;
  border-left: 10px solid #52c2d0;
  border-top: 10px solid transparent;
  border-bottom: 10px solid transparent;
}
table td{
  width: 70%;
  text-align: center;
  background-color: #eee;
  padding: 10px 0;
}
</style>
@endsection