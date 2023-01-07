<?php
//menyertakan file program koneksi.php pada register
require('../Functions/koneksi.php');
//inisialisasi session
session_start();
$error = '';
$validate = '';
//mengecek apakah form registrasi di submit atau tidak
if( isset($_POST['submit']) ){
        // menghilangkan backslashes
        $username = stripslashes($_POST['username']);
        //cara sederhana mengamankan dari sql injection
        $username = mysqli_real_escape_string($conn, $username);
        $occupation = stripslashes($_POST['occupation']);
        $occupation = mysqli_real_escape_string($conn, $occupation);
        $email    = stripslashes($_POST['email']);
        $email    = mysqli_real_escape_string($conn, $email);
        $password = stripslashes($_POST['password']);
        $password = mysqli_real_escape_string($conn, $password);
        $repass   = stripslashes($_POST['repassword']);
        $repass   = mysqli_real_escape_string($conn, $repass);
        //cek apakah nilai yang diinputkan pada form ada yang kosong atau tidak
        if(!empty(trim($username)) && !empty(trim($email)) && !empty(trim($password)) && !empty(trim($repass))){
            //mengecek apakah password yang diinputkan sama dengan re-password yang diinputkan kembali
            if($password == $repass){
                //memanggil method cek_nama untuk mengecek apakah user sudah terdaftar atau belum
                if( cek_nama($name,$conn) == 0 ){
                    //hashing password sebelum disimpan didatabase
                    $pass  = password_hash($password, PASSWORD_DEFAULT);
                    //insert data ke database
                    $query = "INSERT INTO user (username,password, email, role ) VALUES ('$username','$pass','$email','$occupation')";
                    $result   = mysqli_query($conn, $query);
                    //jika insert data berhasil maka akan diredirect ke halaman index.php serta menyimpan data username ke session
                    if ($result) {
                        $_SESSION['username'] = $username;
                        if($_POST['occupation'] == 'Admin') {
                          echo
                          "<script>
                          alert('Selamat Datang')
                          document.location.href = '../Admin/index.html'
                          </script>";
                        }else{
                          echo
                          "<script>
                          alert('Selamat Datang')
                          document.location.href = '../User/index.html'
                          </script>";
                        }
                    //jika gagal maka akan menampilkan pesan error
                    } else {
                        $error =  'Register User Gagal !!';
                    }
                }else{
                        $error =  'Username sudah terdaftar !!';
                }
            }else{
                $validate = 'Password tidak sama !!';
            }
             
        }else {
            $error =  'Data tidak boleh kosong !!';
        }
    } 
    //fungsi untuk mengecek username apakah sudah terdaftar atau belum
    function cek_nama($username,$conn){
        $nama = mysqli_real_escape_string($conn, $username);
        $query = "SELECT * FROM user WHERE username = '$nama'";
        if( $result = mysqli_query($conn, $query) ) return mysqli_num_rows($result);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Tailwind</title>
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
  <header>
    <div class="py-8 bg-tema">
      <div class="flex text-white relative"> 
        <h1 class="font-family-inter font-semibold text-2xl pl-24">Dana Pensiun PT Makmur</h1>
        <a href="login.php" class="absolute right-12"><button class="bg-yellow-600 px-5 py-2 rounded-full text-slate-800 font-semibold font-family-inter block mx-auto hover:text-slate-900 hover:bg-yellow-500 active:bg-yellow-600 focus:ring focus:ring-sky-900">Login</button></a>
      </div>
    </div>
  </header>
  <div class="flex h-screen items-center">
    <div class="w-[60%] px-32 bg-tema-abu h-screen">
      
      <form action="register.php" class="relative mt-20" method="POST">
        <p class="font-family-inter font-bold text-2xl mb-4 text-center text-slate-600">Register</p>
        <label for="username">
          <span class="block font-semibold mt-4 text-slate-700 border-0">Username</span>
          <input type="text" name="username" id="username" placeholder="Username" class="px-3 py-2 border shadow rounded w-full block text-sm placeholder:text-slate-400 focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500 invalid:text-pink-700 invalid:focus:ring-pink-700 invalid:focus:border-pink-700 peer"/>
        </label>
        <label for="email">
          <span class="block font-semibold mt-4 text-slate-700 border-0">E-Mail</span>
          <input type="text" name="email" id="email" placeholder="E-Mail" class="px-3 py-2 border shadow rounded w-full block text-sm placeholder:text-slate-400 focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500 invalid:text-pink-700 invalid:focus:ring-pink-700 invalid:focus:border-pink-700 peer"/>
        </label>
        <label for="password">
          <span class="block font-semibold mt-4 text-slate-700 border-0">Password</span>
          <input type="password" name="password" id="password" placeholder="Password" class="px-3 py-2 border shadow rounded w-full block text-sm placeholder:text-slate-400 focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500 invalid:text-pink-700 invalid:focus:ring-pink-700 invalid:focus:border-pink-700 peer"/>
        </label>
        <label for="repassword">
          <span class="block font-semibold mt-4 text-slate-700 border-0">Re-Password</span>
          <input type="password" name="repassword" id="repassword" placeholder="Re-Password" class="px-3 py-2 border shadow rounded w-full block text-sm placeholder:text-slate-400 focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500 invalid:text-pink-700 invalid:focus:ring-pink-700 invalid:focus:border-pink-700 peer"/>
        </label>
        <label for="occupation">
          <span class="block font-semibold mt-4 text-slate-700 border-0">Occupation</span>
          <select id="occupation" name="occupation" class="px-3 py-2 border shadow rounded w-full block text-sm placeholder:text-slate-400 focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500 invalid:text-pink-700 invalid:focus:ring-pink-700 invalid:focus:border-pink-700 peer">
            <option value="#" disabled selected>Pilih :</option>
            <option value="Peserta">Peserta</option>
            <option value="Admin">Admin</option>
          </select>
        </label>

        <div class="flex mt-6 absolute right-0">
        <button type="submit" name="submit" class="bg-slate-300 px-5 py-2 rounded-full text-slate-800 font-semibold font-family-inter block  hover:text-slate-900 hover:bg-slate-100 active:bg-slate-300 focus:ring focus:ring-sky-900">Register</button>
        </div>
      </form>
    </div>

    <div class="flex w-[40%] items-center h-screen">
        <div class="mx-auto">
          <img src="../../dist/images/pensiun.png">
        </div>
        <p></p>
    </div>
  </div>
</body>
</html>