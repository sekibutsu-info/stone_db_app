<x-app-layout>

  @push('css')
    <link rel="stylesheet" href="/js/themes/default/style.min.css" />
    <link rel="stylesheet" href="/leaflet/leaflet.css" />
    <link rel="stylesheet" href="/leaflet/L.Control.MapCenterCoord.css" type="text/css" />
    <link rel="stylesheet" href="/leaflet/L.Control.Pan.css" type="text/css" />
    <link rel="stylesheet" href="/css/index.css" />
  @endpush

  @push('scripts')
    <script type="text/javascript" src="/js/jquery-3.6.3.js"></script>
    <script type="text/javascript" src="/leaflet/leaflet.js"></script>
    <script type="text/javascript" src="/leaflet/L.Control.MapCenterCoord.js"></script>
    <script type="text/javascript" src="/leaflet/L.Control.Pan.js"></script>
    <script type="text/javascript" src="/js/muni.js"></script>
  @endpush

  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        休眠ユーザのデータを改善
    </h2>
  </x-slot>

  <div class="py-6">
    <div class="max-w-7xl mx-auto px-6">

      @if($message)
        <div class="text-base bg-white rounded-lg p-2">
          {{$message}}
        </div>
      @endif

      <table>
        <tr><td>Permalink：</td><td><a href="https://map.sekibutsu.info/archive/{{$entity['id']}}">https://map.sekibutsu.info/archive/{{$entity['id']}}</a></td></tr>
        @if($user_id != '')
          <tr><td>データ作成者：</td><td><a href="/userpage?id={{$user_id}}">{{ $nickname }}</a></td></tr>
        @else
          <tr><td>データ作成者：</td><td>{{ $nickname }}</td></tr>
        @endif
        <tr><td>データ作成日：</td><td>{{ $entity['created_at']->format('Y年 n月 j日'); }}</td></tr>
      </table>

      <div style="background-color:rgb(229 231 235);">
        <table style="overflow-y:hidden;margin-right:10px"><tr>
          @foreach($images as $image)
            <td><img src="/images/{{$image}}"
              style="margin:5px;width:auto;height:200px;object-fit:contain;">
            </td>
          @endforeach
        </tr></table>
      </div>

      <div class="py-4">
        <hr/>
      </div>

      <div id="minimap" style="height:300px;width:100%;">
      </div>
      <form method="POST" action="/move_entity">
        @csrf
        <input type="hidden" id="edit_entity_id" name="edit_entity_id" value="{{ $entity['id'] }}" />
        <input type="hidden" id="ret_page" name="ret_page" value="edit_data2" />
        <div style="margin-top:20px;">
          <label for="lat" class="mb-2 text-gray-900">緯度：</label>
          <input id="lat" class="bg-gray-200 border border-gray-300 text-gray-900 rounded-lg  w-32 p-1" type="text" name="lat" readonly />
          <label for="lon" class="mb-2 text-gray-900">経度：</label>
          <input id="lon" class="bg-gray-200 border border-gray-300 text-gray-900 rounded-lg  w-32 p-1" type="text" name="lon" readonly />
        </div>
        <div style="margin-top:10px;">
          <label for="address" class="mb-2 text-gray-900">所在地：</label>
          <input id="address" class="bg-gray-200 border border-gray-300 text-gray-900 rounded-lg w-96 p-1" type="text" name="address" readonly value="" />
          <input id="city_code" class="bg-gray-200 border border-gray-300 text-gray-900 rounded-lg w-16 p-1" type="text" name="city_code" readonly value="" />
        </div>
        <div style="margin-top:10px;">
          <input type="submit" id="move_button" class="text-white bg-blue-200 font-medium rounded-lg text-sm px-5 py-2 text-center cursor-default" value="移動" disabled />
          （操作は記録されます）<br/>
          <div style="margin-top:10px;">
            ● 移動は、より正確な石造物の位置に近付けるためにのみ使用して下さい。<br/>
            ● 石造物が移設された場合は、位置の変更はせずに「不在種別：移設」を追加し、移設後に撮影した写真で新規データを登録して下さい。<br/>
            ● 自動設定される所在地名は正しいとは限りません。緯度経度の正確さの方が重要です。<br/>
          </div>
        </div>
      </form>

      <div class="py-4">
        <hr/>
      </div>

      <form method="POST" action="/add_prop2">
        @csrf
        <div class="">
          <!-- 種類 -->
          <div style="margin-top:10px;display:table;">
            <div style="display:table-cell;vertical-align:middle;white-space:nowrap;" class="mb-2 text-gray-900">種類：</div>
            <div style="display:table-cell;">
              <select id="add_type" class="" name="add_type" >
                <option value=""></option>
                @php
                  $exist_types = explode(', ', $types);
                  $all_types = ['月待塔','三日月塔','七夜待塔','十三夜塔','十五夜塔','十六夜塔','十七夜塔','十八夜塔','十九夜塔','二十日夜塔','二十一夜塔','二十二夜塔','二十三夜塔','二十六夜塔','日待塔','庚申塔','甲子塔','巳待塔','地神塔','五神名地神塔','出羽三山塔','八日塔','湯殿山塔','御嶽山塔','道標','養蚕信仰塔','疫神塔','疱瘡神塔','龍神塔','八大龍王塔','九頭龍神塔','倶利伽羅龍王塔'];
                  foreach($all_types as $add_type) {
                    if( !in_array($add_type, $exist_types) ) {
                      echo '<option value="'.$add_type.'">'.$add_type.'</option>';
                    }
                  }
                @endphp
              </select>
            </div>
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
                <option value=""></option>
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
                <option value=""></option>
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
        <div style="margin-top:10px;">
          <input type="submit" class="text-white bg-blue-600 font-medium rounded-lg text-sm px-5 py-2 text-center cursor-pointer" value="追加" />
          （操作は記録されます）<br/>
        </div>
        <input type="hidden" name="edit_entity_id" value="{{ $entity['id'] }}" />
        <input type="hidden" name="add_property_entity_id" value="{{ $entity['id'] }}" />
      </form>

      <div class="py-4">
        <hr/>
      </div>

      <form method="POST" action="/del_prop">
        @csrf
        <input type="hidden" id="edit_entity_id" name="edit_entity_id" value="{{ $entity['id'] }}" />
        <input type="hidden" id="ret_page" name="ret_page" value="edit_data2" />
        @foreach($properties as $property)
          <input type="checkbox" name="del_prop_id[]" value="{{$property['prop_id']}}" />
          {{$property['property']}}：{{$property['value']}}<br/>
        @endforeach
        <div style="margin-top:10px;">
          チェックを付けた項目を 
          <input type="submit" id="" class="text-white bg-red-600 font-medium rounded-lg text-sm px-5 py-2 text-center cursor-pointer" value="削除" />
          （操作は記録されます）<br/>
          ● 削除は間違いを修正するための機能ですので、古くなった情報でも過去の記録として有用であれば削除しないで下さい。
        </div>
      </form>

      <div class="py-4">
        <hr/>
      </div>

      <div class="">
        <form method="POST" action="/add_sp_prop">
          @csrf
          <input type="hidden" id="edit_entity_id" name="edit_entity_id" value="{{ $entity['id'] }}" />
          <input type="hidden" id="ret_page" name="ret_page" value="edit_data2" />
          マップに示される所在地に現存しない場合の不在種別：
          <select id="absence" class="" name="absence" >
            <option name="absence" value=""> </option>
            <option name="absence" value="missing">所在不明</option>
            <option name="absence" value="moved">移設</option>
          </select><br/>
          <div style="margin-top:10px;">
            @if($has_absence)
              <input type="submit" id="" class="text-white bg-blue-200 font-medium rounded-lg text-sm px-5 py-2 text-center cursor-default" value="追加" disabled />
            @else
              <input type="submit" id="" class="text-white bg-blue-600 font-medium rounded-lg text-sm px-5 py-2 text-center cursor-pointer" value="追加" />
            @endif
            （操作は記録されます）
          </div>
      </div>

      <div class="py-2">
        </form>
        <form method="POST" action="/add_sp_prop">
          @csrf
          <input type="hidden" id="edit_entity_id" name="edit_entity_id" value="{{ $entity['id'] }}" />
          <input type="hidden" id="ret_page" name="ret_page" value="edit_data2" />
          同一石造物が既に登録済みの場合、そのデータのID：
          <input id="sameas" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg w-16 p-1" type="text" name="sameas" maxlength="10" />
          <div style="margin-top:10px;">
            <input type="submit" id="" class="text-white bg-blue-600 font-medium rounded-lg text-sm px-5 py-2 text-center cursor-pointer" value="追加" />
          （操作は記録されます）
          </div>
        </form>
      </div>

    </div>
  </div>

