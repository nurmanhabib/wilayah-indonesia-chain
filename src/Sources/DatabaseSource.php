<?php

namespace Nurmanhabib\WilayahIndonesia\Sources;

use Illuminate\Database\Capsule\Manager as Capsule;

class DatabaseSource extends Source
{
    protected $db;

    public function __construct()
    {
        $this->db = Capsule::connection();
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

    public function getParentByDesa($desa)
    {
        $inf_lokasi = $this->db->table('inf_lokasi')
                    ->where('lokasi_kode', $desa)
                    ->first();

        if ($inf_lokasi) {
            $provinsi   = sprintf('%02d', $inf_lokasi->lokasi_propinsi);
            $kota       = sprintf('%02d', $inf_lokasi->lokasi_kabupatenkota);
            $kecamatan  = sprintf('%02d', $inf_lokasi->lokasi_kecamatan);
            $desa       = sprintf('%04d', $inf_lokasi->lokasi_kelurahan);

            $result['provinsi']     = $provinsi . '.00.00.0000';
            $result['kota']         = $provinsi . '.' . $kota . '.00.0000';
            $result['kecamatan']    = $provinsi . '.' . $kota . '.' . $kecamatan . '.0000';
            $result['desa']         = $provinsi . '.' . $kota . '.' . $kecamatan . '.' . $desa;
        } else {
            $result['provinsi']     = '';
            $result['kota']         = '';
            $result['kecamatan']    = '';
            $result['desa']         = '';
        }
        
        return $result;
    }
}