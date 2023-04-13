<div>
    <div class="input-group mb-3">
        <input wire:model='search' type="text" class="form-control" placeholder="Search Order...">
        <button class="btn btn-sb" type="button" id="button-search-order"><i class="fa-regular fa-magnifying-glass"></i></button>
    </div>

    <div class="order-list row row-gap-3 mb-3 h-100">
        @if ($orders->isEmpty())
            <h5 class="text-center text-muted mt-3"><i class="fa-solid fa-circle-exclamation"></i> Order not found</h5>
        @else
            @foreach ($orders as $order)
                <a href="/production-panel/{{ $order->id }}" class="order col-md-6 h-100">
                    <div class="card h-100">
                        <div class="card-body justify-content-start">
                            <table class="table table-responsive mb-1">
                                <tr>
                                    <td class="text-nowrap">Buyer</td>
                                    <td class="text-nowrap">:</td>
                                    <td class="fw-bold">{{ ucwords($order->buyer_name) }}</td>
                                </tr>
                                <tr>
                                    <td class="text-nowrap">WS Number</td>
                                    <td class="text-nowrap">:</td>
                                    <td class="fw-bold">{{ $order->ws_number }}</td>
                                </tr>
                                <tr>
                                    <td class="text-nowrap">OP Number</td>
                                    <td class="text-nowrap">:</td>
                                    <td class="fw-bold">{{ $order->ws_number }}</td>
                                </tr>
                                <tr>
                                    <td class="text-nowrap">Product Type</td>
                                    <td class="text-nowrap">:</td>
                                    <td class="fw-bold">{{ $order->product_type }}</td>
                                </tr>
                                <tr>
                                    <td class="text-nowrap">Style</td>
                                    <td class="text-nowrap">:</td>
                                    <td class="fw-bold">{{ ucwords($order->style_name) }}</td>
                                </tr>
                                <tr>
                                    <td class="text-nowrap">Plan Date</td>
                                    <td class="text-nowrap">:</td>
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
