<div>
    {{-- Production Input --}}
    <div class="production-input row row-gap-3">
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center bg-rework text-light">
                    <p class="mb-0 fs-5">Data Defect</p>
                    <div class="d-flex justify-content-end align-items-center gap-1">
                        <button class="btn btn-dark">
                            <i class="fa-regular fa-rotate-left"></i>
                        </button>
                        <button class="btn btn-dark">
                            <i class="fa-regular fa-gear    "></i>
                        </button>
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
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        @if ($defects->count() < 1)
                            <tr>
                                <td colspan='7'>Defect tidak ditemukan</td>
                            </tr>
                        @else
                            @foreach ($defects as $defect)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $defect->id }}</td>
                                    <td>{{ $defect->so_det_size }}</td>
                                    <td>{{ $defect->defectArea->defectType->defect_type}}</td>
                                    <td>{{ $defect->defectArea->defect_area }}</td>
                                    <td class="text-defect fw-bold">{{ strtoupper($defect->defect_status) }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-rework fw-bold w-100" wire:click="$emit('preSubmitRework', '{{ $defect->id }}', '{{ $defect->so_det_size }}', '{{ $defect->defectArea->defectType->defect_type }}', '{{ $defect->defectArea->defect_area }}')">REWORK</button>
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
                        <button class="btn btn-dark">
                            <i class="fa-regular fa-rotate-left"></i>
                        </button>
                        <button class="btn btn-dark">
                            <i class="fa-regular fa-gear"></i>
                        </button>
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
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        @if ($reworks->count() < 1)
                            <tr>
                                <td colspan='7'>Rework tidak ditemukan</td>
                            </tr>
                        @else
                            @foreach ($reworks as $rework)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $rework->defect->id }}</td>
                                    <td>{{ $rework->so_det_size }}</td>
                                    <td>{{ $rework->defect->defectArea->defectType->defect_type}}</td>
                                    <td>{{ $rework->defect->defectArea->defect_area }}</td>
                                    <td class="text-rework fw-bold">{{ strtoupper($rework->defect->defect_status) }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-defect fw-bold w-100" wire:click="$emit('preCancelRework', '{{ $rework->id }}', '{{ $rework->defect->id }}', '{{ $rework->so_det_size }}', '{{ $rework->defect->defectArea->defectType->defect_type }}', '{{ $rework->defect->defectArea->defect_area }}')">CANCEL</button>
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

    {{-- Back --}}
    <a wire:click="$emit('toProductionPanel')" class="back bg-sb text-light text-center w-auto">
        <i class="fa-regular fa-reply"></i>
    </a>
</div>
