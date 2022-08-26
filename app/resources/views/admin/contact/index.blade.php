@extends('layouts.admin_page_layout')

@section('content')
@if(session('status'))
    <p>{{ session('status') }}</p>
@endif
<div class="panel">
    <a href="{{ url('admin/contact/form') }}" class="btn">Add contact</a>
</div>
@if($contacts)
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Content</th>
            <th>Icon</th>
            <th>Action</th>
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
            <td class="action">
                <form action="{{ url('admin/contact/destroy/'.$key) }}" method="post">
                    <a href="{{ url('admin/contact/form/'.$key) }}" class="btn">Update</a>
                    @csrf
                    <button type='submit' class="btn" id='destroy-button'>Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
<p>Not Found</p>
@endif
@endsection