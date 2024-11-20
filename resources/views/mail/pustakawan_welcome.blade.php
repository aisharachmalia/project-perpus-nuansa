<!-- resources/views/emails/welcome_librarian.blade.php -->

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang di Perpustakaan</title>
</head>
<body>
    <h1>Selamat Datang, {{ $name }}!</h1>
    <p>Akun Anda untuk mengakses sistem perpustakaan telah berhasil dibuat. Berikut adalah informasi akun Anda:</p>

    <ul>
        <li><strong>Email:</strong> {{ $email }}</li>
        <li><strong>Password:</strong> {{ $password }}</li>
    </ul>

    <p>Silakan login dan mulai mengelola perpustakaan Anda. Jika Anda membutuhkan bantuan lebih lanjut, jangan ragu untuk menghubungi kami.</p>

    <p>Terima kasih!</p>
</body>
</html>
