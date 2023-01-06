<?php 
  require_once("../Functions/function-krip.php");

  $id = $_GET['np'];
  $data = query("SELECT np, nama, nip, tempat_lahir, tanggal_lahir, agama, jenis_kelamin, alamat, no_telp, email, status_keluarga, instansi, tgl_pegawai, data_diri.golongan, dana.total_dana, jabatan, usia_pensiun, iuran_perbulan, status_berkas FROM data_diri JOIN dana ON data_diri.golongan = dana.golongan WHERE data_diri.np = $id")[0];

  if (isset($_POST['submit'])) {
    if (update($_POST) > 0) {
        echo "<script>
            alert('Input Success')
            document.location.href = 'krip.php';
        </script>";
    } else {
        echo "<script>
            alert('Input Failed')
            document.location.href = 'krip.php';
        </script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Tailwind Admin Template</title>
    <meta name="author" content="David Grzyb" />
    <meta name="description" content="" />

    <!-- Link tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
      tailwind.config = {
        theme: {
          container: {
            center: true,
            padding: "16px",
          },
          extend: {
            colors: {},
            screens: {
              "2xl": "1320px",
            },
            keyframes: {},
          },
        },
      };
    </script>

    <style type="text/tailwindcss">
      @import url("https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap");
      .font-family-inter {
        font-family: "Inter", sans-serif;
      }
      /* .bg-sidebar { background: #0A161E; } */
      .cta-btn {
        color: #3d68ff;
      }
      .upgrade-btn {
        background: #1947ee;
      }
      .upgrade-btn:hover {
        background: #0038fd;
      }
      .active-nav-link {
        background: #1947ee;
      }
      .nav-item:hover {
        background: #1947ee;
      }
      .account-link:hover {
        background: #3d68ff;
      }
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
            <a href="krip.php" class="flex items-center active-nav-link text-white opacity-75 hover:opacity-100 py-4 pl-6 nav-item">
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
                <a href="datachart.php" class="flex items-center text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
                  <i class="fas fa-chart-bar mr-3"></i>
                    Data Chart
                </a>
                <a href="krip.php" class="flex items-center active-nav-link text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
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
          <div class="flex gap-3 items-center bg-gray-300 p-4 rounded">
            <img src="../../dist/images/icon-peserta.png" alt="" width="40px" />
            <h1 class="font-bold text-xl text-slate-700">Kartu Identitas Peserta</h1>
          </div>
          <div class="mt-4 bg-gray-300 p-4 rounded relative">
            <form action="" method="post">
              <label for="np">
                <span class="text-slate-700">Nomor Pensiun</span>
                <input type="number" name="np" id="np" disabled class="block rounded-md w-full p-1 focus:outline-none focus:ring-2 ring-sky-500 mt-1 mb-3 bg-slate-50" value="<?= $data['np']; ?>">
              </label>

              <label for="nama_lengkap">
                <span class="text-slate-700">Nama Lengkap</span>
                <input type="text" name="nama_lengkap" id="nama_lengkap" class="block rounded-md p-1 w-full focus:outline-none focus:ring-2 ring-sky-500 mt-1 mb-3" value="<?= $data['nama']; ?>"/>
              </label>

              <label for="jenis_kelamin">
                <span class="text-slate-700">Jenis Kelamin</span>
                <select name="jenis_kelamin" id="jenis_kelamin" class="block w-full p-2 rounded-md mt-1 mb-3 focus:outline-none focus:ring-2 ring-sky-500">
                  <option value="" disabled selected>Pilih Jenis Kelamin</option>
                  <option value="Laki-Laki" selected=<?php if( $data['jenis_kelamin'] == 'Laki-laki' ){echo"selected";} ?>>Laki-Laki</option>
                  <option value="Perempuan" selected=<?php if( $data['jenis_kelamin'] == 'Perempuan' ){echo"selected";} ?>>Perempuan</option>
                </select>
              </label>

              <label for="alamat">
                <span class="text-slate-700">Alamat</span>
                <textarea name="alamat" id="alamat" class="block resize-none p-1 w-full rounded-md h-40 focus:outline-none focus:ring-2 ring-sky-500 mt-1 mb-3"><?= $data['alamat'] ?></textarea>
              </label>

              <label for="masa_pensiun">
                <span class="text-slate-700">Masa Pensiun</span>
                <input type="number" name="masa_pensiun" id="masa_pensiun" class="block p-1 rounded-md w-full focus:outline-none focus:ring-2 ring-sky-500 mt-1 mb-3" value="<?= $data['usia_pensiun']; ?>" />
              </label>

              <label for="golongan_pensiun">
                <span class="text-slate-700">Golongan Pensiun</span>
                <select name="golongan_pensiun" id="golongan_pensiun" class="block w-full p-2 rounded-md mt-1 mb-3 focus:outline-none focus:ring-2 ring-sky-500">
                  <option value="" disabled selected>Pilih Golongan</option>
                  <option value="1" selected=<?php if( $data['golongan'] == '1' ){echo"selected";} ?>>1</option>
                  <option value="2" selected=<?php if( $data['golongan'] == '2' ){echo"selected";} ?>>2</option>
                  <option value="3" selected=<?php if( $data['golongan'] == '3' ){echo"selected";} ?>>3</option>
                  <option value="4" selected=<?php if( $data['golongan'] == '4' ){echo"selected";} ?>>4</option>
                </select>
              </label>

              <br />
              <label for="total_dana_pencairan">
                <span class="text-slate-700">Total Dana Pencairan</span>
                <input type="number" name="total_dana_pencairan" id="total_dana_pencairan" disabled value="<?= $data['total_dana']?>" class="block p-1 rounded-md w-full focus:outline-none focus:ring-2 ring-sky-500 mt-1 mb-3 bg-slate-50" />
              </label>
              <input type="hidden" name="np" value="<?= $data['np']; ?>">

              <section class="absolute left-5 bottom-17 text-lg font-bold">[ <?= $data['instansi'] ?> ]</section>
              <br /><br /><br /><br /><br />
              <button value="submit" name="submit" id="submit" class="absolute right-2 bottom-2 py-2 px-4 bg-cyan-700 rounded-md hover:bg-cyan-800 text-white">Simpan</button>
            </form>
          </div>
        </main>

        <footer class="w-full bg-white text-right p-4">&#169; Copyright to <a target="_blank" href="https://github.com/Queniex/Aplikasi-Pensiun" class="underline text-[#152A38] hover:text-blue-500">Kelompok 3</a></footer>
      </div>
    </div>

    <!-- AlpineJS -->
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" integrity="sha256-KzZiKy0DWYsnwMF+X1DvQngQ2/FxF7MF3Ff72XcpuPs=" crossorigin="anonymous"></script>
  </body>
</html>
