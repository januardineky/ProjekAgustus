<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Ini Judul</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <link rel="stylesheet" href="{{ asset('asset/css/bootstrap.min.css') }}">
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="styles.css" rel="stylesheet" />
        <style>
            .gradient-custom {
    /* fallback for old browsers */
    background: #6a11cb;

    /* Chrome 10-25, Safari 5.1-6 */
    background: -webkit-linear-gradient(to right, rgba(106, 17, 203, 1), rgba(37, 117, 252, 1));

    /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
    background: linear-gradient(to right, rgba(106, 17, 203, 1), rgba(37, 117, 252, 1))
    }
        </style>
    </head>
    <body>
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-dark gradient-custom">
            <div class="container px-4 px-lg-5">
                <a class="navbar-brand" href="#!">Ini Judul</a>
                    <form class="d-flex" action="/home/search" method="POST" style="margin-left: 250px">
                        @csrf
                        <input class="form-control me-2 w-100" type="search" placeholder="Search" name="cari" aria-label="Search">
                        <input class="btn btn-outline-light" value="Cari" type="submit"></input>
                    </form>
                        <a href="/cart" style="text-decoration: none" class="btn btn-outline-light" style="margin-left: 50px">
                            <i class="bi-cart me-1"></i>
                            Keranjang
                        </a>
                        <a href="/auth/logout" onclick="return window.confirm('Apakah anda ingin Logout?')" style="text-decoration: none" class="btn btn-outline-light">
                        <i class="bi bi-box-arrow-right"></i>
                        Logout
                        </a>
                </div>
            </div>
        </nav>
        <!-- Header-->
        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
              <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
              <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
              <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner bg-dark">
              <div class="carousel-item text-center active">
                <img src="{{ asset('asset/logo/asset5.jpg') }}" width="600px" alt="...">
              </div>
              <div class="carousel-item text-center">
                <img src="{{ asset('asset/logo/asset6.jpg') }}" width="600px" alt="...">
              </div>
              <div class="carousel-item text-center">
                <img src="{{ asset('asset/logo/asset7.jpg') }}" width="600px" alt="...">
              </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
            </button>
          </div>
        <!-- Section-->
        <section class="py-5">
            <div class="container px-4 px-lg-5 mt-5" style="padding-bottom: 100px">
                <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                    @foreach ($produk as $key => $item)
                    <div class="col mb-5">
                        <div class="card h-100">
                            <!-- Product image-->
                            <img class="card-img-top" src="{{ asset('storage/gambar/'.$item->gambar) }}" alt="" />
                            <!-- Product details-->
                            <div class="card-body p-4">
                                <!-- Product name-->
                                <h6 class="fw-normal">{{ $item->name }}</h6>
                                <!-- Product price-->
                                <p class="fw-bolder">Rp.{{ $item->harga }}</p>
                                <p class="fw-light text-secondary" style="margin-top: -10px">Kategori : {{ $item->kategori }}</p>
                                <p class="fw-light text-secondary" style="margin-top: -10px">Stok : {{ $item->stok }}</p>
                            </div>
                            <!-- Product actions-->
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent" style="margin-top: -25px">
                                <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">Tambah</a></div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        <!-- Footer-->
        <footer class="py-5 gradient-custom">
            <div class="container"><p class="m-0 text-center text-white">Copyright &copy; Januardi 2024</p></div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
        <script src="{{ asset('asset/js/bootstrap.min.js') }}"></script>
    </body>
</html>
