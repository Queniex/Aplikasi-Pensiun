<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <meta name="author" content="David Grzyb">
    <meta name="description" content="">

    <!-- Link tailwind -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tw-elements/dist/css/index.min.css" />
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
          theme: {
            container: {
              center: true,
              padding: '16px'
            },
            extend: {
              colors: {
              },
              screens: {
                '2xl': '1320px',
              },
              keyframes:{
              }
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
            <a href="index.php" class="flex items-center active-nav-link text-white py-4 pl-6 nav-item">
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
            <a href="saldo.php" class="flex items-center text-white opacity-75 hover:opacity-100 py-4 pl-6 nav-item">
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
                <a href="index.php" class="flex items-center active-nav-link text-white py-2 pl-4 nav-item">
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
                <a href="saldo.php" class="flex items-center text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
                    <i class="fas fa-money-bill mr-3"></i>
                    Cek Saldo
                </a>
                <button class="w-full bg-white cta-btn font-semibold py-2 mt-3 rounded-lg shadow-lg hover:shadow-xl hover:bg-gray-300 flex items-center justify-center">
                  <i class="fas fa-arrow-alt-circle-left mr-3"></i>
                  Log Out
                </button>
            </nav>
        </header>
    
        <div class="w-full overflow-x-hidden border-t flex flex-col">
            <main class="w-full flex-grow p-6">
                <h1 class="text-3xl text-black pb-6 underline underline-offset-4">Dashboard</h1>
    
                <div class="flex flex-wrap mt-4">
                    <div class="w-full lg:w-1/2 pr-0 lg:pr-2">
                        <div id="carouselExampleIndicators" class="carousel slide relative" data-bs-ride="carousel">
                            <div class="carousel-indicators absolute right-0 bottom-0 left-0 flex justify-center p-0 mb-4">
                              <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                              <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" class="active" aria-current="true" aria-label="Slide 2"></button>
                              <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" class="active" aria-current="true" aria-label="Slide 3"></button>
                            </div>

                            <div class="carousel-inner relative w-full overflow-hidden">
                              <div class="carousel-item active float-left w-full">
                                <img src="https://mdbcdn.b-cdn.net/img/new/slides/041.webp" class="block w-full" alt="Wild Landscape"/>
                              </div>
                              <div class="carousel-item float-left w-full">
                                <img src="https://mdbcdn.b-cdn.net/img/new/slides/042.webp" class="block w-full" alt="Camera"/>
                              </div>
                              <div class="carousel-item float-left w-full">
                                <img src="https://mdbcdn.b-cdn.net/img/new/slides/043.webp" class="block w-full" alt="Exotic Fruits"/>
                              </div>
                            </div>

                            <button
                              class="carousel-control-prev absolute top-0 bottom-0 flex items-center justify-center p-0 text-center border-0 hover:outline-none hover:no-underline focus:outline-none focus:no-underline left-0"
                              type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                              <span class="carousel-control-prev-icon inline-block bg-no-repeat" aria-hidden="true"></span>
                              <span class="visually-hidden">Previous</span>
                            </button>
                            <button
                              class="carousel-control-next absolute top-0 bottom-0 flex items-center justify-center p-0 text-center border-0 hover:outline-none hover:no-underline focus:outline-none focus:no-underline right-0"
                              type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                              <span class="carousel-control-next-icon inline-block bg-no-repeat" aria-hidden="true"></span>
                              <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>

                    <div class="w-full lg:w-1/2 pr-0 lg:pr-2">
                        <h3 class="underline underline-offset-4 mt-4">Tentang Kami</h1>
                        <div class="flex justify-center">
                            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Provident officiis quod dolore porro, itaque debitis excepturi? Recusandae, perspiciatis minus odit quaerat cum vitae accusantium. Repellendus ad harum obcaecati fugit ab quisquam ratione quas in numquam enim doloremque, exercitationem quae nostrum debitis quibusdam laboriosam, illum placeat nulla, officiis dolorum nemo. Reprehenderit!
                        </div>
                    </div>
                </div>
    
                <div class="w-full mt-9">
                    <p class="text-xl pb-3 flex items-center">
                        <i class="fas fa-list mr-3"></i> Proses Pencairan Dana Pensiun
                    </p>
                    <div class="bg-white overflow-auto">
                        <div class="min-w-full">
                            <div class="bg-blue-300 h-[40vh]"></div>
                        </div>
                    </div>
                </div>

            </main>
    
            <footer class="w-full bg-white text-right p-4">
               Copyright to <a target="_blank" href="https://github.com/Queniex/Aplikasi-Pensiun" class="underline text-[#152A38] hover:text-blue-500">Kelompok 3</a><br>
               All Right Reserved
            </footer>
        </div>
        
    </div>

    <!-- AlpineJS -->
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" integrity="sha256-KzZiKy0DWYsnwMF+X1DvQngQ2/FxF7MF3Ff72XcpuPs=" crossorigin="anonymous"></script>
    <!-- ChartJS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js" integrity="sha256-R4pqcOYV8lt7snxMQO/HSbVCFRPMdrhAFMH+vr9giYI=" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/tw-elements/dist/js/index.min.js"></script>

    <script>
        var chartOne = document.getElementById('chartOne');
        var myChart = new Chart(chartOne, {
            type: 'bar',
            data: {
                labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                datasets: [{
                    label: '# of Votes',
                    data: [12, 19, 3, 5, 2, 3],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });

        var chartTwo = document.getElementById('chartTwo');
        var myLineChart = new Chart(chartTwo, {
            type: 'line',
            data: {
                labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                datasets: [{
                    label: '# of Votes',
                    data: [12, 19, 3, 5, 2, 3],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>
</body>
</html>