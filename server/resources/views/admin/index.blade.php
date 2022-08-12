@extends('layouts.admin_page_layout')

@section('content')
<h4>Таблицы</h4>
@if($tables)
<ul class="tables">
@foreach($tables as $key=>$item)
<li>
<a href='{{ url("admin/".$key) }}'>{{ $key }}</a>
</li>
@endforeach
</ul>
@else
<p>Not Found</p>
@endif
@endsection