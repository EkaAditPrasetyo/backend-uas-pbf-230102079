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

4. Penerapan Database SQL, Query ini di taruh di MySql agar saat .env dapat menggunakan nama database yang telah dibuat
   
``` sh
CREATE DATABASE db_rumahsakit_230102079;
USE db_rumahsakit_230102079;

CREATE TABLE pasien (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(100),
  alamat TEXT,
  tanggal_lahir DATE,
  jenis_kelamin ENUM('L', 'P')
);

CREATE TABLE obat (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama_obat VARCHAR(100),
  kategori VARCHAR(50),
  stok INT,
  harga DECIMAL(10,2)
);
```
4. Controller
   - Obat.php

     ``` sh
     <?php namespace App\Controllers; //Eka Adit Prasetyo
      use CodeIgniter\RESTful\ResourceController;
      
      class Obat extends ResourceController {
          protected $modelName = 'App\\Models\\ObatModel';
          protected $format    = 'json';

       public function index() //buat method ini untuk menampilkan kaynya
       {
           $data = $this->model->findAll();

        return $this->respond([
            'status' => 200,
            'message' => 'Data obat berhasil diambil',
            'data' => $data
        ]);
       }
   
       public function show($id = null) //menampilkan
       {
           $data = $this->model->find($id);

        if (!$data) {
            return $this->failNotFound("Data obat dengan ID $id tidak ditemukan.");
        }

        return $this->respond([
            'status' => 200,
            'message' => 'Data obat ditemukan',
            'data' => $data
        ]);
       }
   
       public function update($id = null)//ubah
       {
           $data = $this->request->getJSON(true); // Ambil data JSON dalam bentuk array

        if (!$this->model->find($id)) {
            return $this->failNotFound("Data obat dengan ID $id tidak ditemukan.");
        }

        if ($this->model->update($id, $data)) {
            return $this->respond([
                'status'  => 200,
                'message' => "Data obat ID $id berhasil diubah.",
                'data'    => $data
            ]);
        }

        return $this->failValidationErrors($this->model->errors());
       }
   
       public function delete($id = null)//hapus
       {
           // Cek apakah data dengan ID ini ada
           $obat = $this->model->find($id);
           if (!$obat) {
               return $this->failNotFound("Data obat dengan ID $id tidak ditemukan.");
           }

        // Hapus data
        if ($this->model->delete($id)) {
            return $this->respondDeleted([
                'status'  => 200,
                'message' => "Data obat ID $id berhasil dihapus."
            ]);
        }

        return $this->failServerError("Gagal menghapus data.");
       }
   
   
       public function create()//buat
       {
           $data = $this->request->getJSON(true); // Ambil data sebagai array

        if (empty($data)) {
            return $this->fail('Data kosong atau format tidak sesuai.');
        }

        // Jika array pertama berisi array, berarti ini multiple insert
        if (isset($data[0]) && is_array($data[0])) {
            if ($this->model->insertBatch($data)) {
                return $this->respondCreated([
                    'status'  => 201,
                    'message' => 'Beberapa data obat berhasil ditambahkan',
                    'data'    => $data
                ]);
            }
        } else {
            if ($this->model->insert($data)) {
                return $this->respondCreated([
                    'status'  => 201,
                    'message' => 'Satu data obat berhasil ditambahkan',
                    'data'    => $data
                ]);
            }
        }

        return $this->failValidationErrors($this->model->errors());
          }
      }
      ```
   - Pasien.php

     ``` sh
     <?php namespace App\Controllers; //Eka Adit Prasetyo
      use CodeIgniter\RESTful\ResourceController;
      
      class Pasien extends ResourceController {
          protected $modelName = 'App\\Models\\PasienModel';
          protected $format    = 'json';

       public function index() //buat method ini untuk menampilkan kaynya
       {
           $data = $this->model->findAll();

        return $this->respond([
            'status' => 200,
            'message' => 'Data pasien berhasil diambil',
            'data' => $data
        ]);
       }
   
       public function show($id = null) //menampilkan
       {
           $data = $this->model->find($id);

        if (!$data) {
            return $this->failNotFound("Data pasien dengan ID $id tidak ditemukan.");
        }

        return $this->respond([
            'status' => 200,
            'message' => 'Data pasien ditemukan',
            'data' => $data
        ]);
       }
   
       public function update($id = null)//ubah
       {
           $data = $this->request->getJSON(true); // Ambil data JSON dalam bentuk array

        if (!$this->model->find($id)) {
            return $this->failNotFound("Data pasien dengan ID $id tidak ditemukan.");
        }

        if ($this->model->update($id, $data)) {
            return $this->respond([
                'status'  => 200,
                'message' => "Data pasien ID $id berhasil diubah.",
                'data'    => $data
            ]);
        }

        return $this->failValidationErrors($this->model->errors());
       }
   
       public function delete($id = null)//hapus
       {
           // Cek apakah data dengan ID ini ada
           $obat = $this->model->find($id);
           if (!$obat) {
               return $this->failNotFound("Data pasien dengan ID $id tidak ditemukan.");
           }

        // Hapus data
        if ($this->model->delete($id)) {
            return $this->respondDeleted([
                'status'  => 200,
                'message' => "Data obat ID $id berhasil dihapus."
            ]);
        }

        return $this->failServerError("Gagal menghapus data.");
       }
   
       public function create() // ini kalau misal create post datanya lebih dari 1
       {
           $data = $this->request->getJSON(true); // Ambil data sebagai array

        if (empty($data)) {
            return $this->fail('Data kosong atau format tidak sesuai.');
        }

        // Jika array pertama berisi array, berarti ini multiple insert
        if (isset($data[0]) && is_array($data[0])) {
            if ($this->model->insertBatch($data)) {
                return $this->respondCreated([
                    'status'  => 201,
                    'message' => 'Beberapa data pasien berhasil ditambahkan',
                    'data'    => $data
                ]);
            }
        } else {
            if ($this->model->insert($data)) {
                return $this->respondCreated([
                    'status'  => 201,
                    'message' => 'Satu data pasien berhasil ditambahkan',
                    'data'    => $data
                ]);
            }
        }

        return $this->failValidationErrors($this->model->errors());
          }
      
      }
     
     ```
