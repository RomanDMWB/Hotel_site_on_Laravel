@extends('layouts.admin_page_layout')

@section('content')
@if(session('status'))
    <p>{{ session('status') }}</p>
@endif
<div class="panel">
    <a href="{{ url('admin/place/form') }}" class="btn">Add place</a>
</div>
@if($places)
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Room Number</th>
            <th>Is Occupied</th>
            <th>Room Type</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @php $i=1 @endphp
        @foreach($places as $key=>$item)
        <tr>
            <td>{{ $i++ }}</td>
            <td>{{ $item['number'] }}</td>
            <td>@if($item['isOccupied'])
                    Занято
                @else
                    Свободно
                @endif
            </td>
            <td>{{ $item['type'] }}</td>
            <td class="action">
                <a href="{{ url('admin/place/form/'.$key) }}" class="btn">Update</a>
                <form action="{{ url('admin/place/destroy/'.$key) }}" method="post">
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