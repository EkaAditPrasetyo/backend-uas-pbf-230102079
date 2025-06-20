<?php namespace App\Models;
use CodeIgniter\Model;

class ObatModel extends Model {
    protected $table = 'obat';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama_obat', 'kategori', 'stok', 'harga'];
    protected $useTimestamps = false;
}