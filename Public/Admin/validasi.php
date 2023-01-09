<?php
session_start();
if( !isset($_SESSION['username']) ) {
  header("Location: ../Login/login.php");
  exit;
}

if( $_SESSION['role'] != 'Admin') {
  header("Location: ../Login/login.php");
  exit;
}

require '../Functions/function-daftar.php';


// pagination configuration
$totalDataPage = 5;
$totalData = count(query("SELECT np, nama, nip, instansi, status_berkas, pelampiran_file.nf AS 'nf' FROM data_diri LEFT JOIN pelampiran_file ON data_diri.id_user WHERE status_berkas = 'checked'"));
$totalPage = ceil($totalData / $totalDataPage);
$activePage = ( isset($_GET["page"]) ) ? $_GET["page"] : 1;
$data = ($totalDataPage * $activePage ) - $totalDataPage;
$datas = query("SELECT np, nama, nip, instansi, status_berkas, pelampiran_file.nf AS 'nf' FROM data_diri LEFT JOIN pelampiran_file ON data_diri.id_user WHERE status_berkas = 'checked' LIMIT $data, $totalDataPage ");

if ( isset($_POST["cari"]) ){
  $datas = find($_POST["keyword"]);
}

if ( isset($_POST["approved"]) ){
    if( approve($_POST) > 0){
      echo "
          <script>
              document.location.href = 'validasi.php'
          </script>
     "; 
    }
    else {
      die('invalid Query : ' . mysqli_error($conn));
      echo mysqli_error($conn);
    }
}

