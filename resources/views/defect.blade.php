{{-- Production Input --}}
<div class="production-input row row-gap-3">
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center bg-defect text-light">
                <p class="mb-0 fs-5">QTY</p>
                <button class="btn btn-dark">
                    <i class="fa-regular fa-plus"></i>
                </button>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <h3 class="text-center"><i class="fa-regular fa-shirt"></i> Piece</h3>
                </div>
                <input type="text" class="qty-input" id="defect-input" value="1">
                <div class="d-flex justify-content-between gap-1 mt-3">
                    <button class="btn btn-danger w-50 fs-3" id="decrement" onclick="decrement('defect-input')">-1</button>
                    <button class="btn btn-success w-50 fs-3" id="increment" onclick="increment('defect-input')">+1</button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center bg-defect text-light">
                <p class="mb-1 fs-5">Size</p>
                <div class="d-flex flex-wrap justify-content-md-end align-items-center gap-1">
                    {{-- <div class="d-flex align-items-center gap-1 me-3">
                        <label class="mb-1">Type</label>
                        <select type="text" class="form-select">
                            <option value="" selected>Defect Type</option>
                            <option value="">asd</option>
                            <option value="">asd</option>
                        </select>
                    </div>
                    <div class="d-flex align-items-center gap-1 me-3">
                        <label class="mb-1">Area</label>
                        <select type="text" class="form-select">
                            <option value="" selected>Defect Area</option>
                            <option value="">asd</option>
                            <option value="">asd</option>
                        </select>
                    </div> --}}
                    <div class="d-flex align-items-center gap-3 me-3">
                        <p class="mb-1 fs-5">DEFECT</p>
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
                    <div class="col-sm-6 col-md-3">
                        <button class="btn btn-defect w-100 h-100 fs-3 btn-size" value="xs" data-bs-toggle="modal" data-bs-target="#defect-modal">
                            XS
                        </button>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <button class="btn btn-defect w-100 h-100 fs-3 btn-size" value="s" onclick="showDefectModal()">
                            S
                        </button>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <button class="btn btn-defect w-100 h-100 fs-3 btn-size" value="m" onclick="showDefectModal()">
                            M
                        </button>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <button class="btn btn-defect w-100 h-100 fs-3 btn-size" value="l" onclick="showDefectModal()">
                            L
                        </button>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <button class="btn btn-defect w-100 h-100 fs-3 btn-size" value="xl" onclick="showDefectModal()">
                            XL
                        </button>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <button class="btn btn-defect w-100 h-100 fs-3 btn-size" value="xxl" onclick="showDefectModal()">
                            XXL
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Defect Modal --}}
<div class="modal" tabindex="-1" id="defect-modal">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header bg-defect text-light">
            <h5 class="modal-title">DEFECT</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form>
                <div class="mb-3">
                    <label class="form-label">Defect Type</label>
                    <select class="form-select">
                        <option selected>Select defect type</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Defect Area</label>
                    <select class="form-select">
                        <option selected>Select defect area</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
            <button type="button" class="btn btn-success" data-bs-dismiss="modal">Selesai</button>
        </div>
        </div>
    </div>
</div>

{{-- Back --}}
<a onclick="toProductionPanel('#defect-container')" class="back bg-sb text-light text-center w-auto">
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
