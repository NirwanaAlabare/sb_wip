<div class="row row-gap-3">
    <div class="col-md-6" id="rft-panel">
        <div class="d-flex h-100">
            <div class="card-custom bg-rft d-flex justify-content-between align-items-center w-75 h-100" onclick="toRft()">
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
    <div class="col-md-6" id="defect-panel">
        <div class="d-flex h-100">
            <div class="card-custom bg-defect d-flex justify-content-between align-items-center w-75 h-100" onclick="toDefect()">
                <div class="d-flex flex-column gap-3">
                    <p class="text-light"><i class="fa-regular fa-circle-exclamation fa-2xl"></i></p>
                    <p class="text-light">DEFECT</p>
                </div>
                <p class="text-light fs-1">313</p>
            </div>
            <div class="card-custom-footer bg-light w-25 h-100">
                <div class="d-flex flex-column justify-content-center align-items-stretch h-100 gap-1">
                    <button class="history multi-item upper btn btn-pale h-50" onclick="toDefectHistory()">
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
    <div class="col-md-6" id="reject-panel">
        <div class="d-flex h-100">
            <div class="card-custom bg-reject d-flex justify-content-between align-items-center w-75 h-100" onclick="toReject()">
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
    <div class="col-md-6" id="rework-panel">
        <div class="d-flex h-100">
            <div class="card-custom bg-rework d-flex justify-content-between align-items-center w-75 h-100" onclick="toRework()">
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