<script>
$(function(){
  var lat = {{$lat}};
  var lon = {{$lon}};
  var zoom = 19;

  var minimap = L.map('minimap', {
    minZoom: 16,
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

  minimap.setView([lat, lon], zoom);
  L.control.mapCenterCoord({
    latLngFormatter : function (lat, lng) {
      return '';
    }
  }).addTo(minimap);
  L.control.pan().addTo(minimap);
  update_location();

  minimap.on('moveend', function() {
    update_location();
    $('#move_button').prop('disabled', false);
    $('#move_button').removeClass('bg-blue-200');
    $('#move_button').addClass('bg-blue-600');
    $('#move_button').removeClass('cursor-default');
    $('#move_button').addClass('cursor-pointer');

  });

  // 1秒後に既存データのマーカー表示と所在地を更新
  setTimeout(function(){

    bounds = minimap.getBounds();
    minlat = bounds.getSouth();
    minlon = bounds.getWest();
    maxlat = bounds.getNorth();
    maxlon = bounds.getEast();
    var clr = '';
    $.ajax({
      url: '/local.geojson?minlat='+minlat+'&minlon='+minlon+'&maxlat='+maxlat+'&maxlon='+maxlon,
      type: 'GET',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
      }
    }).done(function(json) {
      var poiLayer = L.geoJson(json, {
        pointToLayer: function (feature, latlng) {
          if(feature['properties']['id'] == {{$entity['id']}} ) {
            clr = '#0000ff';
          } else {
            clr = '#ff0000';
          }
          return L.circleMarker(latlng, {
            radius: 3,
            color: clr,
            fill: true,
            fillColor: clr,
            fillOpacity: 1,
            interactive: false
          });
        }
      }).addTo(minimap);
    });

  }, 1000);

  function update_location() {
    lon = Math.floor(minimap.getCenter().lng*1000000)/1000000;
    lat = Math.floor(minimap.getCenter().lat*1000000)/1000000;
    $('#lon').val(lon);
    $('#lat').val(lat);
    var query = '?lat=' + lat + '&lon=' + lon;
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
      } else {
        $('#address').val('');
        $('#city_code').val('');
      }
    });
  }

});
</script>

</x-app-layout>
