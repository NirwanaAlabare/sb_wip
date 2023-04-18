@extends('layouts.index')

@section('content')
    {{-- Production Panel Livewire --}}
    @livewire('production-panel', ['orderInfo' => $orderInfo, 'orderWsDetails' => $orderWsDetails])
@endsection

@section('custom-script')
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

        Livewire.on('fromInputPanel', (type) => {
            $('#input-type').hide();
        })

        Livewire.on('toInputPanel', (type) => {
            $('#input-type').removeClass();
            $('#input-type').addClass('bg-'+type+' w-100 fs-5 pb-1 mb-0 rounded text-center text-light fw-bold');
            $('#input-type').html(type.toUpperCase());
            $('#input-type').show();
        })

        Livewire.on('preSubmitRework', (defectId, defectSize, defectType, defectArea) => {
            Swal.fire({
                icon: 'info',
                title: 'REWORK defect ini?',
                html: `<table class="table text-start w-auto mx-auto">
                            <tr>
                                <td>ID<td>
                                <td>:<td>
                                <td>`+defectId+`<td>
                            <tr>
                            <tr>
                                <td>Size<td>
                                <td>:<td>
                                <td>`+defectSize+`<td>
                            <tr>
                            <tr>
                                <td>Defect Type<td>
                                <td>:<td>
                                <td>`+defectType+`<td>
                            <tr>
                            <tr>
                                <td>Defect Area<td>
                                <td>:<td>
                                <td>`+defectArea+`<td>
                            <tr>
                        </table>`,
                showConfirmButton: true,
                showDenyButton: true,
                confirmButtonText: 'Rework',
                confirmButtonColor: '#447efa',
                denyButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emit('submitRework', defectId);
                } else if (result.isDenied) {
                    Swal.fire({
                        icon: 'info',
                        title: 'Submit REWORK dibatalkan',
                        confirmButtonText: 'Ok',
                        confirmButtonColor: '#447efa',
                    });
                }
            });
        })

        Livewire.on('preCancelRework', (reworkId, defectId, defectSize, defectType, defectArea) => {
            Swal.fire({
                icon: 'warning',
                title: 'Kembalikan REWORK ini ke DEFECT?',
                html: `<table class="table text-start w-auto mx-auto">
                            <tr>
                                <td>Rework ID<td>
                                <td>:<td>
                                <td>`+reworkId+`<td>
                            <tr>
                                <tr>
                                <td>Defect ID<td>
                                <td>:<td>
                                <td>`+defectId+`<td>
                            <tr>
                            <tr>
                                <td>Size<td>
                                <td>:<td>
                                <td>`+defectSize+`<td>
                            <tr>
                            <tr>
                                <td>Defect Type<td>
                                <td>:<td>
                                <td>`+defectType+`<td>
                            <tr>
                            <tr>
                                <td>Defect Area<td>
                                <td>:<td>
                                <td>`+defectArea+`<td>
                            <tr>
                        </table>`,
                showConfirmButton: true,
                showDenyButton: true,
                confirmButtonText: 'Defect',
                confirmButtonColor: '#ff971f',
                denyButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emit('cancelRework', reworkId, defectId);
                } else if (result.isDenied) {
                    Swal.fire({
                        icon: 'info',
                        title: 'Pengembalian REWORK KE DEFECT dibatalkan',
                        confirmButtonText: 'Ok',
                        confirmButtonColor: '#447efa',
                    });
                }
            });
        })
    </script>
@endsection
