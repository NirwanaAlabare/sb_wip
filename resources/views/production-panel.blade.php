@extends('layouts.index')

@section('custom-link')
    @livewireStyles
@endsection

@section('content')
    @php
        $orderInfo = $orderSql->where('master_plan.id', $plan_id)->first();
        $orderWsSql = $orderSql->where('master_plan.sewing_line', Auth::user()->username)->where('act_costing.kpno', $orderInfo->ws_number);
        $orderWsColors = $orderWsSql->get();
    @endphp

    {{-- Info --}}
    <div class="production-info row row-gap-1 align-items-center mb-3">
        <div class="col-md-2">
            <div class="mb-1">
                <label class="form-label mb-0">Buyer</label>
                <input type="text" class="form-control form-control-sm" id="buyer-name" value="{{ $orderInfo->buyer_name }}" readonly>
            </div>
        </div>
        <div class="col-md-2">
            <div class="mb-1">
                <label class="form-label mb-0">WS Number</label>
                <input type="text" class="form-control form-control-sm" id="ws-number" value="{{ $orderInfo->ws_number }}" readonly>
            </div>
        </div>
        <div class="col-md-2">
            <div class="mb-1">
                <label class="form-label mb-0">PO</label>
                <input type="text" class="form-control form-control-sm" id="po-number" value="{{ $orderInfo->ws_number }}" readonly>
            </div>
        </div>
        <div class="col-md-2">
            <div class="mb-1">
                <label class="form-label mb-0">Style</label>
                <input type="text" class="form-control form-control-sm" id="style-name" value="{{ $orderInfo->style_name }}" readonly>
            </div>
        </div>
        <div class="col-md-2">
            <div class="mb-1">
                <label class="form-label mb-0">Product Type</label>
                <input type="text" class="form-control form-control-sm" id="product-type" value="-" readonly>
            </div>
        </div>
        <div class="col-md-2">
            <div class="mb-1">
                <label class="form-label mb-0">Color</label>
                {{-- <input type="text" class="form-control form-control-sm" id="product-color" readonly> --}}
                <select class="select2 form-select-sm" name="state" id="product-color">
                    @foreach ($orderWs as $order)
                        <option value="{{ $order->color }}">{{ $order->color }}</option>
                    @endforeach
                    <option value="asd">asd</option>
                </select>
            </div>
        </div>
    </div>

    {{-- Panel --}}
    <div class="production-panel row row-gap-3" id="production-panel">
        <livewire:production-panel :orderWs="$orderWs">
    </div>

    <div id="rft-container">
        @include('rft')
    </div>
    <div id="defect-container">
        @include('defect')
    </div>
    <div id="defect-history-container">
        @include('defect-history')
    </div>
    <div id="reject-container">
        @include('reject')
    </div>
    <div id="rework-container">
        @include('rework')
    </div>
@endsection

@section('custom-script')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            let orderWs = @js($orderWs)

            $('.select2').select2({
                theme: "bootstrap-5",
                width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
                placeholder: $( this ).data( 'placeholder' ),
            });
            $('#rft-container').hide();
            $('#defect-container').hide();
            $('#defect-history-container').hide();
            $('#reject-container').hide();
            $('#rework-container').hide();
            $('.footer').hide();
        })

        $('#product-color').on('select2:select', (e) => {
            let
            let color = $('#product-color').val();

            // Livewire.emitTo('production-panel', ['orderWs' => orderWs, 'color' => color]);
        });
    </script>

    @livewireScripts
@endsection
