<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use SimpleXMLElement;

class GeoCodeController extends Controller
{

    /**
     * 緯度経度から所在地名を取得
     */
    public function reverse(Request $request) {

      $result = array();
      if(isset($_GET['lat']) && isset($_GET['lon'])) {
        $lat = $_GET['lat'];
        $lon = $_GET['lon'];
        if($lat != '' && $lon != '') {
          if( preg_match( "/[2-4][0-9]\.[0-9]+/u", $lat, $matches ) &&
              preg_match( "/1[2-5][0-9]\.[0-9]+/u", $lon, $matches )) {
            $yahoo = 'https://map.yahooapis.jp/geoapi/V1/reverseGeoCoder';
            $appid = '非公開';
            $xml = file_get_contents( $yahoo.'?lat='.$lat.'&lon='.$lon.'&appid='.$appid );
            $rsp = new SimpleXMLElement($xml);
            if(isset($rsp->Feature->Property->Address)) {
              $result['address'] = $rsp->Feature->Property->Address->__toString();
            }
            if(isset($rsp->Feature->Property->AddressElement[1]->Code)) {
              $result['city_code'] = $rsp->Feature->Property->AddressElement[1]->Code->__toString();
            }
          } else {
          }
        }
      } else {
      }
      return response()->json($result)
                       ->withHeaders([
                           'Cache-Control' => 'no-store',
                         ]);
    }
}
