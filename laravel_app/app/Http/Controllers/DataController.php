<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Entity;
use App\Models\Property;

class DataController extends Controller
{
    /**
     * /data?id=番号 から /archive/番号 にリダイレクト
     */
    public function redirect(Request $request): RedirectResponse
    {
        $id = $request->input('id');
        $url = '/archive/'.$id;
        return redirect()->to($url);

        /*
        $props = Property::where('entity_id', $id)->get();
        $lat = '';
        $lon = '';
        if( $props ) {
          foreach( $props as $prop) {
            if ($prop->property == 'latitude') {
              $lat = $prop->value;
            } else if ($prop->property == 'longitude') {
              $lon = $prop->value;
            }
          }
          if( $lat != '' && $lon != '' ) {
            $url = '/map?x='.$lon.'&y='.$lat.'&z=16&e='.$id;
            return redirect()->to($url);
          } else {
            return redirect()->to('/');
          }
        } else {
          return redirect()->to('/');
        }
        */
    }

}

