@extends('layouts.index')

@section('content')
    {{-- Info --}}
    <div class="production-info row row-gap-1 align-items-center mb-3">
        <div class="col-md-2">
            <div class="mb-1">
                <label class="form-label mb-0">Buyer</label>
                <input type="text" class="form-control form-control-sm" id="buyer-name" readonly>
            </div>
        </div>
        <div class="col-md-2">
            <div class="mb-1">
                <label class="form-label mb-0">WS Number</label>
                <input type="text" class="form-control form-control-sm" id="ws-number" readonly>
            </div>
        </div>
        <div class="col-md-2">
            <div class="mb-1">
                <label class="form-label mb-0">PO</label>
                <input type="text" class="form-control form-control-sm" id="po-number" readonly>
            </div>
        </div>
        <div class="col-md-2">
            <div class="mb-1">
                <label class="form-label mb-0">Style</label>
                <input type="text" class="form-control form-control-sm" id="style-name" readonly>
            </div>
        </div>
        <div class="col-md-2">
            <div class="mb-1">
                <label class="form-label mb-0">Product Type</label>
                <input type="text" class="form-control form-control-sm" id="product-type" readonly>
            </div>
        </div>
        <div class="col-md-2">
            <div class="mb-1">
                <label class="form-label mb-0">Color</label>
                <input type="text" class="form-control form-control-sm" id="product-color" readonly>
            </div>
        </div>
    </div>

    {{-- Panel --}}
    <div class="production-panel row row-gap-3">
        <div class="col-md-6" id="to-rft">
            <div class="d-flex h-100">
                <div class="card-custom bg-success d-flex justify-content-between align-items-center w-75 h-100">
                    <div class="d-flex flex-column gap-3">
                        <p class="text-light"><i class="fa-regular fa-circle-check fa-2xl"></i></p>
                        <p class="text-light">RFT</p>
                    </div>
                    <p class="text-light fs-1">313</p>
                </div>
                <div class="card-custom-footer bg-light w-25 h-100">
                    <div class="d-flex flex-column justify-content-center align-items-stretch h-100 gap-1">
                        <div class="filter multi-item upper h-50 bg-pale">
                            <div class="d-flex flex-column justify-content-between w-100 h-100">
                                <select class="form-select" style="border-radius: 0 15px 0 0">
                                    <option selected>All Size</option>
                                    <option value="s">S</option>
                                    <option value="m">M</option>
                                    <option value="l">L</option>
                                    <option value="xl">XL</option>
                                </select>
                                <p class="text-center fs-3 mt-auto mb-auto">313</p>
                            </div>
                        </div>
                        <button class="reset multi-item lower btn btn-pale h-50">
                            <i class="fa-regular fa-rotate-left fa-2xl"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6" id="to-defect">
            <div class="d-flex h-100">
                <div class="card-custom bg-warning d-flex justify-content-between align-items-center w-75 h-100">
                    <div class="d-flex flex-column gap-3">
                        <p class="text-light"><i class="fa-regular fa-circle-exclamation fa-2xl"></i></p>
                        <p class="text-light">DEFECT</p>
                    </div>
                    <p class="text-light fs-1">313</p>
                </div>
                <div class="card-custom-footer bg-light w-25 h-100">
                    <div class="d-flex flex-column justify-content-center align-items-stretch h-100 gap-1">
                        <button class="filter multi-item upper btn btn-pale h-50">
                            <div class="d-flex flex-column justify-content-center align-items-center w-100 h-100">
                                <p class="mb-1">HISTORY</p>
                                <p class="mb-0"><i class="fa-regular fa-clock-rotate-left fa-xl"></i></p>
                            </div>
                        </button>
                        <button class="reset multi-item lower btn btn-pale h-50">
                            <div class="d-flex flex-column justify-content-center align-items-center w-100 h-100">
                                <p class="mb-1">RESET</p>
                                <p class="mb-0"><i class="fa-regular fa-rotate-left fa-xl"></i></p>
                            </div>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6" id="to-reject">
            <div class="d-flex h-100">
                <div class="card-custom bg-danger d-flex justify-content-between align-items-center w-75 h-100">
                    <div class="d-flex flex-column gap-3">
                        <p class="text-light"><i class="fa-regular fa-circle-xmark fa-2xl"></i></p>
                        <p class="text-light">REJECT</p>
                    </div>
                    <p class="text-light fs-1">313</p>
                </div>
                <div class="card-custom-footer bg-light w-25 h-100">
                    <button class="reset single-item btn btn-pale w-100 h-100">
                        <i class="fa-regular fa-rotate-left fa-2xl"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="col-md-6" id="to-rework">
            <div class="d-flex h-100">
                <div class="card-custom bg-primary d-flex justify-content-between align-items-center w-75 h-100">
                    <div class="d-flex flex-column gap-3">
                        <p class="text-light"><i class="fa-regular fa-arrows-rotate fa-2xl"></i></p>
                        <p class="text-light">REWORK</p>
                    </div>
                    <p class="text-light fs-1">313</p>
                </div>
                <div class="card-custom-footer bg-light w-25 h-100">
                    <button class="reset single-item btn btn-pale w-100 h-100">
                        <i class="fa-regular fa-rotate-left fa-2xl"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
