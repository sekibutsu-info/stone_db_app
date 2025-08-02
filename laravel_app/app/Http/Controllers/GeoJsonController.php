<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Auth;
use App\Models\Entity;
use App\Models\Property;

class GeoJsonController extends Controller
{
    /**
     * GeoJson for mymap.
     */
    public function get(Request $request)
    {
      $auth = Auth::user();

      $id = $auth->id;
      $contributor = $auth->nickname;
      $entities = Entity::leftJoin('users', 'entities.user_id', '=', 'users.id')
                          ->select('entities.id as entity_id', 'nickname', 'latitude', 'longitude', 'address', 'place', 'types', 'images')
                          ->where('user_id', $id)->get();

      return $this->make_geojson($entities);

    }

    /**
     * GeoJson for mobile map.
     */
    public function get_mobile(Request $request)
    {
      return $this->get_common($request, true);
    }

    /**
     * GeoJson for local map.
     */
    public function get_local(Request $request)
    {
      return $this->get_common($request, false);
    }

    /**
     * GeoJson common.
     */
    public function get_common(Request $request, $mobile)
    {

      if($mobile) {
        $min_lat = $request->lat - 0.05;
        $max_lat = $request->lat + 0.05;
        $min_lon = $request->lon - 0.05;
        $max_lon = $request->lon + 0.05;
      } else {
        // ±20%ずつバッファ
        $buf_lat = ($request->maxlat - $request->minlat) * 0.2;
        $buf_lon = ($request->maxlon - $request->minlon) * 0.2;
        $min_lat = $request->minlat - $buf_lat;
        $max_lat = $request->maxlat + $buf_lat;
        $min_lon = $request->minlon - $buf_lon;
        $max_lon = $request->maxlon + $buf_lon;
      }

      $entities = Entity::leftJoin('users', 'entities.user_id', '=', 'users.id')
                          ->select('entities.id as entity_id', 'nickname', 'latitude', 'longitude', 'address', 'place', 'types', 'images')
                          ->where([['latitude', '>', $min_lat],
                                   ['latitude', '<', $max_lat],
                                   ['longitude', '>', $min_lon],
                                   ['longitude', '<', $max_lon],
                                   ['hidden', '=', 0]])
                          ->orderBy('entity_id', 'asc')->get();

      return $this->make_geojson($entities);

    }

    /**
     * GeoJson for tagged map.
     */
    public function get_tag(Request $request)
    {

      $tags = $request->input('tag');

      $entities = Entity::leftJoin('users', 'entities.user_id', '=', 'users.id')
                        ->select('entities.id as entity_id', 'nickname', 'latitude', 'longitude', 'address', 'place', 'types', 'images')
                        ->whereIn('entities.id', Property::select('entity_id')
                                                           ->where('property', 'tag')
                                                           ->whereIn('value', explode(',', $tags)))
                        ->orderBy('entity_id', 'asc')->get();

      return $this->make_geojson($entities);

    }

    /**
     * EntityからGeoJSONを作成する
     */
    public function make_geojson($entities)
    {

      $geojson = array(
       'type'      => 'FeatureCollection',
       'crs'       => array('type' => 'name',
                                      'properties' => array('name' => 'urn:ogc:def:crs:OGC:1.3:CRS84') ),
       'features'  => array()
      );

      $current = 0;
      foreach( $entities as $entity ) {
        $props = array();
        $id = $entity->entity_id;
        $props["id"] = $id;
        $props["contributor"] = $entity->nickname;
        $props["address"] = [$entity->address];
        if($entity->place) {
          $props["place"] = [$entity->place];
        }
        if($entity->types) {
          $props["type"] = array_map('trim', explode(',', $entity->types));
        }
        if($entity->images) {
          $props["image"] = array_map('trim', explode(',', $entity->images));
        }
        $feature = array(
          'type' => 'Feature', 
          'geometry' => array(
            'type' => 'Point',
            'coordinates' => array($entity->longitude, $entity->latitude)
          ),
          'properties' => $props
        );
        array_push($geojson['features'], $feature);
      }

      return response()->json($geojson)
                       ->withHeaders([
                           'Cache-Control' => 'no-store',
                         ]);;

    }
}
