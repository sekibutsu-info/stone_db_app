<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Auth;
use DB;

use App\Models\User;
use App\Models\Entity;
use App\Models\Property;
use App\Models\DeleteHistory;
use App\Models\AddSpHistory;
use App\Models\MoveHistory;

use App\Http\Controllers\EntityController;

class EditController extends Controller
{

    /**
     * データの取得
     */
    public function get(Request $request): View
    {
      return $this->get_common($request, '', 'edit_data');
    }

    /**
     * データの取得（休眠ユーザのデータ編集用）
     */
    public function get2(Request $request): View
    {
      if(Auth::check()) {
        $auth = Auth::user();
        if( $auth->manage) {
          return $this->get_common($request, '', 'edit_data2');
        }
      }
      abort(403, '権限がありません');
    }

    /**
     * データの取得
     */
    public function get_common(Request $request, $message, $page): View
    {

      if(Auth::check()) {
        $auth = Auth::user();
      }
      $entity_id = $request->edit_entity_id;

      $entity = Entity::find($entity_id);
      if(empty($entity)) {
        abort(404, 'データがありません');
      }

      if($page == 'edit_data') {
        if($entity->user_id != $auth->id) {
          abort(403, '権限がありません');
        }
      } else {
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

      $image_list = array();
      $property_list = array();
      $lat = $lon = '0';
      //$address = '';
      //$sameas = '';
      $has_absence = false;

      $types_list = array();
      $place = '';
      $built_year = '';
      $built_year_ce = '';
      $figure = '';
      $principal = '';

      foreach($properties as $property) {
        $prop_id = $property->id;
        $prop = trim($property->property);
        $value = trim($property->value);
        if($prop == 'latitude') {
          $lat = rtrim($value, '0');
        } else if($prop == 'longitude') {
          $lon = rtrim($value, '0');
        } else if ($prop == 'image' ) {
          array_push($image_list, $value);
        } else if($prop == 'address') {
          //$address = $value;
        } else if($prop == 'sameas') {
          $permalink = 'https://map.sekibutsu.info/archive/'.$value;
          array_push($property_list, array('prop_id' => $prop_id, 'property' => '同一物', 'value' => $permalink));
        } else if($prop == 'absence') {
          if($value == 'missing') {
            array_push($property_list, array('prop_id' => $prop_id, 'property' => '不在種別', 'value' => '所在不明'));
            $has_absence = true;
          } else if($value == 'moved') {
            array_push($property_list, array('prop_id' => $prop_id, 'property' => '不在種別', 'value' => '移設'));
            $has_absence = true;
          }
        } else if($prop == 'type') {
          array_push($property_list, array('prop_id' => $prop_id, 'property' => '種類', 'value' => $value));
          array_push($types_list, $value);
        } else if($prop == 'place') {
          array_push($property_list, array('prop_id' => $prop_id, 'property' => '場所', 'value' => $value));
          $place = $value;
        } else if($prop == 'built_year') {
          array_push($property_list, array('prop_id' => $prop_id, 'property' => '造立年（和暦）', 'value' => $value));
          $built_year = $value;
        } else if($prop == 'built_year_ce') {
          array_push($property_list, array('prop_id' => $prop_id, 'property' => '造立年（西暦）', 'value' => $value));
          $built_year_ce = $value;
        } else if($prop == 'figure') {
          array_push($property_list, array('prop_id' => $prop_id, 'property' => '像容', 'value' => $value));
          $figure = $value;
        } else if($prop == 'principal') {
          array_push($property_list, array('prop_id' => $prop_id, 'property' => '主尊銘', 'value' => $value));
          $principal = $value;
        } else if($prop == 'project') {
          array_push($property_list, array('prop_id' => $prop_id, 'property' => 'プロジェクト', 'value' => $value));
        } else if($prop == 'comment') {
          array_push($property_list, array('prop_id' => $prop_id, 'property' => '備考', 'value' => $value));
        } else if($prop == 'ref_url') {
          array_push($property_list, array('prop_id' => $prop_id, 'property' => '参考URL', 'value' => $value));
        } else if($prop == '3D_model_url') {
          array_push($property_list, array('prop_id' => $prop_id, 'property' => '3Dモデル', 'value' => $value));
        } else if($prop == 'photo_date') {
          array_push($property_list, array('prop_id' => $prop_id, 'property' => '写真撮影日', 'value' => $value));
        }
      }

      return view($page, [
        'nickname' => $nickname,
        'user_id' => $user_id,
        'entity' => $entity,
        'images' => $image_list,
        'lat' => $lat,
        'lon' => $lon,
        'properties' => $property_list,
        'message' => $message,
        'has_absence' => $has_absence,
        'types' => implode(', ', $types_list),
        'place' => $place,
        'built_year' => $built_year,
        'built_year_ce' => $built_year_ce,
        'figure' => $figure,
        'principal' => $principal,
      ]);
    }

    /**
     * delete property.
     */
    public function del_prop(Request $request): View
    {

      $auth = Auth::user();

      if($request->ret_page) {
        $ret_page = $request->ret_page;
      } else {
        $ret_page = 'edit_data';
      }

      if($request->del_prop_id) {
        foreach($request->del_prop_id as $del_prop_id) {
          Property::destroy($del_prop_id);
          DeleteHistory::create(['user_id' => $auth->id,
                                 'property_id' => $del_prop_id,
                                ]);
        }

        // Entityの更新
        $this->update_entity($request->edit_entity_id);

        return $this->get_common($request, '削除しました', $ret_page);
      }
      return $this->get_common($request, '', $ret_page);
    }

    /**
     * delete history.
     */
    public function delete_history(Request $request): View
    {

      $delete_history = DeleteHistory::leftJoin('users', 'delete_history.user_id', '=', 'users.id')
                                     ->leftJoin('properties', 'delete_history.property_id', '=', 'properties.id')
                                     ->select('users.nickname as nickname',
                                              'properties.entity_id as entity_id',
                                              'properties.property as property',
                                              'properties.value as value',
                                              'delete_history.created_at as created_at')
                                     ->orderBy('delete_history.id', 'desc')
                                     ->take(100)
                                     ->get();

      return view('delete_history', [
        'delete_history' => $delete_history,
      ]);

    }

    /**
     * add special property.
     */
    public function add_sp_prop(Request $request): View
    {

      $auth = Auth::user();

      if($request->ret_page) {
        $ret_page = $request->ret_page;
      } else {
        $ret_page = 'edit_data';
      }

      if($request->absence) {

        $property = new Property();
        $add = $property->create([
          'entity_id' => $request->edit_entity_id,
          'property' => 'absence',
          'value' => $request->absence,
          'user_id' => $auth->id,
        ]);

        AddSpHistory::create(['user_id' => $auth->id,
                              'entity_id' => $request->edit_entity_id,
                              'property' => 'absence',
                              'value' => $request->absence,
                             ]);
        return $this->get_common($request, '追加しました', $ret_page);

      } else if($request->sameas) {

        if( Entity::find($request->sameas)) {

          $property = new Property();
          $add = $property->create([
            'entity_id' => $request->edit_entity_id,
            'property' => 'sameas',
            'value' => $request->sameas,
            'user_id' => $auth->id,
          ]);

          AddSpHistory::create(['user_id' => $auth->id,
                                'entity_id' => $request->edit_entity_id,
                                'property' => 'sameas',
                                'value' => $request->sameas,
                               ]);

          return $this->get_common($request, '追加しました', $ret_page);
        }
      }
      return $this->get_common($request, '', $ret_page);
    }

    /**
     * add special property history.
     */
    public function add_sp_history(Request $request): View
    {

      $add_sp_history = AddSpHistory::leftJoin('users', 'add_sp_history.user_id', '=', 'users.id')
                                    ->select('nickname',
                                             'entity_id',
                                             'property',
                                             'value',
                                             'add_sp_history.created_at as created_at')
                                     ->orderBy('add_sp_history.id', 'desc')
                                     ->take(100)
                                     ->get();

      return view('add_sp_history', [
        'add_sp_history' => $add_sp_history,
      ]);

    }

    /**
     * move entity.
     */
    public function move_entity(Request $request): View
    {

      $auth = Auth::user();

      if($request->ret_page) {
        $ret_page = $request->ret_page;
      } else {
        $ret_page = 'edit_data';
      }

      if($request->lat && $request->lon && $request->address) {

        DB::transaction(function () use ($request, $auth) {

          $entity_id = $request->edit_entity_id;
          $new_lat = $request->lat;
          $new_lon = $request->lon;
          $new_adr = $request->address;
          $city_code = $request->city_code;

          $old_lat = Property::where([['entity_id', $entity_id],['property', 'latitude']])->value('value');
          $old_lon = Property::where([['entity_id', $entity_id],['property', 'longitude']])->value('value');
          $old_adr = Property::where([['entity_id', $entity_id],['property', 'address']])->value('value');

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

          Property::where([['entity_id', $entity_id],['property', 'latitude']])->delete();
          Property::where([['entity_id', $entity_id],['property', 'longitude']])->delete();
          Property::where([['entity_id', $entity_id],['property', 'address']])->delete();
          Property::where([['entity_id', $entity_id],['property', 'city_code']])->delete();
          Property::where([['entity_id', $entity_id],['property', 'mesh_code']])->delete();

          Property::insert([
            [
              'entity_id' => $entity_id,
              'property' => 'latitude',
              'value' => $new_lat,
              'user_id' => $auth->id,
            ],
            [
              'entity_id' => $entity_id,
              'property' => 'longitude',
              'value' => $new_lon,
              'user_id' => $auth->id,
            ],
            [
              'entity_id' => $entity_id,
              'property' => 'address',
              'value' => $new_adr,
              'user_id' => $auth->id,
            ],
            [
              'entity_id' => $entity_id,
              'property' => 'city_code',
              'value' => htmlspecialchars($city_code, ENT_QUOTES, 'UTF-8'),
              'user_id' => $auth->id,
            ],
            [
              'entity_id' => $entity_id,
              'property' => 'mesh_code',
              'value' => $mesh_code,
              'user_id' => $auth->id,
            ],
          ]);

          // Entityの更新
          $this->update_entity($entity_id);

          MoveHistory::create(['user_id' => $auth->id,
                               'entity_id' => $entity_id,
                               'old_latitude' => $old_lat,
                               'old_longitude' => $old_lon,
                               'old_address' => $old_adr,
                               'new_latitude' =>  $new_lat,
                               'new_longitude' => $new_lon,
                               'new_address' => $new_adr,
                              ]);

        });

        return $this->get_common($request, '移動しました', $ret_page);

      }
      return $this->get_common($request, '', $ret_page);
    }

    /**
     * move history.
     */
    public function move_history(Request $request): View
    {

      $move_history = MoveHistory::leftJoin('users', 'move_history.user_id', '=', 'users.id')
                                 ->select('nickname',
                                          'entity_id',
                                          'old_latitude',
                                          'old_longitude',
                                          'old_address',
                                          'move_history.created_at as created_at',
                                          'new_latitude',
                                          'new_longitude',
                                          'new_address')
                                 ->orderBy('move_history.id', 'desc')
                                 ->take(100)
                                 ->get();

      return view('move_history', [
        'move_history' => $move_history,
      ]);

    }

    /**
     * プロパティの追加（休眠ユーザーのデータ編集）
     */
    public function add_prop2(Request $request): String
    {
      // 必ず認証されている
      $auth = Auth::user();

      $validated = $request->validate([
        'add_property_entity_id' => 'required',
      ]);

      $add_ok = false;

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
          AddSpHistory::create(['user_id' => $auth->id,
                                'entity_id' => $request->add_property_entity_id,
                                'property' => 'type',
                                'value' => $request->add_type,
                               ]);
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
          AddSpHistory::create(['user_id' => $auth->id,
                                'entity_id' => $request->add_property_entity_id,
                                'property' => 'place',
                                'value' => htmlspecialchars($request -> add_place, ENT_QUOTES, 'UTF-8'),
                               ]);
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
          AddSpHistory::create(['user_id' => $auth->id,
                                'entity_id' => $request->add_property_entity_id,
                                'property' => 'built_year',
                                'value' => htmlspecialchars($request -> add_built_year, ENT_QUOTES, 'UTF-8'),
                               ]);
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
          $ce = EntityController::nengo( $request -> add_built_year );
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
          AddSpHistory::create(['user_id' => $auth->id,
                                'entity_id' => $request->add_property_entity_id,
                                'property' => 'built_year_ce',
                                'value' => htmlspecialchars($add_built_year_ce, ENT_QUOTES, 'UTF-8'),
                               ]);
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
          AddSpHistory::create(['user_id' => $auth->id,
                                'entity_id' => $request->add_property_entity_id,
                                'property' => 'figure',
                                'value' => htmlspecialchars($request -> add_figure, ENT_QUOTES, 'UTF-8'),
                               ]);
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
          AddSpHistory::create(['user_id' => $auth->id,
                                'entity_id' => $request->add_property_entity_id,
                                'property' => 'principal',
                                'value' => htmlspecialchars($request -> add_principal, ENT_QUOTES, 'UTF-8'),
                               ]);
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
          AddSpHistory::create(['user_id' => $auth->id,
                                'entity_id' => $request->add_property_entity_id,
                                'property' => 'comment',
                                'value' => htmlspecialchars($request -> add_comment, ENT_QUOTES, 'UTF-8'),
                               ]);
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
          AddSpHistory::create(['user_id' => $auth->id,
                                'entity_id' => $request->add_property_entity_id,
                                'property' => 'ref_url',
                                'value' => htmlspecialchars($request -> add_refurl, ENT_QUOTES, 'UTF-8'),
                               ]);
          $add_ok = true;
        }
      }

      // Entityの更新
      $this->update_entity($request->add_property_entity_id);

      if($add_ok) {
        return $this->get_common($request, '追加しました', 'edit_data2');
      } else {
        return $this->get_common($request, '', 'edit_data2');
      }

    }

}
