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
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @php $i=1 @endphp
        @forelse($services as $key=>$item)
        <tr>
            <td>{{ $i++ }}</td>
            <td>{{ $item['name'] }}</td>
            <td>{{ $item['icon'] }}</td>
            <td class="action">
                <form action="{{ url('admin/service/destroy/'.$key) }}" method="post">
                    @csrf
                    <a href="{{ url('admin/service/form/'.$key) }}" class="btn">Update</a>
                    <button type='submit' class="btn" id='destroy-button'>Delete</button>
                </form>
            </td>
        </tr>
        @empty
        <p>Not Found</p>
        @endforelse
    </tbody>
</table>
@endsection