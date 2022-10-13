@extends('layouts.main_page_layout')

@section('content')
<div class='contact-list'>
    <h1>Our Contacts</h1>
    <ul>
        @foreach($contacts as $item)
        <li>
            <p class="header">{{ $item['name'] }}:</p>
            <p class="content">{{ $item['content'] }}</p>
        </li>
        @endforeach
    </ul>
</div>
@endsection
