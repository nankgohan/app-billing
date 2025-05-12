@extends('layouts.member.app')

@section('content')
<div class="container">
    <h1>Member Dashboard</h1>
    <p>Welcome, {{ auth()->user()->name }} (Member)</p>
</div>
@endsection