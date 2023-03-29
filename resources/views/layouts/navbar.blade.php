<header>
    <nav class="navbar bg-body-secondary navbar-expand">
        <div class="container-fluid">
            <a class="navbar-brand" href="/"><img src="/assets/images/logosb.png" alt="" width="150"></a>
            <ul class="navbar-nav align-items-center gap-3">
                <div class="row">
                    <div class="col-md-4">
                        <li class="nav-item w-100">
                            <input type="date" class="form-control" id="tanggal" name="tanggal" onload="showTime(this)">
                        </li>
                    </div>
                    <div class="col-md-4">
                        <li class="nav-item w-100">
                            <input type="text" class="form-control text-center" id="jam" name="jam" onload="showTime(this)" readonly>
                        </li>
                    </div>
                    <div class="col-md-4">
                        <li class="nav-item dropdown w-100">
                            <button class="btn bg-white dropdown-toggle w-100" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-regular fa-gear"></i>
                                <span>LINE 01</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="#"><i class="fa-regular fa-gear"></i> LINE 01</a></li>
                                <li><a class="dropdown-item" href="/login"><i class="fa-solid fa-arrow-right-from-bracket"></i> Log Out</a></li>
                            </ul>
                        </li>
                    </div>
                </div>
            </ul>
        </div>
    </nav>
</header>
