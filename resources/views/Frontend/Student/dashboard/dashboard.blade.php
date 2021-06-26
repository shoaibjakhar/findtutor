@extends('layout')
@section('content')

	<center><h1 style="margin-top: 20%">Student Panel</h1>
	<form method="post" action="logout">
        @csrf
            <input type="submit" value="Logout">
    </form>
</center>
@endsection