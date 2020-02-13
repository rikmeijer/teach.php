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

    <nav>
        <ul class="horizontal-menu">
            @foreach ($modules as $module)
                <li><a href="#{{$module->naam}}">{{$module->naam}}</a></li>
            @endforeach
        </ul>
    </nav>
@endsection
