@extends('layouts.admin_page_layout')

@section('content')
@if(session('status'))
    <p>{{ session('status') }}</p>
@endif
<div class="panel">
    <a href="{{ url('admin/contact/create') }}" class="btn">Add contact</a>
</div>
@if($contacts)
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Content</th>
            <th>Icon</th>
        </tr>
    </thead>
    <tbody>
        @php $i=1 @endphp
        @foreach($contacts as $key=>$item)
        <tr>
            <td>{{ $i++ }}</td>
            <td>{{ $item['name'] }}</td>
            <td>{{ $item['content'] }}</td>
            <td>{{ $item['icon'] }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
<p>Not Found</p>
@endif
@endsection