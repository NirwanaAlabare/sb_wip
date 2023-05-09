<div>
    {{-- Summary Line --}}
    <div class="mb-5">
        <h5 class="text-center mb-3">SUMMARY LINE</h5>
        <div class="d-flex justify-content-center align-items-center">
            <div class="mb-3">
                <input type="date" class="form-control" name="date-from" id="date-from" value="{{ date('Y-m-d') }}" wire:model='dateFrom'>
            </div>
            <span class="mx-3 mb-3"> - </span>
            <div class="mb-3">
                <input type="date" class="form-control" name="date-to" id="date-to" value="{{ date('Y-m-d') }}" wire:model='dateTo'>
            </div>
        </div>
        <div class="row row-gap-3">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-rft text-light fw-bold">
                        RFT
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Total RFT</h5>
                        <p class="card-text fs-3 fw-bold text-rft">{{ $totalRft }}</p>
                        {{-- <a href="#" class="btn btn-primary">Go somewhere</a> --}}
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-defect text-light fw-bold">
                        DEFECT
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Total DEFECT</h5>
                        <p class="card-text fs-3 fw-bold text-defect">{{ $totalDefect }}</p>
                        {{-- <a href="#" class="btn btn-primary">Go somewhere</a> --}}
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-reject text-light fw-bold">
                        REJECT
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Total REJECT</h5>
                        <p class="card-text fs-3 fw-bold text-reject">{{ $totalReject }}</p>
                        {{-- <a href="#" class="btn btn-primary">Go somewhere</a> --}}
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-rework text-light fw-bold">
                        REWORK
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Total REWORK</h5>
                        <p class="card-text fs-3 fw-bold text-rework">{{ $totalRework }}</p>
                        {{-- <a href="#" class="btn btn-primary">Go somewhere</a> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-5">
        <h5 class="text-center">LATEST OUTPUT</h5>
        <div class="row">
            {{-- <div class="col-md-12 table-responsive">
                <table class="table table-bordered w-100 mx-auto">
                    <thead>
                        <tr>
                            <th class="text-end w-50">Tanggal & Waktu</th>
                            <th class="text-start w-50">Tipe Output</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for ($i = 0; $i < count($latestOutput); $i++)
                            <tr>
                                <td class="text-end w-50">{{ $latestOutput[$i]->updated_at }}</td>
                                <td class="text-start w-50"> - </td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </div> --}}
            <div class="col-md-6 table-responsive mt-3">
                <table class="table table-bordered w-100 mx-auto">
                    <thead>
                        <tr>
                            <th class="text-end w-50">Tanggal & Waktu</th>
                            <th class="text-start w-50">Tipe Output</th>
                            <th class="text-start w-50">Ukuran Output</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($latestRfts) < 1)
                            <tr>
                                <td colspan="3">Data tidak ditemukan</td>
                            </tr>
                        @else
                            @foreach ($latestRfts as $latestRft)
                                <tr>
                                    <td class="text-end w-50">{{ $latestRft->updated_at }}</td>
                                    <td class="text-center text-rft fw-bold w-50"> RFT </td>
                                    <td class="text-start w-50">{{ $latestRft->size }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                {{ $latestRfts->links( )}}
            </div>
            <div class="col-md-6 table-responsive mt-3">
                <table class="table table-bordered w-100 mx-auto">
                    <thead>
                        <tr>
                            <th class="text-end w-50">Tanggal & Waktu</th>
                            <th class="text-center w-50">Tipe Output</th>
                            <th class="text-start w-50">Ukuran Output</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($latestDefects) < 1)
                            <tr>
                                <td colspan="3">Data tidak ditemukan</td>
                            </tr>
                        @else
                            @foreach ($latestDefects as $latestDefect)
                                <tr>
                                    <td class="text-end w-50">{{ $latestDefect->updated_at }}</td>
                                    <td class="text-center text-defect fw-bold w-50"> DEFECT </td>
                                    <td class="text-start w-50">{{ $latestDefect->size }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                {{ $latestDefects->links( )}}
            </div>
            <div class="col-md-6 table-responsive mt-3">
                <table class="table table-bordered w-100 mx-auto">
                    <thead>
                        <tr>
                            <th class="text-end w-50">Tanggal & Waktu</th>
                            <th class="text-center w-50">Tipe Output</th>
                            <th class="text-start w-50">Ukuran Output</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($latestRejects) < 1)
                            <tr>
                                <td colspan="3">Data tidak ditemukan</td>
                            </tr>
                        @else
                            @foreach ($latestRejects as $latestReject)
                                <tr>
                                    <td class="text-end w-50">{{ $latestReject->updated_at }}</td>
                                    <td class="text-center text-reject fw-bold w-50"> REJECT </td>
                                    <td class="text-start w-50">{{ $latestReject->size }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                {{ $latestRejects->links( )}}
            </div>
            <div class="col-md-6 table-responsive mt-3">
                <table class="table table-bordered w-100 mx-auto">
                    <thead>
                        <tr>
                            <th class="text-end w-50">Tanggal & Waktu</th>
                            <th class="text-start w-50">Tipe Output</th>
                            <th class="text-start w-50">Ukuran Output</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($latestReworks) < 1)
                            <tr>
                                <td colspan="3">Data tidak ditemukan</td>
                            </tr>
                        @else
                            @foreach ($latestReworks as $latestRework)
                                <tr>
                                    <td class="text-end w-50">{{ $latestRework->updated_at }}</td>
                                    <td class="text-center text-rework fw-bold w-50"> REWORK </td>
                                    <td class="text-start w-50">{{ $latestRework->size }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                {{ $latestReworks->links( )}}
            </div>
            {{-- <div class="col-md-8">
                <div id="daily-chart"></div>
            </div> --}}
        </div>
    </div>
</div>