if ( isset($_POST["refused"]) ){
  if( refuse($_POST) > 0){
    echo "
        <script>
            document.location.href = 'validasi.php'
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
    <title>Validasi Berkas</title>
    <meta name="author" content="David Grzyb">
    <meta name="description" content="">

    <!-- Link tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Link Daisyui -->
    <link href="https://cdn.jsdelivr.net/npm/daisyui@2.46.1/dist/full.css" rel="stylesheet" type="text/css" />

    <!-- Link Flowbite -->
    <link rel="stylesheet" href="https://unpkg.com/flowbite@1.6.0/dist/flowbite.min.css" />

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
            <a href="index.php?id=<?= $_SESSION['id_user'] ?>" class="text-white text-3xl font-semibold uppercase hover:text-gray-300">Admin</a>
            <button class="w-full bg-white cta-btn font-semibold py-2 mt-5 rounded-br-lg rounded-bl-lg rounded-tr-lg shadow-lg hover:shadow-xl hover:bg-gray-300 flex items-center justify-center">
                <i class="fas fa-plus mr-3"></i> New Report
            </button>
        </div>
        <nav class="text-white text-base font-semibold pt-0">
            <a href="index.php?id=<?= $_SESSION['id_user'] ?>" class="flex items-center text-white py-4 pl-6 nav-item">
                <i class="fas fa-tachometer-alt mr-3"></i>
                Dashboard
            </a>
            <a href="datachart.php?id=<?= $_SESSION['id_user'] ?>" class="flex items-center text-white opacity-75 hover:opacity-100 py-4 pl-6 nav-item">
                <i class="fas fa-chart-bar mr-3"></i>
                  Data Chart
            </a>
            <a href="validasi.php?id=<?= $_SESSION['id_user'] ?>" class="flex items-center active-nav-link text-white opacity-75 hover:opacity-100 py-4 pl-6 nav-item">
                <i class="fas fa-sticky-note mr-3"></i>
                Validasi Berkas
            </a>
            <a href="krip.php?id=<?= $_SESSION['id_user'] ?>" class="flex items-center text-white opacity-75 hover:opacity-100 py-4 pl-6 nav-item">
              <i class="fas fa-book-reader mr-3"></i>
              KRIP
            </a>
            <a href="user.php?id=<?= $_SESSION['id_user'] ?>" class="flex items-center text-white opacity-75 hover:opacity-100 py-4 pl-6 nav-item">
                <i class="fas fa-user-cog mr-3"></i>
                Kelola User
            </a>
        </nav>
        <a href="../Login/logout.php" class="absolute w-full upgrade-btn bottom-0 active-nav-link text-white flex items-center justify-center py-4">
            <i class="fas fa-arrow-alt-circle-left mr-3"></i>
            Log Out
        </a>
    </aside>

    <div class="w-full flex flex-col h-screen overflow-y-hidden">
        <!-- Desktop Header -->
        <header class="w-full items-center bg-white py-2 px-6 hidden sm:flex">
            <div class="w-1/2">
              <form method="POST">   
                <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
                  <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                        <input type="search" name="keyword" id="default-search" class="block w-full p-4 pl-10 text-sm text-black border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="Masukkan Data.." required>
                        <button type="submit" name="cari" class="text-white absolute right-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Search</button>
                  </div>
              </form>
            </div>
            <div x-data="{ isOpen: false }" class="relative w-1/2 flex justify-end">
                <button @click="isOpen = !isOpen" class="realtive z-10 w-12 h-12 rounded-full overflow-hidden border-4 border-gray-400 hover:border-gray-300 focus:border-gray-300 focus:outline-none">
                    <img src="../../dist/images/Profile.png">
                </button>
                <button x-show="isOpen" @click="isOpen = false" class="h-full w-full fixed inset-0 cursor-default"></button>
                <div x-show="isOpen" class="absolute w-32 bg-white rounded-lg shadow-lg py-2 mt-16">
                    <a href="cekakun.php?id=<?= $_SESSION['id_user'] ?>" class="block px-4 py-2 account-link hover:text-white">Account</a>
                </div>
            </div>
        </header>

        <!-- Mobile Header & Nav -->
        <header x-data="{ isOpen: false }" class="bg-[#152A38] w-full bg-sidebar py-5 px-6 sm:hidden">
            <div class="flex items-center justify-between">
                <a href="index.php?id=<?= $_SESSION['id_user'] ?>" class="text-white text-3xl font-semibold uppercase hover:text-gray-300">Admin</a>
                <button @click="isOpen = !isOpen" class="text-white text-3xl focus:outline-none">
                    <i x-show="!isOpen" class="fas fa-bars"></i>
                    <i x-show="isOpen" class="fas fa-times"></i>
                </button>
            </div>

            <!-- Dropdown Nav -->
            <nav :class="isOpen ? 'flex': 'hidden'" class="flex flex-col pt-4">
                <a href="index.php?id=<?= $_SESSION['id_user'] ?>" class="flex items-center text-white py-2 pl-4 nav-item">
                    <i class="fas fa-tachometer-alt mr-3"></i>
                    Dashboard
                </a>
                <a href="datachart.php?id=<?= $_SESSION['id_user'] ?>" class="flex items-center text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
                    <i class="fas fa-chart-bar mr-3"></i>
                      Data Chart
                </a>
                <a href="validasi.php?id=<?= $_SESSION['id_user'] ?>" class="flex items-center active-nav-link text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
                    <i class="fas fa-sticky-note mr-3"></i>
                    Validasi Berkas
                </a>
                <a href="krip.php?id=<?= $_SESSION['id_user'] ?>" class="flex items-center text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
                  <i class="fas fa-book-reader mr-3"></i>
                  KRIP
                </a>
                <a href="user.php?id=<?= $_SESSION['id_user'] ?>" class="flex items-center text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
                    <i class="fas fa-user-cog mr-3"></i>
                    Kelola User
                </a>
                <a href="../Login/logout.php" class="w-full bg-white cta-btn font-semibold py-2 mt-3 rounded-lg shadow-lg hover:shadow-xl hover:bg-gray-300 flex items-center justify-center">
                  <i class="fas fa-arrow-alt-circle-left mr-3"></i>
                  Log Out
                </a>
            </nav>
        </header>
    
        <div class="w-full h-screen overflow-x-hidden border-t flex flex-col">
            <main class="w-full flex-grow p-6">
              <div class="lg:flex lg:flex-row">
                <h1 class="sm:mb-3 lg:text-3xl w-1/2 lg:mt-3 lg:mb-3 text-black underline underline-offset-4">Validasi Berkas Dana Pensiun</h1>
                <span class="justify-end w-1/2 ">

                </span>
              </div>
                <div class="flex flex-wrap mt-4 mb-8">
                    <div class="overflow-x-auto w-full">
                        <table class="table w-full">
                          <!-- head -->
                          <thead>
                            <tr>
                              <th class="text-center">Nama</th>
                              <th class="text-center">Keterangan</th>
                              <th class="text-center">Kontrol</th>
                              <th class="text-center">Aksi</th>
                            </tr>
                          </thead>
                          <tbody>
                            
                          <?php foreach( $datas as $data ) : ?>
                            <tr>
                               <td class="text-center">   
                                  <div>
                                    <div class="font-bold"><?= $data["nama"]; ?></div>
                                    <div class="text-sm opacity-50"><?= $data["nip"]; ?></div>
                                  </div>
                              </td>
                              <td class="text-center">
                              <?= $data["instansi"]; ?>
                                <br/>
                                <span class="badge badge-ghost badge-sm"><?= $data["status_berkas"]; ?></span>
                              </td>
                              <td class="text-center">
                                <span>
                                  <a href="daftar_read.php?np=<?= $data["np"]; ?>&nf=<?= $data["nf"]; ?>" class="font-bold text-blue-400 hover:text-white">Lihat</a> | <a href="daftar_edit.php?np=<?= $data["np"]; ?>&nf=<?= $data["nf"]; ?>" class="font-bold text-lime-500 hover:text-white">Edit</a>
                                </span>
                              </td>
                              <th>
                                <div class="grid justify-center">
                                    <span>
                                      <button data-modal-target="popup-approve" data-modal-toggle="popup-approve" type="button" class="text-lime-600 hover:text-white">Terima</button> | <button data-modal-target="popup-modal" data-modal-toggle="popup-modal" type="button" class="text-red-500 hover:text-white">Tolak</button>
                                    </span>
                                </div>
                              </th>
                            </tr>
                          <?php endforeach; ?> 

                          </tbody>
                        </table>
                      
                    </div>
                </div>

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

    <form method="POST">
    <!-- Delete Modal -->
    <div id="popup-modal" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
        <div class="relative w-full h-full max-w-md md:h-auto">
            <div class="relative bg-white rounded-lg shadow dark:bg-black">
                <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-hide="popup-modal">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-6 text-center">
                    <input type="hidden" name="np" value="<?= $data["np"]; ?>">  
                    <svg aria-hidden="true" class="mx-auto mb-4 text-gray-400 w-14 h-14 dark:text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Anda yakin ingin menghapus data ini?</h3>
                    <button data-modal-hide="popup-modal" name="refused" type="submit" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                        IYA
                    </button>
                    <button data-modal-hide="popup-modal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Tidak</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Delete Modal -->

    <!-- Accept Modal -->
    <div id="popup-approve" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
      <div class="relative w-full h-full max-w-md md:h-auto">
          <div class="relative bg-white rounded-lg shadow dark:bg-black">
              <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-hide="popup-approve">
                  <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                  <span class="sr-only">Close modal</span>
              </button>
              <div class="p-6 text-center">
                  <input type="hidden" name="np" value="<?= $data["np"]; ?>">  
                  <center><svg fill="#1fcf07" class="w-20 h-20" height="200px" width="200px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 472.615 472.615" xml:space="preserve" stroke="#1fcf07"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_iconCarrier"> <g> <g> <path d="M236.308,0C105.799,0,0,105.798,0,236.308c0,130.507,105.799,236.308,236.308,236.308 c130.509,0,236.308-105.801,236.308-236.308C472.615,105.798,366.816,0,236.308,0z M189.676,343.493L89.455,243.272l13.923-13.923 l86.298,86.299l179.557-179.558l13.923,13.923L189.676,343.493z"></path> </g> </g> </g></svg></center>
                  <h3 class="mb-5 mt-1 text-lg font-normal text-gray-500 dark:text-gray-400">Anda yakin ingin mengapprove data ini?</h3>
                  <button data-modal-hide="popup-approve" type="submit" name="approved" class="text-white bg-lime-600 hover:bg-lime-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-lime-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                      Yes, I'm sure
                  </button>
                  <button data-modal-hide="popup-approve" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">No, cancel</button>
              </div>
          </div>
      </div>
    </div>
    <!-- End Accept Modal -->
    </form>

    <!-- AlpineJS -->
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" integrity="sha256-KzZiKy0DWYsnwMF+X1DvQngQ2/FxF7MF3Ff72XcpuPs=" crossorigin="anonymous"></script>
    <!-- Link Flowbite -->
    <script src="https://unpkg.com/flowbite@1.6.0/dist/flowbite.min.js"></script>
</body>
</html>
