<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Auth;
use DB;

use App\Models\User;
use App\Models\Tag;
use App\Models\TagUser;
use App\Models\Property;


class TagController extends Controller
{
    /**
     * 「タグ一覧」ページの表示
     */
    public function show(Request $request): View
    {
      $tag_count = array();
      $tag_c = Property::select('properties.value as tag', DB::raw('count(properties.id) AS p_count'))
                       ->where('properties.property', 'tag')
                       ->groupBy('tag')
                       ->get();
      foreach( $tag_c as $tag ) {
        $tag_count[$tag->tag] = $tag->p_count;
      }

      return view('tag', [
        'all_tag' => Tag::get(),
        'tag_list' => Tag::LeftJoin('tag_users', 'tags.id', '=', 'tag_users.tag_id')
                         ->LeftJoin('users', 'tag_users.user_id', '=', 'users.id')
                         ->whereNull('tag_users.deleted_at')
                         ->GroupBy('tags.id')
                         ->select('tags.id as tag_id',
                                  DB::raw("GROUP_CONCAT(DISTINCT tags.name) as tag_name"),
                                  DB::raw("GROUP_CONCAT(DISTINCT tags.note) as tag_note"),
                                  DB::raw("GROUP_CONCAT(users.nickname SEPARATOR ', ') AS nickname"))
                         ->orderBy('disp_order')
                         ->get(),
        'tag_count' => $tag_count,
        'tag_user' => User::where('tagging', '1')
                          ->get(),
      ]);
    }


    /**
     * ユーザーにタグ付けの権限を付与
     */
    public function add(Request $request): String
    {
      if($request->add_tag && $request->add_user) {
        if(TagUser::where([['tag_id', $request->add_tag], ['user_id', $request->add_user]])->exists()) {
          return 'exist';
        }
        $add = TagUser::create([
          'tag_id' => $request->add_tag,
          'user_id' => $request->add_user,
        ]);
        if($add) {
          return 'OK';
        }
      }
      return 'NG';
    }
}
