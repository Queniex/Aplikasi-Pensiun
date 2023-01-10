<?php
require('../Functions/koneksi.php');
session_start();
$error = '';
$validate = '';
//mengecek apakah sesssion username tersedia atau tidak jika tersedia maka akan diredirect ke halaman index

if( isset($_SESSION['username']) ) {
  if ($_SESSION['role'] == 'Admin') {
    header('Location: ../Admin/index.php');
    var_dump($sql);
  }else {
    header('Location: ../User/index.php');
  }
}
//mengecek apakah form disubmit atau tidak
if( isset($_POST['submit']) ){
         
        $username = stripslashes($_POST['username']);
        $username = mysqli_real_escape_string($conn, $username);
        $password = stripslashes($_POST['password']);
        $password = mysqli_real_escape_string($conn, $password);
        $captcha = $_POST['kodecaptcha'];
        
        //cek apakah nilai yang diinputkan pada form ada yang kosong atau tidak
        if(!empty(trim($username)) && !empty(trim($password))){
            $occupation = htmlspecialchars($_POST['occupation']);
            if(!empty(trim($password))){
              //select data berdasarkan username dari database
            $query      = "SELECT * FROM user WHERE username = '$username'";
            $result     = mysqli_query($conn, $query);
            $rows       = mysqli_num_rows($result);

            if ($rows != 0) {
                $hash   = mysqli_fetch_assoc($result)['password'];
                if(password_verify($password, $hash)){
                    // $_SESSION['username'] = $username;
                    if ($_SESSION['code'] != $captcha) {
                        $error = 'Kode Captcha Salah!';
                    } else { // jika captcha benar, maka perintah yang bawah akan dijalankan
                        require_once('../Functions/function-krip.php');
                        $sql = query("SELECT * FROM user WHERE username = '$username'")[0];
                        $_SESSION['username'] = $sql['username'];
                        $_SESSION['id_user'] = $sql['id_user']; 
                        if($_POST['occupation'] == 'Admin') {
                          $_SESSION['role'] = 'Admin';
                          echo
                          "<script>
                          alert('Selamat Datang')
                          document.location.href = '../Admin/index.php'
                          </script>";
                        }else{
                          $_SESSION['role'] = 'Peserta';
                          echo
                          "<script>
                          alert('Selamat Datang')
                          document.location.href = '../User/index.php'
                          </script>";
                    
                        }

                        // header('Location: index.php');
                    }
                    // header('Location: index.php');
                } 
                   else {
                    $error =  'Username atau Password Salah!';
                }
              }
            }          
            //jika gagal maka akan menampilkan pesan error
             
        } else {
            $error =  'Data tidak boleh kosong!';
        }
    } 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
            colors: {
              'tema': '#152A38',
              'tema-abu': '#D9D9D9',
            },
            margin: {
              'half': '30%',
            },
            screens: {
              '2xl': '1320px',
            },
            keyframes:{
            },
          }
        }
      }
    </script>
    <style type="text/tailwindcss"> 
        /* * {
          border: 1px solid red;
        } */
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap');
        .font-family-inter{ font-family: 'Inter', sans-serif; }
        /* .bg-sidebar { background: #0A161E; } */
        .cta-btn { color: #3d68ff; }
        .upgrade-btn { background: #1947ee; }
        .upgrade-btn:hover { background: #0038fd; }
        .active-nav-link { background: #1947ee; }
        .nav-item:hover { background: #1947ee; }
        .account-link:hover { background: #3d68ff; }
    </style>
</head>
<body>
  <header clas>
    <div class="py-8 bg-tema">
      <div class="flex text-white relative"> 
        <h1 class="font-family-inter font-semibold text-2xl pl-24">Dana Pensiun PT Makmur</h1>
        <a href="register.php" class="absolute right-12"><button class="bg-yellow-600 px-5 py-2 rounded-full text-slate-800 font-semibold font-family-inter block mx-auto hover:text-slate-900 hover:bg-yellow-500 active:bg-yellow-600 focus:ring focus:ring-sky-900">Register</button></a>
      </div>
    </div>
  </header>
  <div class="lg:flex h-screen items-center bg-tema-abu">
    <div class="lg:w-[60%] md:w-[100%] sm:w-[100%] px-32 h-screen">
      <div class="h-32 w-full lg:hidden"></div>
      <form action="login.php" class="relative lg:mt-20" method="POST">
        <p class="font-family-inter font-bold text-2xl mb-4 text-center text-slate-600 lg:mt-0">Sign In</p>
        <?php if($error != ''){ ?>
          <div class="text-pink-700 font-semibold"><?= $error; ?></div>
        <?php } ?>
        <label for="username">
          <span class="block font-semibold mt-4 text-slate-700 border-0">Username</span>
          <input type="text" name="username" id="username" placeholder="Username" class="px-3 py-2 border shadow rounded w-full block text-sm placeholder:text-slate-400 focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500 invalid:text-pink-700 invalid:focus:ring-pink-700 invalid:focus:border-pink-700 peer"/>
        </label>
        <label for="password">
          <span class="block font-semibold mt-4 text-slate-700 border-0">Password</span>
          <input type="password" name="password" id="password" placeholder="Password" class="px-3 py-2 border shadow rounded w-full block text-sm placeholder:text-slate-400 focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500 invalid:text-pink-700 invalid:focus:ring-pink-700 invalid:focus:border-pink-700 peer"/>
        </label>
        <label for="occupation">
          <span class="block font-semibold mt-4 text-slate-700 border-0">Occupation</span>
          <select id="occupation" name="occupation" class="px-3 py-2 border shadow rounded w-full block text-sm placeholder:text-slate-400 focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500 invalid:text-pink-700 invalid:focus:ring-pink-700 invalid:focus:border-pink-700 peer">
            <option value="#" disabled selected>Pilih :</option>
            <option value="Peserta">Peserta</option>
            <option value="Admin">Admin</option>
          </select>
        </label>
        <label for="Captcha">
          <img class="my-4" id="Captcha" src="../Functions/captcha.php" alt="gambar">
          <?php //var_dump($_SESSION['code'])?>
          <input type="text" class="px-3 py-2 border shadow rounded w-full block text-sm placeholder:text-slate-400 focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500 invalid:text-pink-700 invalid:focus:ring-pink-700 invalid:focus:border-pink-700 peer" name="kodecaptcha" value="" maxlength="5" placeholder="Masukkan Captcha...">
        </label>


        <div class="flex mt-6 absolute right-0">
        <button type="submit" name="submit" class="bg-slate-300 px-5 py-2 rounded-full text-slate-800 font-semibold font-family-inter block  hover:text-slate-900 hover:bg-slate-100 active:bg-slate-300 focus:ring focus:ring-sky-900">Login</button>
        </div>
      </form>
    </div>

    <div class="lg:flex lg:w-[40%] lg:visible hidden lg:items-center lg:h-[100%]">
        <div class="mx-auto mr-16">
          <img class="rounded-3xl" src="../../dist/images/logo_pensiun1.jpg">
        </div>
        <p></p>
    </div>

  </div>
  <footer class="w-full bg-white text-center p-4">
      Copyright to <a target="_blank" href="https://github.com/Queniex/Aplikasi-Pensiun" class="underline text-[#152A38] hover:text-blue-500">Kelompok 3</a><br>
      All Right Reserved
  </footer>
</body>
</html>