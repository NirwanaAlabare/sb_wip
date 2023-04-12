<div>
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
                @error('outputInput')
                    <div class="alert alert-danger alert-dismissible fade show mb-0 rounded-0" role="alert">
                        <strong>Error</strong> {{$message}}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @enderror
                <div class="card-body">
                    <div class="mb-3">
                        <h3 class="text-center"><i class="fa-regular fa-shirt"></i> Piece</h3>
                    </div>
                    <input type="text" class="qty-input" id="rft-input" value="{{ $outputInput }}" wire:model='outputInput'>
                    <div class="d-flex justify-content-between gap-1 mt-3">
                        <button class="btn btn-danger w-50 fs-3" id="decrement" wire:click="outputDecrement">-1</button>
                        <button class="btn btn-success w-50 fs-3" id="increment" wire:click="outputIncrement">+1</button>
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
                            <p class="mb-1 fs-5">RFT</p>
                            <p class="mb-1 fs-5">:</p>
                            <p id="rft-qty" class="mb-1 fs-5">0</p>
                        </div>
                        <button class="btn btn-dark" wire:click='clearInput'>
                            <i class="fa-regular fa-rotate-left"></i>
                        </button>
                        <button class="btn btn-dark">
                            <i class="fa-regular fa-gear"></i>
                        </button>
                    </div>
                </div>
                @error('sizeInput')
                    <div class="alert alert-danger alert-dismissible fade show mb-0 rounded-0" role="alert">
                        <strong>Error</strong> {{$message}}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @enderror
                <div class="card-body">
                    <input type="hidden" class="form-control mb-3" id="size-input" value="{{ $sizeInput }}" wire:model='sizeInput'>
                    <div class="row h-100 row-gap-3">
                        @foreach ($orderWsDetailSizes as $order)
                            <div class="col-md-4">
                                <button class="btn btn-reject w-100 h-100 fs-3 {{ $sizeInput == $order->size ? 'active' : '' }}" wire:click="setSizeInput('{{ $order->size }}')">
                                    {{ $order->size }}
                                </button>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Back --}}
    <a wire:click="$emit('toProductionPanel')" class="back bg-sb text-light text-center w-auto">
        <i class="fa-regular fa-reply"></i>
    </a>

    {{-- Footer --}}
    <footer class="footer fixed-bottom py-3">
        <div class="container-fluid">
            <div class="d-flex justify-content-end">
                <button class="btn btn-dark btn-lg ms-auto fs-3" wire:click='submitInput'>SELESAI</button>
            </div>
        </div>
    </footer>
</div>
