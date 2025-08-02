@if($entity['hidden'])
  @push('ogp')
    {{-- インデックスさせない --}}
    <meta name="robots" content="noindex">
  @endpush
@endif

<table>
    <tr><td class="whitespace-nowrap">Permalink：</td><td><a href="https://map.sekibutsu.info/archive/{{$entity['id']}}">https://map.sekibutsu.info/archive/{{$entity['id']}}</a>
    @if($entity['hidden'])
      <span class="whitespace-nowrap">（<a href="https://map.sekibutsu.info/?x={{$latlon[1]}}&y={{$latlon[0]}}&z=18" rel="nofollow">
    @else
      <span class="whitespace-nowrap">（<a href="https://map.sekibutsu.info/?x={{$latlon[1]}}&y={{$latlon[0]}}&z=18&e={{$entity['id']}}" rel="nofollow">
    @endif
    <i class="fa fa-map-marker" aria-hidden="true"></i> マップ</a>）</span></td></tr>
    @if($user_id != '')
      <tr><td class="whitespace-nowrap">データ作成者：</td><td><a href="/userpage?id={{$user_id}}" class="underline cursor-pointer" >{{ $nickname }}</a>
      @if($inactive_user)
        <a href="#" class="transititext-primary text-primary transition duration-150 ease-in-out hover:text-primary-600 focus:text-primary-600 active:text-primary-700 dark:text-primary-400 dark:hover:text-primary-500 dark:focus:text-primary-500 dark:active:text-primary-600" data-te-toggle="tooltip" title="休眠ユーザー">&#x1F634;</a>
      @endif
      </td></tr>
    @else
      <tr><td class="whitespace-nowrap">データ作成者：</td><td>{{ $nickname }}</td></tr>
    @endif
    <tr><td class="whitespace-nowrap">データ作成日：</td><td>{{ $entity['created_at']->format('Y年 n月 j日'); }}</td></tr>
</table>

<div style="background-color:rgb(229 231 235);">
  <table style="overflow-y:hidden;margin-right:10px"><tr>
    @foreach($images as $image)
        <td><img src="/images/{{$image}}"
             class="cursor-pointer"
             style="margin:5px;width:auto;height:200px;object-fit:contain;"
             onClick="javascript:popupImage({{$loop->index}});"></td>
    @endforeach
  </tr></table>
  <div class="text-sm" style="margin-left:0.5rem;padding-bottom:0.5rem;">&copy;{{ $nickname }} (Licensed under <a href="https://creativecommons.org/licenses/by/4.0/" target="_blank">CC BY 4.0</a>)</div>
</div>

<table>
    @if($photo_date != '')
      <tr><td class="whitespace-nowrap">写真撮影日：</td><td>{{$photo_date}}</td></tr>
    @endif
    <tr><td class="whitespace-nowrap">緯度経度：</td><td>{{$latlon[0]}}, {{$latlon[1]}}</td></tr>
    <tr><td class="whitespace-nowrap">所在地：</td><td>{{$address}}（{{$city_code}}）</td></tr>
    @if($place != '')
      <tr><td class="whitespace-nowrap">場所：</td><td>{{$place}}</td></tr>
    @endif
    <tr><td class="whitespace-nowrap">種類：</td><td>{{$types}}</td></tr>
    @if($built_year != '')
      <tr><td class="whitespace-nowrap">造立年（和暦）：</td><td>{{$built_year}}</td></tr>
    @endif
    @if($built_year_ce != '')
      <tr><td class="whitespace-nowrap">造立年（西暦）：</td><td>{{$built_year_ce}}</td></tr>
    @endif
    @if($figure != '')
      <tr><td class="whitespace-nowrap">像容（刻像）：</td><td>{{$figure}}</td></tr>
    @endif
    @if($principal != '')
      <tr><td class="whitespace-nowrap">主尊銘：</td><td>{{$principal}}</td></tr>
    @endif
    @foreach($projects as $project)
      <tr><td class="whitespace-nowrap">プロジェクト：</td><td>{{$project}}</td></tr>
    @endforeach
    @if($sameas != '')
      <tr><td class="whitespace-nowrap">同一物：</td><td><a href="https://map.sekibutsu.info/archive/{{$sameas}}">https://map.sekibutsu.info/archive/{{$sameas}}</a></td></tr>
    @endif
    @if($absence == 'missing')
      <tr><td class="whitespace-nowrap">不在種別：</td><td>所在不明</td></tr>
    @elseif($absence == 'moved')
      <tr><td class="whitespace-nowrap">不在種別：</td><td>移設</td></tr>
    @endif
    @foreach($comments as $comment)
      <tr><td class="whitespace-nowrap">備考：</td><td>{!! nl2br(e($comment)) !!}</td></tr>
    @endforeach
    @foreach($ref_urls as $ref_url)
      <tr><td class="whitespace-nowrap">参考URL：</td><td><a href="{{$ref_url}}" target="_blank" class="underline cursor-pointer">{{$ref_url}}</a></td></tr>
    @endforeach
    @foreach($model_urls as $model_url)
      <tr><td class="whitespace-nowrap">3Dモデル：</td><td><a href="{{$model_url}}" target="_blank" class="underline cursor-pointer">{{$model_url}}</a></td></tr>
    @endforeach
    @foreach($tags as $tag)
      <tr><td class="whitespace-nowrap">タグ：</td><td><a href="/all?tag={{$tag}}" class="underline cursor-pointer">{{$tag}}</a></td></tr>
    @endforeach

