<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\eflOrder;
use Spatie\ArrayToXml\ArrayToXml;
class JsonToXmlController extends Controller
{
    public function index()
    {
        $id =2;
        $data = eflOrder::find($id);
        $a = $data->json;
        $a = preg_replace('"\@(.*?)\w+\"\:\"(.*?\")"', '_attributes":{"${0}":${1}}', $a);
        $a = str_replace('"":}', '"}', $a);
        $a = str_replace('{"@', '{"', $a);
        $a = str_replace(',"$":', ',"_value":', $a);

        \File::put('master_dataa.xml', ArrayToXml::convert(json_decode($a, true)));
        
        return $data;
    }
}
