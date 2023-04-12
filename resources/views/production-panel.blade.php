@extends('layouts.index')

@section('custom-link')
    @livewireStyles
@endsection

@section('content')
    {{-- Production Panel Livewire --}}
    @livewire('production-panel', ['orderInfo' => $orderInfo, 'orderWsDetails' => $orderWsDetails])
@endsection

@section('custom-script')
    @livewireScripts

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            $('.select2').select2({
                theme: "bootstrap-5",
                width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
                placeholder: $( this ).data( 'placeholder' ),
            });
        })

        Livewire.on('alert', (type, message) => {
            showNotification(type, message);
        })

        Livewire.on('showModal', (type) => {
            if (type == 'defect') {
                showDefectModal();
            }
        })

        Livewire.on('hideModal', (type) => {
            if (type == 'defect') {
                hideDefectModal();
            }
        })
    </script>
@endsection
