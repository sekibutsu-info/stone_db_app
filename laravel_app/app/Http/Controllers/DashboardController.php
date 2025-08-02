<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Auth;

use App\Models\Issue;
use App\Models\Notice;
use App\Models\Entity;
use App\Models\Property;
use App\Models\TsukimachiBingo;
use App\Models\Suggestion;
use App\Models\Invitation;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display Dashboard.
     */
    public function show(Request $request): View
    {
      $auth = Auth::user();

      // システム管理者への問合せ
      if( $auth->admin ) {
        $issues = Issue::all();
      } else {
        $issues = Issue::where('user_id', $auth->id)->get();
      }

      // 新規投稿リスト
      $entity_list = array();
      $new_entity = 30;
      $entities = Entity::where('user_id', $auth->id)->orderBy('id', 'desc')->take($new_entity)->get();
      if(count($entities)>0) {
        $min_id = $entities[count($entities)-1]->id;
        $properties = Property::where('entity_id', '>=', $min_id)->where('user_id', $auth->id)->get();

        foreach($entities as $entity) {
          $types = [];
          $figures = [];
          $principals = [];
          $address = "";
          $place = "";
          $latitude = "";
          $longitude = "";
          foreach($properties as $property) {
            if($property->entity_id == $entity->id) {
              if($property->property == 'address') {
                $address = $property->value;
              } else if($property->property == 'place') {
                $place = ' '.$property->value;
              } else if($property->property == 'type') {
                array_push($types, $property->value);
              } else if($property->property == 'latitude') {
                $latitude = $property->value;
              } else if($property->property == 'longitude') {
                $longitude = $property->value;
              } else if($property->property == 'figure') {
                array_push($figures, $property->value);
              } else if($property->property == 'principal') {
                array_push($principals, $property->value);
              }
            }
          }
          array_push($entity_list, [
            'entity_id' => $entity->id,
            'created_at' => $entity->created_at,
            'types' => implode(', ', $types),
            'figures' => implode(', ', $figures),
            'principals' => implode(', ', $principals),
            'address' => $address,
            'place' => $place,
            'latitude' => $latitude,
            'longitude' => $longitude,
          ]);
        }
      }

      // 県別投稿数
      $pref_stats = Property::leftjoin('pref_code', 'pname', '=', DB::raw('LEFT(value, 3)'))
                              ->groupBy('pcode')
                              ->select('pcode', DB::raw('COUNT(properties.id) AS p_count'))
                              ->where('property', '=', 'address')
                              ->where('user_id', '=', $auth->id)
                              ->orderBy('p_count', 'DESC')->get();

      // 改善提案
      $suggestions = Suggestion::where([['contributor_id',  $auth->id], ['closed', 0]])->count();
      // タグ付けの提案
      $tag_suggestions = Suggestion::leftJoin('tags', 'suggestions.suggestion', '=', 'tags.name')
                                   ->leftJoin('tag_users', 'tags.id', '=', 'tag_users.tag_id')
                                   ->where([['closed', 0],
                                            ['contributor_id', 0],
                                            ['tag_users.user_id', $auth->id],
                                            ['tag_users.deleted_at', null]])
                                   ->count();
      $suggestions = $suggestions + $tag_suggestions;

      // 招待コード
      $invitations = Invitation::where('inviter', $auth->name)->get();
      if($invitations->isEmpty()) {
        $invitations = null;
      }

      return view('dashboard', [
        'notices' => Notice::whereNull('to_user')->get(),
        'to_notices' => Notice::where('to_user',  $auth->id)->get(),
        'suggestions' => $suggestions,
        'issues' => $issues,
        'invitations' => $invitations,
        'num_entities' => Entity::where('user_id', $auth->id)->count(),
        'entities' => $entity_list,
        'bingo' => TsukimachiBingo::where('user_id', $auth->id)->count(),
        'koshin' => Property::where([['property', 'type'],['value', '庚申塔'],['user_id', $auth->id]])->count(),
        'pref_stats' => $pref_stats,
      ]);

    }
}

