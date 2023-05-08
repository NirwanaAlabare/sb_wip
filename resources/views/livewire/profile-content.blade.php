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
            <div class="col table-responsive">
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
            </div>
            {{-- <div class="col-md-8">
                <div id="daily-chart"></div>
            </div> --}}
        </div>
    </div>
</div>
