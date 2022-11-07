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
            <th>Display Name</th>
            <th>Email</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @php $i=1 @endphp
        @forelse($users as $key=>$item)
        <tr>
            <td>{{ $i++ }}</td>
            <td>{{ $item->displayName }}</td>
            <td>{{ $item->email }}</td>
            <td class="action">
                <form action="{{ url('admin/user/destroy/'.$key) }}" method="post">
                    @csrf
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
