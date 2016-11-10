# Validasi dan Ubah Katasandi User

Aplikasi ini memberikan contoh sederhana validasi katasandi lama user untuk kemudian disimpan ke dalam basisdata apabila data valid.

# Instalasi

- Clone repositori ```https://github.com/arvernester/tutorial```.
- Masuk ke dalam direktori ```change-password``` dan jalankan perintah ```composer update```.
- Salin berkas ```.env.example``` menjadi ```.env``` dan jalankan perintah ```php artisan key:generat```.
- Ubah pengaturan basisdata pada berkas ```.env``` dan jalankan migrasi dengan perintah ```php artisan migrate```.
- Jalankan built-in web server, ```php artisan server``` dan jalankan melalui browser dengan mengakses URL ```http://localhost:8000```.

Artikel lengkap serta pembahasan dapat dilihat pada tulisan [Bagaimana memvalidasi katasandi (password) lama user?](http://laravel.web.id/tutorial/bagaimana-memvalidasi-katasandi-password-lama-user/)