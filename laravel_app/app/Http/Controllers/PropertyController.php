<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Auth;

use App\Models\User;
use App\Models\Property;
use App\Models\Entity;

class PropertyController extends Controller
{
    /**
     * 一つのプロパティの追加（管理者用）
     */
    public function add_one_prop(Request $request): View
    {
      // 必ず認証されている
      $auth = Auth::user();
      if( $auth->admin ) {
        if( isset($request->entity_id) && isset($request->property) && isset($request->value) ) {
          $property = new Property();
          $add = $property->create([
            'entity_id' => $request->entity_id,
            'property' => $request->property,
            'value' => $request->value,
            'user_id' => $auth->id,
          ]);

          // Entityの更新
          $this->update_entity($request->entity_id);

          return view('add_prop', [
            'message' => '追加しました。',
          ]);
        } else {
          return view('add_prop', [
          ]);
        }
      } else {
        abort(403, '権限がありません');
      }
    }

    /**
     * エンティティの削除（管理者用）
     */
    public function delete_entity(Request $request): View
    {
      // 必ず認証されている
      $auth = Auth::user();
      if( $auth->admin ) {
        if( isset($request->entity_id) ) {
          $entity_id = $request->entity_id;

          Entity::where('id', $entity_id)->delete();
          Property::where('entity_id', $entity_id)->delete();

          return view('delete_entity', [
            'message' => '削除しました。',
          ]);
        } else {
          return view('delete_entity', [
          ]);
        }
      } else {
        abort(403, '権限がありません');
      }
    }

    /**
     * 画像の追加（管理者用）
     */
    public function add_photo(Request $request): View
    {
      // 必ず認証されている
      $auth = Auth::user();
      if( $auth->admin ) {
        if( isset($request->entity_id) && isset($request->file1) ) {
          $path = $request->file1->store('images');
          $path = str_replace('images/', '', $path);
          $property = new Property();
          $property = $property->create([
            'entity_id' => $request->entity_id,
            'property' => 'image',
            'value' => $path,
            'user_id' => $auth->id,
          ]);

          // Entityの更新
          $this->update_entity($request->entity_id);

          return view('add_photo', [
            'message' => '追加しました。',
          ]);
        } else {
          return view('add_photo', [
          ]);
        }
      } else {
        abort(403, '権限がありません');
      }
    }

}
