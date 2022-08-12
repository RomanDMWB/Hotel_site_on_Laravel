@extends('layouts.admin_page_layout')

@section('content')
@if(session('status'))
    <p>{{ session('status') }}</p>
@endif
<div class="panel">
    <a href="{{ url('admin/contact/form') }}" class="btn">Add contact</a>
</div>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Icon</th>
        </tr>
    </thead>
    <tbody>
        @php $i=1 @endphp
        @forelse($services as $key=>$item)
        <tr>
            <td>{{ $i++ }}</td>
            <td>{{ $item['name'] }}</td>
            <td>{{ $item['icon'] }}</td>
        </tr>
        @empty
        <p>Not Found</p>
        @endforelse
    </tbody>
</table>
@endsection