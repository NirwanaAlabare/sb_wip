@extends('layouts.index')

@section('content')
    {{-- Production Panel Livewire --}}
    @livewire('production-panel', ['orderInfo' => $orderInfo, 'orderWsDetails' => $orderWsDetails])

    {{-- Select Defect Area --}}
    <div class="select-defect-area" id="select-defect-area">
        <div class="defect-area-position-container">
            <div class="d-flex">
                <div class="d-flex justify-content-center align-items-center">
                    <label class="text-light bg-dark" style="padding: .375rem .75rem;height: 100%">X </label>
                    <input type="text" class="form-control rounded-0" id="defect-area-position-x" readonly>
                </div>
                <div class="d-flex justify-content-center align-items-center">
                    <label class="text-light bg-dark h-100" style="padding: .375rem .75rem;height: 100%">Y </label>
                    <input type="text" class="form-control rounded-0" id="defect-area-position-y" readonly>
                </div>
            </div>
            <div class="d-flex">
                <button class="btn btn-success rounded-0" id="defect-area-confirm">
                    <i class="fa-regular fa-check"></i>
                </button>
                <button class="btn btn-danger rounded-0" id="defect-area-cancel">
                    <i class="fa-regular fa-xmark"></i>
                </button>
            </div>
        </div>
        <div class="defect-area-img-container" id="defect-area-img-container">
            <div class="defect-area-img-point" id="defect-area-img-point"></div>
            <img src="" alt="" class="img-fluid defect-area-img" id="defect-area-img">
        </div>
    </div>

    {{-- Show Defect Area --}}
    <div class="show-defect-area" id="show-defect-area">
        <div class="position-relative d-flex flex-column justify-content-center align-items-center">
            <button type="button" class="btn btn-lg btn-light rounded-0 hide-defect-area-img" onclick="onHideDefectAreaImage()">
                <i class="fa-regular fa-xmark fa-lg"></i>
            </button>
            <div class="defect-area-img-container mx-auto">
                <div class="defect-area-img-point" id="defect-area-img-point-show"></div>
                <img src="" alt="" class="img-fluid defect-area-img" id="defect-area-img-show">
            </div>
        </div>
    </div>
@endsection

@section('custom-script')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            $('.select2').select2({
                theme: "bootstrap-5",
                width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
                placeholder: $( this ).data( 'placeholder' ),
            });
        });

        Livewire.on('alert', (type, message) => {
            showNotification(type, message);
        })

        Livewire.on('showModal', (type) => {
            if (type == 'defect') {
                showDefectModal();
            } else if (type == 'undo') {
                showUndoModal();
            } else if (type == 'addProductType') {
                showAddProductTypeModal();
            } else if (type == 'addDefectType') {
                showAddDefectTypeModal();
            } else if (type == 'addDefectArea') {
                showAddDefectAreaModal();
            }
        });

        Livewire.on('hideModal', (type) => {
            if (type == 'defect') {
                hideDefectModal();
            } else if (type == 'undo') {
                hideUndoModal();
            } else if (type == 'addDefectType') {
                hideAddDefectTypeModal();
            } else if (type == 'addDefectArea') {
                hideAddDefectAreaModal();
            }
        });

        Livewire.on('fromInputPanel', (type) => {
            $('#input-type').hide();
        });

        Livewire.on('toInputPanel', (type) => {
            $('#input-type').removeClass();
            $('#input-type').addClass('bg-'+type+' w-100 fs-6 pb-1 mb-0 rounded text-center text-light fw-bold');
            $('#input-type').html(type.toUpperCase());
            $('#input-type').show();
        });

        Livewire.on('preSubmitRework', (defectId, defectSize, defectType, defectArea, defectImage, defectX, defectY) => {
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
                            <tr>
                                <td>Defect Image<td>
                                <td>:<td>
                                <td>
                                    <button type="button" class="btn btn-dark" onclick="onShowDefectAreaImage('`+defectImage+`', '`+defectX+`', '`+defectY+`')">
                                        <i class="fa-regular fa-image"></i>
                                    </button>
                                <td>
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
        });

        Livewire.on('preCancelRework', (reworkId, defectId, defectSize, defectType, defectArea, defectImage, defectX, defectY) => {
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
                            <tr>
                                <td>Defect Image<td>
                                <td>:<td>
                                <td>
                                    <button type="button" class="btn btn-dark" onclick="onShowDefectAreaImage('`+defectImage+`', '`+defectX+`', '`+defectY+`')">
                                        <i class="fa-regular fa-image"></i>
                                    </button>
                                <td>
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
        });

        // Select Defect Area Position
        Livewire.on('showSelectDefectArea', async function (defectAreaImage) {
            showSelectDefectArea(defectAreaImage);
        });

        if (document.getElementById('select-defect-area')) {
            let defectAreaImageContainer = document.getElementById('defect-area-img-container');
            let defectAreaImage = document.getElementById('defect-area-img');
            let defectAreaImagePoint = document.getElementById('defect-area-img-point');
            let defectAreaPositionX = document.getElementById('defect-area-position-x');
            let defectAreaPositionY = document.getElementById('defect-area-position-y');
            let defectAreaConfirm = document.getElementById('defect-area-confirm');
            let defectAreaCancel = document.getElementById('defect-area-cancel');

            let localMousePos = { x: undefined, y: undefined };
            let globalMousePos = { x: undefined, y: undefined };

            defectAreaImageContainer.addEventListener('mousemove', (event) => {
                let rect = defectAreaImage.getBoundingClientRect();

                const localX = event.clientX - rect.left;
                const localY = event.clientY - rect.top;

                localMousePos = { x: localX, y: localY };

                defectAreaImageContainer.addEventListener('click', (event) => {
                    defectAreaImagePoint.style.left = (localMousePos.x - 25)+'px';
                    defectAreaImagePoint.style.top = (localMousePos.y - 25)+'px';
                    defectAreaImagePoint.style.display = 'block';

                    defectAreaPositionX.value = localMousePos.x;
                    defectAreaPositionY.value = localMousePos.y;
                });
            });

            defectAreaConfirm.addEventListener('click', () => {
                Livewire.emit('setDefectAreaPosition', defectAreaPositionX.value, defectAreaPositionY.value);

                hideSelectDefectArea();
            });

            defectAreaCancel.addEventListener('click', () => {
                defectAreaImagePoint.style.left = '0px';
                defectAreaImagePoint.style.top = '0px';
                defectAreaImagePoint.style.display = 'none';

                defectAreaPositionX.value = null;
                defectAreaPositionY.value = null;

                Livewire.emit('setDefectAreaPosition', defectAreaPositionX.value, defectAreaPositionY.value);

                hideSelectDefectArea();
            });
        }

        function onShowDefectAreaImage(defectAreaImage, x, y) {
            Livewire.emit('showDefectAreaImage', defectAreaImage, x, y);
        }

        Livewire.on('showDefectAreaImage', (defectAreaImage, x, y) => {
            let defectAreaImagePoint = document.getElementById('defect-area-img-point-show');

            defectAreaImagePoint.style.left = (parseFloat(x)-25)+'px';
            defectAreaImagePoint.style.top = (parseFloat(y)-25)+'px';
            defectAreaImagePoint.style.display = 'block';

            showDefectAreaImage(defectAreaImage)
        });

        function onHideDefectAreaImage() {
            hideDefectAreaImage();

            Livewire.emit('hideDefectAreaImageClear');
        }
    </script>
@endsection
