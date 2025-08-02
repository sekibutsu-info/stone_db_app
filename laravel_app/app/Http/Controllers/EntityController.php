<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Auth;

use App\Models\User;
use App\Models\Entity;
use App\Models\Property;
use App\Models\Issue;
use App\Models\Tag;
use App\Models\TagUser;
use App\Models\Suggestion;

class EntityController extends Controller
{

    /**
     * データの取得
     */
    public function get(Request $request): View
    {
      if(Auth::check()) {
        $auth = Auth::user();
      }

      $entity_id = $request->id;
      $result_page = false;

      return $this->get_common($entity_id, $result_page, false);
    }

    /**
     * データの取得共通処理
     */
    function get_common($entity_id, $result_page, $archive_page=false): View
    {

      $entity = Entity::find($entity_id);
      if(empty($entity)) {
        abort(404, 'データがありません');
      }
      $properties = Property::where('entity_id', $entity_id)->get();
      if(empty($properties)) {
        abort(404, 'データがありません');
      }
      $user_id = $entity->user_id;
      $nickname = User::where('id', $entity->user_id)->value('nickname');
      if( !$nickname ) {
        $nickname = 'N/A';
      }

      $last_post_date = Entity::where('user_id', $entity->user_id)
                         ->max('created_at');
      $last_post_date = strtotime($last_post_date);
      $current_date = time();
      $one_year_ago = strtotime('-1 year', $current_date);
      if ($last_post_date < $one_year_ago && $user_id != 2) {
        $inactive_user = true;
      } else {
        $inactive_user = false;
      }

      $tags_available = Tag::select('tags.id', 'tags.name')
                           ->orderBy('tags.disp_order')
                           ->get();

      $tags_enabled = null;
      if(Auth::check()) {
        $auth = Auth::user();
        $tags_enabled = Tag::leftJoin('tag_users', 'tags.id', '=', 'tag_users.tag_id')
                           ->where('tag_users.user_id', '=', $auth->id)
                           ->whereNull('tag_users.deleted_at')
                           ->select('tags.id', 'tags.name')
                           ->orderBy('tags.disp_order')
                           ->get();
      }

      $image_list = array();
      $types_list = array();
      $lat = $lon = '0';
      $address = '';
      $city_code = '';
      $place = '';
      $built_year = '';
      $built_year_ce = '';
      $figure = '';
      $principal = '';
      $sameas = '';
      $absence = '';
      $project_list = array();
      $comment_list = array();
      $refurl_list = array();
      $model_list = array();
      $tag_list = array();
      $photo_date = '';

      foreach($properties as $property) {
        $prop = trim($property->property);
        $value = trim($property->value);
        if($prop == 'latitude') {
          $lat = rtrim($value, '0');
        } else if($prop == 'longitude') {
          $lon = rtrim($value, '0');
        } else if($prop == 'address') {
          $address = $value;
        } else if($prop == 'city_code') {
          $city_code = $value;
        } else if($prop == 'place') {
          $place = $value;
        } else if($prop == 'type') {
          array_push($types_list, $value);
        } else if($prop == 'built_year') {
          $built_year = $value;
        } else if($prop == 'built_year_ce') {
          $built_year_ce = $value;
        } else if($prop == 'figure') {
          $figure = $value;
        } else if($prop == 'principal') {
          $principal = $value;
        } else if($prop == 'sameas') {
          $sameas = $value;
        } else if($prop == 'absence') {
          $absence = $value;
        } else if($prop == 'project') {
          array_push($project_list, $value);
        } else if($prop == 'comment') {
          array_push($comment_list, $value);
        } else if($prop == 'ref_url') {
          array_push($refurl_list, $value);
        } else if($prop == '3D_model_url') {
          array_push($model_list, $value);
        } else if ($prop == 'image' ) {
          array_push($image_list, $value);
        } else if ($prop == 'tag' ) {
          array_push($tag_list, $value);
        } else if($prop == 'photo_date') {
          $photo_date = $value;
        }
      }

      if($archive_page) {
        $blade = 'archive';
      } else {
        $blade = 'get_entity';
      }

      return view($blade, [
        'id' => $entity_id,                   // archive用
        'nickname' => $nickname,
        'user_id' => $user_id,
        'entity' => $entity,
        'latlon' => [$lat, $lon],
        'address' => $address,
        'city_code' => $city_code,
        'place' => $place,
        'types' => implode(', ', $types_list),
        'built_year' => $built_year,
        'built_year_ce' => $built_year_ce,
        'figure' => $figure,
        'principal' => $principal,
        'sameas' => $sameas,
        'absence' => $absence,
        'projects' => $project_list,
        'comments' => $comment_list,
        'ref_urls' => $refurl_list,
        'model_urls' => $model_list,
        'images' => $image_list,
        'tags' => $tag_list,
        'tags_available' => $tags_available,
        'tags_enabled' => $tags_enabled,
        'result_page' => $result_page,
        'photo_date' => $photo_date,
        'inactive_user' => $inactive_user,
      ]);
    }

