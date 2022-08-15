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
            <td class="action">
                <a href="{{ url('admin/booking/form/'.$key) }}" class="btn">Update</a>
                <form action="{{ url('admin/booking/destroy/'.$key) }}" method="post">
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
<script>
    document.getElementById('destroy-button').addEventListener('click',(e)=>{
        if(!confirm('Are you sure to delete the data?'))
            e.preventDefault();
    })
</script>
@endsection