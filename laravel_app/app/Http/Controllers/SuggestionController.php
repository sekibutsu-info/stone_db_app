<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Auth;

use App\Models\Entity;
use App\Models\Suggestion;
use App\Models\TagUser;

class SuggestionController extends Controller
{

    /**
     * 改善提案の表示
     */
    public function show(Request $request): View
    {
      $enabled_tags = array();
      if(Auth::check()) {
        $auth = Auth::user();
        $tags = TagUser::leftJoin('tags', 'tag_users.tag_id', '=', 'tags.id')
                       ->where('user_id', $auth->id)
                       ->get();
        foreach($tags as $tag) {
          array_push($enabled_tags, trim($tag->name));
        }
      }

      $suggestions = Suggestion::leftJoin('users AS contribute', 'suggestions.contributor_id', '=', 'contribute.id')
                               ->leftJoin('users AS suggest', 'suggestions.suggested_by', '=', 'suggest.id')
                               ->leftJoin('users AS reply', 'suggestions.replied_by', '=', 'reply.id')
                               ->leftJoin('users AS decide', 'suggestions.decided_by', '=', 'decide.id')
                               ->select('suggestions.id AS suggestion_id', 'contributor_id', 'closed','useful','suggestions.updated_at AS suggestion_updated_at',
                                        'entity_id', 'contribute.nickname AS contribute_nickname',
                                        'suggestion', 'suggest.nickname AS suggested_nickname', 'suggested_at',
                                        'reply', 'reply_comment', 'reply.nickname AS replied_nickname', 'replied_at',
                                        'decision', 'decision_comment', 'decide.nickname AS decided_nickname', 'decided_at')
                               ->orderBy('closed', 'asc')->orderBy('suggestion_updated_at', 'desc')
                               ->take(50)->get();

      return view('suggestions', [
        'suggestions' => $suggestions,
        'enabled_tags' => $enabled_tags,
      ]);
    }

    /**
     * Save suggestion.
     */
    public function suggest(Request $request): String
    {
      // 必ず認証されている
      $auth = Auth::user();

      $validated = $request->validate([
        'suggest_entity_id' => 'required',
      ]);

      $entity = Entity::leftJoin('users', 'entities.user_id', '=', 'users.id')
                        ->select('users.id as user_id')
                        ->where('entities.id', $request -> suggest_entity_id)->get();
      if( !$entity ) {
        return 'NG';
      }

      $suggested = 'NG';

      if( $request->suggest_to == 'admin' ) {
        $contributor_id = 1;
      } else {
        $contributor_id = $entity[0] -> user_id;
      }

      if( trim($request->suggest_comment) != '' ) {
        $suggestion = new Suggestion();
        $suggest = $suggestion->create([
          'entity_id' => $request->suggest_entity_id,
          'contributor_id' => $contributor_id,
          'suggestion' => htmlspecialchars($request->suggest_comment, ENT_QUOTES, 'UTF-8'),
          'suggested_by' => $auth -> id,
          'suggested_at' => now(),
        ]);
        if( $suggest ) {
          $suggested = 'OK';
        }
      }

      if( $request->tag_suggestion2 != '' ) {
        $suggestion = new Suggestion();
        $suggest = $suggestion->create([
          'entity_id' => $request->suggest_entity_id,
          'contributor_id' => 0,
          'suggestion' => $request->tag_suggestion2,
          'suggested_by' => $auth->id,
          'suggested_at' => now(),
        ]);
        if( $suggest ) {
          $suggested = 'OK';
        }
      }

      return $suggested;

    }

    /**
     * Reply suggestion.
     */
    public function reply(Request $request): String
    {
      // 必ず認証されている
      $auth = Auth::user();

      $validated = $request->validate([
        'reply_suggestion_id' => 'required',
        'reply_agreement' => 'required',
        'reply_comment' => 'required',
      ]);

      $suggestion = Suggestion::where('id', $request->reply_suggestion_id)
         ->update(['reply' => $request->reply_agreement,
                   'reply_comment' => htmlspecialchars($request -> reply_comment, ENT_QUOTES, 'UTF-8'),
                   'replied_by' => $auth->id,
                   'replied_at' => now(),
                  ]);

      if( $suggestion ) {
        return 'OK';
      } else {
        return 'NG';
      }
    }

    /**
     * Decide suggestion.
     */
    public function decide(Request $request): String
    {
      // 必ず認証されている
      $auth = Auth::user();

      $validated = $request->validate([
        'reply_suggestion_id' => 'required',
        'reply_agreement' => 'required',
        'reply_comment' => 'required',
      ]);

      $suggestion = Suggestion::where('id', $request->reply_suggestion_id)
         ->update(['decision' => $request->reply_agreement,
                   'decision_comment' => htmlspecialchars($request -> reply_comment, ENT_QUOTES, 'UTF-8'),
                   'decided_by' => $auth->id,
                   'decided_at' => now(),
                  ]);

      if( $suggestion ) {
        return 'OK';
      } else {
        return 'NG';
      }
    }

    /**
     * Close suggestion.
     */
    public function close(Request $request): String
    {
      // 必ず認証されている
      $auth = Auth::user();

      $validated = $request->validate([
        'close_suggestion_id' => 'required',
        'useful' => 'required',
      ]);

      //$suggestion = Suggestion::where('id', $request->close_suggestion_id)
      //   ->update(['closed' => true,]);

      // updated_atは更新しない
      $suggestion = Suggestion::where('id', $request->close_suggestion_id)->first();
      $suggestion->closed = true;
      $suggestion->useful = $request->useful;
      $suggestion->timestamps = false;
      $suggestion->save();

      if( $suggestion ) {
        return 'OK';
      } else {
        return 'NG';
      }
    }

}

