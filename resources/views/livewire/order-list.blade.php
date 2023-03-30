<div>
    <div class="input-group mb-3">
        <input wire:model='search' type="text" class="form-control" placeholder="Search Order...">
        <button class="btn btn-sb" type="button" id="button-search-order"><i class="fa-regular fa-magnifying-glass"></i></button>
    </div>

    <div class="row row-gap-3 mb-3">
        @foreach ($items as $item)
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body row justify-content-start">
                        <h3 text-center>{{ $item->name }}</h3>
                        {{-- <div class="col-lg-6">
                            <table class="table">
                                <tr>
                                    <td class="fw-bold">Buyer</td>
                                    <td class="fw-bold">:</td>
                                    <td class="fw-bold">?????????</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">WS Number</td>
                                    <td class="fw-bold">:</td>
                                    <td class="fw-bold">?????????</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">OP Number</td>
                                    <td class="fw-bold">:</td>
                                    <td class="fw-bold">?????????</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-lg-6">
                            <table class="table">
                                <tr>
                                    <td>Product Type</td>
                                    <td>:</td>
                                    <td>?????????</td>
                                </tr>
                                <tr>
                                    <td>Style</td>
                                    <td>:</td>
                                    <td>?????????</td>
                                </tr>
                                <tr>
                                    <td>Color</td>
                                    <td>:</td>
                                    <td>?????????</td>
                                </tr>
                            </table>
                        </div> --}}
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