5. Models
   - ObatModel

     ``` sh
     <?php namespace App\Models;
      use CodeIgniter\Model;
      
      class ObatModel extends Model {
          protected $table = 'obat';
          protected $primaryKey = 'id';
          protected $allowedFields = ['nama_obat', 'kategori', 'stok', 'harga'];
          protected $useTimestamps = false;
      }
     ```
   - PasienModel
     
     ``` sh
     <?php namespace App\Models;
      use CodeIgniter\Model;
      
      class PasienModel extends Model {
          protected $table = 'pasien';
          protected $primaryKey = 'id';
          protected $allowedFields = ['nama', 'alamat', 'tanggal_lahir', 'jenis_kelamin'];
          protected $useTimestamps = false;
      }
     ```
# Menjalankan Server

- Pada terminal VSCode ketik berikut :
  
``` sh
php spark serve
```
Kemudian memunculkan link yang diakses pada browser: http://localhost:8080

Akses melalui browser atau Postman:

http://localhost:8080/pasien

![Screenshot 2025-06-20 140505](https://github.com/user-attachments/assets/3f9ce165-bd1f-4b2a-918a-13610e15a849)


http://localhost:8080/obat

![Screenshot 2025-06-20 140448](https://github.com/user-attachments/assets/31c02446-2c08-4a5f-a03e-039bc6182a43)



# Pengujian dengan Postman

- Membuat Collection Postman:

Nama: uas_pasien dan uas_obat

Tambahkan endpoint:
### 📚 Daftar Endpoint Obat

| Method | Endpoint       | Deskripsi               |
|--------|----------------|--------------------------|
| GET    | `/obat`        | Ambil semua data obat    |
| GET    | `/obat/{id}`   | Ambil detail obat tertentu |
| POST   | `/obat`        | Tambah data obat         |
| PUT    | `/obat/{id}`   | Ubah data obat tertentu  |
| DELETE | `/obat/{id}`   | Hapus data obat tertentu |

Gunakan body JSON saat POST dan PUT. Contoh:

``` sh
{
  "nama_obat": "Bodrek",
  "kategori": "pil",
  "stok": 30,
  "harga": "120000"
}
```

### 📚 Daftar Endpoint Pasien

| Method | Endpoint         | Deskripsi                   |
|--------|------------------|------------------------------|
| GET    | `/pasien`        | Ambil semua data pasien      |
| GET    | `/pasien/{id}`   | Ambil detail pasien tertentu |
| POST   | `/pasien`        | Tambah pasien baru           |
| PUT    | `/pasien/{id}`   | Ubah data pasien             |
| DELETE | `/pasien/{id}`   | Hapus data pasien            |

Gunakan body JSON saat POST dan PUT. Contoh:

``` sh
{
  "nama": "Siti Aisyah",
  "alamat": "Jl. Mawar No. 10",
  "tanggal_lahir": "1995-05-12",
  "jenis_kelamin": "P"
}
```
## 👨‍💻 Dibuat oleh
Eka Adit Prasetyo, Praktikum Pemrograman Berbasis Framework – Genap 2024/2025 Politeknik Negeri Cilacap
