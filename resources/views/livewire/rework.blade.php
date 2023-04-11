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
                <div class="card-body table-responsive-sm">
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
                        <tr>
                            <td>1</td>
                            <td>1</td>
                            <td>XS</td>
                            <td>Asd</td>
                            <td>Fgh</td>
                            <td class="text-defect fw-bold">Defect</td>
                            <td>
                                <button class="btn btn-rework fw-bold w-100" onclick="reworkConfirmation()">REWORK</button>
                            </td>
                        </tr>
                    </table>
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
                <div class="card-body table-responsive-sm">
                    <table class="table table-bordered text-center align-middle">
                        <tr>
                            <th>No.</th>
                            <th>ID</th>
                            <th>Size</th>
                            <th>Defect Type</th>
                            <th>Defect Area</th>
                            <th>Status</th>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>2</td>
                            <td>S</td>
                            <td>Zxc</td>
                            <td>Vbn</td>
                            <td class="text-rework fw-bold">Reworked</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Back --}}
    <a wire:click="$emit('toProductionPanel')" class="back bg-sb text-light text-center w-auto">
        <i class="fa-regular fa-reply"></i>
    </a>
</div>
