<div class="modal fade" id="profile" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title me-3 fw-bold text-sb">Profile</h3>
                <button class="btn btn-sb rounded-circle me-3 mt-1" id="enable-profile" onclick="enableEditProfile()"><i class="fa fa-pencil fa-sm"></i></button>
                <button class="btn btn-danger rounded-circle me-3 mt-1 d-none" id="disable-profile" onclick="disableEditProfile()"><i class="fa-regular fa-xmark fa-sm"></i></button>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <div class="input-group">
                        <span class="input-group-text">Full Name</span>
                        <input type="text" class="form-control fs-6" id="full-name" value="{{ Auth::user()->FullName }}" disabled>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="input-group">
                        <span class="input-group-text">Username</span>
                        <input type="text" class="form-control fs-6" id="full-name" value="{{ Auth::user()->username }}" disabled>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="row">
                        <div class="col">
                            <input type="password" class="form-control fs-6" id="password" name="password" placeholder="Password Baru" disabled>
                        </div>
                        <div class="col">
                            <input type="password" class="form-control fs-6" id="password-confirm" name="password-confirm" placeholder="Konfirmasi Password" disabled>
                        </div>
                    </div>
                </div>
                <div class="mt-5">
                    <h5 class="text-center mb-3">SUMMARY LINE</h5>
                    <div class="d-flex justify-content-center align-items-center">
                        <div class="mb-3">
                            <input type="date" class="form-control" name="date-from" id="date-from" value="{{ date('Y-m-d') }}">
                        </div>
                        <span class="mx-3 mb-3"> - </span>
                        <div class="mb-3">
                            <input type="date" class="form-control" name="date-to" id="date-to" value="{{ date('Y-m-d') }}">
                        </div>
                    </div>
                    <div class="row row-gap-3">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header bg-rft text-light fw-bold">
                                    TOTAL RFT
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">Total RFT</h5>
                                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                                    {{-- <a href="#" class="btn btn-primary">Go somewhere</a> --}}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header bg-defect text-light fw-bold">
                                    TOTAL DEFECT
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">Total DEFECT</h5>
                                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                                    {{-- <a href="#" class="btn btn-primary">Go somewhere</a> --}}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header bg-reject text-light fw-bold">
                                    TOTAL REJECT
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">Total REJECT</h5>
                                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                                    {{-- <a href="#" class="btn btn-primary">Go somewhere</a> --}}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header bg-rework text-light fw-bold">
                                    TOTAL REWORK
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">Total REWORK</h5>
                                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                                    {{-- <a href="#" class="btn btn-primary">Go somewhere</a> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-5 table-responsive">
                    <h5 class="text-center">Latest Output</h5>
                    <table class="table table-bordered">
                        <thead>
                            <th>asd</th>
                            <th>asd</th>
                            <th>asd</th>
                        </thead>
                        <tbody>
                            <td>asd</td>
                            <td>asd</td>
                            <td>asd</td>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                ...
            </div>
        </div>
    </div>
</div>
