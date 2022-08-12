<?php header("Content-Type: text/html; charset=utf-8"); ?>
@extends('layouts.admin_page_layout')

@section('content')
@if(session('status'))
    <p>{{ session('status') }}</p>
@endif
<div class="panel">
    <a href="{{ url('admin/room/form') }}" class="btn">Add room</a>
</div>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Services</th>
            <th>Cost</th>
            <th>Size</th>
            <th>Description</th>
            <th>Image</th>
            <th>Add Services</th>
            <th>Update</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
        @php $i=1;$j=1 @endphp
        @forelse($rooms as $key=>$item)
        <tr>
            <td>{{ $i++ }}</td>
            <td>{{ $item['name'] }}</td>
            <td>
                @if($item['services'])
                <table>
                    <thead><th>ID</th><th>Name</th><th>Icon</th></thead>
                    <tbody>
                        @forelse($item['services'] as $service)
                        <tr>
                            <td>{{ $j++ }}</td>
                            <td>{{ $service['name'] }}</td>
                            <td><p>{!! $service['icon'] !!}</p></td>
                        </tr>
                        @empty
                        <p>Not Found</p>
                        @endforelse
                    </tbody>
                </table>
                @endif
            </td>
            <td>{{ $item['cost'] }}</td>
            <td>{{ $item['size'] }}</td>
            <td>{{ $item['description'] }}</td>
            <td>{{ $item['image'] }}</td>
            <td><a href="{{ url('admin/room/add-service/'.$key) }}" class='btn'>Add</a></td>
            <td><a href="{{ url('admin/room/update/'.$key) }}" class='btn'>Update</a></td>
            <td><a href="" class='btn'>Delete</a></td>
        </tr>
        @empty
        <p>Not Found</p>
        @endforelse
    </tbody>
</table>
@endsection