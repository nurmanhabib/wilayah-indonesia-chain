<?php

namespace Nurmanhabib\WilayahIndonesia\Sources;

abstract class Source
{
    abstract public function getAllProvinsi();

    abstract public function getKotaByParent($provinsi);

    abstract public function getKecamatanByParent($provinsi, $kota);

    abstract public function getDesaByParent($provinsi, $kota, $kecamatan);
}