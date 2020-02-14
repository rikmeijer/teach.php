@extends('layouts.master')
@section('title', 'Welcome')

@section('content')
    <header>
        <h1>Overzicht contactmomenten</h1>
        <ul class="horizontal-menu">
            <li><a href="{{url('/contactmoment/import')}}" target="_blank">Importeer contactmomenten</a></li>

            @auth
                <li><a href="{{ route('logout') }}" target="_blank">Afmelden</a></li>
            @else
                <a href="{{ route('login') }}">Aanmelden</a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}">Registreer</a>
                @endif
            @endauth
        </ul>
    </header>

    <nav>
        <ul class="horizontal-menu">
            @foreach ($modules as $module)
                <li><a href="#{{$module->naam}}">{{$module->naam}}</a></li>
            @endforeach
        </ul>
    </nav>

    <section>
        @component('contactmomenten_vandaag', ['caption' => 'Contactmomenten vandaag', 'contactmomenten' => $contactmomenten])
            Geen contactmomenten vandaag
        @endcomponent
    </section>
@endsection
