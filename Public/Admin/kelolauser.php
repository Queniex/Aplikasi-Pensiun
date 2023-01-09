<?php
require '../Functions/function-cekakun.php';

// pagination configuration
$totalDataPage = 5;
$totalData = count(query("SELECT id_user, nama, email, no_telp, alamat, foto FROM user WHERE role = 'Peserta'"));
$totalPage = ceil($totalData / $totalDataPage);
$activePage = ( isset($_GET["page"]) ) ? $_GET["page"] : 1;
$data = ($totalDataPage * $activePage ) - $totalDataPage;
$datas = query("SELECT id_user, nama, email, no_telp, alamat, foto FROM user WHERE role = 'Peserta' LIMIT $data, $totalDataPage  ");

if ( isset($_POST["search"]) ){
  $datas = find($_POST["keyword"]);
}

if ( isset($_POST["delete"]) ){
    if( deletes($_POST) > 0){
      echo "
          <script>
              document.location.href = 'kelolauser.php'
          </script>
     "; 
    }
    else {
      die('invalid Query : ' . mysqli_error($conn));
      echo mysqli_error($conn);
    }
  }

?>

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
    <!-- Link Flowbite -->
    <link rel="stylesheet" href="https://unpkg.com/flowbite@1.6.0/dist/flowbite.min.css" />
    <script src="https://unpkg.com/flowbite@1.6.0/dist/flowbite.min.js"></script>

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
            <a href="kelolauser.php" class="flex items-center active-nav-link text-white opacity-75 hover:opacity-100 py-4 pl-6 nav-item">
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
                <a href="kelolauser.php" class="flex items-center active-nav-link text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
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

                <?php foreach( $datas as $data ) : ?>
                <div class="flex flex-col mt-4 mb-4 mx-8">
                    <div class="flex flex-wrap w-full bg-gray-300 rounded-lg h-20 mt-4">
                        <div class="flex-1 p-5 ">
                            <div class="flex flex-wrap justify-start ">
                                <div class="flex-0 rounded-full">
                                    <?php if ($data["foto"] > 0) : ?>
                                        <img class="border-2 border-black rounded-full" width="40px" src="../../dist/images/<?= $data["foto"]; ?>">
                                    <?php else : ?>
                                        <img class="border-2 border-black rounded-full" width="40px" src="../../dist/images/Profile.png">   
                                    <?php endif ?>   
                                </div>
                                <div class="flex-1 self-center mx-5">
                                    <?php if ($data["nama"] > 0) : ?>
                                        <h2 class="text-black"><?= $data["nama"]; ?></h2>
                                    <?php else : ?>
                                        <h2 class="text-black">user : <?= $data["id_user"]; ?></h2>
                                    <?php endif ?> 
                                </div>
                            </div>
                        </div>
                        <div class="flex-1 p-5 self-center">
                                <div class="flex flex-wrap justify-end">
                                <span>
                                      <button data-modal-target="readModal<?= $data["id_user"]; ?>" data-modal-toggle="readModal<?= $data["id_user"]; ?>" type="button" class="text-lime-600 hover:text-white">Details</button> | <button data-modal-target="delete-modal<?= $data["id_user"]; ?>" data-modal-toggle="delete-modal<?= $data["id_user"]; ?>" type="button" class="text-red-500 hover:text-white">Hapus</button>
                                    </span>
                                </div>
                        </div>
                    </div>
                    
                </div>
                <?php endforeach; ?>

                <!-- Navigation -->
                <div class="btn-group flex justify-center">
                    <?php if( $activePage > 1 ) : ?>
                        <a class="btn bg-[#152A38] text-white hover:text-black hover:bg-white" href="?page=<?= $activePage - 1; ?>">«</a>
                    <?php endif; ?> 
                    
                    <?php for( $i = 1; $i <= $totalPage; $i++ ) : ?>
                        <?php if( $i == $activePage ) : ?>
                            <a class="btn bg-[#152A38] text-white hover:text-black hover:bg-white" href="?page=<?= $i; ?>"><?= $i; ?></a>
                        <?php else : ?>
                            <a class="btn bg-[#152A38] text-white hover:text-black hover:bg-white" href="?page=<?= $i; ?>"><?= $i; ?></a>
                        <?php endif; ?>
                    <?php endfor; ?>

                    <?php if( $activePage < $totalPage ) : ?>
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
    
    <?php foreach( $datas as $data ) : ?>
    <!-- Delete Modal -->
    <form method="POST">
    <div id="delete-modal<?= $data["id_user"]; ?>" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
        <div class="relative w-full h-full max-w-md md:h-auto">
            <div class="relative bg-white rounded-lg shadow dark:bg-black">
                <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-hide="delete-modal<?= $data["id_user"]; ?>">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-6 text-center">
                    <input type="hidden" name="id" value="<?= $data["id_user"]; ?>">  
                    <svg aria-hidden="true" class="mx-auto mb-4 text-gray-400 w-14 h-14 dark:text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Anda yakin ingin menghapus akun user : <br> <?= $data["nama"]; ?>?</h3>
                    <button data-modal-hide="delete-modal<?= $data["id_user"]; ?>" name="delete" type="submit" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                        IYA
                    </button>
                    <button data-modal-hide="delete-modal<?= $data["id_user"]; ?>" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Tidak</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Delete Modal -->
    </form>

    <!-- Read Modal -->
    <div id="readModal<?= $data["id_user"]; ?>" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
      <div class="relative w-full h-full max-w-md md:h-auto">
          <div class="relative bg-white rounded-lg shadow dark:bg-black">
              <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-hide="readModal<?= $data["id_user"]; ?>">
                  <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                  <span class="sr-only">Close modal</span>
              </button>
              <div class="p-6">
                    <div class="m-2 text-black">
                          <center><div class="rounded-full">
                            <?php if ($data["foto"] > 0) : ?>
                                <img class="rounded-full " width="150px" height="150px" src="../../dist/images/<?= $data["foto"]; ?>">   
                            <?php else : ?>
                                <img class="rounded-full" width="150px" height="150px" src="../../dist/images/Profile.png">   
                            <?php endif; ?>
                          </div></center>
                          <div class="form-control w-full">
                            <label class="label">
                              <span class="label-text">Nama</span>
                            </label>
                            <input name="nama" type="text" value="<?= $data["nama"]; ?>" placeholder="Masukkan Disini" class="input input-bordered w-full" />
                          </div>   
                          
                          <div class="form-control w-full">
                            <label class="label">
                              <span class="label-text">Email</span>
                            </label>
                            <input name="email" type="email" value="<?= $data["email"]; ?>" placeholder="Masukkan Disini" class="input input-bordered w-full" />
                          </div>  

                          <div class="form-control w-full">
                            <label class="label">
                              <span class="label-text">Alamat</span>
                            </label>
                            <textarea name="alamat" class="bg-white textarea textarea-bordered" placeholder="Masukkan Disini"><?= $data["alamat"]; ?></textarea>
                          </div>
                          
                          <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text">Nomor Telepon</span>
                            </label>
                            <input name="no_telp" type="text" value="<?= $data["no_telp"]; ?>" placeholder="Masukkan Disini" class="input input-bordered w-full" />
                          </div>

                        </div>
                        <div class="text-center mt-7">
                    <button data-modal-hide="readModal<?= $data["id_user"]; ?>" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Back</button>
                    </div>
                    </div>
                    
              </div>
          </div>
      </div>
    </div>
    <!-- End Accept Modal -->
    <?php endforeach; ?>                          

    <!-- AlpineJS -->
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" integrity="sha256-KzZiKy0DWYsnwMF+X1DvQngQ2/FxF7MF3Ff72XcpuPs=" crossorigin="anonymous"></script>
</body>
</html>