# Contoh Aplikasi Menggunakan API SMSGateway.me

Aplikasi berikut dibuat berdasarkan artikel yang ada pada blog [Laravel.web.id](http://laravel.web.id/tutorial/membangun-sms-gateway-dengan-android-smsgateway-me-dan-laravel/).

[![SMSGateway.me.png](https://s12.postimg.org/y8hai0ubh/SMSGateway_me.png)](https://postimg.org/image/e13uppwu1/)

## Fitur

- Kirim SMS
- Manajemen SMS

## Instalasi
- Clone repositori ini ke mesin lokal.
- Masuk ke direkori root dan update framework berserta package lainnya menggunakan perintah compo- update.
- Salin berkas .env.example menjadi .env.
- Generate key baru dengan perintah php artisan key:generate.
- Ubah pengaturan basisdata dan email pada berkas .env.
- Jalankan migrasi dan seeder dengan perintah `php artisan migrate --seed.
- Jalankan built-in server dengan perintah `php artisan serve dan akses melalui peramban (browser).
