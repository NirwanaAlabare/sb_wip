<div>
    <div class="production-input row row-gap-3">
        <div class="col-md-12">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center bg-defect text-light">
                    <p class="mb-0 fs-5">Defect History</p>
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
                            <td>1</td>
                            <td>1</td>
                            <td>XS</td>
                            <td>Asd</td>
                            <td>Fgh</td>
                            <td class="text-defect fw-bold">Defect</td>
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
        {{-- <div class="col-md-8">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center bg-rework text-light">
                    <p class="mb-0 fs-5">Size</p>
                    <div class="d-flex justify-content-end align-items-center gap-1">
                        <div class="d-flex align-items-center gap-3 me-3">
                            <p class="mb-1 fs-5">REWORK</p>
                            <p class="mb-1 fs-5">:</p>
                            <p id="rft-qty" class="mb-1 fs-5">0</p>
                        </div>
                        <button class="btn btn-dark">
                            <i class="fa-regular fa-rotate-left"></i>
                        </button>
                        <button class="btn btn-dark">
                            <i class="fa-regular fa-gear"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <input type="hidden" class="form-control mb-3">
                    <div class="row h-100 row-gap-3">
                        <div class="col-3">
                            <button class="btn btn-rework w-100 h-100 fs-3">
                                XS
                            </button>
                        </div>
                        <div class="col-3">
                            <button class="btn btn-rework w-100 h-100 fs-3">
                                S
                            </button>
                        </div>
                        <div class="col-3">
                            <button class="btn btn-rework w-100 h-100 fs-3">
                                M
                            </button>
                        </div>
                        <div class="col-3">
                            <button class="btn btn-rework w-100 h-100 fs-3">
                                L
                            </button>
                        </div>
                        <div class="col-3">
                            <button class="btn btn-rework w-100 h-100 fs-3">
                                XL
                            </button>
                        </div>
                        <div class="col-3">
                            <button class="btn btn-rework w-100 h-100 fs-3">
                                XXL
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>

    {{-- Back --}}
    <a wire:click="$emit('toProductionPanel')" class="back bg-sb text-light text-center w-auto">
        <i class="fa-regular fa-reply"></i>
    </a>
</div>
