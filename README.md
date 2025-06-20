# UAS PBF Eka Adit Prasetyo (230102079) TI 2D

Nama : Eka Adit Prasetyo (7)

Kelas : TI 2D

NPM : 230102079

## Backend Rumah Sakit

Repositori ini merupakan backend dari sistem manajemen rumah sakit. Backend ini dibangun menggunakan **CodeIgniter 4**, sebuah PHP framework modern dengan arsitektur MVC yang ringan dan efisien.

## Struktur Utama

Beberapa folder penting dalam proyek ini:

- `app/` - Berisi controller, model, config, dan logic utama aplikasi.
- `public/` - Berisi file `index.php` sebagai entry point aplikasi (web root).
- `writable/` - Tempat file yang dapat ditulis (logs, cache, dll).
- `.env` - File konfigurasi lingkungan.
- `composer.json` - File konfigurasi Composer untuk dependency PHP.

1. Routes.php
   
   ``` sh
   $routes->resource('pasien');
   $routes->resource('obat');
   ```
2. .env

   ``` sh
   CI_ENVIRONMENT = development

    app.baseURL = 'http://localhost:8080/'
    If you have trouble with `.`, you could also use `_`.
    app_baseURL = ''
    app.forceGlobalSecureRequests = false
    app.CSPEnabled = false

    database.default.hostname = localhost
    database.default.database = db_rumahsakit_230102079
    database.default.username = root
    database.default.password = 
    database.default.DBDriver = MySQLi
    database.default.DBPrefix =
    database.default.port = 3306

    session.driver = 'CodeIgniter\Session\Handlers\FileHandler'
    session.savePath = null
   ```
3. App.php

   ``` sh
    public string $indexPage = '';
   ```

