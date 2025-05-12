<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang di SinyalVoucher</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #4e73df, #224abe);
            color: white;
            font-family: 'Segoe UI', sans-serif;
        }

        .hero {
            padding: 100px 0;
            text-align: center;
        }

        .hero h1 {
            font-size: 3rem;
            font-weight: bold;
        }

        .hero p {
            font-size: 1.2rem;
            margin-bottom: 30px;
        }

        .navbar {
            background-color: rgba(0, 0, 0, 0.3);
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="#">SinyalVoucher</a>
            <div class="ms-auto">
                <a href="{{ url('/login') }}" class="btn btn-outline-light me-2">Login</a>
                <a href="{{ url('/register') }}" class="btn btn-light text-primary">Register</a>
            </div>
        </div>
    </nav>

    <section class="hero">
        <div class="container">
            <h1>Selamat Datang di SinyalVoucher</h1>
            <p>Platform untuk kebutuhan Internet dan Vpn Voucheran.</p>
            <a href="{{ url('/register') }}" class="btn btn-lg btn-light text-primary fw-bold">Gabung Sekarang</a>
        </div>
    </section>

    <footer class="text-center p-4">
        <small>&copy; {{ date('Y') }} SinyalVoucher. All rights reserved.</small>
    </footer>

</body>

</html>