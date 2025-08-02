<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use App\Models\Entity;
use App\Models\Property;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    // Entityの更新
    public function update_entity($entity_id)
    {

      $properties = Property::where('entity_id', $entity_id)->get();
      if(empty($properties)) {
        return;
      }

      $image_list = array();
      $type_list = array();
      $lat = $lon = '0';
      $adr = '';
      $plc = '';

      foreach($properties as $property) {
        $prop = trim($property->property);
        $value = trim($property->value);
        if($prop == 'latitude') {
          $lat = rtrim($value, '0');
        } else if($prop == 'longitude') {
          $lon = rtrim($value, '0');
        } else if($prop == 'address') {
          $adr = $value;
        } else if($prop == 'place') {
          $plc = $value;
        } else if($prop == 'type') {
          array_push($type_list, $value);
        } else if ($prop == 'image' ) {
          array_push($image_list, $value);
        }
      }

      $entity = Entity::where('id', $entity_id)
                ->update(['latitude' => $lat,
                   'longitude' => $lon,
                   'address' => $adr,
                   'place' => $plc,
                   'types' => implode(', ', $type_list),
                   'images' => implode(', ', $image_list),
                  ]);
      }

}
