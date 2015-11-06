<?php

namespace Nurmanhabib\WilayahIndonesia\Sources;

use Illuminate\Database\Capsule\Manager as Capsule;

abstract class Source
{
    protected $db = null;

    public function __construct()
    {
        $this->db = $this->getConnection();
    }

    public function setConnection($connection)
    {
        $this->db = $connection;
    }

    public function getConnection()
    {
        if ($this->db)
            return $this->db;
        
        $capsule    = new Capsule;
        $config     = require_once(__DIR__ . '/../../config/database.php');

        $capsule->addConnection($config);

        $capsule->setAsGlobal();

        return $capsule;
    }

    abstract public function getAllProvinsi();

    abstract public function getKotaByParent($provinsi);

    abstract public function getKecamatanByParent($provinsi, $kota);

    abstract public function getDesaByParent($provinsi, $kota, $kecamatan);
}