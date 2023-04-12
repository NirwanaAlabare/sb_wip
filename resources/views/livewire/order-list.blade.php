<div>
    <div class="input-group mb-3">
        <input wire:model='search' type="text" class="form-control" placeholder="Search Order...">
        <button class="btn btn-sb" type="button" id="button-search-order"><i class="fa-regular fa-magnifying-glass"></i></button>
    </div>

    <div class="order-list row row-gap-3 mb-3">
        @if ($orders->isEmpty())
            <h5 class="text-center text-muted mt-3"><i class="fa-solid fa-circle-exclamation"></i> Order not found</h5>
        @else
            @foreach ($orders as $order)
                <a href="/production-panel/{{ $order->id }}" class="order col-md-6">
                    <div class="card">
                        <div class="card-body justify-content-start">
                            <table class="table table-responsive mb-1">
                                <tr>
                                    <td>Buyer</td>
                                    <td>:</td>
                                    <td class="fw-bold">{{ ucwords($order->buyer_name) }}</td>
                                </tr>
                                <tr>
                                    <td>WS Number</td>
                                    <td>:</td>
                                    <td class="fw-bold">{{ $order->ws_number }}</td>
                                </tr>
                                <tr>
                                    <td>OP Number</td>
                                    <td>:</td>
                                    <td class="fw-bold">{{ $order->ws_number }}</td>
                                </tr>
                                <tr>
                                    <td>Product Type</td>
                                    <td>:</td>
                                    <td class="fw-bold">{{ $order->product_type }}</td>
                                </tr>
                                <tr>
                                    <td>Style</td>
                                    <td>:</td>
                                    <td class="fw-bold">{{ ucwords($order->style_name) }}</td>
                                </tr>
                                <tr>
                                    <td>Plan Date</td>
                                    <td>:</td>
                                    <td class="fw-bold">{{ $order->plan_date }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </a href="/production-panel/{{ $order->id }}">
            @endforeach
        @endif
    </div>
</div>
