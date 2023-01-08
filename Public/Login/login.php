<?php
require('../Functions/koneksi.php');
session_start();
$error = '';
$validate = '';
//mengecek apakah sesssion username tersedia atau tidak jika tersedia maka akan diredirect ke halaman index
if( isset($_SESSION['username']) ) {
  //mengecek role dari session yang sedang aktif
  if ($_SESSION['role'] == 'Admin') {
    header('Location: ../Admin/index.php');
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
        $occupation = htmlspecialchars($_POST['occupation']);
        $captcha = $_POST['kodecaptcha'];
        
        //cek apakah nilai yang diinputkan pada form ada yang kosong atau tidak
        if(!empty(trim($username)) && !empty(trim($password)) && !empty(trim($occupation))){
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
                        $_SESSION['username'] = $username;
                        $_SESSION['role'] = $occupation;
                        
                        if ($_SESSION['role'] == 'Admin') {
                          header('Location: ../Admin/index.php');
                        }else {
                          header('Location: ../User/index.php');
                        }
                    }
                
                    // header('Location: index.php');
                }
                             
            //jika gagal maka akan menampilkan pesan error
            } else {
                $error =  'Username atau Password Salah!';
            }
             
        }else {
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
        /* *{
          border: 1px red solid;
        } */
    </style>
</head>
<body>
  <?php var_dump($_SESSION['username']); ?>
  <header>
    <div class="py-8 bg-tema">
      <div class="flex text-white relative"> 
        <h1 class="font-family-inter font-semibold text-2xl pl-24">Dana Pensiun PT Asep Makmur</h1>
        <a href="register.php" class="absolute right-12"><button class="bg-yellow-600 px-5 py-2 rounded-full text-slate-800 font-semibold font-family-inter block mx-auto hover:text-slate-900 hover:bg-yellow-500 active:bg-yellow-600 focus:ring focus:ring-sky-900">Register</button></a>
      </div>
    </div>
  </header>
  <div class="flex h-screen items-center">
    <div class="w-[60%] px-32 bg-tema-abu h-screen">
      
      <form action="login.php" class="relative mt-20" method="POST">
        <p class="font-family-inter font-bold text-2xl mb-4 text-center text-slate-600">Sign In</p>
        <?php if($error != ''){ ?>
                        <p><?= $error; ?></p>
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
          <input type="text" class="px-3 py-2 border shadow rounded w-full block text-sm placeholder:text-slate-400 focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500 invalid:text-pink-700 invalid:focus:ring-pink-700 invalid:focus:border-pink-700 peer" name="kodecaptcha" value="" maxlength="5" placeholder="Masukkan Captcha...">
        </label>
        <?php var_dump($_SESSION['code']); ?>


        <div class="flex mt-6 absolute right-0">
        <button type="submit" name="submit" class="bg-slate-300 px-5 py-2 rounded-full text-slate-800 font-semibold font-family-inter block  hover:text-slate-900 hover:bg-slate-100 active:bg-slate-300 focus:ring focus:ring-sky-900">Login</button>
        </div>
      </form>
    </div>

    <div class="flex w-[40%] items-center h-screen">
        <div class="mx-auto">
          <img src="../../dist/images/logo_pensiun1.jpg">
        </div>
        <p></p>
    </div>
  </div>
</body>
</html>