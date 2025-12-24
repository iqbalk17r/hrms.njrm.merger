<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Informasi Pengguna</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #eaf7ea; /* Warna latar belakang hijau muda */
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #3d8a3d; /* Warna teks judul hijau tua */
        }

        p {
            color: #555555;
        }

        table {
            font-size: 11px;
            width: 70%;
            border-collapse: collapse;
            margin-top: 15px; /* Slightly smaller margin top */
        }

        th, td {
            border: 1px solid #dddddd;
            padding: 8px; /* Slightly smaller padding */
            text-align: left;
        }

        th {
            background-color: #3d8a3d; /* Warna latar belakang header hijau tua */
            color: #ffffff; /* Warna teks header putih */
        }

        .user-info {
            margin-top: 20px;
            border-top: 1px solid #dddddd;
            padding-top: 20px;
        }

        strong {
            color: #3d8a3d; /* Warna teks tebal hijau tua */
        }

        .logo {
            text-align: center;
            margin-bottom: 10px;
        }

        .logo img {
            width: 30%;
            height: 30%;
        }
        .title{
            margin-top: 50px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="logo">
        <img src="<?php echo base_url('assets/img/logo-depan/logo_depan.png') ?>" alt="NUSA Logo">
    </div>
    <h1 class="title">Selamat Datang di Perusahaan Kami!</h1>
    <p>Saudara/i [fullname],</p>
    <p>Terima kasih telah bergabung dengan perusahaan kami. Kami sangat senang Anda bergabung.</p>

    <div class="user-info">
        <h2>Informasi akun anda:</h2>
        <table>
            <thead>
                <tr>
                    <th>Aplikasi</th>
                    <th>Username</th>
                    <th>Password</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>[appname1]</td>
                    <td>[username1]</td>
                    <td>[password1]</td>
                </tr>
                <tr>
                    <td>[appname2]</td>
                    <td>[username2]</td>
                    <td>[password2]</td>
                </tr>
                <tr>
                    <td>[appname3]</td>
                    <td>[username3]</td>
                    <td>[password3]</td>
                </tr>
            </tbody>

            <!-- Tambahkan baris lebih banyak sesuai kebutuhan untuk aplikasi tambahan -->
        </table>
    </div>

    <p>Jika Anda memiliki pertanyaan atau membutuhkan bantuan, jangan ragu untuk menghubungi administrasi.</p>

    <br>
    <p>Salam terbaik,<br> Tim [companyName] </p>
</div>
</body>
</html>
