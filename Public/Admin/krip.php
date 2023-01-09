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

require_once("../Functions/function-krip.php");

$data = query("SELECT * FROM data_diri WHERE status_berkas = 'approve'");

$jumlahdata = count($data);
$batas = 2;
$banyaknyahalaman = ceil($jumlahdata / $batas);

$halaman = 1;
if (isset($_GET['halaman'])) {
    $halaman = $_GET['halaman'];
}
$posisi = ($halaman - 1) * $batas;

if (isset($_POST['search'])) {
  if (search($_POST['keyword']) > 0) {
      $data = search($_POST['keyword']);
  } else {
      $data = query("SELECT * FROM data_diri WHERE status_berkas = 'approve' LIMIT $posisi,$batas");
  }
} else {
  $data = query("SELECT * FROM data_diri WHERE status_berkas = 'approve' LIMIT $posisi,$batas");
}

$id = $_SESSION['id_user']; 
$data_foto = query("SELECT * FROM user WHERE id_user  = $id")[0];
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
        <a href="validasi.php?id=<?= $_SESSION['id_user'] ?>" class="flex items-center text-white opacity-75 hover:opacity-100 py-4 pl-6 nav-item">
          <i class="fas fa-sticky-note mr-3"></i>
          Validasi Berkas
        </a>
        <a href="krip.php?id=<?= $_SESSION['id_user'] ?>" class="flex items-center active-nav-link text-white opacity-75 hover:opacity-100 py-4 pl-6 nav-item">
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
          <form action="" method="post" class="flex gap-2">
            <input type="text" id="keyword" name="keyword" autofocus autocomplete="off" placeholder="Cari Data.." class="rounded-lg bg-slate-100 block px-3 py-1 w-96 outline-none" required>
            <button type="submit" name="search">
              <img src="../../dist/images/search.png" alt="cari" width="30px">
            </button>
          </form>
        </div>
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
          <a href="datachart.php?id=<?= $_SESSION['id_user'] ?>" class="flex items-center text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
            <i class="fas fa-chart-bar mr-3"></i>
            Data Chart
          </a>
          <a href="validasi.php?id=<?= $_SESSION['id_user'] ?>" class="flex items-center text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
            <i class="fas fa-sticky-note mr-3"></i>
            Validasi Berkas
          </a>
          <a href="krip.php?id=<?= $_SESSION['id_user'] ?>" class="flex items-center active-nav-link text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
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
        <main class="w-full flex-grow p-6 relative">
          <h1 class="text-xl font-bold text-black underline underline-offset-4 mb-5">KARIP</h1>

          <?php if($data < [0]) : ?>
            <h1 class="italic text-3xl mt-5 text-red-700 text-center">Unknown data Available</h1>
          <?php else : ?>
            <?php foreach ($data as $row) : ?>
            <div class="w-full h-20 rounded bg-[#152A38] hover:bg-[#22466d] mt-2 p-3 pl-5 relative">
              <div class="absolute mt-1">
                <h2 class="capitalize text-white">Nama : <?= $row['nama'] ?></h2>
                <p class="text-white">Nomor Pensiun : <?= $row['np'] ?></p>
              </div>
              <div class="absolute right-0 mt-1 flex gap-3 mr-10">
                <a href="krip-read.php?np=<?= $row['np'] ?>" class="bg-blue-500 p-1 rounded hover:bg-blue-700">
                  <img src="../../dist/images/icon-read.png" alt="read" />
                </a>
                <a href="krip-edit.php?np=<?= $row['np'] ?>" class="bg-lime-700 p-1 rounded hover:bg-lime-800">
                  <img src="../../dist/images/icon-edit.png" alt="edit" />
                </a>
                <a href="krip-delete.php?np=<?= $row['np']; ?>" onclick="return confirm('Yakin ingin menghapus?')" class="bg-red-500 p-1 rounded hover:bg-red-700">
                  <img src="../../dist/images/icon-remove.png" alt="remove" />
                </a>
              </div>
            </div>
            <?php endforeach; ?>
          <?php endif ?>

          <div class="h-32 relative">
            <ul class="text-center absolute bottom-2 right-1/2">
              <?php for($i = 1; $i <= $banyaknyahalaman; $i++): ?>
                <?php if($i == $halaman): ?>
                  <li class="inline-block"><a href="?halaman=<?= $i ?>" class="bg-[#152A38] hover:bg-[#22466d] p-2 text-white rounded"><?= $i ?></a></li>
                <?php else: ?>
                  <li class="inline-block"><a href="?halaman=<?= $i ?>" class="border bg-[#152A38] hover:bg-[#22466d] p-2 text-white rounded"><?= $i ?></a></li>
                <?php endif; ?>
              <?php endfor; ?>
            </ul>
          </div>


        </main>

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
