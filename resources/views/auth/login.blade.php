<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SB WIP</title>

    @include('layouts.link')
</head>

<body>
    <div class="login-card card">
        <div class="row align-items-center g-0">
            <div class="col-md-6">
                <img src="/assets/images/logosb.png" class="img-fluid mt-auto mb-auto" alt="...">
            </div>
            <div class="col-md-6">
                <div class="card-body my-5">
                    <h2 class="text-center text-sb fw-bold mb-3">LOGIN</h2>
                    <form method="POST" action="{{ url('login/authenticate') }}" class="login-form mx-3">
                        @csrf
                        <div class="mb-3 position-relative">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" name="username" id="username">
                        </div>
                        <div class="mb-3 position-relative">
                            <label for="username">Password</label>
                            <input type="password" class="form-control" name="password" id="password">
                        </div>
                        <div class="mt-3 mb-3">
                            <button type="submit" class="btn btn-sb w-100 mt-3 mb-3">LOGIN</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.script')
</body>

</html>
