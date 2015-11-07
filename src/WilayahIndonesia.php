<?php

namespace Nurmanhabib\WilayahIndonesia;

use Symfony\Component\HttpFoundation\Request;

class WilayahIndonesia
{
    protected $source;
    protected $selected;
    protected $text_no_selected;
    protected $url_ajax;

    public function __construct(Sources\Source $source = null, $url_ajax = 'ajax.php')
    {
        $this->source           = $source ?: new Sources\DatabaseSource;
        $this->selected         = null;
        $this->url_ajax         = $url_ajax;
        $this->text_no_selected = array(
            'provinsi'      => 'Silahkan pilih provinsi...',
            'kota'          => '--',
            'kecamatan'     => '--',
            'desa'          => '--',
        );
    }

    public function setSource(Sources\Source $source)
    {
        $this->source = $source;

        return $this;
    }

    public function getSource()
    {
        return $this->source;
    }

    public function generateSelect($name, $options = array(), $selected = null)
    {
        $html = '<select name="' . $name . '" id="' . $name . '" class="form-control">';

        $selected           = $selected ?: $this->selected;
        $text_no_selected   = safe_array_access($this->text_no_selected, $name);

        if ($text_no_selected) {
            $options = array_merge(array($text_no_selected), $options);
        }

        foreach ($options as $value => $text) {
            if ($value == $selected)
                $html .= '<option value="' . $value . '" selected>' . $text . '</option>';
            else
                $html .= '<option value="' . $value . '">' . $text . '</option>';
        }

        $html .= '</select>';

        return $html;
    }

    public function generateSelectProvinsi()
    {
        $options = $this->source->getAllProvinsi();

        return $this->generateSelect('provinsi', $options);
    }

    public function generateSelectKota($provinsi = null, $selected = null)
    {
        $this->withSelected($selected);

        $options = $provinsi ? $this->source->getKotaByParent($provinsi) : array();

        return $this->generateSelect('kota', $options);
    }

    public function generateSelectKecamatan($provinsi = null, $kota = null, $selected = null)
    {
        $this->withSelected($selected);

        $options = $provinsi && $kota ? $this->source->getKecamatanByParent($provinsi, $kota) : array();

        return $this->generateSelect('kecamatan', $options);
    }

    public function generateSelectDesa($provinsi = null, $kota = null, $kecamatan = null, $selected = null)
    {
        $this->withSelected($selected);

        $options = $provinsi && $kota && $kecamatan ? $this->source->getDesaByParent($provinsi, $kota, $kecamatan, $desa) : array();

        return $this->generateSelect('desa', $options);
    }

    public function generateJson($name, $options = array(), $selected = null)
    {
        $this->withSelected($selected);

        $text_no_selected = safe_array_access($this->text_no_selected, $name);

        if (empty($options))
            $options = array('00' => $text_no_selected);

        if ($this->selected) {
            $options['selected'] = $this->selected;
        }

        return json_encode($options);
    }

    public function generateJsonProvinsi()
    {
        $options = $this->source->getAllProvinsi();

        return $this->generateJson('provinsi', $options);
    }

    public function generateJsonKota($provinsi)
    {
        $options = $this->source->getKotaByParent($provinsi);

        return $this->generateJson('kota', $options);
    }

    public function generateJsonKecamatan($provinsi, $kota)
    {
        $options = $this->source->getKecamatanByParent($provinsi, $kota);

        return $this->generateJson('kecamatan', $options);
    }

    public function generateJsonDesa($provinsi, $kota, $kecamatan)
    {
        $options = $this->source->getDesaByParent($provinsi, $kota, $kecamatan);

        return $this->generateJson('desa', $options);
    }

    public function withSelected($selected)
    {
        $this->selected = $selected;
    }

    public function ajax()
    {
        $request    = Request::createFromGlobals();
        $query      = $request->query;

        if ($query->has('selected')) {
            $this->withSelected($query->get('selected'));
        }

        if ($query->has('provinsi')) {
            if ($query->has('kota')) {
                if ($query->has('kecamatan')) {
                    $dropdown = $this->generateJsonDesa(
                                    $query->get('provinsi'),
                                    $query->get('kota'),
                                    $query->get('kecamatan')
                                );
                } else {
                    $dropdown = $this->generateJsonKecamatan(
                                    $query->get('provinsi'),
                                    $query->get('kota')
                                );
                }
            } else {
                $dropdown = $this->generateJsonKota($query->get('provinsi'));
            }
        } else {
            $dropdown = $this->generateJsonProvinsi();
        }

        return $dropdown;
    }

    public function script($url_ajax = null, $loading = 'Loading...')
    {
        $url_ajax = $url_ajax ?: $this->url_ajax;

        $script  = "<script>var url = '$url_ajax';";
        $script .= "var loading = '$loading';" . PHP_EOL;
        $script .= file_get_contents(__DIR__ . '/wilayah-indonesia-chained.js');
        $script .= "</script>";

        return $script;
    }
}