    /**
     * データ登録画面の表示
     */
    public function add(Request $request): View
    {

      // 必ず認証されている
      $auth = Auth::user();

      $lat = $request->lat;
      $lon = $request->lon;
      $zoom = $request->zoom;

      $tags_available = Tag::select('tags.id', 'tags.name')
                           ->orderBy('tags.disp_order')
                           ->get();

      $tags_enabled = null;
      $tags_enabled = Tag::leftJoin('tag_users', 'tags.id', '=', 'tag_users.tag_id')
                         ->where('tag_users.user_id', '=', $auth->id)
                         ->whereNull('tag_users.deleted_at')
                         ->select('tags.id', 'tags.name')
                         ->orderBy('tags.disp_order')
                         ->get();

      return view('add_entity', [
        'user_id' => $auth -> id,
        'lat' => $lat,
        'lon' => $lon,
        'zoom' => $zoom,
        'tags_available' => $tags_available,
        'tags_enabled' => $tags_enabled,
      ]);
    }

    /**
     * データの保存
     */
    public function save(Request $request): View
    {

      // 二重送信防止
      $request->session()->regenerateToken();

      // 必ず認証されている
      $auth = Auth::user();

      $validated = $request->validate([
        'lat' => 'required',
        'lon' => 'required',
        'address' => 'required',
        'types' => 'required',
      ]);

      $entity = new Entity();

      $entity = $entity->create([
        'user_id' => $auth->id,
      ]);

      $entity_id = $entity->id;

      // 緯度
      $property = new Property();
      $property = $property->create([
        'entity_id' => $entity_id,
        'property' => 'latitude',
        'value' => $request->lat,
        'user_id' => $auth->id,
      ]);
      // 経度
      $property = new Property();
      $property = $property->create([
        'entity_id' => $entity_id,
        'property' => 'longitude',
        'value' => $request->lon,
        'user_id' => $auth->id,
      ]);
      // 所在地
      $property = new Property();
      $property = $property->create([
        'entity_id' => $entity_id,
        'property' => 'address',
        'value' => htmlspecialchars($request->address, ENT_QUOTES, 'UTF-8'),
        'user_id' => $auth->id,
      ]);
      // 市区町村コード
      $property = new Property();
      $property = $property->create([
        'entity_id' => $entity_id,
        'property' => 'city_code',
        'value' => htmlspecialchars($request->city_code, ENT_QUOTES, 'UTF-8'),
        'user_id' => $auth->id,
      ]);
      // 場所
      if($request->place) {
        $property = new Property();
        $property = $property->create([
          'entity_id' => $entity_id,
          'property' => 'place',
          'value' => htmlspecialchars($request->place, ENT_QUOTES, 'UTF-8'),
          'user_id' => $auth->id,
        ]);
      }
      // 種類
      foreach(explode(",", $request->types) as $type) {
        $property = new Property();
        $property = $property->create([
          'entity_id' => $entity_id,
          'property' => 'type',
          'value' => htmlspecialchars($type, ENT_QUOTES, 'UTF-8'),
          'user_id' => $auth->id,
        ]);
      }
      // 造立年（和暦）
      if($request->built_year) {
        $property = new Property();
        $property = $property->create([
          'entity_id' => $entity_id,
          'property' => 'built_year',
          'value' => htmlspecialchars($request->built_year, ENT_QUOTES, 'UTF-8'),
          'user_id' => $auth->id,
        ]);
      }
      // 造立年（西暦）
      if($request->built_year_ce) {
        $property = new Property();
        $property = $property->create([
          'entity_id' => $entity_id,
          'property' => 'built_year_ce',
          'value' => htmlspecialchars($request->built_year_ce, ENT_QUOTES, 'UTF-8'),
          'user_id' => $auth->id,
        ]);
      } else if($request->built_year)  {
        // 変換して入力
        $ce = $this->nengo($request->built_year);
        if($ce > 0) {
          $property = new Property();
          $property = $property->create([
            'entity_id' => $entity_id,
            'property' => 'built_year_ce',
            'value' => $ce,
            'user_id' => $auth->id,
          ]);
        }
      }
      // 像容
      if($request->figure) {
        $property = new Property();
        $property = $property->create([
          'entity_id' => $entity_id,
          'property' => 'figure',
          'value' => htmlspecialchars($request->figure, ENT_QUOTES, 'UTF-8'),
          'user_id' => $auth->id,
        ]);
      }
      // 主尊
      if($request->principal) {
        $property = new Property();
        $property = $property->create([
          'entity_id' => $entity_id,
          'property' => 'principal',
          'value' => htmlspecialchars($request->principal, ENT_QUOTES, 'UTF-8'),
          'user_id' => $auth->id,
        ]);
      }

      // プロジェクト
      if($request->projects) {
        foreach(explode(",", $request->projects) as $project) {
          $property = new Property();
          $property = $property->create([
            'entity_id' => $entity_id,
            'property' => 'project',
            'value' => htmlspecialchars($project, ENT_QUOTES, 'UTF-8'),
            'user_id' => $auth->id,
          ]);
        }
      }
      // 備考
      if($request->comment) {
        $property = new Property();
        $property = $property->create([
          'entity_id' => $entity_id,
          'property' => 'comment',
          'value' => htmlspecialchars($request->comment, ENT_QUOTES, 'UTF-8'),
          'user_id' => $auth->id,
        ]);
      }

      // タグ付けの提案
      if($request->tag_suggestion) {
        $suggestion = new Suggestion();
        $suggestion = $suggestion->create([
          'entity_id' => $entity_id,
          'user_id' => 0,
          'suggestion' => $request->tag_suggestion,
          'suggested_by' => $auth->id,
          'suggested_at' => now(),
        ]);
      }

      // ファイル保存
      if($request->file1) {
        $path = $request->file1->store('images');
        $path = str_replace('images/', '', $path);
        $property = new Property();
        $property = $property->create([
          'entity_id' => $entity_id,
          'property' => 'image',
          'value' => $path,
          'user_id' => $auth->id,
        ]);
      }
      if($request->file2) {
        $path = $request->file2->store('images');
        $path = str_replace('images/', '', $path);
        $property = new Property();
        $property = $property->create([
          'entity_id' => $entity_id,
          'property' => 'image',
          'value' => $path,
          'user_id' => $auth->id,
        ]);
      }
      if($request->file3) {
        $path = $request->file3->store('images');
        $path = str_replace('images/', '', $path);
        $property = new Property();
        $property = $property->create([
          'entity_id' => $entity_id,
          'property' => 'image',
          'value' => $path,
          'user_id' => $auth->id,
        ]);
      }
      if($request->file4) {
        $path = $request->file4->store('images');
        $path = str_replace('images/', '', $path);
        $property = new Property();
        $property = $property->create([
          'entity_id' => $entity_id,
          'property' => 'image',
          'value' => $path,
          'user_id' => $auth->id,
        ]);
      }
      if($request->file5) {
        $path = $request->file5->store('images');
        $path = str_replace('images/', '', $path);
        $property = new Property();
        $property = $property->create([
          'entity_id' => $entity_id,
          'property' => 'image',
          'value' => $path,
          'user_id' => $auth->id,
        ]);
      }

      // 写真撮影日
      if($request->photo_date) {
        $property = new Property();
        $property = $property->create([
          'entity_id' => $entity_id,
          'property' => 'photo_date',
          'value' => htmlspecialchars($request->photo_date, ENT_QUOTES, 'UTF-8'),
          'user_id' => $auth->id,
        ]);
      }

      // 3次メッシュコード
      $lat = $request->lat;
      $lon = $request->lon;
      $digit_12 = intval($lat*(3/2));
      $digit_34 = intval($lon - 100);
      $digit_5 = intval(($lat*(3/2) - $digit_12)/(1/8));
      $digit_6 = intval(($lon - intval($lon))/(1/8));
      $digit_7 = intval(($lat*(3/2) - $digit_12 - $digit_5 * (1/8))/(1/8/10));
      $digit_8 = intval(($lon - intval($lon) - $digit_6 * (1/8)) / (1/8/10));
      $mesh_code = $digit_12*1000000 + $digit_34*10000 + $digit_5*1000 + $digit_6*100 + $digit_7*10 + $digit_8;
      $property = new Property();
      $property = $property->create([
        'entity_id' => $entity_id,
        'property' => 'mesh_code',
        'value' => $mesh_code,
        'user_id' => $auth->id,
      ]);

      // Entityの更新
      $this->update_entity($entity_id);

      // 登録したデータ表示
      $result_page = true;
      return $this->get_common($entity_id, $result_page);

    }

