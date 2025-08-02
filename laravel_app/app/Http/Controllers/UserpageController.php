<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Auth;

use App\Models\User;
use App\Models\Entity;
use App\Models\Property;
use App\Models\Userpage;
use Illuminate\Support\Facades\DB;

class UserpageController extends Controller
{
    /**
     * ユーザーページの表示（権限チェック）
     */
    public function userpage(Request $request): View
    {
      $validated = $request->validate([
      ]);

      $userpage = Userpage::where('user_id', $request->id)->first();
      if($userpage) {
        if($userpage->open) {
          // 公開ユーザーページ
          return $this->get_userpage($request->id, $userpage);
        } else {
          if(Auth::check()) {
            $auth = Auth::user();
            if($auth->email_verified_at) {
              // 限定公開ユーザーページを閲覧可
              return $this->get_userpage($request->id, $userpage);
            } else {
              // 権限なし・新規投稿一覧
              return $this->get_userpost($request->id);
            }
          } else {
            // 権限なし・新規投稿一覧
            return $this->get_userpost($request->id);
          }
        }
      } else {
        // ユーザーページなし・新規投稿一覧
        return $this->get_userpost($request->id);
      }
    }

    /**
     * ユーザーページの表示
     */
    function get_userpage($user_id, $userpage): View
    {
      $user = User::where('id', $user_id)->first();

      $user_contrib = 0;
      if($userpage->contrib) {
        $user_contrib = Entity::where('user_id', $user_id)->count();
      }

      $pref_stats = null;
      if($userpage->pref) {
        $pref_stats = Property::leftjoin('pref_code', 'pname', '=', DB::raw('LEFT(value, 3)'))
                              ->groupBy('pcode')
                              ->select('pcode', DB::raw('COUNT(properties.id) AS p_count'))
                              ->where('property', '=', 'address')
                              ->where('user_id', '=', $user_id)
                              ->orderBy('p_count', 'DESC')->get();
      }

      $koshin = null;
      if($userpage->koshin) {
        $koshin = Property::where([['property', 'type'],['value', '庚申塔'],['user_id', $user_id]])->count();
      }

      return view('userpage', [
        'show' => true,
        'nickname' => $user->nickname,
        'userpage' => $userpage,
        'user_contrib' => $user_contrib,
        'pref_stats' => $pref_stats,
        'koshin' => $koshin,
        'entities' => $this->userpost($user_id),
      ]);
    }

    /**
     * ユーザーの新規投稿一覧の表示
     */
    function get_userpost($user_id): View
    {
      $user = User::where('id', $user_id)->first();
      if($user) {
        return view('userpage', [
          'show' => false,
          'nickname' => $user->nickname,
          'entities' => $this->userpost($user_id),
        ]);
      } else {
        abort(404);
      }
    }

    /**
     * ユーザーの新規投稿リスト取得
     */
    function userpost($user_id)
    {
      $entity_list = array();
      $new_entity = 20;
      $entities = Entity::where('user_id', $user_id)->orderBy('id', 'desc')->take($new_entity)->get();
      if(count($entities)>0) {
        $min_id = $entities[count($entities)-1]->id;
        $properties = Property::where('entity_id', '>=', $min_id)->where('user_id', $user_id)->get();

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
      return($entity_list);
    }

    /**
     * マイページの登録
     */
    public function mypage(Request $request): View
    {
      // 必ず認証されている
      $auth = Auth::user();

      if( $request->isMethod('put') ) {

        $validated = $request->validate([
        ]);

        $message = '';

        $userpage = Userpage::where('user_id', $auth->id)->first();
        if($userpage) {
          // update
          $userpage->open = $request->my_open;
          $userpage->comment = htmlspecialchars($request->my_comment, ENT_QUOTES, 'UTF-8');
          $userpage->twitter = trim($request->my_twitter, '@');
          $userpage->twitter_disp = $request->my_twitter_disp;
          $userpage->homepage = trim($request->my_homepage);
          $userpage->contrib = $request->my_contrib;
          $userpage->pref = $request->my_pref;
          $userpage->bingo = $request->my_bingo;
          $userpage->koshin = $request->my_koshin;
          $userpage->save();
          if( $userpage ) {
            $message = '更新しました';
          } else {
            $message = '更新できませんでした';
          }
        } else {
          // insert
          $userpage = new Userpage();
          $userpage = $userpage->create([
            'user_id' => $auth->id,
            'open' => $request->my_open,
            'comment' => htmlspecialchars($request->my_comment, ENT_QUOTES, 'UTF-8'),
            'twitter' => trim($request->my_twitter, '@'),
            'twitter_disp' => $request->my_twitter_disp,
            'homepage' => trim($request->my_homepage),
            'contrib' => $request->my_contrib,
            'pref' => $request->my_pref,
            'bingo' => $request->my_bingo,
            'koshin' => $request->my_koshin,
          ]);
          if( $userpage ) {
            $message = '登録しました';
          } else {
            $message = '登録できませんでした';
          }
        }

        return view('mypage', [
          'userpage' => Userpage::where('user_id', $auth->id)->first(),
          'message' => $message,
        ]);

      } else {
        return view('mypage', [
          'userpage' => Userpage::where('user_id', $auth->id)->first(),
          'message' => '',
        ]);
      }
    }

}
