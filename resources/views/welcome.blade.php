@extends('layouts.master')
@section('title', 'Welcome')

@section('content')
<header>
    <h1>Overzicht contactmomenten</h1>
    <ul class="horizontal-menu">
        <li><a href="{{url('/contactmoment/import')}}" target="_blank">Importeer contactmomenten</a></li>
        <li><a href="{{url('/logout')}}" target="_blank">Afmelden</a></li>
    </ul>
</header>
@endsection
