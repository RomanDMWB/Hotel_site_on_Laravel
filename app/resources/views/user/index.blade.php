@extends('layouts.main_page_layout')

@section('content')
@if(isset($status))
<p class="info">{{ $status }}</p>
@endif
<h1>User Info</h1>
<form action="{{ url('user/save') }}" method="GET">
    @csrf
    <label>Name and Surname</label>
    <input type='text' required name="displayName" value="{{ $user->displayName }}">
    <label>Email</label>
    <input type='email' name="email" required value="{{ $user->email }}">
    <label>New Password</label>
    <input type='password' name="password">
    <input type='submit' value="Сохранить" class="btn">
</form>
@endsection
