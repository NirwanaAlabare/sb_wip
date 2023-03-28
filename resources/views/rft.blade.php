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

    {{-- Input Production --}}
    <div class="row">
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <p class="mb-0 fs-5">QTY</p>
                    <button class="btn btn-dark">
                        <i class="fa-regular fa-plus"></i>
                    </button>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h3 class="text-center"><i class="fa-regular fa-shirt"></i> Piece</h3>
                    </div>
                    <input type="text" class="qty-input" value="1">
                    <div class="d-flex justify-content-between gap-1 mt-3">
                        <button class="btn btn-danger w-50 fs-3">-1</button>
                        <button class="btn btn-success w-50 fs-3">+1</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <p class="mb-0 fs-5">Size</p>
                    <div class="d-flex justify-content-end align-items-center gap-1">
                        <div class="d-flex align-items-center gap-3 me-3">
                            <p class="mb-0 fs-5">RFT</p>
                            <p id="rft-qty" class="mb-0 fs-5">0</p>
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
                            <button class="btn btn-primary w-100 h-100">
                                XS
                            </button>
                        </div>
                        <div class="col-3">
                            <button class="btn btn-primary w-100 h-100">
                                S
                            </button>
                        </div>
                        <div class="col-3">
                            <button class="btn btn-primary w-100 h-100">
                                M
                            </button>
                        </div>
                        <div class="col-3">
                            <button class="btn btn-primary w-100 h-100">
                                L
                            </button>
                        </div>
                        <div class="col-3">
                            <button class="btn btn-primary w-100 h-100">
                                XL
                            </button>
                        </div>
                        <div class="col-3">
                            <button class="btn btn-primary w-100 h-100">
                                XXL
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
