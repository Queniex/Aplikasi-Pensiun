<?php

require '../Functions/function-datachart.php';


// pagination configuration
$totalDataPage = 5;
$totalData = count(query("SELECT nama, golongan, status_berkas FROM data_diri "));
$totalPage = ceil($totalData / $totalDataPage);
$activePage = (isset($_GET["page"])) ? $_GET["page"] : 1;
$data = ($totalDataPage * $activePage) - $totalDataPage;
$datas = query("SELECT nama, golongan, status_berkas FROM data_diri LIMIT $data, $totalDataPage ");

if (isset($_POST["cari"])) {
    $datas = find($_POST["keyword"]);
}

$namaBar = [];
$jumlahBar = [];
$item = query("SELECT DISTINCT golongan FROM dana ORDER BY golongan ASC");
for ($i = 0; $i < count($item); $i++) {
    array_push($namaBar, $item[$i]["golongan"]);
    $query = mysqli_query($conn,"SELECT COUNT(golongan) AS jumlah FROM data_diri WHERE golongan = '".($i+1)."'");
    $row = $query->fetch_array();
    array_push($jumlahBar, $row[0]);
}

// Berkas
$namaBar2 = [];
$jumlahBar2 = [];
$item2 = query("SELECT DISTINCT status_berkas FROM status_berkas ORDER BY id_status ASC");
for ($i = 0; $i < count($item2); $i++) {
    array_push($namaBar2, $item2[$i]["status_berkas"]);
    $query2 = mysqli_query($conn,"SELECT COUNT(data_diri.status_berkas) AS 'jumlah' FROM data_diri INNER JOIN status_berkas on data_diri.status_berkas = status_berkas.status_berkas WHERE status_berkas.id_status = '".($i+1)."'");
    $row2= $query2->fetch_array();
    array_push($jumlahBar2, $row2[0]);
}
$counter = 1;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Chart</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <meta name="author" content="David Grzyb">
    <meta name="description" content="">

    <!-- Link tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Link Daisyui -->
    <link href="https://cdn.jsdelivr.net/npm/daisyui@2.46.1/dist/full.css" rel="stylesheet" type="text/css" />

    <!-- Link Flowbite -->
    <link rel="stylesheet" href="https://unpkg.com/flowbite@1.6.0/dist/flowbite.min.css" />

    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

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
            <a href="index.php" class="text-white text-3xl font-semibold uppercase hover:text-gray-300">Admin</a>
            <button class="w-full bg-white cta-btn font-semibold py-2 mt-5 rounded-br-lg rounded-bl-lg rounded-tr-lg shadow-lg hover:shadow-xl hover:bg-gray-300 flex items-center justify-center">
                <i class="fas fa-plus mr-3"></i> New Report
            </button>
        </div>
        <nav class="text-white text-base font-semibold pt-0">
            <a href="index.php" class="flex items-center text-white py-4 pl-6 nav-item">
                <i class="fas fa-tachometer-alt mr-3"></i>
                Dashboard
            </a>
            <a href="datachart.php" class="flex items-center active-nav-link text-white opacity-75 hover:opacity-100 py-4 pl-6 nav-item">
                <i class="fas fa-chart-bar mr-3"></i>
                Data Chart
            </a>
            <a href="validasi.php" class="flex items-center text-white opacity-75 hover:opacity-100 py-4 pl-6 nav-item">
                <i class="fas fa-sticky-note mr-3"></i>
                Validasi Berkas
            </a>
            <a href="krip.php" class="flex items-center text-white opacity-75 hover:opacity-100 py-4 pl-6 nav-item">
                <i class="fas fa-book-reader mr-3"></i>
                KRIP
            </a>
            <a href="user.php" class="flex items-center text-white opacity-75 hover:opacity-100 py-4 pl-6 nav-item">
                <i class="fas fa-user-cog mr-3"></i>
                Kelola User
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
            <div class="w-1/2">
                <form method="post" class="flex gap-2">
                    <input type="search" id="default-search" name="keyword" autofocus autocomplete="off" placeholder="Cari Data.." class="rounded-lg bg-slate-100 block px-3 py-1 w-96 outline-none">
                    <button type="submit" name="cari">
                        <img src="../../dist/images/search.png" alt="cari" width="30px">
                    </button>
                </form>
            </div>
            <div x-data="{ isOpen: false }" class="relative w-1/2 flex justify-end">
                <button @click="isOpen = !isOpen" class="realtive z-10 w-12 h-12 rounded-full overflow-hidden border-4 border-gray-400 hover:border-gray-300 focus:border-gray-300 focus:outline-none">
                    <img src="../../dist/images/Profile.png" />
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
                <a href="index.php" class="text-white text-3xl font-semibold uppercase hover:text-gray-300">Admin</a>
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
                <a href="validasi.php" class="flex items-center text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
                    <i class="fas fa-sticky-note mr-3"></i>
                    Validasi Berkas
                </a>
                <a href="datachart.php" class="flex items-center active-nav-link text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
                    <i class="fas fa-chart-bar mr-3"></i>
                    Data Chart
                </a>
                <a href="krip.php" class="flex items-center text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
                    <i class="fas fa-book-reader mr-3"></i>
                    KRIP
                </a>
                <a href="user.php" class="flex items-center text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
                    <i class="fas fa-user-cog mr-3"></i>
                    Kelola User
                </a>
                <button class="w-full bg-white cta-btn font-semibold py-2 mt-3 rounded-lg shadow-lg hover:shadow-xl hover:bg-gray-300 flex items-center justify-center">
                    <i class="fas fa-arrow-alt-circle-left mr-3"></i>
                    Log Out
                </button>
            </nav>
        </header>


        <div class="w-full h-screen overflow-x-hidden border-t flex flex-col">
            <main class="w-full flex-grow p-6">
                <h1 class="sm:mb-3 lg:text-3xl w-1/2 lg:mt-3 lg:mb-3 text-black underline underline-offset-4">Data Chart</h1>
                <div class="w-full mt-6 flex flex-col lg:flex-row">
                    <div class="w-full lg:w-1/3 lg:h-56 lg:ml-56">
                        <div class="ml-[112px] lg:ml-0 h-[300px] w-[300px] lg:h-full lg:w-full">
                            <canvas id="myChart"></canvas>
                        </div>
                        <h1 class="mr-[55px] ml-2 text-center">Golongan Penerima Pensiun</h1>
                    </div>
                    <div class="w-full lg:w-2/3 lg:h-56">
                        <div class="ml-[112px] h-full lg:ml-0 lg:w-full w-[300px]">
                            <canvas id="myChart2"></canvas>
                        </div>
                        <h1 class="lg:mr-[112px] ml-1 lg:ml-0 text-center">Seluruh Status Data Berkas Pendaftaran</h1>
                    </div>
                </div>
                
                <h1 class="sm:mb-3 lg:text-3xl w-1/2 lg:mt-6 lg:mb-3 text-black underline underline-offset-4">Tabel Data</h1>
                <div class="w-full mt-6">
                    <div class="bg-white overflow-auto">
                        <table class="min-w-full bg-white">
                            <thead class="bg-gray-800 text-white">
                                <tr>
                                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">No</th>
                                    <th class="w-1/3 text-left py-3 px-4 uppercase font-semibold text-sm">Nama</th>
                                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Golongan </th>
                                    <th class="text-left py-3 px-4   uppercase font-semibold text-sm">Status Berkas</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-700">
                                <?php foreach ($datas as $data) : ?>
                                    <tr>
                                        <td class="text-left py-3 px-4"><?php echo $counter; ?></td>
                                        <td class="w-1/3 text-left py-3 px-4"> <?= $data["nama"]; ?> </td>
                                        <td class="w-1/3 text-left py-3 px-4"> <?= $data["golongan"]; ?> </td>
                                        <td class="w-1/3 text-left py-3 px-4"> <?= $data["status_berkas"]; ?> </td>
                                        <?php $counter++; ?>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div><br>

                <!-- Navigation -->
                <div class="btn-group flex justify-center">
                    <?php if ($activePage > 1) : ?>
                        <a class="btn bg-[#152A38] text-white hover:text-black hover:bg-white" href="?page=<?= $activePage - 1; ?>">«</a>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $totalPage; $i++) : ?>
                        <?php if ($i == $activePage) : ?>
                            <a class="btn bg-[#152A38] text-white hover:text-black hover:bg-white" href="?page=<?= $i; ?>"><?= $i; ?></a>
                        <?php else : ?>
                            <a class="btn bg-[#152A38] text-white hover:text-black hover:bg-white" href="?page=<?= $i; ?>"><?= $i; ?></a>
                        <?php endif; ?>
                    <?php endfor; ?>

                    <?php if ($activePage < $totalPage) : ?>
                        <a class="btn bg-[#152A38] text-white hover:text-black hover:bg-white" href="?page=<?= $activePage + 1; ?>">»</a>
                    <?php endif; ?>
                </div>
                <!-- End Navigation -->
            </main>

            <footer class="w-full bg-white text-right p-4">
                &#169; Copyright to <a target="_blank" href="https://github.com/Queniex/Aplikasi-Pensiun" class="underline text-[#152A38] hover:text-blue-500">Kelompok 3</a>.
            </footer>
        </div>
    </div>

    <script>
            const ctx = document.getElementById('myChart');
            new Chart(ctx, {
            type: 'doughnut',
            data: {
                    labels: ['Gol I', 'Gol II', 'Gol III', 'Gol IV'],
                    datasets: [{
                    label: 'Jumlah Pendaftar ',
                    data: <?php echo json_encode($jumlahBar); ?>,
                    backgroundColor: [
                                    'rgb(26, 61, 142)',
                                    'rgb(88, 111, 166)',
                                    'rgb(161, 178, 216)',
                                    'rgb(140, 199, 229)'
                                    ],
                    borderColor: 'rgb(0, 0, 0)',
                    hoverOffset: 4,
                    borderWidth: 1
                        }]
                    },
                    options: {
                    scales: {
                    y: {
                        beginAtZero: true
                        }
                        }
                    }
                });

            const cty = document.getElementById('myChart2');
            new Chart(cty, {
            type: 'bar',
            data: {
                    labels: ['Checked', 'Approve', 'Refuse'],
                    datasets: [{
                    label: 'Grafik Status Berkas',
                    data: <?php echo json_encode($jumlahBar2); ?>,
                    backgroundColor: 'rgba(106, 185, 225, 0.2)',
                    borderColor: 'rgb(36, 28, 149)',
                    borderWidth: 1
                        }]
                    },
                    options: {
                    scales: {
                    y: {
                        beginAtZero: true
                        }
                        }
                    }
                });
        </script>  

    <!-- AlpineJS -->
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" integrity="sha256-KzZiKy0DWYsnwMF+X1DvQngQ2/FxF7MF3Ff72XcpuPs=" crossorigin="anonymous"></script>
    <!-- JQuery -->
    <script
    src="https://code.jquery.com/jquery-3.6.1.min.js"
    integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ="
    crossorigin="anonymous"></script>
    <!-- Server -->
    <script src="/fetch/script.js"></script>
</body>

</html>
