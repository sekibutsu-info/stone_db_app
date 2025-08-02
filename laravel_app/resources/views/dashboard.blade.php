<x-app-layout>

  @section('subtitle', ' - ダッシュボード')

  @push('css')
    <link rel="stylesheet" href="/css/font-awesome.min.css" type="text/css" />
  @endpush

  @push('scripts')
    <script type="text/javascript" src="/js/jquery-3.6.3.js"></script>
  @endpush

    <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
          {{Auth::user()->nickname}}さんのダッシュボード
      </h2>
    </x-slot>

  <div id="entity" class="modal fade fixed top-0 left-0 hidden w-full h-full outline-none overflow-x-hidden overflow-y-auto" tabindex="-1">
    <div class="modal-dialog modal-fullscreen relative w-auto pointer-events-none">
      <div class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none text-current">
        <div class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 rounded-t-md" id="entity-header">
          <div id="entity-header-message"></div>
          <button type="button"
                  class="btn-close box-content w-4 h-4 p-1 text-black border-none rounded-none opacity-50 focus:shadow-none focus:outline-none focus:opacity-100 hover:text-black hover:opacity-75 hover:no-underline"
                  data-bs-dismiss="modal" aria-label="閉じる"></button>
        </div>
        <div id="entity-body" class="modal-body relative p-4">
        </div>
        <div class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-end p-4 border-t border-gray-200 rounded-b-md">
          <button type="button"
                  class="inline-block px-6 py-2.5 bg-gray-700 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-gray-900 hover:shadow-lg focus:bg-gray-900 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-gray-900 active:shadow-lg transition duration-150 ease-in-out"
                  data-bs-dismiss="modal">閉じる</button>
        </div>
      </div>
    </div>
  </div>

  <div id="photo-popup" style="z-index:1060;background-color:rgba(0, 0, 0, 0.5);" class="modal fade fixed top-0 left-0 hidden w-full h-full outline-none overflow-x-hidden overflow-y-auto" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered relative w-auto pointer-events-none">
      <div class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none text-current">
        <div id="photo-popup-body" class="modal-body relative p-4" data-bs-dismiss="modal" >
        </div>
      </div>
    </div>
  </div>

    <div class="py-6">
      <div class="max-w-7xl mx-auto px-6">
        @if(Auth::user()->admin)
          <div class="text-lg p-2">
            システムの稼働状況
          </div>
          <div class="text-base bg-white rounded-lg p-2">
          @if(file_exists("/home/midoriit/stone_db/stone_db_app/storage/logs/laravel.log"))
            <font color="red">ログファイルがあります。</font>
          @else
            ログファイルはありません。
          @endif
          （Laravel {{ App::VERSION() }}, PHP 
          @php
            echo phpversion();
          @endphp
          ）
          </div>
        @endif

        <div class="text-lg p-2">
          提案された改善
        </div>
        <div class="text-base bg-white rounded-lg p-2">
          @if($suggestions>0)
            <font color="red">提案された改善事項が{{$suggestions}}件あります。<a href="/suggestions" class="underline">改善提案</a>のページを確認して下さい。</font>
          @else
            提案された改善事項はありません。
          @endif
        </div>

        <div class="text-lg p-2">
          システム管理者からの個別連絡
        </div>
        <div class="text-base bg-white rounded-lg p-2">
          @if(Auth::user()->email_verified_at)
            @if(count($to_notices)>0)
              @foreach($to_notices as $to_notice)
                {{$to_notice->text}}
              @endforeach
            @else
              個別の連絡事項は特にありません。
            @endif
          @else
            <font color="red">メールアドレスが未確認です。確認をお願いします。</font>
          @endif
        </div>

        <div class="text-lg p-2">
          システム管理者への問合せ状況
        </div>
        <div class="text-base bg-white rounded-lg p-2">
          @if(count($issues)>0)
            @if(Auth::user()->admin)
              <font color="red">
              @foreach($issues as $issue)
                {{$issue['content']}}<br>
              @endforeach
              </font>
            @else
              対処されていない問合せが{{count($issues)}}件あります。
            @endif
          @else
            対処されていない問合せはありません。
          @endif
        </div>

        @if($invitations)
          <div class="text-lg p-2">
            招待コード（1つの招待コードで1名のみユーザー登録できます）
          </div>
          <div class="text-base bg-white rounded-lg p-2">
            @foreach($invitations as $invitation)
              {{$invitation['invitation_code']}}<br>
            @endforeach
          </div>
        @endif

        <div class="text-lg p-2">
          これまでの投稿数
        </div>
        <div class="text-base bg-white rounded-lg p-2">
          {{number_format($num_entities)}}件
        </div>

        <div class="text-lg p-2">
          最近の投稿
        </div>
        <div class="text-base bg-white rounded-lg p-2" style="white-space:nowrap;overflow:scroll;height:200px;">
          @if(count($entities)>0)
            @foreach($entities as $entity)
              @php
                if( $entity['figures'] ) {
                  $figure = '（像容：'.$entity['figures'].'）';
                } else {
                  $figure = '';
                }
                if( $entity['principals'] ) {
                  $principal = '（主尊銘：'.$entity['principals'].'）';
                } else {
                  $principal = '';
                }
              @endphp
              {{$entity['created_at']->format('Y年m月d日');}}に{{$entity['address']}}{{$entity['place']}} の
              {{$entity['types']}}{{$figure}}{{$principal}}を投稿しました
             （<a class="underline cursor-pointer" onClick="javascript:show_entity('{{$entity['entity_id']}}');">データ詳細</a>／<a href="/?x={{$entity['longitude']}}&y={{$entity['latitude']}}&z=16&e={{$entity['entity_id']}}" class="underline">マップ</a>）<br/>
            @endforeach
          @else
            まだ投稿はありません。
          @endif
        </div>

        <div class="text-lg p-2">
          県別投稿数マップ
        </div>
        <div class="text-base bg-white rounded-lg p-4">
          @component('components.japan-simple-map', ['pref_stats' => $pref_stats])
          @endcomponent
        </div>

        @if( $koshin > 0 )
          <div class="text-lg p-2">
            庚申メーター
          </div>
          <div class="text-base bg-white rounded-lg p-2">
            @php
              $hyaku_koshin_bar = ($koshin > 100) ? 100 : intval(($koshin/100)*100);
              $hyaku_koshin_space = ($koshin > 100) ? 0 : 100 - $hyaku_koshin_bar;
              $sen_koshin_bar = ($koshin > 1000) ? 100 : intval(($koshin/1000)*100);
              $sen_koshin_space = ($koshin > 1000) ? 0 : 100 - $sen_koshin_bar;
            @endphp
            <div style="display:table;" class="p-1">
              <div style="display:table-cell;white-space:nowrap;" class="text-lg">百庚申：</div>
              <div style="display:table-cell;background-color:yellowgreen;width:{{$hyaku_koshin_bar}}%;height:25px;"></div>
              <div style="display:table-cell;background-color:whitesmoke;width:{{$hyaku_koshin_space}}%;height:25px;"></div>
            </div>
            @if( $koshin >= 100 )
              <div style="display:table;" class="p-1">
                <div style="display:table-cell;white-space:nowrap;" class="text-lg">千庚申：</div>
                <div style="display:table-cell;background-color:yellowgreen;width:{{$sen_koshin_bar}}%;height:25px;"></div>
                <div style="display:table-cell;background-color:whitesmoke;width:{{$sen_koshin_space}}%;height:25px;"></div>
              </div>
            @endif
            @if( $koshin < 100 )
              <div class="p-1">百庚申まであと{{100-$koshin}}です。</div>
            @elseif( $koshin < 1000 )
              <div class="p-1">百庚申達成おめでとうございます。</div>
              <div class="p-1">千庚申まであと{{1000-$koshin}}です。</div>
            @else
              <div class="p-1">千庚申達成おめでとうございます。</div>
            @endif
          </div>
        @endif

        @if( $bingo > 0 )
          <div class="text-lg p-2">
            月待ビンゴ
          </div>
          <div>
            <iframe style="width:80vmin;height:80vmin;" src="https://moon.sekibutsu.info/index2.php?user_id={{Auth::user()->id}}"></iframe>
          </div>
        @endif

      </div>
    </div>

<script>
  window.show_entity = function(id) {
    var url = "/getEntity";
    var data = {id: id};
    $.ajax({
      url: url,
      data: data,
      type: 'POST',
      async: false,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
      }
    }).done(function(html) {
      $('#entity-header-message').html('データ詳細');
      $('#entity-body').html(html);
      $('#entity').modal('show');
    }).fail(function(jqXHR, textStatus, errorThrown) {
     //window.location.reload(true);
    });
  }
</script>

</x-app-layout>
