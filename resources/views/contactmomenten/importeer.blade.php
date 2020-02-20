@extends('layouts.master')
@section('title', 'Importeer contactmomenten')

@section('content')
    <header>
        <h1>Importeer contactmomenten</h1>
    </header>
    <section>
        <form method="{{route('contactmomenten.importeer')}}}">
            @csrf
            rooster.avans.nl
            <input type="submit" value="Importeren"/>
        </form>
    </section>
@endsection
