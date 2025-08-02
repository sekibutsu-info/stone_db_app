<x-app-layout>

    <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
          マイページ設定
      </h2>
    </x-slot>

    <div class="py-6">
      <div class="max-w-7xl mx-auto px-6">

      @if($message=='')
        <div style="margin-top:10px;">
        ユーザーページで公開される内容を設定します。
        </div>
        <form method="POST" action="/mypage">

          @csrf
          @method('put')

          <div style="margin-top:10px;">
            <label for="my_open" class="mb-2 text-gray-900">公開範囲：</label>
            @isset($userpage)
              @if($userpage->open==1)
                <input type="radio" name="my_open" id="my_open" value="1" checked> <i class="fa fa-thumbs-o-up" aria-hidden="true"></i> すべてのユーザーに公開
                <input type="radio" name="my_open" id="my_open" value="0"> <i class="fa fa-thumbs-o-down" aria-hidden="true"></i> ログインしているメール認証済みユーザーのみに公開
              @else
                <input type="radio" name="my_open" id="my_open" value="1"> <i class="fa fa-thumbs-o-up" aria-hidden="true"></i> すべての人に公開
                <input type="radio" name="my_open" id="my_open" value="0" checked> <i class="fa fa-thumbs-o-down" aria-hidden="true"></i> ログインしているメール認証済みユーザーのみに公開
              @endif
            @else
              <input type="radio" name="my_open" id="my_open" value="1"> <i class="fa fa-thumbs-o-up" aria-hidden="true"></i> すべての人に公開
              <input type="radio" name="my_open" id="my_open" value="0" checked> <i class="fa fa-thumbs-o-down" aria-hidden="true"></i> ログインしているメール認証済みユーザーのみに公開
            @endif
          </div>

          <div style="margin-top:10px;display:table;">
            <div style="display:table-cell;vertical-align:middle;white-space:nowrap;" class="mb-2 text-gray-900">自己紹介：</div>
            <div style="display:table-cell;" class="w-full">
              @isset($userpage)
                <textarea id="my_comment" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg w-full p-1" name="my_comment" maxlength="1000">{{$userpage->comment}}</textarea>
              @else
                <textarea id="my_comment" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg w-full p-1" name="my_comment" maxlength="1000"></textarea>
              @endif
            </div>
          </div>
          <div style="margin-top:10px;">
            <label for="my_twitter" class="mb-2 text-gray-900">Twitterユーザ名：</label>
            @isset($userpage)
              <input id="my_twitter" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg w-32 p-1" type="text" name="my_twitter" maxlength="15" value="{{$userpage->twitter}}" />
            @else
              <input id="my_twitter" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg w-32 p-1" type="text" name="my_twitter" maxlength="15" />
            @endif
            （先頭の@は不要）
          </div>
          <div style="margin-top:10px;">
            <label for="my_twitter_disp" class="mb-2 text-gray-900">Twitter表示名：</label>
            @isset($userpage)
              <input id="my_twitter_disp" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg w-64 p-1" type="text" name="my_twitter_disp" maxlength="256" value="{{$userpage->twitter_disp}}" />
            @else
              <input id="my_twitter_disp" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg w-64 p-1" type="text" name="my_twitter_disp" maxlength="256" />
            @endif
          </div>
          <div style="margin-top:10px;">
            <label for="my_homepage" class="mb-2 text-gray-900">ホームページのURL：</label>
            @isset($userpage)
              <input id="my_homepage" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg w-64 p-1" type="text" name="my_homepage" maxlength="256" value="{{$userpage->homepage}}" />
            @else
              <input id="my_homepage" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg w-64 p-1" type="text" name="my_homepage" maxlength="256" />
            @endif
          </div>
          <div style="margin-top:10px;">
            <label for="my_contrib" class="mb-2 text-gray-900">投稿数の表示：</label>
            @isset($userpage)
              @if($userpage->contrib==1)
                <input type="radio" name="my_contrib" id="my_contrib" value="1" checked> <i class="fa fa-thumbs-o-up" aria-hidden="true"></i> 表示する
                <input type="radio" name="my_contrib" id="my_contrib" value="0"> <i class="fa fa-thumbs-o-down" aria-hidden="true"></i> 表示しない
              @else
                <input type="radio" name="my_contrib" id="my_contrib" value="1"> <i class="fa fa-thumbs-o-up" aria-hidden="true"></i> 表示する
                <input type="radio" name="my_contrib" id="my_contrib" value="0" checked> <i class="fa fa-thumbs-o-down" aria-hidden="true"></i> 表示しない
              @endif
            @else
              <input type="radio" name="my_contrib" id="my_contrib" value="1"> <i class="fa fa-thumbs-o-up" aria-hidden="true"></i> 表示する
              <input type="radio" name="my_contrib" id="my_contrib" value="0" checked> <i class="fa fa-thumbs-o-down" aria-hidden="true"></i> 表示しない
            @endif
          </div>
          <div style="margin-top:10px;">
            <label for="my_pref" class="mb-2 text-gray-900">県別投稿数マップの表示：</label>
            @isset($userpage)
              @if($userpage->pref==1)
                <input type="radio" name="my_pref" id="my_contrib" value="1" checked> <i class="fa fa-thumbs-o-up" aria-hidden="true"></i> 表示する
                <input type="radio" name="my_pref" id="my_contrib" value="0"> <i class="fa fa-thumbs-o-down" aria-hidden="true"></i> 表示しない
              @else
                <input type="radio" name="my_pref" id="my_contrib" value="1"> <i class="fa fa-thumbs-o-up" aria-hidden="true"></i> 表示する
                <input type="radio" name="my_pref" id="my_contrib" value="0" checked> <i class="fa fa-thumbs-o-down" aria-hidden="true"></i> 表示しない
              @endif
            @else
              <input type="radio" name="my_pref" id="my_contrib" value="1"> <i class="fa fa-thumbs-o-up" aria-hidden="true"></i> 表示する
              <input type="radio" name="my_pref" id="my_contrib" value="0" checked> <i class="fa fa-thumbs-o-down" aria-hidden="true"></i> 表示しない
            @endif
          </div>
          <div style="margin-top:10px;">
            <label for="my_bingo" class="mb-2 text-gray-900">ビンゴカードの表示：</label>
            @isset($userpage)
              @if($userpage->bingo==1)
                <input type="radio" name="my_bingo" id="my_bingo" value="1" checked> <i class="fa fa-thumbs-o-up" aria-hidden="true"></i> 表示する
                <input type="radio" name="my_bingo" id="my_bingo" value="0"> <i class="fa fa-thumbs-o-down" aria-hidden="true"></i> 表示しない
              @else
                <input type="radio" name="my_bingo" id="my_bingo" value="1"> <i class="fa fa-thumbs-o-up" aria-hidden="true"></i> 表示する
                <input type="radio" name="my_bingo" id="my_bingo" value="0" checked> <i class="fa fa-thumbs-o-down" aria-hidden="true"></i> 表示しない
              @endif
            @else
              <input type="radio" name="my_bingo" id="my_bingo" value="1"> <i class="fa fa-thumbs-o-up" aria-hidden="true"></i> 表示する
              <input type="radio" name="my_bingo" id="my_bingo" value="0" checked> <i class="fa fa-thumbs-o-down" aria-hidden="true"></i> 表示しない
            @endif
          </div>
          <div style="margin-top:10px;">
            <label for="my_koshin" class="mb-2 text-gray-900">庚申メーターの表示：</label>
            @isset($userpage)
              @if($userpage->koshin==1)
                <input type="radio" name="my_koshin" id="my_koshin" value="1" checked> <i class="fa fa-thumbs-o-up" aria-hidden="true"></i> 表示する
                <input type="radio" name="my_koshin" id="my_koshin" value="0"> <i class="fa fa-thumbs-o-down" aria-hidden="true"></i> 表示しない
              @else
                <input type="radio" name="my_koshin" id="my_koshin" value="1"> <i class="fa fa-thumbs-o-up" aria-hidden="true"></i> 表示する
                <input type="radio" name="my_koshin" id="my_koshin" value="0" checked> <i class="fa fa-thumbs-o-down" aria-hidden="true"></i> 表示しない
              @endif
            @else
              <input type="radio" name="my_koshin" id="my_koshin" value="1"> <i class="fa fa-thumbs-o-up" aria-hidden="true"></i> 表示する
              <input type="radio" name="my_koshin" id="my_koshin" value="0" checked> <i class="fa fa-thumbs-o-down" aria-hidden="true"></i> 表示しない
            @endif
          </div>

          <div style="margin-top:10px;">
            <input type="submit" class="text-white bg-blue-600 font-medium rounded-lg text-sm px-5 py-2 text-center cursor-pointer" value="登録" id="submit_button" />
          </div>
        </form>
      @else
        <div style="margin-top:10px;">
        {{$message}}
        </div>
        <div style="margin-top:10px;">
        <a href="/userpage?id={{Auth::user()->id}}">ユーザーページを見る</a>
        </div>
      @endif
      </div>
    </div>

</x-app-layout>
