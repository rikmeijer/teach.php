@extends('layouts.master')
@section('title', 'Importeer contactmomenten')

@section('content')
    <header>
        <h1>Contactmomenten ge&iuml;mporteerd</h1>
    </header>
    <section>
        <p>{{session('numberImported')}} contactmomenten zijn ge&iuml;mporteerd</p>
    </section>
@endsection
