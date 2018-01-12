@extends('layouts.app')

@section('content')

  <form enctype="multipart/form-data" method="post" action="/import">
      {{ csrf_field() }}
   <p><input type="file" name="f">
   <input type="submit" value="Отправить"></p>
  </form> 

@endsection
