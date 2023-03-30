@extends('layouts.index')

@section('custom-link')
    @livewireStyles
@endsection

@section('content')
    <livewire:order-list/>

    <div class="row row-gap-3">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body row justify-content-start">
                    <div class="col-lg-6">
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
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body row">
                    <div class="col-lg-6">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-script')
    @livewireScripts
@endsection
