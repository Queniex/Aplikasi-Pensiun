<?php

require '../Functions/function-saldo.php';

$id = 1005; //harus diganti pake id_user
$data = query("SELECT data_diri.nama AS 'nama', data_diri.golongan AS 'golongan', dana.total_dana AS 'total_dana' FROM data_diri LEFT JOIN dana ON data_diri.golongan = dana.golongan WHERE data_diri.id_user");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tailwind Admin Template</title>
    <meta name="author" content="David Grzyb">
    <meta name="description" content="">

    <!-- Link tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                container: {
                    center: true,
                    padding: '16px'
                },
                extend: {
                    colors: {},
                    screens: {
                        '2xl': '1320px',
                    },
                    keyframes: {}
                }
            }
        }
    </script>

    <style type="text/tailwindcss">
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap');
        .font-family-inter{ font-family: 'Inter', sans-serif; }
        /* .bg-sidebar { background: #0A161E; } */
        .cta-btn { color: #3d68ff; }
        .upgrade-btn { background: #1947ee; }
        .upgrade-btn:hover { background: #0038fd; }
        .active-nav-link { background: #1947ee; }
        .nav-item:hover { background: #1947ee; }
        .account-link:hover { background: #3d68ff; }
        /* *{
          border: 1px red solid;
        } */
    </style>
</head>

<body class="bg-gray-100 font-family-inter flex">

    <aside class="relative bg-[#152A38] h-screen w-64 hidden sm:block shadow-xl">
        <div class="p-6 bg-[#0A161E]">
            <a href="index.php" class="text-white text-3xl font-semibold uppercase hover:text-gray-300">User</a>
            <button class="w-full bg-white cta-btn font-semibold py-2 mt-5 rounded-br-lg rounded-bl-lg rounded-tr-lg shadow-lg hover:shadow-xl hover:bg-gray-300 flex items-center justify-center">
                <i class="fas fa-plus mr-3"></i> New Report
            </button>
        </div>
        <nav class="text-white text-base font-semibold pt-0">
            <a href="index.php" class="flex items-center text-white py-4 pl-6 nav-item">
                <i class="fas fa-tachometer-alt mr-3"></i>
                Dashboard
            </a>
            <a href="daftar.php" class="flex items-center text-white opacity-75 hover:opacity-100 py-4 pl-6 nav-item">
                <i class="fas fa-sticky-note mr-3"></i>
                Daftar Berkas
            </a>
            <a href="krip.php" class="flex items-center text-white opacity-75 hover:opacity-100 py-4 pl-6 nav-item">
                <i class="fas fa-book-reader mr-3"></i>
                KRIP
            </a>
            <a href="saldo.php" class="flex items-center active-nav-link text-white opacity-75 hover:opacity-100 py-4 pl-6 nav-item">
                <i class="fas fa-money-bill mr-3"></i>
                Cek Saldo
            </a>
        </nav>
        <a href="#" class="absolute w-full upgrade-btn bottom-0 active-nav-link text-white flex items-center justify-center py-4">
            <i class="fas fa-arrow-alt-circle-left mr-3"></i>
            Log Out
        </a>
    </aside>

    <div class="w-full flex flex-col h-screen overflow-y-hidden">
        <!-- Desktop Header -->
        <header class="w-full items-center bg-white py-2 px-6 hidden sm:flex">
            <div class="w-1/2"></div>
            <div x-data="{ isOpen: false }" class="relative w-1/2 flex justify-end">
                <button @click="isOpen = !isOpen" class="realtive z-10 w-12 h-12 rounded-full overflow-hidden border-4 border-gray-400 hover:border-gray-300 focus:border-gray-300 focus:outline-none">
                    <img src="../../dist/images/Profile.png">
                </button>
                <button x-show="isOpen" @click="isOpen = false" class="h-full w-full fixed inset-0 cursor-default"></button>
                <div x-show="isOpen" class="absolute w-32 bg-white rounded-lg shadow-lg py-2 mt-16">
                    <a href="#" class="block px-4 py-2 account-link hover:text-white">Account</a>
                </div>
            </div>
        </header>

        <!-- Mobile Header & Nav -->
        <header x-data="{ isOpen: false }" class="bg-[#152A38] w-full bg-sidebar py-5 px-6 sm:hidden">
            <div class="flex items-center justify-between">
                <a href="index.php" class="text-white text-3xl font-semibold uppercase hover:text-gray-300">User</a>
                <button @click="isOpen = !isOpen" class="text-white text-3xl focus:outline-none">
                    <i x-show="!isOpen" class="fas fa-bars"></i>
                    <i x-show="isOpen" class="fas fa-times"></i>
                </button>
            </div>

            <!-- Dropdown Nav -->
            <nav :class="isOpen ? 'flex': 'hidden'" class="flex flex-col pt-4">
                <a href="index.php" class="flex items-center text-white py-2 pl-4 nav-item">
                    <i class="fas fa-tachometer-alt mr-3"></i>
                    Dashboard
                </a>
                <a href="daftar.php" class="flex items-center text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
                    <i class="fas fa-sticky-note mr-3"></i>
                    Daftar Berkas
                </a>
                <a href="krip.php" class="flex items-center text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
                    <i class="fas fa-book-reader mr-3"></i>
                    KRIP
                </a>
                <a href="saldo.php" class="flex items-center active-nav-link text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
                    <i class="fas fa-money-bill mr-3"></i>
                    Cek Saldo
                </a>
                <button class="w-full bg-white cta-btn font-semibold py-2 mt-3 rounded-lg shadow-lg hover:shadow-xl hover:bg-gray-300 flex items-center justify-center">
                    <i class="fas fa-arrow-alt-circle-left mr-3"></i>
                    Log Out
                </button>
            </nav>
        </header>

        <div class="w-full h-screen overflow-x-hidden border-t flex flex-col">
            <main class="w-full flex-grow p-6">
                <div class="flex flex-wrap">
                    <form class="p-10 bg-white rounded shadow-xl container">

                        <div class="container">
                            <?php foreach ($data as $data) : ?>
                                <div class="row">
                                    <div class="col-sm-2">
                                        Nama <br />
                                        Golongan <br />
                                        Dana Pengsiun <br /><br>
                                    </div>
                                    <div class="col-sm-5">
                                        : <?= $data["nama"]; ?> <br />
                                        : <?= $data["golongan"]; ?> <br />
                                        : <?= $data["total_dana"]; ?>
                                    </div>
                                <?php endforeach; ?>
                                </div>
                        </div>
                    </form>
                </div>
        </div><br>

        <form class="p-20 bg-white rounded shadow-xl container">
            <div class="container">
                <div class="row row-cols-2 row-cols-lg-5 g-2 g-lg-3">

                    <div class="col">
                        <div class="p-5 btn btn-light bg-subtle border border-primary-subtle rounded-3 " data-bs-toggle="modal" data-bs-target="#modal1">
                            <img src="https://www.svgrepo.com/show/345389/file-document-data-health-result-archive-folder.svg" alt="Jaminan Hari Tua">
                            <br><br><i class="icon-tab icon-program-1">Jaminan Hari Tua</i>
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="modal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Kriteria Pengajuan Klaim</h1>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-sm-1">
                                                a. <br />
                                                b. <br />
                                                c. <br />
                                                d. <br />
                                                e. <br />
                                                f. <br />
                                                g. <br />
                                                h. <br />
                                                i. <br />
                                                j. <br />
                                                k.
                                            </div>
                                            <div class="col-sm-7">
                                                Usia Pensiun 56 Tahun <br />
                                                Usia Pensiun Perjanjian <br />
                                                Perjanjian Kerja Waktu Tertentu <br />
                                                Berhenti usaha <br />
                                                Mengundurkan diri <br />
                                                Pemutusan Hubungan Kerja <br />
                                                Meninggalkan Indonesia selamanya <br />
                                                Cacat total tetap <br />
                                                Meninggal dunia <br />
                                                Klaim (JHT) 10% <br />
                                                Klaim (JHT) 30% <br />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    </main><br>

    <footer class="w-full bg-white text-center p-4">
        Copyright to <a target="_blank" href="https://github.com/Queniex/Aplikasi-Pensiun" class="underline text-[#152A38] hover:text-blue-500">Kelompok 3</a><br>
        All Right Reserved
    </footer>
    </div>

    </div>

    <!-- AlpineJS -->
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" integrity="sha256-KzZiKy0DWYsnwMF+X1DvQngQ2/FxF7MF3Ff72XcpuPs=" crossorigin="anonymous"></script>
</body>

</html>