{{-- Production Input --}}
<div class="production-input row row-gap-3">
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center bg-reject text-light">
                <p class="mb-0 fs-5">QTY</p>
                <button class="btn btn-dark">
                    <i class="fa-regular fa-plus"></i>
                </button>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <h3 class="text-center"><i class="fa-regular fa-shirt"></i> Piece</h3>
                </div>
                <input type="text" class="qty-input" id="reject-input" value="1">
                <div class="d-flex justify-content-between gap-1 mt-3">
                    <button class="btn btn-danger w-50 fs-3" id="decrement" onclick="decrement('reject-input')">-1</button>
                    <button class="btn btn-success w-50 fs-3" id="increment" onclick="increment('reject-input')">+1</button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center bg-reject text-light">
                <p class="mb-0 fs-5">Size</p>
                <div class="d-flex justify-content-end align-items-center gap-1">
                    <div class="d-flex align-items-center gap-3 me-3">
                        <p class="mb-0 fs-5">REJECT</p>
                        <p class="mb-0 fs-5">:</p>
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
                    <div class="col-md-3">
                        <button class="btn btn-reject w-100 h-100 fs-3">
                            XS
                        </button>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-reject w-100 h-100 fs-3">
                            S
                        </button>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-reject w-100 h-100 fs-3">
                            M
                        </button>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-reject w-100 h-100 fs-3">
                            L
                        </button>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-reject w-100 h-100 fs-3">
                            XL
                        </button>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-reject w-100 h-100 fs-3">
                            XXL
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Back --}}
<a onclick="toProductionPanel('#reject-container')" class="back bg-sb text-light text-center w-auto">
    <i class="fa-regular fa-reply"></i>
</a>

@section('footer')
    <footer class="footer fixed-bottom py-3">
        <div class="container-fluid">
            <div class="d-flex justify-content-end">
                <button class="btn btn-dark btn-lg ms-auto fs-3">SELESAI</button>
            </div>
        </div>
    </footer>
@endsection
