    <hr style="margin-top:10px;">
    <div style="margin-top:10px;" class="mb-2 text-gray-900">このデータに情報を追加：</div>
    <form method="POST" id="add_property">

      <!-- 写真撮影日 -->
      @if($photo_date == '')
        <div style="margin-top:10px;">
          写真撮影日：
          <input type="date" id="photo_date" name="photo_date" />
          不明は記入不要 
        </div>
      @else
        <input id="photo_date" type="hidden" name="photo_date" />
      @endif
      <!-- 種類 -->
      <div style="margin-top:10px;display:table;">
        <div style="display:table-cell;vertical-align:middle;white-space:nowrap;" class="mb-2 text-gray-900">種類：</div>
        <div style="display:table-cell;">
          <select id="add_type" class="" name="add_type" >
            <option  value="">&emsp;</option>
            @php
              $exist_types = explode(', ', $types);
              $all_types = ['月待塔','三日月塔','七夜待塔','十三夜塔','十五夜塔','十六夜塔','十七夜塔','十八夜塔','十九夜塔','二十日夜塔','二十一夜塔','二十二夜塔','二十三夜塔','二十六夜塔','日待塔','庚申塔','甲子塔','巳待塔','地神塔','五神名地神塔','出羽三山塔','八日塔','湯殿山塔','御嶽山塔','道標','養蚕信仰塔','疫神塔','龍神塔','八大龍王塔','九頭龍神塔','倶利伽羅龍王塔','大六天塔','道祖神塔'];
              foreach($all_types as $add_type) {
                if( !in_array($add_type, $exist_types) ) {
                  echo '<option value="'.$add_type.'">'.$add_type.'</option>';
                }
              }
            @endphp
          </select>
        </div>
      </div>
      <!-- 場所 -->
      @if($place == '')
        <div style="margin-top:10px;">
         <label for="add_place" class="mb-2 text-gray-900">場所：</label>
         <input id="add_place" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg w-48 p-1" type="text" name="add_place" />
        </div>
      @else
        <input id="add_place" type="hidden" name="add_place" />
      @endif
      <!-- 造立年 -->
      @if($built_year == '')
        <div style="margin-top:10px;">
          <label for="add_built_year" class="mb-2 text-gray-900">造立年（和暦）：</label>
          <input id="add_built_year" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg w-32 p-1" type="text" name="add_built_year" maxlength="30" />
        </div>
      @else
        <input id="add_built_year" type="hidden" name="add_built_year" />
      @endif
      @if($built_year_ce == '')
      <div style="margin-top:10px;">
        <label for="add_built_year_ce" class="mb-2 text-gray-900">造立年（西暦）：</label>
        <input id="add_built_year_ce" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg w-16 p-1" type="text" name="add_built_year_ce"  maxlength="4" inputmode="numeric" pattern="\d*" /> 半角数字のみ
      </div>
      @else
        <input id="add_built_year_ce" type="hidden" name="add_built_year_ce" />
      @endif
      <!-- 像容 -->
      @if($figure == '')
        <div style="margin-top:10px;display:table;">
          <div style="display:table-cell;vertical-align:middle;white-space:nowrap;" class="mb-2 text-gray-900">像容（刻像塔のみ）：</div>
          <div style="display:table-cell;">
            <select id="add_figure" class="" name="add_figure" >
              <option  value="">&emsp;</option>
              @php
                $all_figures = ['地蔵','聖観音','大黒天','愛染明王','不動明王','子安観音','馬頭観音','青面金剛','勢至菩薩','大日如来','阿弥陀如来','如意輪観音'];
                foreach($all_figures as $add_figure) {
                  echo '<option value="'.$add_figure.'">'.$add_figure.'</option>';
                }
              @endphp
            </select>
          </div>
        </div>
      @else
        <input id="add_figure" type="hidden" name="add_figure" />
      @endif
      <!-- 主尊銘 -->
      @if($principal == '')
        <div style="margin-top:10px;display:table;">
          <div style="display:table-cell;vertical-align:middle;white-space:nowrap;" class="mb-2 text-gray-900">主尊銘（文字塔のみ）：</div>
          <div style="display:table-cell;">
            <select id="add_principal" class="" name="add_principal" >
              <option  value="">&emsp;</option>
              @php
                $all_principals = ['大黒天','猿田彦','帝釈天','馬頭観音','青面金剛'];
                foreach($all_principals as $add_principal) {
                  echo '<option value="'.$add_principal.'">'.$add_principal.'</option>';
                }
              @endphp
            </select>
          </div>
        </div>
      @else
        <input id="add_principal" type="hidden" name="add_principal" />
      @endif

      <!-- プロジェクト -->
      <div style="margin-top:10px;display:table;">
        <div style="display:table-cell;vertical-align:middle;white-space:nowrap;" class="mb-2 text-gray-900">プロジェクト：</div>
        <div style="display:table-cell;">
          <select id="add_project" class="" name="add_project" >
            <option value="">&emsp;</option>
            @php
              $all_projects = ['月待ビンゴ'];
              foreach($all_projects as $add_project) {
                if( !in_array($add_project, $projects) ) {
                  echo '<option value="'.$add_project.'">'.$add_project.'</option>';
                }
              }
            @endphp
          </select>
        </div>
      </div>

      <!-- 備考 -->
      <div style="margin-top:10px;display:table;">
        <div style="display:table-cell;vertical-align:middle;white-space:nowrap;" class="mb-2 text-gray-900">備考：</div>
        <div style="display:table-cell;" class="w-full">
          <textarea id="add_comment" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg w-full p-1" name="add_comment" maxlength="1000"></textarea>
          石造物の情報として有用な内容のみ記載して下さい。
        </div>
      </div>

      <!-- 参考URL -->
      <div style="margin-top:10px;display:table;">
        <div style="display:table-cell;vertical-align:middle;white-space:nowrap;" class="mb-2 text-gray-900">参考URL：</div>
        <div style="display:table-cell;" class="w-full">
          <input type="text" id="add_refurl" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg w-full p-1" name="add_refurl" maxlength="1000" placeholder="https://">
          この石造物について記載されたページのURLを登録して下さい。サイトのトップベージなど、この石造物についての情報が直ぐに得られないURLは不可です。
        </div>
      </div>

      <!-- 3Dモデル -->
      <div style="margin-top:10px;display:table;">
        <div style="display:table-cell;vertical-align:middle;white-space:nowrap;" class="mb-2 text-gray-900">3Dモデル：</div>
        <div style="display:table-cell;" class="w-full">
          <input type="text" id="add_3Dmodel" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg w-full p-1" name="add_3Dmodel" maxlength="1000" placeholder="https://">
          この石造物の3Dモデル（メッシュデータ）のURLを登録して下さい。
        </div>
      </div>

      <!-- タグ付けの提案 -->
      <div style="margin-top:10px;display:table;">
        <div style="display:table-cell;vertical-align:middle;white-space:nowrap;" class="mb-2 text-gray-900">タグ付けの提案：</div>
        <div style="display:table-cell;">
          <select id="tag_suggestion1" class="" name="tag_suggestion1" >
            <option  value="">&emsp;</option>
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
                    // ダグ付け権限を持っているので提案は無し
                  }
                } else {
                  if( in_array($tag->name, $tags) ) {
                    // 既にダグが付けられているので提案は無し
                  } else {
                    echo '<option value="'.$tag->name.'">'.$tag->name.'</option>';
                  }
                }
              }
            @endphp
          </select>
        </div>
      </div>

      <div style="margin-top:10px;">
        <input type="button" id="add_property_button" class="text-white bg-blue-200 font-medium rounded-lg text-sm px-5 py-2 text-center cursor-default" value="追加" disabled />
        <span style="margin-top:10px;" id="add_property_result" />
      </div>
      <input type="hidden" id="add_property_entity_id" name="add_property_entity_id" value="{{ $entity['id'] }}" />
    </form>
    <hr style="margin-top:10px;">

  <script>
  var added = false;

  $('#photo_date').on('change', function (e) {
    change_add_property_button_status();
  });
  $('#add_type').on('change', function (e) {
    change_add_property_button_status();
  });
  $('#add_place').on('change', function (e) {
    change_add_property_button_status();
  });
  $('#add_built_year').on('change', function (e) {
    change_add_property_button_status();
  });
  $('#add_built_year_ce').on('change', function (e) {
    change_add_property_button_status();
  });
  $('#add_figure').on('change', function (e) {
    change_add_property_button_status();
  });
  $('#add_principal').on('change', function (e) {
    change_add_property_button_status();
  });
  $('#add_project').on('change', function (e) {
    change_add_property_button_status();
  });
  $('#add_comment').on('keyup', function() {
    change_add_property_button_status();
  });
  $('#add_refurl').on('keyup', function() {
    change_add_property_button_status();
  });
  $('#add_3Dmodel').on('keyup', function() {
    change_add_property_button_status();
  });
  $('#tag_suggestion1').on('change', function (e) {
    change_add_property_button_status();
  });

  function change_add_property_button_status () {
    if( ($('#add_comment').val() != '' ||
         $('#add_refurl').val() != '' ||
         $('#add_3Dmodel').val() != '' ||
         $('#photo_date').val() != '' ||
         $('#add_type').val() != '' ||
         $('#add_place').val() != '' ||
         $('#add_built_year').val() != '' ||
         $('#add_built_year_ce').val() != '' ||
         $('#add_figure').val() != '' ||
         $('#add_principal').val() != '' ||
         $('#add_project').val() != '' ||
         $('#tag_suggestion1').val() != '') && !added) {
      $('#add_property_button').prop('disabled', false);
      $('#add_property_button').removeClass('bg-blue-200');
      $('#add_property_button').addClass('bg-blue-600');
      $('#add_property_button').removeClass('cursor-default');
      $('#add_property_button').addClass('cursor-pointer');
    } else {
      $('#add_property_button').prop('disabled', true);
      $('#add_property_button').addClass('bg-blue-200');
      $('#add_property_button').removeClass('bg-blue-600');
      $('#add_property_button').addClass('cursor-default');
      $('#add_property_button').removeClass('cursor-pointer');
    }
  }

  $('#add_property_button').on('click', function() {
    $('#add_property_button').prop('disabled', true);
    $('#add_property_button').addClass('bg-blue-200');
    $('#add_property_button').removeClass('bg-blue-600');
    $('#add_property_button').addClass('cursor-default');
    $('#add_property_button').removeClass('cursor-pointer');
    var url = "/addProperty";
    var formdata = new FormData($('#add_property').get(0));
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
        $('#add_property_result').html(' 追加しました');
        added = true;
      } else {
        $('#add_property_result').html(' 追加できませんでした');
      }
    }).fail(function() {
      $('#add_property_result').html(' 追加できませんでした');
    });
  });
  </script>
