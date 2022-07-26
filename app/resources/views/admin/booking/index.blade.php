@extends('layouts.admin_page_layout')

@section('content')
@if(session('status'))
<p>{{ session('status') }}</p>
@endif
@if($bookings)
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Adults</th>
            <th>Childs</th>
            <th>Cost</th>
            <th>Date</th>
            <th>Nights</th>
            <th>Place</th>
            <th>Type</th>
            <th>Email</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @php $i=1 @endphp
        @foreach($bookings as $key=>$item)
        <tr>
            <td>{{ $i++ }}</td>
            <td>{{ $item['adults'] }}</td>
            <td>{{ $item['childs'] }}</td>
            <td>{{ $item['cost'] }}</td>
            <td>{{ $item['date'] }}</td>
            <td>{{ $item['nights'] }}</td>
            <td>{{ $item['place'] }}</td>
            <td>{{ $item['type'] }}</td>
            <td>{{ $item['email'] }}</td>
            <td class="action">
                <form action="{{ url('admin/booking/destroy/'.$item['booking']) }}" method="post">
                    @csrf
                    <a href="{{ url('admin/booking/form/'.$item['booking']) }}" class="btn">Update</a>
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
