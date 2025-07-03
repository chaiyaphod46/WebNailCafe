<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nailcafe</title>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link rel="icon" href="{{ asset('imag/nailcafe1.jpg') }}">
    <style>
        body {
            font-family: "Itim", cursive;
            background-color: #ffe4e1;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            transition: box-shadow 0.3s ease-in-out;
        }

        .card:hover {
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.3);
        }

        .btn {
            background-color: #ff69b4;
            color: #fff;
            border-radius: 8px;
            transition: background-color 0.3s, transform 0.3s;
        }

        .btn:hover {
            background-color: #ff1493;
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        .form-control {
            border-radius: 8px;
        }

        .form-label {
            color: #ff69b4;
            font-weight: 600;
        }

        .input-group-text {
            background-color: transparent;
            border: none;
            color: #ff69b4;
        }

        .login-section {
            background-color: #ffffff;
            border-radius: 15px;
        }

        .link-color {
            color: #ff69b4;
        }

        .link-color:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

<section class="pb-4">
    <div class="d-flex justify-content-center align-items-center min-vh-100">
        <div class="card login-section" style="width: 95vw; max-width: 1000px;">
            <div class="row g-0">
                <div class="col-md-6 d-none d-md-block">
                    <img src="imag/nailcafe1.jpg" alt="register form" class="img-fluid rounded-start" style="width: 100%; height: auto; object-fit: cover;">
                </div>
                <div class="col-md-6 d-flex align-items-center bg-light rounded-end" style="background-color: #fff0f5;">
                    <div class="card-body p-5 text-black">

                        <form method="POST" action="{{ route('register') }}">
                            <div class="d-flex align-items-center mb-3 pb-1">
                                <i class="fas fa-cubes fa-2x me-3" style="color: #ff69b4;"></i>
                                <span class="h1 fw-bold mb-0">NailCafe</span>
                            </div>

                            @csrf

                            <div class="form-outline mb-4">
                                <label class="form-label" for="name">
                                    <i class="fas fa-user me-2"></i>{{ __('ชื่อ') }}
                                </label>
                                <input type="text" id="name" class="form-control form-control-lg" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-outline mb-4">
                                <label class="form-label" for="phon">
                                    <i class="fas fa-phone me-2"></i>{{ __('เบอร์โทรศัพท์') }}
                                </label>
                                <input type="text" id="phon" class="form-control form-control-lg" name="phon" value="{{ old('phon') }}" required autocomplete="phon">
                                @error('phon')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-outline mb-4">
                                <label class="form-label" for="email">
                                    <i class="fas fa-envelope me-2"></i>{{ __('อีเมล') }}
                                </label>
                                <input type="email" id="email" class="form-control form-control-lg" name="email" value="{{ old('email') }}" required autocomplete="email">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-outline mb-4">
                                <label class="form-label" for="password">
                                    <i class="fas fa-lock me-2"></i>{{ __('รหัสผ่าน') }}
                                </label>
                                <input type="password" id="password" class="form-control form-control-lg" name="password" required autocomplete="new-password">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-outline mb-4">
                                <label class="form-label" for="password-confirm">
                                    <i class="fas fa-lock me-2"></i>{{ __('ยืนยันรหัสผ่าน') }}
                                </label>
                                <input type="password" id="password-confirm" class="form-control form-control-lg" name="password_confirmation" required autocomplete="new-password">
                            </div>

                            <div class="pt-1 mb-4">
                                <button class="btn btn-lg btn-block" type="submit">{{ __('ลงทะเบียน') }}</button>
                            </div>
                            <p class="mb-5 pb-lg-2">
                                หากคุณมีบัญชีอยู่แล้ว <a href="{{url('/login')}}" class="link-color">เข้าสู่ระบบ</a>
                            </p>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>
