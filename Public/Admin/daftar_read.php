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
$id = $_GET["np"];
$nf = $_GET["nf"];
$data = query("SELECT * FROM data_diri WHERE np = $id")[0]; //
$datas = query("SELECT * FROM pelampiran_file WHERE nf = $nf")[0];

$id = $_SESSION['id_user']; 
$data_foto = query("SELECT * FROM user WHERE id_user  = $id")[0];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Berkas</title>

    <!-- Link tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Link DaisyUi -->
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
            <a href="index.php?id=<?= $_SESSION['id_user'] ?>&role=<?= $_SESSION['role'] ?>" class="text-white text-3xl font-semibold uppercase hover:text-gray-300">Admin</a>
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
            <div class="w-1/2"></div>
            <div x-data="{ isOpen: false }" class="relative w-1/2 flex justify-end">
                <button @click="isOpen = !isOpen" class="realtive z-10 w-12 h-12 rounded-full overflow-hidden border-4 border-gray-400 hover:border-gray-300 focus:border-gray-300 focus:outline-none">
                  <?php if ($data_foto["foto"] > 0) : ?>
                    <img src="../../dist/images/<?= $data_foto["foto"]; ?>">   
                  <?php else : ?>
                    <img src="../../dist/images/Profile.png">
                  <?php endif ?>
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
                <a href="validasi.php?id=<?= $_SESSION['id_user'] ?>" class="flex items-center active-nav-link text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
                  <i class="fas fa-sticky-note mr-3"></i>
                  Validasi Berkas
                </a>
                <a href="datachart.php?id=<?= $_SESSION['id_user'] ?>" class="flex items-center text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
                  <i class="fas fa-chart-bar mr-3"></i>
                    Data Chart
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
                <h1 class="text-3xl text-black ml-6">Data Dana Pensiun Pegawai</h1>
                <h3 class="pb-3 ml-6">Form Pengajuan Permintan Dana Pensiun Pegawai</h3>

                <!-- Start Data Diri -->
                <div class="flex flex-wrap mt-4 pl-1 mb-14">
                  <div class="w-full pr-0">
                    <div class="bg-blue-400 h-9 rounded-t-3xl"></div>
                    <div class="bg-gray-200 h-full rounded-b-3xl">
                      <div class="pt-1 ml-6 mr-6">
                        
                        <form method="POST" enctype="multipart/form-data">
                          <div class="form-control w-full">
                            <label class="label">
                              <span class="label-text">NAMA LENGKAP :</span>
                            </label>
                            <input name="nama" type="text" value="<?= $data["nama"]; ?>" placeholder="Masukkan Disini" class="input input-bordered w-full" readonly />
                          </div>   
                          
                          <div class="form-control w-full">
                            <label class="label">
                              <span class="label-text">NIP :</span>
                            </label>
                            <input name="nip" type="text" value="<?= $data["nip"]; ?>" placeholder="Masukkan Disini" class="input input-bordered w-full" readonly />
                          </div>   

                          <div class="flex -mx-3">
                            <div class="md:w-1/2 px-3 md:mb-0">
                              <div class="form-control w-full">
                                <label class="label">
                                  <span class="label-text">TEMPAT LAHIR :</span>
                                </label>
                                <input name="tempat_lahir" type="text" value="<?= $data["tempat_lahir"]; ?>" placeholder="Masukkan Disini" class="input input-bordered w-full" readonly/>
                              </div>   
                            </div>
                            <div class="md:w-1/2 md:px-3">
                              <div class="form-control w-full">
                                <label class="label">
                                  <span class="label-text">TANGGAL LAHIR :</span>
                                </label>
                                <input name="tanggal_lahir" type="date" value="<?= $data["tanggal_lahir"]; ?>" class="input input-bordered w-full" readonly/>
                              </div>   
                            </div>
                          </div>

                          <div class="form-control md:w-1/3">
                            <label class="label">
                              <span class="label-text">AGAMA :</span>
                            </label>
                            <div class="relative">
                              <select name="agama" class="input input-bordered w-full" id="grid-state" readonly>
                                <option><?= $data["agama"]; ?></option>
                              </select>
                              <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-1 text-gray-700">
                                <svg class="fill-current h-2 w-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                              </div>
                            </div>
                          </div>   

                          <div class="form-control md:w-1/3">
                            <label class="label">
                              <span class="label-text">JENIS KELAMIN :</span>
                            </label>
                            <div class="relative">
                              <select name="jenis_kelamin" class="input input-bordered w-full" id="grid-state" readonly>
                                <option value=""><?= $data["jenis_kelamin"]; ?></option>
                              </select>
                              <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-1 text-gray-700">
                                <svg class="fill-current h-2 w-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                              </div>
                            </div>
                          </div> 
                          
                          <div class="form-control w-full">
                            <label class="label">
                              <span class="label-text">ALAMAT :</span>
                            </label>
                            <textarea name="alamat" value="" readonly class="textarea textarea-bordered" placeholder="<?= $data["alamat"]; ?>"></textarea>
                          </div>
                          
                          <div class="flex -mx-3">
                            <div class="md:w-1/2 px-3 md:mb-0">
                              <div class="form-control w-full">
                                <label class="label">
                                  <span class="label-text">NOMOR TELEPON :</span>
                                </label>
                                <input name="no_telp" value="<?= $data["no_telp"]; ?>" type="text" placeholder="Masukkan Disini" class="input input-bordered w-full" readonly/>
                              </div>   
                            </div>
                            <div class="md:w-1/2 md:px-3">
                              <div class="form-control w-full">
                                <label class="label">
                                  <span class="label-text">EMAIL :</span>
                                </label>
                                <input name="email" type="email" value="<?= $data["email"]; ?>" placeholder="email@email" class="input input-bordered w-full" readonly/>
                              </div>   
                            </div>
                          </div>

                          <div class="form-control md:w-1/3">
                            <label class="label">
                              <span class="label-text">STATUS KELUARGA :</span>
                            </label>
                            <div class="relative">
                              <select name="status_keluarga" readonly class="input input-bordered w-full" id="grid-state">
                                <option  value=""><?= $data["status_keluarga"]; ?></option>
                              </select>
                              <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-1 text-gray-700">
                                <svg class="fill-current h-2 w-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                              </div>
                            </div>
                          </div> 

                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- End Data Diri -->
                  
                  <!-- Start Pegawai -->
                  <div class="flex flex-wrap mt-4 pl-1 mb-14">
                    <div class="w-full pr-0">
                      <div class="bg-blue-400 h-9 rounded-t-3xl"></div>
                      <div class="bg-gray-200 h-full rounded-b-3xl">
                        <div class="pt-1 ml-6 mr-6">
                          
                          <div class="form-control w-full">
                            <label class="label">
                              <span class="label-text">INSTANSI :</span>
                            </label>
                            <input name="instansi" type="text" value="<?= $data["instansi"]; ?>" placeholder="Masukkan Disini" class="input input-bordered w-full" readonly />
                          </div>   
                          
                          <div class="form-control w-full">
                            <label class="label">
                              <span class="label-text">TANGGAL PEGAWAI :</span>
                            </label>
                            <input name="tgl_pegawai" value="<?= $data["tgl_pegawai"]; ?>" type="date" class="input input-bordered w-full" readonly/>
                          </div>   

                          <div class="flex -mx-3">
                            <div class="md:w-1/2 px-3 md:mb-0">
                              <div class="form-control w-full">
                                <label class="label">
                                  <span class="label-text">GOLONGAN :</span>
                                </label>
                                <div class="relative">
                                  <select name="golongan" class="input input-bordered w-full" readonly id="grid-state">
                                    <option  value=""><?= $data["golongan"]; ?></option>
                                  </select>
                                  <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-1 text-gray-700">
                                    <svg class="fill-current h-2 w-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                  </div>
                                </div>
                              </div>   
                            </div>
                            <div class="md:w-1/2 md:px-3">
                              <div class="form-control w-full">
                                <label class="label">
                                  <span class="label-text">JABATAN :</span>
                                </label>
                                <div class="relative">
                                  <select name="jabatan" readonly class="input input-bordered w-full" id="grid-state">
                                    <option  value=""><?= $data["jabatan"]; ?></option>
                                  </select>
                                  <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-1 text-gray-700">
                                    <svg class="fill-current h-2 w-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                  </div>
                                </div>
                              </div>   
                            </div>
                          </div>

                          <div class="form-control md:w-1/3">
                            <label class="label">
                              <span class="label-text">USIA PENSIUN :</span>
                            </label>
                            <div class="relative">
                              <select name="usia_pensiun" class="input input-bordered w-full" readonly id="grid-state">
                                <option  value=""><?= $data["usia_pensiun"]; ?></option>
                              </select>
                              <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-1 text-gray-700">
                                <svg class="fill-current h-2 w-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                              </div>
                            </div>
                          </div>   

                          <div class="form-control md:w-1/3">
                            <label class="label">
                              <span class="label-text">IURAN PERBULAN : </span>
                            </label>
                            <input name="iuran_perbulan" value="<?= $data["iuran_perbulan"]; ?>" type="text" placeholder="Masukkan Disini" class="input input-bordered w-full" readonly/>
                          </div> 

                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- End Pegawai -->

                  <!-- Start Berkas Pegawai -->
                  <div class="flex flex-wrap mt-4 pl-1 mb-14">
                    <div class="w-full pr-0">
                      <div class="bg-blue-400 h-9 rounded-t-3xl"></div>
                      <div class="bg-gray-200 h-full rounded-b-3xl">
                        <div class="pt-6 ml-6 mr-6">

                          <div class="flex flex-col">
                              <a class="text-slate-900 font-medium hover:text-blue-500" href="../Functions/download.php?file=<?= $datas["skpl"]; ?>">- File SKPL</a>
                              <a class="text-slate-900 font-medium hover:text-blue-500" href="../Functions/download.php?file=<?= $datas["skcp"]; ?>">- File SKCP</a>
                              <a class="text-slate-900 font-medium hover:text-blue-500" href="../Functions/download.php?file=<?= $datas["skcltn"]; ?>">- File SKCLTN</a>
                              <a class="text-slate-900 font-medium hover:text-blue-500" href="../Functions/download.php?file=<?= $datas["skpi"]; ?>">- File SKPI</a>
                          </div>  
                          
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- End Berkas Pegawai -->
                  <a href="validasi.php" name="submit" type="submit" class="btn btn-outline text-black bg-blue-400 hover:bg-blue-500 mx-2">Kembali</a>
                </form>
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
</body>
</html>
