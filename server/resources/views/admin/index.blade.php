@extends('layouts.admin_page_layout')

@section('content')
<h4>Таблицы</h4>
@if($tables)
@foreach($tables as $key=>$item)
<a href='{{ url("admin/".$key) }}'>{{ $key }}</a>
@endforeach
@else
<p>Not Found</p>
@endif
@endsection