</table>

@auth
  @if(Auth::user()->id == $entity['user_id'] && Auth::user()->email_verified_at)
    @if(!$result_page)

      @component('components.add-prop', [
        'entity' => $entity,
        'photo_date' => $photo_date,
        'types' => $types,
        'place' => $place,
        'built_year' => $built_year,
        'built_year_ce' => $built_year_ce,
        'figure' => $figure,
        'principal' => $principal,
        'projects' => $projects,
        'tags' => $tags,
        'tags_available' => $tags_available,
        'tags_enabled' => $tags_enabled,
      ])
      @endcomponent

    @endif
  @endif
@endauth

  <script>
  var images = [];
  var max_img = -1;
  @foreach($images as $image)
    images.push("{{$image}}");
    max_img++;
  @endforeach

  function popupImage(index) {
    var html = '<img src="/images/' + images[index] + '" id="' + index + '">';
    $('#photo-popup-body').html(html);
    $('#photo-popup').modal('show');
  }

  var posX=0, moveX=0;

  $("#photo-popup-body").on("touchstart", function(event) {
    posX = event.originalEvent.touches[0].pageX;
    moveX = 0;
  });

  $('#photo-popup-body').on('touchmove', function(event) {
    var curX = event.originalEvent.touches[0].pageX;
    if(posX - curX > 70) {
      moveX = 1;
    } else if(posX - curX > -70) {
      moveX = -1;
    }
  });

  $("#photo-popup-body").on("touchend", function(event) {
    var index = parseInt($('#photo-popup-body img').attr('id'));
    if(moveX != 0) {
      index = index + moveX;
      if(!(index < 0 || max_img < index)) {
        popupImage(index);
      }
      moveX = 0;
    }
  });

  </script>

