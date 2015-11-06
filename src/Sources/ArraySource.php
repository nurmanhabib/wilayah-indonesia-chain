<?php

namespace Nurmanhabib\WilayahIndonesia\Sources;

class ArraySource extends Source
{
    protected $wilayah;

    public function __construct()
    {
        $this->wilayah = [
            'Daerah Istimewa Yogyakarta'    => [
                'Kota Yogyakarta'       => [
                    'Pakualaman'    => [
                        'Purwokinanti',
                        'Gunungketur',
                    ],
                    'Umbulharjo'    => [
                        'Semaki',
                        'Muja-muju',
                        'Tahunan',
                        'Warungboto',
                        'Pandeyan',
                        'Sorosutan',
                        'Giwangan',
                    ]
                ],
                'Kabupaten Bantul'      => [
                    'Bantul'    => []
                ],
                'Kabupaten Sleman'      => [],
                'Kabupaten Gunungkidul' => [],
                'Kabupaten Kulonprogo'  => [],
            ],
            'Jawa Tengah'    => [
                'Kota Semarang'       => [
                    'Gunungpati' => []
                ]
            ]
        ];
    }

    public function getAllProvinsi()
    {
        $result = [];

        foreach ($this->wilayah as $provinsi => $kota) {
            $result[$provinsi] = $provinsi;
        }

        return $result;
    }

    public function getKotaByParent($provinsi_id)
    {
        $result     = [];
        $wilayah    = safe_array_access($this->wilayah, $provinsi_id);

        if ($wilayah) {
            foreach ($wilayah as $kota => $kecamatan) {
                $result[$kota] = $kota;
            }
        }

        return $result;
    }

    public function getKecamatanByParent($provinsi_id, $kota_id)
    {
        $result     = [];
        $wilayah    = safe_array_access($this->wilayah, $provinsi_id, $kota_id);

        if ($wilayah) {
            foreach ($wilayah as $kecamatan => $desa) {
                $result[$kecamatan] = $kecamatan;
            }
        }

        return $result;
    }

    public function getDesaByParent($provinsi_id, $kota_id, $kecamatan_id)
    {
        $result     = [];
        $wilayah    = safe_array_access($this->wilayah, $provinsi_id, $kota_id, $kecamatan_id);

        if ($wilayah) {
            foreach ($wilayah as $desa) {
                $result[$desa] = $desa;
            }
        }

        return $result;
    }
}