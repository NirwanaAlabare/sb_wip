@extends('layouts.index')

@section('custom-link')
    @livewireStyles
@endsection

@section('content')
    <livewire:order-list/>
@endsection

@section('custom-script')
    @livewireScripts
@endsection
