<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Entity;
use App\Models\Property;
use Auth;
use App\Models\Suggestion;
use App\Models\Tag;

class MapController extends Controller
{
    /**
     * マップ
     */
    public function show(Request $request): View
    {
      $entity_id = $request->input('e');
      return $this->map_common($request, 'default', $entity_id, null);
    }

    /**
     * 全国版マップ
     */
    public function show_all(Request $request): View
    {
      $valid_tags = [];

      $param = $request->input('tag');
      if($param) {
        $tags = explode(',', $param);
        foreach($tags as $tag) {
          if( Tag::where('name', trim($tag))->exists() ){
            array_push($valid_tags, trim($tag));
          }
        }
      }
      return $this->map_common($request, 'all', null, $valid_tags);
    }

    /**
     * モバイル用マップ
     */
    public function show_mobile(Request $request): View
    {
      return $this->map_common($request, 'mobile', null, null);
    }

    /**
     * マップ用共通処理
     */
    function map_common($request, $maptype, $entity_id, $tags): View
    {

        $suggestions = 0;
        if(Auth::check()) {
          $auth = Auth::user();
          $suggestions = Suggestion::where([['contributor_id',  $auth->id], ['closed', 0]])->count();

          $tag_suggestions = Suggestion::leftJoin('tags', 'suggestions.suggestion', '=', 'tags.name')
                                       ->leftJoin('tag_users', 'tags.id', '=', 'tag_users.tag_id')
                                       ->where([['closed', 0],
                                                ['contributor_id', 0],
                                                ['tag_users.user_id', $auth->id],
                                                ['tag_users.deleted_at', null]])
                                       ->count();
          $suggestions = $suggestions + $tag_suggestions;
        }

        if($tags) {
          return view('map', [
            'og_title' => 'みんなで石仏調査 - タグ：'.implode(',', $tags),
            'tags' => $tags,
            'num_data' => Entity::where('hidden', 0)->count(),
            'maptype' => $maptype,
            'suggestions' => $suggestions,
          ]);
        } else if ($entity_id) {
          $props = Property::where('entity_id', $entity_id)->get();
          $image = '';
          $address = '';
          $place = '';
          $types = [];
          if( $props ) {
            foreach( $props as $prop) {
              if($prop->property == 'image') {
                if($image=='') {
                  $image = $prop->value;
                }
              } else if ($prop->property == 'address') {
                $address = $prop->value;
              } else if ($prop->property == 'place') {
                $place = ' '.$prop->value;
              } else if ($prop->property == 'type') {
                array_push($types, $prop->value);
              }
            }
            if( $image != '' && $address != '') {
              return view('map', [
                'og_image' => $image,
                'og_title' => 'みんなで石仏調査 - '.$address.$place.'の'.implode(',', $types),
                'num_data' => Entity::where('hidden', 0)->count(),
                'maptype' => $maptype,
                'suggestions' => $suggestions,
              ]);
            }
          }
        } else if ($maptype == 'mobile') {
          return view('mobile', [
            'num_data' => Entity::where('hidden', 0)->count(),
            'maptype' => $maptype,
            'suggestions' => $suggestions,
          ]);
        }

        return view('map', [
          'num_data' => Entity::where('hidden', 0)->count(),
          'maptype' => $maptype,
          'suggestions' => $suggestions,
        ]);
    }

    /**
     * マイマップ
     */
    public function my_show(Request $request): View
    {
      if(Auth::check()) {
        $auth = Auth::user();
        $suggestions = Suggestion::where([['contributor_id',  $auth->id], ['closed', 0]])->count();
      } else {
        return $this->show($request);
      }

      return view('map', [
        'num_data' => Entity::where('hidden', 0)->count(),
        'maptype' => 'mymap',
        'suggestions' => $suggestions,
      ]);
    }

}

