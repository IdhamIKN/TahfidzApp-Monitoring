<p align="center"><a href="https://tahfidzapp.bmdsyariah.com" target="_blank"><img src="https://tahfidzapp.bmdsyariah.com/layout_login/images/logo.png" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>


## About TahfidzApp

TahfidzApp adalah sebuah aplikasi web yang didesain untuk membantu mempermudah proses pembelajarantahfidz Al-Quran secara online. Aplikasi ini memiliki tiga level akses yaitu Creator, Admin, dan Guru.

Level Creator memiliki akses penuh pada sistem dan dapat mengakses semua fitur yang tersedia, termasukfungsi-fungsi administratif dan manajemen pengguna. Creator juga dapat membuat kelas dan mengundangsiswa untuk bergabung ke dalam kelas tersebut.

Level Admin hampir sama dengan Creator, namun tidak dapat melakukan penilaian. Admin memiliki aksespenuh ke semua fitur administratif dan manajemen pengguna, termasuk melihat daftar siswa, menambahkanatau menghapus siswa dari kelas, dan memberikan akses kepada guru.

Level Guru memiliki akses terbatas pada sistem dan hanya dapat melakukan penilaian. Guru dapat melihatdaftar siswa yang terdaftar di kelas yang dia akses, membuat penilaian, dan memberikan umpan balikpada penilaian yang telah dilakukan.

<h2 id="fitur">Fitur apa saja yang tersedia di TahfidzApp?</h2>

- Pembuatan kelas dan mengundang siswa untuk bergabung.
- Manajemen pengguna, termasuk menambahkan, mengedit, atau menghapus pengguna.
- Manajemen kelas, termasuk menambahkan atau menghapus siswa dari kelas.
- Pengelolaan materi dan latihan untuk setiap kelas.
- Pembuatan dan pengelolaan penilaian untuk setiap siswa di kelas.
- Pengiriman notifikasi kepada siswa dan guru ketika ada penilaian yang telah diberikan.
- Untuk masuk ke dalam sistem, Creator dapat menggunakan username "admin" dan password "password".Admin - - dan Guru akan menerima akun dari Creator dan dapat masuk ke dalam sistem dengan username danpassword yang  telah ditentukan oleh Creator.

## Requirements
- [PHP >= 8.1.6](http://php.net/)
- [Laravel Framework](https://github.com/laravel/framework)
## Laravel Version Compatibility

| Laravel | PHP     |

| 8.x.x   | 8.1.x   |


<h2 id="download">💻 Install</h2>

1. Clone repository

```bash
    git clone https://github.com/IdhamIKN/TahfidzApp.git
```

```bash
    cd TahfidzApp-Monitoring
```

```bash
    composer update
```

```bash
    copy .env.example .env
```
2. Konfigurasi database melalui `.env`

```bash
DB_PORT=3306
DB_DATABASE=xxxx
DB_USERNAME=root
DB_PASSWORD=
```
3. Migrasi dan symlinks

```bash
php artisan key:generate
php artisan migrate --seed
```
4. Jalankan website

```bash
php artisan serve
```


<h2 id="testing-account"> Default Account for Testing</h2>

#### Admin

    -   Username: admin
    -   Password: password
      
     
<h2 id="[dukungan](https://saweria.co/idhamIKN)">💌 [Support Me]</h2>

<p>
Kamu bisa mendukung aku di platform Trakteer! Dukungan kamu akan sangat berarti. Namun, dengan kamu memberikan <i>star</i> pada <i>project</i> ini juga sudah sangat cukup kok~!
</p>

<a href="https://saweria.co/idhamIKN" target="_blank"><img id="wse-buttons-preview" src="💌 [Support Me]" height="40" style="border:0px;height:40px;" alt="💌 [Support Me]" ></a>

<h2 id="kontribusi">🤝 Contributing</h2>

<p>
<i>Contributions, issues and feature requests</i> sangat diapresiasi karena aplikasi ini jauh dari kata sempurna. Jangan ragu untuk melakukan <i>pull request</i> dan membuat perubahan pada <i>project</i> ini, yaaa!
</p>

<h2 id="lisensi">📝 License</h2>

<p>LinkIta is open-sourced software licensed under the MIT license.</p>

<h2 id="pembuat">🧍 Author</h2>

<p>LinkIta s dibuat oleh <a href="https://instagram.com/idhamikn?igshid=MmJiY2I4NDBkZg==">IdhamIKn</a> .</p>
