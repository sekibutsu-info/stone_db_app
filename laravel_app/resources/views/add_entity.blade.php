<p>
  <div id="minimap" style="height:300px;width:100%;">
  </div>

  <form method="POST" action="" id="new_entity" enctype="multipart/form-data">

    @csrf

    <!-- 緯度経度 -->
    <div style="margin-top:20px;">
      <label for="lat" class="mb-2 text-gray-900">緯度：</label>
      <input id="lat" class="bg-gray-200 border border-gray-300 text-gray-900 rounded-lg  w-32 p-1" type="text" name="lat" readonly />
      <label for="lon" class="mb-2 text-gray-900">経度：</label>
      <input id="lon" class="bg-gray-200 border border-gray-300 text-gray-900 rounded-lg  w-32 p-1" type="text" name="lon" readonly />
    </div>
    <!-- 所在地 -->
    <div style="margin-top:10px;">
      <label for="address" class="mb-2 text-gray-900">所在地：</label>
      <input id="address" class="bg-gray-200 border border-gray-300 text-gray-900 rounded-lg w-72 p-1" type="text" name="address" readonly value="" />
      <input id="city_code" class="bg-gray-200 border border-gray-300 text-gray-900 rounded-lg w-16 p-1" type="text" name="city_code" readonly value="" />
    </div>
    <!-- 場所 -->
    <div style="margin-top:10px;">
      <label for="place" class="mb-2 text-gray-900">場所：</label>
      <input id="place" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg w-48 p-1" type="text" name="place" />
    </div>

    <!-- 種類 -->
    <div style="margin-top:10px;display:table;margin-bottom:70px;" id="jstree_container_div">
      <div style="display:table-cell;vertical-align:middle;" class="mb-2 text-gray-900">種類：</div>
      <div style="display:table-cell;">
        <div id="types_tree_div" style="display:table-row;transform:scale(1.15);transform-origin:top left;">
          <ul>
            <li data-jstree='{"icon":false}'>月待塔
              <ul>
                <li data-jstree='{"icon":false}'>三日月塔</li>
                <li data-jstree='{"icon":false}'>七夜待塔</li>
                <li data-jstree='{"icon":false}'>十三夜塔</li>
                <li data-jstree='{"icon":false}'>十五夜塔</li>
                <li data-jstree='{"icon":false}'>十六夜塔</li>
                <li data-jstree='{"icon":false}'>十七夜塔</li>
                <li data-jstree='{"icon":false}'>十八夜塔</li>
                <li data-jstree='{"icon":false}'>十九夜塔</li>
                <li data-jstree='{"icon":false}'>二十日夜塔</li>
                <li data-jstree='{"icon":false}'>二十一夜塔</li>
                <li data-jstree='{"icon":false}'>二十二夜塔</li>
                <li data-jstree='{"icon":false}'>二十三夜塔</li>
                <li data-jstree='{"icon":false}'>二十六夜塔</li>
              </ul>
            </li>
            <li data-jstree='{"icon":false,"opened":true}'>日待塔
              <ul>
                <li data-jstree='{"icon":false}'>庚申塔</li>
                <li data-jstree='{"icon":false}'>甲子塔 （子待塔、大黒天塔）</li>
                <li data-jstree='{"icon":false}'>巳待塔 （己巳塔）</li>
              </ul>
            </li>
            <li data-jstree='{"icon":false}'>地神塔 （社日塔）
              <ul>
                <li data-jstree='{"icon":false}'>五神名地神塔</li>
              </ul>
            </li>
            <li data-jstree='{"icon":false,"checkbox_disabled":true,"opened":true}'>山岳信仰塔
              <ul>
                <li data-jstree='{"icon":false}'>出羽三山塔
                  <ul>
                    <li data-jstree='{"icon":false}'>八日塔</li>
                    <li data-jstree='{"icon":false}'>湯殿山塔</li>
                  </ul>
                </li>
                <li data-jstree='{"icon":false}'>御嶽山塔 （木曽御嶽山）</li>
              </ul>
            </li>
            <li data-jstree='{"icon":false}'>道標 <span style="color:#FF0000;">※注1</span>
            </li>
            <li data-jstree='{"icon":false}'>養蚕信仰塔 （蚕神碑）
            </li>\
            <li data-jstree='{"icon":false}'>疫神塔 （疱瘡神塔）<span style="color:#FF0000;">※注2</span>
            </li>
            <li data-jstree='{"icon":false}'>龍神塔 <span style="color:#FF0000;">※注3</span>
              <ul>
                <li data-jstree='{"icon":false}'>八大龍王塔</li>
                <li data-jstree='{"icon":false}'>九頭龍神塔</li>
                <li data-jstree='{"icon":false}'>倶利伽羅龍王塔 （倶利伽羅不動塔）</li>
              </ul>
            </li>
            <li data-jstree='{"icon":false}'>大六天塔 （第六天塔）
            </li>
            <li data-jstree='{"icon":false}'>道祖神塔 （塞神塔）
            </li>
          </ul>
        </div>
      </div>
    </div>
      <div style="display:inline-block;margin-top:10px;">
        <input id="types" class="bg-gray-200 border border-gray-300 text-gray-900 rounded-lg w-96 p-1" type="text" name="types" readonly />
      </div>
    <div style="margin-top:10px;">
      ● リストにない種類の石造物は、現在はまだデータ収集の対象になっていません。対象外の石造物は登録できません。<br/>
      <span style="color:#FF0000;">※注1</span> 道標単独の場合は<span style="color:#FF0000;">昭和20年まで</span>に造立されたものに限ります。<br/>
      <span style="color:#FF0000;">※注2</span> 疫病そのものを神仏として祀るものに限ります。疫病除けや病歿者供養全般ではありません。<br/>
      <span style="color:#FF0000;">※注4</span> 原則として龍神塔は下位の分類（八大龍王塔、九頭龍神塔、倶利伽羅龍王塔）のいずれにも当てはまらない場合のみ選択して下さい。
    </div>

    <!-- 造立年 -->
    <div style="margin-top:10px;">
      <label for="built_year" class="mb-2 text-gray-900">造立年（和暦）：</label>
      <input id="built_year" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg w-32 p-1" type="text" name="built_year" maxlength="30" /> 不明は記入不要、再建塔は再建年
    </div>
    <div style="margin-top:10px;">
      <label for="built_year_ce" class="mb-2 text-gray-900">造立年（西暦）：</label>
      <input id="built_year_ce" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg w-16 p-1" type="text" name="built_year_ce"  maxlength="4" inputmode="numeric" pattern="\d*" /> 半角数字のみ
    </div>

    <!-- 像容 -->
    <div style="margin-top:10px;display:table;">
      <div style="display:table-cell;vertical-align:middle;white-space:nowrap;" class="mb-2 text-gray-900">像容（刻像塔のみ）：</div>
      <div style="display:table-cell;">
        <select id="figure" class="" name="figure" >
          <option value=""></option>
          @php
            $figures = ['地蔵','聖観音','大黒天','愛染明王','不動明王','子安観音','馬頭観音','青面金剛','勢至菩薩','大日如来','阿弥陀如来','如意輪観音'];
            foreach($figures as $figure) {
              echo '<option value="'.$figure.'">'.$figure.'</option>';
            }
          @endphp
        </select>
      </div>
    </div>

    <!-- 主尊銘 -->
    <div style="margin-top:10px;display:table;">
      <div style="display:table-cell;vertical-align:middle;white-space:nowrap;" class="mb-2 text-gray-900">主尊銘（文字塔のみ）：</div>
      <div style="display:table-cell;">
        <select id="principal" class="" name="principal" >
          <option value=""></option>
          @php
            $principals = ['大黒天','猿田彦','帝釈天','馬頭観音','青面金剛'];
            foreach($principals as $principal) {
              echo '<option value="'.$principal.'">'.$principal.'</option>';
            }
          @endphp
        </select>
      </div>
    </div>

    <!-- 画像Preveiw -->
    <div style="margin-top:10px;display:table;">
      <div style="display:table-cell;vertical-align:middle;white-space:nowrap;" class="mb-2 text-gray-900">写真プレビュー：</div>
      <div style="display:table-cell;background-color:rgb(229 231 235);" class="w-full">
        <table><tr>
          <td><img src="" id="file1_img" class="img_preview" style="margin:5px;width:auto;height:200px;object-fit:contain;"></td>
          <td><img src="" id="file2_img" class="img_preview" style="margin:5px;width:auto;height:200px;object-fit:contain;"></td>
          <td><img src="" id="file3_img" class="img_preview" style="margin:5px;width:auto;height:200px;object-fit:contain;"></td>
          <td><img src="" id="file4_img" class="img_preview" style="margin:5px;width:auto;height:200px;object-fit:contain;"></td>
          <td><img src="" id="file5_img" class="img_preview" style="margin:5px;width:auto;height:200px;object-fit:contain;"></td>
        </tr></table>
      </div>
    </div>

    <!-- 画像 -->
    <div style="margin-top:10px;">
      ● 著作権を持たない写真はアップロードしないで下さい。
      写真を投稿すると、<a href="https://creativecommons.org/licenses/by/4.0/deed.ja" target="_blank" class="underline">CC BY 4.0ライセンス</a>で公開することに同意したことになります。<br/>
      ● このデータの対象石造物とは<span style="color:#FF0000;">無関係な写真はアップロードしないで</span>下さい。<br/>
      ● 複数の投稿に<span style="color:#FF0000;">同じ写真を重複してアップロードしないで</span>下さい。<br/>
      ● <span style="color:#FF0000;">露出補正や色補正以外の加工をした画像、複数の写真を合成した画像の投稿は禁止</span>します。
    </div>
    <div style="margin-top:10px;">
      <label class="mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file1">写真1：</label>
      <input class="w-64 text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none" id="file1" name="file1" type="file" accept=".jpg"/>
    </div>
    <div style="margin-top:10px;">
      <label class="mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file2">写真2：</label>
      <input class="w-64 text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none" id="file2" name="file2" type="file" accept=".jpg"/>
    </div>
    <div style="margin-top:10px;">
      <label class="mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file3">写真3：</label>
      <input class="w-64 text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none" id="file3" name="file3" type="file" accept=".jpg"/>
    </div>
    <div style="margin-top:10px;">
      <label class="mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file4">写真4：</label>
      <input class="w-64 text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none" id="file4" name="file4" type="file" accept=".jpg"/>
    </div>
    <div style="margin-top:10px;">
      <label class="mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file5">写真5：</label>
      <input class="w-64 text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none" id="file5" name="file5" type="file" accept=".jpg"/>
    </div>

    <!-- 写真撮影日 -->
    <div style="margin-top:10px;">
      写真撮影日：
      <input type="date" id="photo_date" name="photo_date" />
      不明は記入不要 
    </div>

    <!-- プロジェクト -->
    <div style="margin-top:10px;">
      プロジェクト（任意）：
      <input type="checkbox" id="bingo" name="bingo" value="月待ビンゴ" />
      <label for="bingo" class="mb-2 text-gray-900">月待ビンゴ</label>
      <input type="hidden" id="projects" name="projects" />
    </div>

    <!-- 備考 -->
    <div style="margin-top:10px;display:table;">
      <div style="display:table-cell;vertical-align:middle;white-space:nowrap;" class="mb-2 text-gray-900">
        備考：
      </div>
      <div style="display:table-cell;" class="w-full">
        <textarea id="comment" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg w-full p-1" name="comment" maxlength="1000"></textarea>
        石造物の情報として有用な内容のみ記載して下さい。
      </div>
    </div>

    <!-- タグ付けの提案 -->
    <div style="margin-top:10px">
      タグ付けの提案：
      <select id="tag_suggestion" class="" name="tag_suggestion" >
        <option value=""></option>
        @php
          foreach($tags_available as $tag) {
            if($tags_enabled) {
              $key = array_search($tag->name, array_column($tags_enabled->toArray(), 'name'));
              if( is_bool($key) ) {
                echo '<option value="'.$tag->name.'">'.$tag->name.'</option>';
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

    <!-- ライセンス確認 -->
    <div style="margin-top:10px;" class="border-2 rounded-md p-2">
      ● 写真の著作権者である私は、投稿した写真が<strong>CC BY 4.0ライセンス</strong>で公開され、
      許諾したライセンスは取り消し不可能なことを<br>
      <input type="checkbox" id="check_license"/> 承知しました。
    </div>

    <div style="margin-top:10px;">
      <input type="button" id="submit_entity" class="text-white bg-blue-200 font-medium rounded-lg text-sm px-5 py-2 text-center cursor-default" value="登録" disabled />
    </div>

  </form>
</p>

<script>
$(function(){

  var file_selected = false;

  $('#types_tree_div')
    .jstree({
      'plugins': ['wholerow','checkbox'],
      'core': {
        'themes':{
          'stripes': true,
          'variant': 'large',
        }
      },
      'checkbox': {
        'three_state': false,
        'cascade': ''
      },
    })
    .on('changed.jstree', function(e, data) {
      var selected_types = [];
      var selected = data.instance.get_selected(true);
      for(i = 0; i< selected.length; i++) {
        var text = selected[i].text.split(' ');
        if(text[0].trim()=='山岳信仰塔') {
          $.jstree.reference('#types_tree_div').uncheck_node(data.instance.get_node(selected[i]));
        } else {
          selected_types.push(text[0]);
        }
      }
      $('#types').val(selected_types.join(','));
      change_submit_status();
    })
    .on('after_open.jstree', function(e, data) {
      update_margin_bottom();
    })
    .on('after_close.jstree', function(e, data) {
      update_margin_bottom();
    });

    function update_margin_bottom() {
      var h = $('#types_tree_div').height();
      $('#jstree_container_div').css('margin-bottom', h * 0.15);
    }

  $('#file1').on('change', function (e) {
    add_preview(e, 1);
  });
  $('#file2').on('change', function (e) {
    add_preview(e, 2);
  });
  $('#file3').on('change', function (e) {
    add_preview(e, 3);
  });
  $('#file4').on('change', function (e) {
    add_preview(e, 4);
  });
  $('#file5').on('change', function (e) {
    add_preview(e, 5);
  });

  function add_preview(e, n) {
    var file = $('#file' + n)[0].files[0];
    if( file.type == 'image/jpeg') {
      var reader = new FileReader();
      var image = new Image();
      reader.onload = function(e) {
        image.src = reader.result;
        image.onload = function() {
          if((image.naturalWidth >= 800 && image.naturalHeight >= 600) ||
             (image.naturalWidth >= 600 && image.naturalHeight >= 800)) {
            $('#file'+ n + '_img').attr('src', e.target.result);
            file_selected = true;
            change_submit_status();
          } else {
            alert('画像は800x600ピクセル以上の解像度でお願いします');
            $('#file'+ n).val(null);
          }
        }
      }
      reader.readAsDataURL(e.target.files[0]);
    } else {
      alert('ファイルタイプが不正です');
      $('#file'+ n).val(null);
      $('#file'+ n).val(null);
    }
  }

  function change_submit_status() {
    if( $('#types').val() != '' && $('#address').val() != '' && file_selected && $('#check_license').prop('checked') ) {
      $('#submit_entity').prop('disabled', false);
      $('#submit_entity').removeClass('bg-blue-200');
      $('#submit_entity').addClass('bg-blue-600');
      $('#submit_entity').removeClass('cursor-default');
      $('#submit_entity').addClass('cursor-pointer');
    } else {
      $('#submit_entity').prop('disabled', true);
      $('#submit_entity').addClass('bg-blue-200');
      $('#submit_entity').removeClass('bg-blue-600');
      $('#submit_entity').addClass('cursor-default');
      $('#submit_entity').removeClass('cursor-pointer');
    }
  }

  $('#check_license').on('click', function() {
    change_submit_status();
  });


  $('#submit_entity').on('click', function() {
    $('#projects').val('');
    if($('#bingo').prop('checked')) {
      $('#projects').val('月待ビンゴ');
    }

    // 二重送信防止
    $('#submit_entity').prop('disabled', true);
    $('#submit_entity').addClass('bg-blue-200');
    $('#submit_entity').removeClass('bg-blue-600');
    $('#submit_entity').addClass('cursor-default');
    $('#submit_entity').removeClass('cursor-pointer');

    var url = "/saveEntity";
    var formdata = new FormData($('#new_entity').get(0));
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
      $('#entity-header-message').html('データ登録結果');
      $('#entity-body').html(html);
    }).fail(function() {
      // セッションが切れていたらエラーになるのでリロード
      window.location.reload(true);
    });
  });

  var lat = {{$lat}};
  var lon = {{$lon}};
  var zoom = {{$zoom}};

  var minimap = L.map('minimap', {
    minZoom: 11,
    maxZoom: 20,
    boxZoom: false,
    doubleClickZoom: false,
    dragging: false,
    scrollWheelZoom: false,
    touchZoom: false,
  });

  // 地理院淡色
  var paleLayer = L.tileLayer(
    'https://cyberjapandata.gsi.go.jp/xyz/pale/{z}/{x}/{y}.png', {
       opacity: 0.9,
       maxNativeZoom: 18,
       maxZoom: 20,
       attribution: '<a href="https://maps.gsi.go.jp/development/ichiran.html" target="_blank">国土地理院</a>',
  }).addTo(minimap);
  // 地理院写真
  var photoLayer = L.tileLayer(
    'https://cyberjapandata.gsi.go.jp/xyz/seamlessphoto/{z}/{x}/{y}.jpg', {
       opacity: 0.9,
       maxNativeZoom: 18,
       maxZoom: 20,
       attribution: '<a href="https://maps.gsi.go.jp/development/ichiran.html" target="_blank">国土地理院</a>'
  });
  var baseLayers = {
    "標準": paleLayer,
    "写真": photoLayer,
  };
  L.control.layers(baseLayers).addTo(minimap);

  $('#entity').on('shown.bs.modal', function(){
    minimap.invalidateSize();
  });

  minimap.setView([lat, lon], zoom);
  L.control.mapCenterCoord({
    latLngFormatter : function (lat, lng) {
      return '';
    }
  }).addTo(minimap);

  L.control.pan().addTo(minimap);

  minimap.on('zoomend moveend', function() {
    set_address();
  });

  // 1秒後に既存データのマーカー表示と所在地を更新
  setTimeout(function(){

    bounds = minimap.getBounds();
    minlat = bounds.getSouth();
    minlon = bounds.getWest();
    maxlat = bounds.getNorth();
    maxlon = bounds.getEast();
    $.ajax({
      url: '/local.geojson?minlat='+minlat+'&minlon='+minlon+'&maxlat='+maxlat+'&maxlon='+maxlon,
      type: 'GET',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
      }
    }).done(function(json) {
      var poiLayer = L.geoJson(json, {
        pointToLayer: function (feature, latlng) {
          return L.circleMarker(latlng, {
            radius: 3,
            color: '#ff0000',
            fill: true,
            fillColor: '#ff0000',
            fillOpacity: 1,
            interactive: false
          });
        }
      }).addTo(minimap);
    });

    set_address();
  }, 1000);

  function set_address() {
    lon = Math.floor(minimap.getCenter().lng*1000000)/1000000;
    lat = Math.floor(minimap.getCenter().lat*1000000)/1000000;
    $('#lon').val(lon);
    $('#lat').val(lat);

    var query = '/reverseGeoCoder?lat=' + lat + '&lon=' + lon;
    $.getJSON(query, function(data){
      var pname = mname = section = '';
      if(data.address) {
        $('#address').val(data.address);
        if(data.city_code) {
          $('#city_code').val(data.city_code);
        } else {
          $('#city_code').val('');
        }
        change_submit_status();
      } else {
        $('#address').val('');
        $('#city_code').val('');
        change_submit_status();
      }
    });
  }

});
</script>