@auth
  @if(Auth::user()->email_verified_at)
    @if(!$result_page)
      <form method="POST" id="suggest_entity">
        @csrf
        <div style="margin-top:10px;" class="mb-2 text-gray-900">このデータについて改善を提案（公開されます）：</div>
        <div style="">
          <div style="" class="w-full">
            <textarea id="suggest_comment" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg w-full p-1" name="suggest_comment" maxlength="1000"></textarea>
          </div>
        </div>
        <div>
          <input type="radio" name="suggest_to" value="contributor" checked> 投稿者宛 
          <input type="radio" name="suggest_to" value="admin"> システム管理者宛
        </div>
        ● 改善提案は、位置情報の修正、<span style="border-bottom:solid 2px #FF0000;">この投稿の写真から識別できる</span>種類・造立年・像容・主尊銘など既定項目の追加や修正（<span style="border-bottom:solid 2px #FF0000;">備考の追加は除く</span>）などです。

        @if(Auth::user()->id != $entity['user_id'])
        <!-- タグ付けの提案 -->
        <div style="margin-top:10px;display:table;">
          <div style="display:table-cell;vertical-align:middle;white-space:nowrap;" class="mb-2 text-gray-900">タグ付けの提案：</div>
            <div style="display:table-cell;">
              <select id="tag_suggestion2" class="" name="tag_suggestion2" >
                <option value=""></option>
                @php
                  foreach($tags_available as $tag) {
                    if($tags_enabled) {
                      $key = array_search($tag->name, array_column($tags_enabled->toArray(), 'name'));
                      if( is_bool($key) ) {
                        if( in_array($tag->name, $tags) ) {
                          // 既にダグが付けられているので提案は無し
                        } else {
                          echo '<option value="'.$tag->name.'">'.$tag->name.'</option>';
                        }
                      } else {
                        // 権限を持っているので提案は無し
                      }
                    } else {
                      echo '<option value="'.$tag->name.'">'.$tag->name.'</option>';
                    }
                  }
                @endphp
              </select>
            </div>
          </div>
        @endif

        <div style="margin-top:10px;">
          <input type="button" id="suggest_entity_button" class="text-white bg-blue-200 font-medium rounded-lg text-sm px-5 py-2 text-center cursor-default" value="提案" disabled />
          <span style="margin-top:10px;" id="suggest_result" />
        </div>
        <input type="hidden" id="suggest_entity_id" name="suggest_entity_id" value="{{ $entity['id'] }}" />
      </form>

      @if(Auth::user()->tagging)
        <hr style="margin-top:10px;">
        <div style="margin-top:10px;">
          <form method="POST" id="tag_entity">
            @csrf
            タグの追加：<select id="add_tag" class="" name="add_tag" >
              <option value=""></option>
              @php
                foreach($tags_enabled as $tag) {
                  if( in_array($tag->name, $tags) ) {
                    // 既にダグが付けられているので追加は無し
                  } else {
                    echo '<option value="'.$tag->id.'">'.$tag->name.'</option>';
                  }
                }
              @endphp
            </select>
            <input type="hidden" id="tag_entity_id" name="tag_entity_id" value="{{ $entity['id'] }}" />
            <div style="margin-top:10px;">
              <input type="button" id="tag_entity_button" class="text-white bg-blue-600 font-medium rounded-lg text-sm px-5 py-2 text-center cursor-pointer" value="追加" />
              <span style="margin-top:10px;" id="tag_result" />
            </div>
          </form>
        </div>
      @endif

      @if(Auth::user()->id == $entity['user_id'])
        <hr style="margin-top:10px;">
        <div style="margin-top:10px;">
          <form method="POST" action="/editData">
            @csrf
            <input type="hidden" id="edit_entity_id" name="edit_entity_id" value="{{ $entity['id'] }}" />
            <input class="cursor-pointer underline" type="submit" value="このデータを詳細編集" />（上級者向け）
          </form>
        </div>
      @elseif($inactive_user)
        @if(Auth::user()->manage)
          <hr style="margin-top:10px;">
          <div style="margin-top:10px;">
            <form method="POST" action="/editData2">
              @csrf
              <input type="hidden" id="edit_entity_id" name="edit_entity_id" value="{{ $entity['id'] }}" />
              <input class="cursor-pointer underline" type="submit" value="このデータを改善" />
            </form>
          </div>
        @endif
      @elseif(Auth::user()->admin)
        <hr style="margin-top:10px;">
        <div style="margin-top:10px;">
          <form method="POST" action="/editData2">
            @csrf
            <input type="hidden" id="edit_entity_id" name="edit_entity_id" value="{{ $entity['id'] }}" />
            <input class="cursor-pointer underline" type="submit" value="管理者権限で編集" />
          </form>
        </div>
      @endif

      <script>
      var suggested = false;

      $('#suggest_comment').on('keyup', function() {
        change_suggest_submit_status();
      });

      $('#tag_suggestion2').on('change', function (e) {
        change_suggest_submit_status();
      });

      function change_suggest_submit_status() {
        if( ($('#suggest_comment').val() != '' ||
             $('#tag_suggestion2').val() != '') && !suggested) {
          $('#suggest_entity_button').prop('disabled', false);
          $('#suggest_entity_button').removeClass('bg-blue-200');
          $('#suggest_entity_button').addClass('bg-blue-600');
          $('#suggest_entity_button').removeClass('cursor-default');
          $('#suggest_entity_button').addClass('cursor-pointer');
        } else {
          $('#suggest_entity_button').prop('disabled', true);
          $('#suggest_entity_button').addClass('bg-blue-200');
          $('#suggest_entity_button').removeClass('bg-blue-600');
          $('#suggest_entity_button').addClass('cursor-default');
          $('#suggest_entity_button').removeClass('cursor-pointer');
        }
      }

      $('#suggest_entity_button').on('click', function() {
        $('#suggest_entity_button').prop('disabled', true);
        $('#suggest_entity_button').addClass('bg-blue-200');
        $('#suggest_entity_button').removeClass('bg-blue-600');
        $('#suggest_entity_button').addClass('cursor-default');
        $('#suggest_entity_button').removeClass('cursor-pointer');
        var url = "/suggestEntity";
        var formdata = new FormData($('#suggest_entity').get(0));
        $.ajax({
          url: url,
          data: formdata,
          type: 'POST',
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
          },
          processData: false,
          contentType: false,
        }).done(function(html) {
          if(html == 'OK') {
            $('#suggest_result').html(' 提案ありがとうございます');
            suggested = true;
          } else {
            $('#suggest_result').html(' 提案できませんでした');
          }
        }).fail(function() {
          $('#suggest_result').html(' 提案できませんでした');
        });
      });

      $('#tag_entity_button').on('click', function() {
        if($('#add_tag').find(":selected").val()) {
          $('#tag_entity_button').prop('disabled', true);
          $('#tag_entity_button').addClass('bg-blue-200');
          $('#tag_entity_button').removeClass('bg-blue-600');
          $('#tag_entity_button').addClass('cursor-default');
          $('#tag_entity_button').removeClass('cursor-pointer');
          var url = "/tagEntity";
          var formdata = new FormData($('#tag_entity').get(0));
          $.ajax({
            url: url,
            data: formdata,
            type: 'POST',
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            processData: false,
            contentType: false,
          }).done(function(html) {
            if(html == 'OK') {
              $('#tag_result').html(' 追加しました');
            } else {
              $('#tag_result').html(' 追加できませんでした');
            }
          }).fail(function() {
            $('#tag_result').html(' 追加できませんでした2');
          });
        }
      });

      </script>

    @endif
  @endif
@endauth
