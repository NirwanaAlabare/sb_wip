<div>
    <div class="loading-container-fullscreen" wire:loading wire:target='submitMassRework'>
        <div class="loading"></div>
    </div>
    {{-- Production Input --}}
    <div class="production-input row row-gap-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header align-items-center bg-rework text-light">
                    <p class="mb-0 fs-5">Defect</p>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-7">
                            <div class="scroll-defect-area-img">
                                <div class="all-defect-area-img-container">
                                    @foreach ($allDefectPosition as $defectPosition)
                                        <div class="all-defect-area-img-point" style="left: {{ floatval($defectPosition->defect_area_x) - floatval(25) }}px;top: {{ floatval($defectPosition->defect_area_y) - floatval(25) }}px;"></div>
                                    @endforeach
                                    @if ($allDefectImage)
                                        <img src="/storage/images/{{ $allDefectImage->productType->image }}" class="all-defect-area-img" alt="defect image">
                                    @else
                                        <img src="/assets/images/notfound.png" class="all-defect-area-img" alt="defect image">
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5 table-responsive">
                            <table class="table table-bordered vertical-align-center">
                                <thead>
                                    <tr>
                                        <th>Tipe</th>
                                        <th>Area</th>
                                        <th>Total</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($allDefectList->count() < 1)
                                        <tr>
                                            <td colspan="4" class="text-center">Defect tidak ditemukan</td>
                                        </tr>
                                    @else
                                        @foreach ($allDefectList as $defectList)
                                            <tr>
                                                <td>{{ $defectList->defect_type }}</td>
                                                <td>{{ $defectList->defect_area }}</td>
                                                <td><b>{{$defectList->total}}</b></td>
                                                <td>
                                                    <button class="btn btn-sm btn-rework fw-bold w-100"
                                                        wire:click="preSubmitMassRework('{{ $defectList->defect_type_id }}', '{{ $defectList->defect_area_id }}', '{{ $defectList->defect_type }}', '{{ $defectList->defect_area }}')">
                                                        REWORK
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center bg-rework text-light">
                    <p class="mb-0 fs-5">Data Defect</p>
                    <div class="d-flex justify-content-end align-items-center gap-1">
                        <button type="button" class="btn btn-dark" wire:click="$emit('preSubmitUndo', 'defect')">
                            <i class="fa-regular fa-rotate-left"></i>
                        </button>
                        {{-- <button type="button" class="btn btn-dark">
                            <i class="fa-regular fa-gear"></i>
                        </button> --}}
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <div class="d-flex justify-content-center align-items-center">
                        <input type="text" class="form-control mb-3 rounded-0" id="search-defect" name="search-defect" wire:model='searchDefect' placeholder="Search here...">
                    </div>
                    <table class="table table-bordered text-center align-middle">
                        <tr>
                            <th>No.</th>
                            <th>ID</th>
                            <th>Size</th>
                            <th>Defect Type</th>
                            <th>Defect Area</th>
                            <th>Defect Area Image</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        @if ($defects->count() < 1)
                            <tr>
                                <td colspan='8'>Defect tidak ditemukan</td>
                            </tr>
                        @else
                            @foreach ($defects as $defect)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $defect->id }}</td>
                                    <td>{{ $defect->so_det_size }}</td>
                                    <td>{{ $defect->defectType->defect_type}}</td>
                                    <td>{{ $defect->defectArea->defect_area }}</td>
                                    <td>
                                        <button type="button" class="btn btn-dark" wire:click="showDefectAreaImage('{{$defect->productType->image}}', {{$defect->defect_area_x}}, {{$defect->defect_area_y}})'">
                                            <i class="fa-regular fa-image"></i>
                                        </button>
                                    </td>
                                    <td class="text-defect fw-bold">{{ strtoupper($defect->defect_status) }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-rework fw-bold w-100"
                                            wire:click="$emit('preSubmitRework', '{{ $defect->id }}', '{{ $defect->so_det_size }}', '{{ $defect->defectType->defect_type }}', '{{ $defect->defectArea->defect_area }}', '{{ $defect->productType->image }}', '{{ $defect->defect_area_x }}', '{{ $defect->defect_area_y }}')">
                                            REWORK
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </table>
                    {{ $defects->links() }}
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center bg-rework text-light">
                    <p class="mb-0 fs-5">Data Rework</p>
                    <div class="d-flex justify-content-end align-items-center gap-1">
                        <button type="button" class="btn btn-dark" wire:click="$emit('preSubmitUndo', 'rework')">
                            <i class="fa-regular fa-rotate-left"></i>
                        </button>
                        {{-- <button type="button" class="btn btn-dark">
                            <i class="fa-regular fa-gear"></i>
                        </button> --}}
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <div class="d-flex justify-content-center align-items-center">
                        <input type="text" class="form-control mb-3 rounded-0" id="search-rework" name="search-rework" wire:model='searchRework' placeholder="Search here...">
                    </div>
                    <table class="table table-bordered text-center align-middle">
                        <tr>
                            <th>No.</th>
                            <th>ID</th>
                            <th>Size</th>
                            <th>Defect Type</th>
                            <th>Defect Area</th>
                            <th>Defect Area Image</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        @if ($reworks->count() < 1)
                            <tr>
                                <td colspan='8'>Rework tidak ditemukan</td>
                            </tr>
                        @else
                            @foreach ($reworks as $rework)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $rework->defect->id }}</td>
                                    <td>{{ $rework->so_det_size }}</td>
                                    <td>{{ $rework->defect->defectType->defect_type}}</td>
                                    <td>{{ $rework->defect->defectArea->defect_area }}</td>
                                    <td class="text-rework fw-bold">{{ strtoupper($rework->defect->defect_status) }}</td>
                                    <td>
                                        <button type="button" class="btn btn-dark" wire:click="showDefectAreaImage('{{$rework->defect->productType->image}}', {{$rework->defect->defect_area_x}}, {{$rework->defect->defect_area_y}})'">
                                            <i class="fa-regular fa-image"></i>
                                        </button>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-defect fw-bold w-100" wire:click="$emit('preCancelRework', '{{ $rework->id }}', '{{ $rework->defect->id }}', '{{ $rework->so_det_size }}', '{{ $rework->defect->defectType->defect_type }}', '{{ $rework->defect->defectArea->defect_area }}', '{{$rework->defect->productType->image}}', {{$rework->defect->defect_area_x}}, {{$rework->defect->defect_area_y}})">CANCEL</button>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </table>
                    {{ $reworks->links() }}
                </div>
            </div>
        </div>
    </div>

    <div class="modal" tabindex="-1" id="mass-rework-modal" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title text-rework fw-bold">MASS REWORK</h5>
              <button type="button" class="btn btn-light border-none pt-1 close" data-dismiss="modal" aria-label="Close" wire:click="$emit('hideModal', 'massRework')">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    @error('massQty')
                        <div class="alert alert-danger alert-dismissible fade show mb-0 rounded-0" role="alert">
                            <small>
                                <strong>Error</strong> {{$message}}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </small>
                        </div>
                    @enderror
                    <label class="form-label">QTY</label>
                    <input type="number" class="form-control @error('massQty') is-invalid @enderror" name="mass-qty" id="mass-qty" value="1" wire:model=massQty>
                </div>
                <div class="mb-3">
                    @error('massSize')
                        <div class="alert alert-danger alert-dismissible fade show mb-0 rounded-0" role="alert">
                            <small>
                                <strong>Error</strong> {{$message}}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </small>
                        </div>
                    @enderror
                    <label class="form-label">Size</label>
                    <select class="form-select @error('massSize') is-invalid @enderror" name="mass-size" id="mass-size" wire:model='massSize'>
                        <option value="" selected disabled>Select Size</option>
                        @foreach ($massSelectedDefect as $defect)
                            <option value="{{ $defect->so_det_id }}">{{ $defect->size }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <input type="hidden" name="mass-defect-type" id="mass-defect-type" wire:model=massDefectType>
                    @error('massDefectType')
                        <div class="alert alert-danger alert-dismissible fade show mb-0 rounded-0" role="alert">
                            <small>
                                <strong>Error</strong> {{$message}}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </small>
                        </div>
                    @enderror
                    <label class="form-label">Defect Type</label>
                    <input type="text" class="form-control @error('massDefectType') is-invalid @enderror" wire:model=massDefectTypeName readonly>
                </div>
                <div class="mb-3">
                    <input type="hidden" name="mass-defect-area" id="mass-defect-area" wire:model=massDefectArea>
                    @error('massDefectArea')
                        <div class="alert alert-danger alert-dismissible fade show mb-0 rounded-0" role="alert">
                            <small>
                                <strong>Error</strong> {{$message}}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </small>
                        </div>
                    @enderror
                    <label class="form-label">Defect Area</label>
                    <input type="text" class="form-control @error('massDefectArea') is-invalid @enderror" wire:model=massDefectAreaName readonly>
                </div>
            </div>
            <div class="modal-footer">
              {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal" wire:click="$emit('hideModal', 'undo')">Close</button> --}}
              <button type="button" class="btn btn-rework" wire:click='submitMassRework()'>REWORK</button>
            </div>
          </div>
        </div>
    </div>

    {{-- Back --}}
    <a wire:click="$emit('toProductionPanel')" class="back bg-sb text-light text-center w-auto">
        <i class="fa-regular fa-reply"></i>
    </a>
</div>
