<?php
$page_title = 'Login Admin — Bekakak Ayam Mang Atang';
$active = 'laporan';
require 'config/db.php';

if (session_status() === PHP_SESSION_NONE) session_start();

// kalau sudah login, langsung lempar ke laporan
if (isset($_SESSION['admin_id'])) {
    header('Location: laporan.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $error = 'Username dan password wajib diisi.';
    } else {
        $stmt = mysqli_prepare($koneksi, "SELECT id, username, password FROM admin WHERE username = ?");
        mysqli_stmt_bind_param($stmt, 's', $username);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        $admin = mysqli_fetch_assoc($res);

        if ($admin && password_verify($password, $admin['password'])) {
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_username'] = $admin['username'];
            header('Location: laporan.php');
            exit;
        } else {
            $error = 'Username atau password salah.';
        }
    }
}

require 'includes/header.php';
?>

<main>
  <section>
    <div class="wrap">
      <div class="section-head" style="margin:0 auto 32px;text-align:center;">
        <p class="eyebrow" style="justify-content:center;">Khusus Admin / Produsen</p>
        <h2>Masuk ke Laporan &amp; Billing</h2>
      </div>

      <form class="gate" method="POST" action="login.php">
        <div style="font-size:30px;">🔒</div>
        <h3 style="margin-top:14px;font-size:18px;">Login Admin</h3>

        <?php if ($error): ?>
          <p class="err"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <label for="username">Username</label>
        <input type="text" id="username" name="username" placeholder="admin" required autofocus>

        <label for="password">Password</label>
        <div style="position: relative; display: flex; align-items: center;">
            <input type="password" id="password" name="password" placeholder="••••••••" required style="width: 100%; padding-right: 40px;">
            <span id="togglePassword" style="position: absolute; right: 12px; cursor: pointer; font-size: 16px; user-select: none;">👁️‍🗨️</span>
        </div>

        <button class="btn btn-ember" type="submit" style="width:100%;justify-content:center;margin-top:18px;">Masuk</button>
        <small>Akun default: admin / admin123 — segera ganti setelah login pertama.</small>
      </form>
    </div>
  </section>
</main>

<script>
const togglePassword = document.querySelector('#togglePassword');
const password = document.querySelector('#password');

togglePassword.addEventListener('click', function () {
    // Ubah tipe input antara password dan text
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);
    
    // Ganti ikon mata
    this.textContent = type === 'password' ? '👁️‍🗨️' : '👁️';
});
</script>

<?php
mysqli_close($koneksi);
require 'includes/footer.php';
?>
