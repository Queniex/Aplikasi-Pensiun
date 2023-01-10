<!-- <?php
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
        $email    = stripslashes($_POST['email']);
        $email    = mysqli_real_escape_string($conn, $email);
        $password = stripslashes($_POST['password']);
        $password = mysqli_real_escape_string($conn, $password);
        $repass   = stripslashes($_POST['repassword']);
        $repass   = mysqli_real_escape_string($conn, $repass);
        //cek apakah nilai yang diinputkan pada form ada yang kosong atau tidak
        if(!empty(trim($username)) && !empty(trim($email)) && !empty(trim($password)) && !empty(trim($repass))){
            $occupation = stripslashes($_POST['occupation']);
            $occupation = mysqli_real_escape_string($conn, $occupation);
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
                        require_once('../Functions/function-krip.php');
                        $sql = query("SELECT * FROM user WHERE username = '$username'")[0];
                        $_SESSION['id_user'] = $sql['id_user']; 
                        if($_POST['occupation'] == 'Admin') {
                          if($_POST['secret'] == 'adminonly'){
                            echo
                            "<script>
                            alert('Selamat Datang')
                            document.location.href = '../Admin/index.php'
                            </script>";
                          } else{
                            $error =  'Secret code Salah !!';
                          }
                        }else{
                          echo
                          "<script>
                          alert('Selamat Datang')
                          document.location.href = '../User/index.php'
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
?> -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
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
    <div class="lg:w-[60%] w-[100vw] px-32 bg-tema-abu h-screen">
      
      <form action="register.php" class="relative mt-20" method="POST">
        <p class="font-family-inter font-bold text-2xl mb-4 text-center text-slate-600">Register</p>
        <?php if($error != ''){ ?>
          <div class="text-pink-700 font-semibold"><?= $error; ?></div>
        <?php } ?>
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
        <div class="flex flex-row">
          <div class="form-control w-3/5">
            <label for="occupation">
              <span class="block font-semibold mt-4 text-slate-700 border-0">Occupation</span>
              <select id="occupation" name="occupation" class="px-3 py-2 border shadow rounded w-full block text-sm placeholder:text-slate-400 focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500 invalid:text-pink-700 invalid:focus:ring-pink-700 invalid:focus:border-pink-700 peer" onClick="check(this.id)">
                <option value="#" disabled selected>Pilih :</option>
                <option value="Peserta">Peserta</option>
                <option id="secret" value="Admin">Admin</option>
              </select>
            </label>  
          </div>
          <div id="occupations" class="form-control w-2/5 mt-12 ml-5 hidden">
            <div class="input-group">
              <input type="text" name="secret" placeholder=" Enter the Secret Code" class="input border-2 border-black input-bordered bg-slate-500 text-black pl-2" />
              <button class="btn btn-square">
              </button>
            </div>
          </div>
        </div>

        <div class="flex mt-6 absolute right-0">
        <button type="submit" name="submit" class="bg-slate-300 px-5 py-2 rounded-full text-slate-800 font-semibold font-family-inter block  hover:text-slate-900 hover:bg-slate-100 active:bg-slate-300 focus:ring focus:ring-sky-900">Register</button>
        </div>
      </form>
    </div>

    <div class="lg:flex lg:w-[40%] lg:items-center lg:h-screen lg:visible hidden bg-tema-abu">
        <div class="mx-auto mr-16">
          <img src="../../dist/images/pensiun.png">
        </div>
        <p></p>
    </div>
  </div>

   <script>
    function check(clicked_id)
  {
      var click = document.getElementById("occupation");
      console.log(click.selectedIndex);
      if(click.selectedIndex == 2) {
        var element = document.getElementById("occupations")
        element.classList.remove("hidden");
      } else {
        var element = document.getElementById("occupations")
        element.classList.add("hidden");
      }
  }
   </script>       

  <footer class="w-full bg-white text-center p-4">
      Copyright to <a target="_blank" href="https://github.com/Queniex/Aplikasi-Pensiun" class="underline text-[#152A38] hover:text-blue-500">Kelompok 3</a><br>
      All Right Reserved
  </footer>
</body>
</html>