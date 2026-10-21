<?php
$nama = $email = $nilai = "";
$hasil = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nama  = trim($_POST["nama"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $nilai = trim($_POST["nilai"] ?? "");

    if ($nama === "" || $email === "" || $nilai === "") {
        $error = "Semua kolom wajib diisi.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Format email tidak valid.";
    } elseif (!is_numeric($nilai) || $nilai < 0 || $nilai > 100) {
        $error = "Nilai ujian harus berupa angka 0 sampai 100.";
    } else {
        $nilai = (float) $nilai;

        // struktur kendali
        if ($nilai > 70) {
            $hasil = "Lulus";
        } else {
            $hasil = "Remedial";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Form Nilai Ujian</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f3f4f6; display: flex; justify-content: center; padding: 40px 16px; }
        .box { background: #fff; padding: 24px; border-radius: 8px; width: 100%; max-width: 420px; box-shadow: 0 2px 8px rgba(0,0,0,.1); }
        label { display: block; margin-top: 12px; font-weight: bold; }
        input { width: 100%; padding: 8px; margin-top: 4px; box-sizing: border-box; }
        button { margin-top: 16px; padding: 10px 16px; cursor: pointer; }
        .error { color: #b91c1c; margin-top: 12px; }
        .hasil { margin-top: 20px; padding: 12px; border-radius: 6px; background: #e0f2fe; }
        .lulus { color: #15803d; font-weight: bold; }
        .remedial { color: #b91c1c; font-weight: bold; }
    </style>
</head>
<body>
<div class="box">
    <h2>Form Nilai Ujian</h2>
    <form method="post" action="">
        <label for="nama">Nama</label>
        <input type="text" id="nama" name="nama" value="<?= htmlspecialchars($nama) ?>">

        <label for="email">Email</label>
        <input type="text" id="email" name="email" value="<?= htmlspecialchars($email) ?>">

        <label for="nilai">Nilai Ujian</label>
        <input type="text" id="nilai" name="nilai" value="<?= htmlspecialchars((string)$nilai) ?>">

        <button type="submit">Kirim</button>
    </form>

    <?php if ($error !== ""): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php elseif ($hasil !== ""): ?>
        <div class="hasil">
            <p>Nama: <?= htmlspecialchars($nama) ?></p>
            <p>Email: <?= htmlspecialchars($email) ?></p>
            <p>Nilai Ujian: <?= $nilai ?></p>
            <p>Status: <span class="<?= strtolower($hasil) ?>"><?= $hasil ?></span></p>
        </div>
    <?php endif; ?>
</div>
</body>
</html>