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
            <th>Action</th>
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
                    <thead><th>ID</th><th>Name</th><th>Icon</th><th>Action</th></thead>
                    <tbody>
                        @forelse($item['services'] as $serviceKey=>$service)
                        <tr>
                            <td>{{ $j++ }}</td>
                            <td>{{ $service['name'] }}</td>
                            <td><p>{!! $service['icon'] !!}</p></td>
                            <td class="action">
                                <form action="{{ url('admin/room/service/destroy/'.$key.'/'.$serviceKey) }}" method="post">
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
                @else
                Not Found
                @endif
            </td>
            <td>{{ $item['cost'] }}</td>
            <td>{{ $item['size'] }}</td>
            <td class="description">
                <p>{{ $item['description'] }}</p>
                <a class="btn">Раскрыть</a>
            </td>
            <td>{{ $item['image'] }}</td>
            <td class="action">
                <form action="{{ url('admin/room/destroy/'.$key) }}" method="post">
                    @csrf
                    <a href="{{ url('admin/room/add-service/'.$key) }}" class='btn'>Add Service</a>
                    <a href="{{ url('admin/room/form/'.$key) }}" class="btn">Update</a>
                    <button type='submit' class="btn" id='destroy-button'>Delete</button>
                </form>
            </td>
        </tr>
    @empty
    <p>Not Found</p>
    @endforelse
    </tbody>
</table>
<script>
    const limit = 100;
    document.querySelectorAll('.description').forEach(el=>{
        const text = el.querySelector('p');
        const textContent = text.textContent;
        const button = el.querySelector('a');
        let isShortText = true;
        if(textContent.length>limit){
            button.style.display='inline';
            text.textContent=textContent.substr(0,limit)+'...';
        }
        else{
            button.style.display='none';
        }
        button.addEventListener('click',()=>{
            if(textContent.length>limit){
                if(isShortText){
                    text.textContent=textContent.substr(0,limit)+'...';
                    isShortText=!isShortText;
                    button.textContent = 'Раскрыть';
                }
                else{
                    text.textContent=textContent;
                    isShortText=!isShortText;
                    button.textContent = 'Свернуть';
                }
            }
        })
    })
</script>
@endsection