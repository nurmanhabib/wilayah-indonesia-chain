<?php

namespace Nurmanhabib\WilayahIndonesia\Sources;

use Illuminate\Database\Capsule\Manager as Capsule;

class DatabaseSource extends Source
{
    protected $db;

    public function __construct($host = null, $username = null, $password = null, $database = null)
    {
        $config     = require_once(__DIR__ . '/../../config/database.php');
        $config     = array_merge(
            array_filter($config),
            array_filter(
                compact('host', 'username', 'password', 'database')
            )
        );
        
        $this->setConnection($config);
    }

    public function setConnection($config)
    {
        $capsule = new Capsule;
        $capsule->addConnection($config);
        $capsule->setAsGlobal();

        $this->db = $capsule->getConnection();

        return $this;
    }

    public function getConnection()
    {
        return $this->db;
    }

    public function getAllProvinsi()
    {
        $data = $this->db->table('inf_lokasi')
                    ->where('lokasi_kabupatenkota', '00')
                    ->where('lokasi_kecamatan', '00')
                    ->where('lokasi_kelurahan', '0000')
                    ->get();

        $result = array();

        foreach ($data as $row) {
            $result[$row->lokasi_kode] = $row->lokasi_nama;
        }

        return $result;
    }

    public function getKotaByParent($provinsi)
    {
        $provinsi   = substr($provinsi, 0, 2);

        $data = $this->db->table('inf_lokasi')
                    ->where('lokasi_propinsi', $provinsi)
                    ->where('lokasi_kabupatenkota', '!=', '00')
                    ->where('lokasi_kecamatan', '00')
                    ->where('lokasi_kelurahan', '0000')
                    ->get();

        $result = array();

        foreach ($data as $row) {
            $result[$row->lokasi_kode] = $row->lokasi_nama;
        }

        return $result;
    }

    public function getKecamatanByParent($provinsi, $kota)
    {
        $provinsi   = substr($provinsi, 0, 2);
        $kota       = substr($kota, 3, 2);
        
        $data = $this->db->table('inf_lokasi')
                    ->where('lokasi_propinsi', $provinsi)
                    ->where('lokasi_kabupatenkota', $kota)
                    ->where('lokasi_kecamatan', '!=', '00')
                    ->where('lokasi_kelurahan', '0000')
                    ->get();

        $result = array();

        foreach ($data as $row) {
            $result[$row->lokasi_kode] = $row->lokasi_nama;
        }

        return $result;
    }

    public function getDesaByParent($provinsi, $kota, $kecamatan)
    {
        $provinsi   = substr($provinsi, 0, 2);
        $kota       = substr($kota, 3, 2);
        $kecamatan  = substr($kecamatan, 6, 2);
        
        $data = $this->db->table('inf_lokasi')
                    ->where('lokasi_propinsi', $provinsi)
                    ->where('lokasi_kabupatenkota', $kota)
                    ->where('lokasi_kecamatan', $kecamatan)
                    ->where('lokasi_kelurahan', '!=', '00')
                    ->get();

        $result = array();

        foreach ($data as $row) {
            $result[$row->lokasi_kode] = $row->lokasi_nama;
        }

        return $result;
    }
}