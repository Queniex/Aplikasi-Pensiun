<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola User</title>
    <meta name="author" content="David Grzyb">
    <meta name="description" content="">

    <!-- Link tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Link Daisyui -->
    <link href="https://cdn.jsdelivr.net/npm/daisyui@2.46.1/dist/full.css" rel="stylesheet" type="text/css" />

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
            <a href="datachart.php" class="flex items-center text-white opacity-75 hover:opacity-100 py-4 pl-6 nav-item">
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
            <a href="user.php" class="flex items-center active-nav-link text-white opacity-75 hover:opacity-100 py-4 pl-6 nav-item">
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
            <form action="" method="post" class="flex gap-2">
            <input type="text" id="keyword" name="keyword" autofocus autocomplete="off" placeholder="Cari Data.." class="rounded-lg bg-slate-100 block px-3 py-1 w-96 outline-none">
            <button type="submit" name="search">
              <img src="../../dist/images/search.png" alt="cari" width="30px">
            </button>
          </form>
            </div>
            <div x-data="{ isOpen: false }" class="relative w-1/2 flex justify-end">
                <button @click="isOpen = !isOpen" class="realtive z-10 w-12 h-12 rounded-full overflow-hidden border-4 border-gray-400 hover:border-gray-300 focus:border-gray-300 focus:outline-none">
                    <img src="../../dist/images/Profile.png">
                </button>
                <button x-show="isOpen" @click="isOpen = false" class="h-full w-full fixed inset-0 cursor-default"></button>
                <div x-show="isOpen" class="absolute w-32 bg-white rounded-lg shadow-lg py-2 mt-16">
                    <a href="cekakun.php" class="block px-4 py-2 account-link hover:text-white">Account</a>
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
                <a href="datachart.php" class="flex items-center text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
                    <i class="fas fa-chart-bar mr-3"></i>
                      Data Chart
                </a>
                <a href="validasi.php" class="flex items-center text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
                    <i class="fas fa-sticky-note mr-3"></i>
                    Validasi Berkas
                </a>
                <a href="krip.php" class="flex items-center text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
                  <i class="fas fa-book-reader mr-3"></i>
                  KRIP
                </a>
                <a href="user.php" class="flex items-center active-nav-link text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
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
            <!------------------------------------------------------------------->
                <h1 class="sm:mb-3 lg:text-3xl w-1/2 lg:mt-3 lg:mb-3 text-black underline underline-offset-4">Kelola User</h1>
                <div class="flex flex-col mt-4 mb-8 mx-8">
                    <div class="flex flex-wrap w-full bg-gray-300 rounded-lg h-25 mt-4">
                        <div class="flex-1 p-5 ">
                            <div class="flex flex-wrap justify-start ">
                                <div class="flex-0 rounded-full">
                                    <img class="border-2 border-black rounded-full" width="40px" src="../../dist/images/Profile.png">   
                                </div>
                                <div class="flex-1 self-center mx-5">
                                <h3 class="text-black">Nama Lengkap</h3>
                                </div>
                            </div>
                        </div>
                        <div class="flex-1 p-5 self-center">
                                <div class="flex flex-wrap justify-end">
                                <span>
                                      <button data-modal-target="popup-approve" data-modal-toggle="popup-approve" type="button" class="text-lime-600 hover:text-white">Edit</button> | <button data-modal-target="popup-modal" data-modal-toggle="popup-modal" type="button" class="text-red-500 hover:text-white">Hapus</button>
                                    </span>
                                </div>
                        </div>
                    </div>

                    <div class="flex flex-wrap w-full bg-gray-300 rounded-lg h-25 mt-4">
                        <div class="flex-1 p-5 ">
                            <div class="flex flex-wrap justify-start">
                                <div class="flex-0 rounded-full">
                                    <img class="border-2 border-black rounded-full" width="40px" src="../../dist/images/Profile.png">   
                                </div>
                                <div class="flex-1 self-center mx-5">
                                <h3 class="text-black">Nama Lengkap</h3>
                                </div>
                            </div>
                        </div>
                        <div class="flex-1 p-5 self-center">
                                <div class="flex flex-wrap justify-end">
                                <span>
                                      <button data-modal-target="popup-approve" data-modal-toggle="popup-approve" type="button" class="text-lime-600 hover:text-white">Edit</button> | <button data-modal-target="popup-modal" data-modal-toggle="popup-modal" type="button" class="text-red-500 hover:text-white">Hapus</button>
                                    </span>
                                </div>
                        </div>
                    </div>

                    <div class="flex flex-wrap w-full bg-gray-300 rounded-lg h-25 mt-4">
                        <div class="flex-1 p-5 ">
                            <div class="flex flex-wrap justify-start">
                                <div class="flex-0 rounded-full">
                                    <img class="border-2 border-black rounded-full" width="40px" src="../../dist/images/Profile.png">   
                                </div>
                                <div class="flex-1 self-center mx-5">
                                <h3 class="text-black">Nama Lengkap</h3>
                                </div>
                            </div>
                        </div>
                        <div class="flex-1 p-5 self-center">
                                <div class="flex flex-wrap justify-end">
                                <span>
                                      <button data-modal-target="popup-edit" data-modal-toggle="popup-edit" type="button" class="text-lime-600 hover:text-white">Edit</button> | <button data-modal-target="popup-hapus" data-modal-toggle="popup-hapus" type="button" class="text-red-500 hover:text-white">Hapus</button>
                                    </span>
                                </div>
                        </div>
                    </div>
                    
                </div>
            </main>
    
            <footer class="w-full bg-white text-right p-4">
                &#169; Copyright to <a target="_blank" href="https://github.com/Queniex/Aplikasi-Pensiun" class="underline text-[#152A38] hover:text-blue-500">Kelompok 3</a>.
            </footer>
        </div>
        
    </div>

    <!-- AlpineJS -->
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" integrity="sha256-KzZiKy0DWYsnwMF+X1DvQngQ2/FxF7MF3Ff72XcpuPs=" crossorigin="anonymous"></script>
</body>
</html>