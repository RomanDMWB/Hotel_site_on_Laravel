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
        </tr>
        @endforeach
    </tbody>
</table>
@else
<p>Not Found</p>
@endif
@endsection