    /**
     * 新着データの取得
     */
    public function get_news(Request $request): View
    {

      $new_entity = 100;

      $entities = Entity::leftJoin('users', 'entities.user_id', '=', 'users.id')
                        ->select('entities.created_at as created_at', 'entities.id as entity_id','nickname', 'users.id as user_id')
                        ->orderBy("entities.id", "desc")
                        ->take($new_entity)->get();

      $properties = Property::where('entity_id', '>=', intval($entities[$new_entity-1]->entity_id))->get();

      $entity_list = array();
      foreach($entities as $entity) {
        $types = [];
        $figures = [];
        $principals = [];
        $tags = [];
        $address = "";
        $place = "";
        $latitude = "";
        $longitude = "";
        foreach($properties as $property) {
          if($property->entity_id == $entity->entity_id) {
            if($property->property == 'address') {
              $address = $property->value;
            } else if($property->property == 'place') {
              $place = ' '.$property->value;
            } else if($property->property == 'type') {
              array_push($types, $property->value);
            } else if($property->property == 'tag') {
              array_push($tags, $property->value);
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
          'entity_id' => $entity->entity_id,
          'created_at' => $entity->created_at,
          'nickname' => $entity->nickname,
          'user_id' => $entity->user_id,
          'types' => implode(', ', $types),
          'figures' => implode(', ', $figures),
          'principals' => implode(', ', $principals),
          'tags' => implode(', ', $tags),
          'address' => $address,
          'place' => $place,
          'latitude' => $latitude,
          'longitude' => $longitude,
        ]);
      }

      return view('news', [
        'entities' => $entity_list,
      ]);
    }

    /**
     * 新着写真の取得
     */
    public function get_newpics(Request $request): View
    {
      $new_pics = 100;

      // 昨日のすべて
      $pics = Property::select('entity_id', 'value')
                      ->whereRaw('(property LIKE "image" and DATE(created_at) = (CURRENT_DATE() - INTERVAL 1 DAY))')
                      ->orderBy('created_at', 'desc')
                      ->get();

      if( count($pics) < $new_pics ) {
        // 昨日までの100件
        $pics = Property::select('entity_id', 'value')
                      ->whereRaw('(property LIKE "image" and DATE(created_at) <= (CURRENT_DATE() - INTERVAL 1 DAY))')
                      ->orderBy('created_at', 'desc')
                      ->take($new_pics)
                      ->get();
      }

      return view('newpics', [
        'pics' => $pics,
      ]);
    }

    /**
     * ランダムに写真を取得
     */
    public function get_random(Request $request): View
    {
      $pics = 50;

      // 昨日までの50件をランダムに取得
      $pics = Property::select('entity_id', 'value')
                      ->whereRaw('(property LIKE "image" and DATE(created_at) <= (CURRENT_DATE() - INTERVAL 1 DAY))')
                      ->orderByRaw('RAND()')
                      ->take($pics)
                      ->get();

      return view('random', [
        'pics' => $pics,
      ]);
    }

    /**
     * プロパティの追加
     */
    public function add_prop(Request $request): String
    {
      // 必ず認証されている
      $auth = Auth::user();

      $validated = $request->validate([
        'add_property_entity_id' => 'required',
      ]);

      $add_ok = false;

      // 写真撮影日
      if($request->photo_date != '') {
        $property = new Property();
        $add = $property->create([
          'entity_id' => $request -> add_property_entity_id,
          'property' => 'photo_date',
          'value' => htmlspecialchars($request->photo_date, ENT_QUOTES, 'UTF-8'),
          'user_id' => $auth->id,
        ]);
        if( $add ) {
          $add_ok = true;
        }
      }

      // 種類
      if( ($request -> add_type) != '') {
        $property = new Property();
        $add = $property->create([
          'entity_id' => $request -> add_property_entity_id,
          'property' => 'type',
          'value' => htmlspecialchars($request -> add_type, ENT_QUOTES, 'UTF-8'),
          'user_id' => $auth->id,
        ]);
        if( $add ) {
          $add_ok = true;
        }
      }
      // 場所
      if( ($request -> add_place) != '') {
        $property = new Property();
        $add = $property->create([
          'entity_id' => $request -> add_property_entity_id,
          'property' => 'place',
          'value' => htmlspecialchars($request -> add_place, ENT_QUOTES, 'UTF-8'),
          'user_id' => $auth->id,
        ]);
        if( $add ) {
          $add_ok = true;
        }
      }
      // 造立年（和暦）
      if( ($request -> add_built_year) != '') {
        $property = new Property();
        $add = $property->create([
          'entity_id' => $request -> add_property_entity_id,
          'property' => 'built_year',
          'value' => htmlspecialchars($request -> add_built_year, ENT_QUOTES, 'UTF-8'),
          'user_id' => $auth->id,
        ]);
        if( $add ) {
          $add_ok = true;
        }
      }
      // 造立年（西暦）
      $add_built_year_ce = $request -> add_built_year_ce;
      if( $add_built_year_ce == '' && $request -> add_built_year != '' ) {
        $ce_exists = Property::where([['entity_id', $request->add_property_entity_id],
                                      ['property', 'built_year_ce']])
                             ->exists();
        if( !$ce_exists ) {
          $ce = $this->nengo( $request -> add_built_year );
          if($ce > 0) {
            $add_built_year_ce = strval($ce);
          }
        }
      }
      if( $add_built_year_ce != '') {
        $property = new Property();
        $add = $property->create([
          'entity_id' => $request -> add_property_entity_id,
          'property' => 'built_year_ce',
          'value' => htmlspecialchars($add_built_year_ce, ENT_QUOTES, 'UTF-8'),
          'user_id' => $auth->id,
        ]);
        if( $add ) {
          $add_ok = true;
        }
      }
      // 像容
      if( ($request -> add_figure) != '') {
        $property = new Property();
        $add = $property->create([
          'entity_id' => $request -> add_property_entity_id,
          'property' => 'figure',
          'value' => htmlspecialchars($request -> add_figure, ENT_QUOTES, 'UTF-8'),
          'user_id' => $auth->id,
        ]);
        if( $add ) {
          $add_ok = true;
        }
      }
      // 主尊
      if( ($request->add_principal) != '') {
        $property = new Property();
        $add = $property->create([
          'entity_id' => $request -> add_property_entity_id,
          'property' => 'principal',
          'value' => htmlspecialchars($request -> add_principal, ENT_QUOTES, 'UTF-8'),
          'user_id' => $auth->id,
        ]);
        if( $add ) {
          $add_ok = true;
        }
      }
      // プロジェクト
      if( ($request->add_project) != '') {
        $property = new Property();
        $add = $property->create([
          'entity_id' => $request -> add_property_entity_id,
          'property' => 'project',
          'value' => htmlspecialchars($request -> add_project, ENT_QUOTES, 'UTF-8'),
          'user_id' => $auth->id,
        ]);
        if( $add ) {
          $add_ok = true;
        }
      }
      // 備考
      if( ($request -> add_comment) != '') {
        $property = new Property();
        $add = $property->create([
          'entity_id' => $request -> add_property_entity_id,
          'property' => 'comment',
          'value' => htmlspecialchars($request -> add_comment, ENT_QUOTES, 'UTF-8'),
          'user_id' => $auth->id,
        ]);
        if( $add ) {
          $add_ok = true;
        }
      }
      // 参考URL
      if( ($request -> add_refurl) != '') {
        $property = new Property();
        $add = $property->create([
          'entity_id' => $request -> add_property_entity_id,
          'property' => 'ref_url',
          'value' => htmlspecialchars($request -> add_refurl, ENT_QUOTES, 'UTF-8'),
          'user_id' => $auth->id,
        ]);
        if( $add ) {
          $add_ok = true;
        }
      }
      // 3Dモデル
      if( ($request -> add_3Dmodel) != '') {
        $property = new Property();
        $add = $property->create([
          'entity_id' => $request -> add_property_entity_id,
          'property' => '3D_model_url',
          'value' => htmlspecialchars($request -> add_3Dmodel, ENT_QUOTES, 'UTF-8'),
          'user_id' => $auth->id,
        ]);
        if( $add ) {
          $add_ok = true;
        }
      }

      // タグ付けの提案
      if($request->tag_suggestion1) {
        $suggestion = new Suggestion();
        $add = $suggestion->create([
          'entity_id' => $request -> add_property_entity_id,
          'contributor_id' => 0,
          'suggestion' => trim($request->tag_suggestion1),
          'suggested_by' => $auth->id,
          'suggested_at' => now(),
        ]);
        if( $add ) {
          $add_ok = true;
        }
      }

      // Entityの更新
      $this->update_entity($request -> add_property_entity_id);

      if( $add_ok ) {
        return 'OK';
      } else {
        return 'NG';
      }
    }

    /**
     * 和暦→西暦
     */
    static function nengo( $wareki )
    {

      $nengo = array(
        "天正" => array("from" => 1573, "max" => 20, "adjust" => false),
        "文禄" => array("from" => 1593, "max" => 5, "adjust" => true),
        "慶長" => array("from" => 1596, "max" => 20, "adjust" => false),
        "元和" => array("from" => 1615, "max" => 10, "adjust" => false),
        "寛永" => array("from" => 1624, "max" => 21, "adjust" => false),
        "正保" => array("from" => 1645, "max" => 5, "adjust" => true),
        "慶安" => array("from" => 1648, "max" => 5, "adjust" => false),
        "承応" => array("from" => 1652, "max" => 4, "adjust" => false),
        "明暦" => array("from" => 1655, "max" => 4, "adjust" => false),
        "万治" => array("from" => 1658, "max" => 4, "adjust" => false),
        "萬治" => array("from" => 1658, "max" => 4, "adjust" => false),
        "寛文" => array("from" => 1661, "max" => 13, "adjust" => false),
        "延宝" => array("from" => 1673, "max" => 9, "adjust" => false),
        "延寶" => array("from" => 1673, "max" => 9, "adjust" => false),
        "延寳" => array("from" => 1673, "max" => 9, "adjust" => false),
        "天和" => array("from" => 1681, "max" => 4, "adjust" => false),
        "貞享" => array("from" => 1684, "max" => 5, "adjust" => false),
        "元禄" => array("from" => 1688, "max" => 17, "adjust" => false),
        "宝永" => array("from" => 1704, "max" => 8, "adjust" => false),
        "寶永" => array("from" => 1704, "max" => 8, "adjust" => false),
        "寳永" => array("from" => 1704, "max" => 8, "adjust" => false),
        "正徳" => array("from" => 1711, "max" => 6, "adjust" => false),
        "正德" => array("from" => 1711, "max" => 6, "adjust" => false),
        "享保" => array("from" => 1716, "max" => 21, "adjust" => false),
        "元文" => array("from" => 1736, "max" => 6, "adjust" => false),
        "寛保" => array("from" => 1741, "max" => 4, "adjust" => false),
        "延享" => array("from" => 1744, "max" => 5, "adjust" => false),
        "寛延" => array("from" => 1748, "max" => 4, "adjust" => false),
        "宝暦" => array("from" => 1751, "max" => 14, "adjust" => false),
        "宝曆" => array("from" => 1751, "max" => 14, "adjust" => false),
        "寶暦" => array("from" => 1751, "max" => 14, "adjust" => false),
        "寶曆" => array("from" => 1751, "max" => 14, "adjust" => false),
        "寳暦" => array("from" => 1751, "max" => 14, "adjust" => false),
        "寳曆" => array("from" => 1751, "max" => 14, "adjust" => false),
        "明和" => array("from" => 1764, "max" => 9, "adjust" => false),
        "安永" => array("from" => 1772, "max" => 10, "adjust" => false),
        "天明" => array("from" => 1781, "max" => 9, "adjust" => false),
        "寛政" => array("from" => 1789, "max" => 13, "adjust" => false),
        "享和" => array("from" => 1801, "max" => 4, "adjust" => false),
        "文化" => array("from" => 1804, "max" => 15, "adjust" => false),
        "文政" => array("from" => 1818, "max" => 13, "adjust" => false),
        "天保" => array("from" => 1831, "max" => 15, "adjust" => true),
        "弘化" => array("from" => 1845, "max" => 5, "adjust" => true),
        "嘉永" => array("from" => 1848, "max" => 7, "adjust" => false),
        "安政" => array("from" => 1855, "max" => 7, "adjust" => true),
        "万延" => array("from" => 1860, "max" => 2, "adjust" => false),
        "萬延" => array("from" => 1860, "max" => 2, "adjust" => false),
        "文久" => array("from" => 1861, "max" => 4, "adjust" => false),
        "元治" => array("from" => 1864, "max" => 2, "adjust" => false),
        "慶応" => array("from" => 1865, "max" => 4, "adjust" => false),
        "慶應" => array("from" => 1865, "max" => 4, "adjust" => false),
        "明治" => array("from" => 1868, "max" => 45, "adjust" => false),
        "大正" => array("from" => 1912, "max" => 15, "adjust" => false),
        "昭和" => array("from" => 1926, "max" => 64, "adjust" => false),
        "平成" => array("from" => 1989, "max" => 31, "adjust" => false),
        "令和" => array("from" => 2019, "max" => 31, "adjust" => false)
      );

      $suuji = array(
        "一" => 1,
        "二" => 2,
        "三" => 3,
        "四" => 4,
        "五" => 5,
        "六" => 6,
        "七" => 7,
        "八" => 8,
        "九" => 9,
        "十" => 10,
        "拾" => 10,
        "十一" => 11,
        "拾一" => 11,
        "十二" => 12,
        "拾二" => 12,
        "十三" => 13,
        "拾三" => 13,
        "十四" => 14,
        "拾四" => 14,
        "十五" => 15,
        "拾五" => 15,
        "十六" => 16,
        "拾六" => 16,
        "十七" => 17,
        "拾七" => 17,
        "十八" => 18,
        "拾八" => 18,
        "十九" => 19,
        "拾九" => 19,
        "二十" => 20,
        "二十一" => 21,
        "廿一" => 21,
        "二十二" => 22,
        "廿二" => 22,
        "二十三" => 23,
        "廿三" => 23,
        "二十四" => 24,
        "廿四" => 24,
        "二十五" => 25,
        "廿五" => 25,
        "二十六" => 26,
        "廿六" => 26,
        "二十七" => 27,
        "廿七" => 27,
        "二十八" => 28,
        "廿八" => 28,
        "二十九" => 29,
        "廿九" => 29,
        "三十" => 30,
        "丗" => 30,
        "三十一" => 31,
        "丗一" => 31,
        "三十二" => 32,
        "丗二" => 32,
        "三十三" => 33,
        "丗三" => 33,
        "三十四" => 34,
        "丗四" => 34,
        "三十五" => 35,
        "丗五" => 35,
        "三十六" => 36,
        "丗六" => 36,
        "三十七" => 37,
        "丗七" => 37,
        "三十八" => 38,
        "丗八" => 38,
        "三十九" => 39,
        "丗九" => 39,
        "四十" => 40,
        "四十一" => 41,
        "四十二" => 42,
        "四十三" => 43,
        "四十四" => 44,
        "四十五" => 45,
        "四十六" => 46,
        "四十七" => 47,
        "四十八" => 48,
        "四十九" => 49,
        "五十" => 50,
        "五十一" => 51,
        "五十二" => 52,
        "五十三" => 53,
        "五十四" => 54,
        "五十五" => 55,
        "五十六" => 56,
        "五十七" => 57,
        "五十八" => 58,
        "五十九" => 59,
        "六十" => 60,
        "六十一" => 61,
        "六十二" => 62,
        "六十三" => 63,
        "六十四" => 64,
      );

      $cnt = 0;
      $ceyear = 0;
      if (preg_match( "/(天正|文禄|慶長|元和|寛永|正保|慶安|承応|明暦|万治|萬治|寛文|延宝|延寶|延寳|天和|貞享|元禄|宝永|寶永|寳永|正徳|正德|享保|元文|寛保|延享|寛延|宝暦|寶暦|寳暦|宝曆|寶曆|寳曆|明和|安永|天明|寛政|享和|文化|文政|天保|弘化|嘉永|安政|万延|萬延|文久|元治|慶応|慶應|明治|大正|昭和|平成|令和)(元|[0-9]+|[０１２３４５６７８９]+|[一壱壹二弐貳三参參四五六七八九十拾廿丗]+)/u", $wareki, $matches )) {
        $intyear = 0;
        $gengo = mb_substr($matches[0], 0, 2);
        $year = mb_substr($matches[0], 2);
        if( $year == "元" ) {
          $intyear = 1;
        } else if ( is_numeric(mb_convert_kana($year, "n")) ) {
          $intyear = intval(mb_convert_kana($year, "n"));
        } else if ( preg_match( "/([一二三四五六七八九十]+)/u", $year, $matches )) {
          if (array_key_exists($year, $suuji)) {
            $intyear = $suuji[$year];
          }
        }
        if( $intyear > 0 ) {
          if( $intyear == 1 ) {
            $ceyear = $nengo[$gengo]["from"];
          } else if( $nengo[$gengo]["adjust"] ) {
            $ceyear = $nengo[$gengo]["from"] + $intyear - 2;
          } else {
            $ceyear = $nengo[$gengo]["from"] + $intyear - 1;
          }
          if( $intyear > $nengo[$gengo]["max"] ) {
            $ceyear = 0; // Out of range
          }
        }
      }
      return $ceyear;
    }

    /**
     * タグの追加
     */
    public function add_tag(Request $request): String
    {
      // 必ず認証されている
      $auth = Auth::user();

      $validated = $request->validate([
        'tag_entity_id' => 'required',
        'add_tag' => 'required',
      ]);

      if(!$auth->tagging) {
        // 権限なし
        return 'NG';
      }

      $tag_user = TagUser::where([['tag_id', '=', $request->add_tag], ['user_id', '=', $auth->id]])
                         ->get();
      if(!$tag_user) {
        // 権限なし
        return 'NG';
      }

      $tag_name = Tag::where('id', $request->add_tag)->value('name');
      $tag = Property::where([['entity_id', '=', $request->tag_entity_id],
                              ['property', '=', 'tag'],
                              ['value', '=', $tag_name]])
                         ->count();
      if($tag!=0) {
        // 既に追加済み
        return 'NG';
      }

      $property = new Property();
      $add = $property->create([
        'entity_id' => $request->tag_entity_id,
        'property' => 'tag',
        'value' => $tag_name,
        'user_id' => $auth->id,
      ]);

      return 'OK';

    }

}
