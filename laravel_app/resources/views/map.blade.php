<x-app-layout>
  @isset($og_title)
    @isset($og_image)
      @push('ogp')
        <meta property="og:image" content="https://map.sekibutsu.info/images/{{ $og_image }}" />
        <meta property="og:title" content="{{ $og_title }}" />
        {{-- インデックスさせない --}}
        <meta name="robots" content="noindex">
      @endpush
    @else
      @push('ogp')
        <meta property="og:image" content="https://map.sekibutsu.info/icon.png" />
        <meta property="og:title" content="{{ $og_title }}" />
      @endpush
    @endisset
  @else
    @push('ogp')
      <meta property="og:image" content="https://map.sekibutsu.info/icon.png" />
      <meta property="og:title" content="みんなで石仏調査" />
    @endpush
  @endisset

  @push('css')
    <link rel="stylesheet" href="/js/themes/default/style.min.css" />
    <link rel="stylesheet" href="/leaflet/leaflet.css" />
    <link rel="stylesheet" href="/leaflet/L.Control.Locate.min.css" type="text/css" />
    <link rel="stylesheet" href="/leaflet/MarkerCluster.css" type="text/css" />
    <link rel="stylesheet" href="/leaflet/MarkerCluster.Default.css" type="text/css" />
    <link rel="stylesheet" href="/leaflet/leaflet.extra-markers.min.css" type="text/css" />
    <link rel="stylesheet" href="/leaflet/Control.Geocoder.css" type="text/css" />
    <link rel="stylesheet" href="/leaflet/L.Control.MapCenterCoord.css" type="text/css" />
    <link rel="stylesheet" href="/leaflet/easy-button.css" type="text/css" />
    <link rel="stylesheet" href="/leaflet/L.Control.Pan.css" type="text/css" />
    <link rel="stylesheet" href="/leaflet/L.Control.SlideMenu.css" type="text/css" />
    <link rel="stylesheet" href="/css/font-awesome.min.css" type="text/css" />
    <link rel="stylesheet" href="/css/index.css" />
  @endpush

  @push('scripts')
    <script type="text/javascript" src="/js/jquery-3.6.3.js"></script>
    <script type="text/javascript" src="/js/jstree.min.js"></script>
    <script type="text/javascript" src="/js/exif.js"></script>
    <script type="text/javascript" src="/leaflet/leaflet.js"></script>
    <script type="text/javascript" src="/leaflet/L.Control.Locate.min.js"></script>
    <script type="text/javascript" src="/leaflet/leaflet.markercluster.js"></script>
    <script type="text/javascript" src="/leaflet/leaflet.extra-markers.min.js"></script>
    <script type="text/javascript" src="/leaflet/Control.Geocoder.js"></script>
    <script type="text/javascript" src="/leaflet/L.Control.MapCenterCoord.js"></script>
    <script type="text/javascript" src="/leaflet/easy-button.js"></script>
    <script type="text/javascript" src="/leaflet/L.Control.Pan.js"></script>
    <script type="text/javascript" src="/leaflet/L.Control.SlideMenu.js"></script>
    <script type="text/javascript" src="/js/muni.js"></script>
  @endpush

  <div id="mapdiv" style="position:absolute;width:100%;top:41px;bottom:0;">
  </div>

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

  <div id="about" class="modal fade fixed top-0 left-0 hidden w-full h-full outline-none overflow-x-hidden overflow-y-auto"
       tabindex="-1" aria-labelledby="exampleModalScrollableLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable relative w-auto pointer-events-none">
      <div class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none text-current">
        <div class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 rounded-t-md">
          <h5 class="text-xl font-medium leading-normal text-gray-800" id="exampleModalScrollableLabel">
            みんなで石仏調査 について
          </h5>
          <button type="button"
                  class="btn-close box-content w-4 h-4 p-1 text-black border-none rounded-none opacity-50 focus:shadow-none focus:outline-none focus:opacity-100 hover:text-black hover:opacity-75 hover:no-underline"
                  data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body relative p-4">
          @component('components.about-common', ['num_data' => $num_data])
          @endcomponent
        </div>
        <div class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-end p-4 border-t border-gray-200 rounded-b-md">
          <button type="button"
                  class="inline-block px-6 py-2.5 bg-gray-700 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-gray-900 hover:shadow-lg focus:bg-gray-900 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-gray-900 active:shadow-lg transition duration-150 ease-in-out"
                  data-bs-dismiss="modal">
            閉じる
          </button>
        </div>
      </div>
    </div>
  </div>

  <script>
$(function(){

  var marker_array = {};
  var markerCluster;
  let currentRequest = null;

  var filter_year = false; // 造立年によるフィルタリング

  //
  // マーカーの表示
  //
  function show_marker(json) {

    if(markerCluster) {
      map.removeLayer(markerCluster);
      marker_array = {};
    }

    markerCluster = L.markerClusterGroup({
      maxClusterRadius: 20,
      showCoverageOnHover: false
    });

    markers = L.geoJson(json, {
      pointToLayer: function(point, latlng) {

        var text = '<table>';
        var marker_color = 'green';
        if( point.properties.absence ) {
          marker_color = 'white';
        }
        if( point.properties.type ) {
          text += '<tr><td align="center" class="text-base">' + point.properties.type.join(',') + '</td></tr>';
        }
        if( point.properties.address ) {
          text += '<tr><td>' + point.properties.address;
          if( point.properties.place ) {
            text += '<br/>' + point.properties.place + '</td></tr>';
          } else {
            text += '</td></tr>';
          }
        }
        if( point.properties.built_year ) {
          text += '<tr><td>' + point.properties.built_year;
          if( point.properties.built_year_ce ) {
            text += '&nbsp（' + point.properties.built_year_ce + '）</td></tr>';
          } else {
            text += '</td></tr>';
          }
        }
        if( point.properties.figure ) {
          text += '<tr><td>像容：' + point.properties.figure + '</td></tr>';
        }
        if( point.properties.principal ) {
          text += '<tr><td>主尊銘：' + point.properties.principal + '</td></tr>';
        }
        var attr = point.properties.contributor;
        text += '<tr><td>&copy;' +  attr + ' (<a href="https://creativecommons.org/licenses/by/4.0/deed.ja" target="_blank">CC BY 4.0</a>)</td></tr>';

        if(point.properties.image) {
          text += '<div id="carouselExampleIndicators" class="carousel slide relative" data-bs-ride="carousel">' +
                  '<div class="carousel-indicators absolute right-0 bottom-0 left-0 flex justify-center p-0 mb-4">' +
                  '<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>';
          if(point.properties.image[1]) {
            text += '<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>';
          }
          if(point.properties.image[2]) {
            text += '<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>';
          }
          if(point.properties.image[3]) {
            text += '<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3" aria-label="Slide 4"></button>';
          }
          if(point.properties.image[4]) {
            text += '<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="4" aria-label="Slide 5"></button>';
          }
          text += '</div>' +
                  '<div class="carousel-inner relative w-full overflow-hidden">' +
                  '<div class="carousel-item active float-left w-full">' +
                  '<img src="/images/' + point.properties.image[0] + '" class="block w-full">' +
                  '</div>';
          if(point.properties.image[1]) {
            text += '<div class="carousel-item float-left w-full">' +
                    '<img src="/images/' + point.properties.image[1] + '" class="block w-full">' +
                    '</div>';
          }
          if(point.properties.image[2]) {
            text += '<div class="carousel-item float-left w-full">' +
                    '<img src="/images/' + point.properties.image[2] + '" class="block w-full">' +
                    '</div>';
          }
          if(point.properties.image[3]) {
            text += '<div class="carousel-item float-left w-full">' +
                    '<img src="/images/' + point.properties.image[3] + '" class="block w-full">' +
                    '</div>';
          }
          if(point.properties.image[4]) {
            text += '<div class="carousel-item float-left w-full">' +
                    '<img src="/images/' + point.properties.image[4] + '" class="block w-full">' +
                    '</div>';
          }
          text += '</div>' +
                  '<button class="carousel-control-prev absolute top-0 bottom-0 flex items-center justify-center p-0 text-center border-0 hover:outline-none hover:no-underline focus:outline-none focus:no-underline left-0"' +
                  '        type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">' +
                  '<span class="carousel-control-prev-icon inline-block bg-no-repeat" aria-hidden="true"></span>' +
                  '<span class="visually-hidden">Previous</span>' +
                  '</button>' +
                  '<button class="carousel-control-next absolute top-0 bottom-0 flex items-center justify-center p-0 text-center border-0 hover:outline-none hover:no-underline focus:outline-none focus:no-underline right-0"' +
                  '        type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">' +
                  '<span class="carousel-control-next-icon inline-block bg-no-repeat" aria-hidden="true"></span>' +
                  '<span class="visually-hidden">Next</span>' +
                  '</button>' +
                  '</div>';
        }
        text += '</table>';
        text += '<button type="button" class="bg-blue-500 text-white h-6 my-2 w-full rounded" onClick="javascript:show_entity(' + point.properties.id + ');">詳細</button>';

        marker = L.marker(latlng, {
          icon: L.ExtraMarkers.icon({
            shape: 'penta',
            markerColor: marker_color,
          }),
        }).bindPopup(text);

        marker_array[String(point.properties.id)] = marker;
        return marker;
      }

    });

    markers.addTo(markerCluster);
    markerCluster.addTo(map);

  }

  $.ajaxSetup({ cache: false });

  var map = L.map('mapdiv', {
    @if($maptype=='all' || $maptype=='mymap')
      minZoom: 5,
    @elseif($maptype=='default')
      minZoom: 12,
    @else
      minZoom: 12,
    @endif
    maxZoom: 19,
  });

  // centerとzoomが決定してから追加
  map.on('load', function() {
    var coord = L.control.mapCenterCoord({
      latLngFormatter : function (lat, lng) {
        return lat.toFixed(6) + ',' + lng.toFixed(6);
      }
    }).addTo(map);
  });

  // 地理院地図
  var layer = L.tileLayer(
    'https://cyberjapandata.gsi.go.jp/xyz/pale/{z}/{x}/{y}.png', {
       opacity: 0.5,
       maxNativeZoom: 18,
       maxZoom: 19,
       attribution: '<a href="https://maps.gsi.go.jp/development/ichiran.html" target="_blank">国土地理院</a>',
  }).addTo(map);
  // 地理院写真
  var pLayer = L.tileLayer(
    'https://cyberjapandata.gsi.go.jp/xyz/seamlessphoto/{z}/{x}/{y}.jpg', {
       opacity: 0.7,
       maxNativeZoom: 18,
       maxZoom: 19,
       attribution: '<a href="https://maps.gsi.go.jp/development/ichiran.html" target="_blank">国土地理院</a>'
  });
  var layers = {
    "標準": layer,
    "写真": pLayer,
  };
  L.control.layers(layers).addTo(map);

  L.control.locate({
    position: 'topright',
    drawCircle: false, 
    setView: 'once',
    follow: false,
    keepCurrentZoomLevel: false,
    strings: {
      title: "現在地"
    }
  }).addTo(map);

  L.Control.geocoder({
    geocoder: new L.Control.Geocoder.Nominatim({
      serviceUrl: 'https://geotool.midoriit.com/'
    }),
    defaultMarkGeocode: false,
    placeholder: '地名検索...'
  })
  .on('markgeocode', function(e) {
    if(map.getZoom()<15){
      map.setView(e.geocode.center, 15);
    } else {
      map.setView(e.geocode.center);
    }
    update_map();
  })
  .addTo(map);

  var lat=0, lon=0, zoom=0, e_id=0;
  var pstr = location.search.substring(1);
  if(pstr) {
    var parr = pstr.split('&');
    var ppair;
    for (i = 0; i < parr.length; i++) {
      ppair = parr[i].split('=');
      switch (ppair[0]){
        case 'x':
          lon = ppair[1];
          break;
        case 'y':
          lat = ppair[1];
          break;
        case 'z':
          zoom = ppair[1];
          break;
        case 'e':
          e_id = ppair[1];
          break;
      }
    }
  }

  if(lat != 0 && lon != 0 && zoom != 0) {
    map.setView([lat, lon], zoom);
  } else {
    @if($maptype == 'default')
      map.setView([35.658099, 139.741357], 12); // 経緯度原点
    @elseif($maptype=='all')
      @isset($tags)
        map.setView([35.658099, 139.741357], 5); // 経緯度原点
      @endisset
    @endif
  }

  @if($maptype=='mymap')
    $.ajax({
      url: '/my_stone_db.geojson',
      type: 'GET',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
      }
    }).done(function(json) {
      show_marker(json);
      if( Object.keys(marker_array).length != 0 ) {
        if(lat != 0 && lon != 0 && zoom != 0) {
          // setView済
        } else {
          map.fitBounds(markers.getBounds());
        }
      }
    });
  @elseif($maptype=='all')
    @isset($tags)
      @php
        $param = implode(',', $tags);
      @endphp

      $.ajax({
        url: '/tags.geojson?tag={{$param}}',
        type: 'GET',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        }
      }).done(function(json) {
        show_marker(json);
        map.fitBounds(markers.getBounds());
      });
    @else
      $.getJSON("/stone_db.geojson", function(json) {
        show_marker(json);
        if(lat != 0 && lon != 0 && zoom != 0) {
          // setView済
          if(e_id != 0) {
            if( marker_array[String(e_id)] ) {
              marker_array[String(e_id)].openPopup();
              // show_entity(e_id);
            }
          }
        } else {
          map.fitBounds(markers.getBounds());
        }
      });
    @endisset
  @else
    bounds = map.getBounds();
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
      show_marker(json);
      if(e_id != 0) {
        if( marker_array[String(e_id)] ) {
          marker_array[String(e_id)].openPopup();
          // show_entity(e_id);
        }
      }
    });
  @endif

  map.on('moveend', function() {
    @isset($tags)
      @php
        $param = implode(',', $tags);
      @endphp
      history.replaceState(null, null, "?x=" + Math.floor(map.getCenter().lng*1000000)/1000000 +
                                       "&y=" + Math.floor(map.getCenter().lat*1000000)/1000000 + 
                                       "&z=" + map.getZoom() +
                                       "&tag={{$param}}");
    @else
      history.replaceState(null, null, "?x=" + Math.floor(map.getCenter().lng*1000000)/1000000 +
                                       "&y=" + Math.floor(map.getCenter().lat*1000000)/1000000 + 
                                       "&z=" + map.getZoom());
    @endisset

    @if($maptype == 'default')
      if( !(map.getContainer().querySelector('.leaflet-popup')) ) {
        update_map();
      }
    @endif
  });

  @if($maptype == 'default')
    map.on('zoomlevelschange', function() {
      update_map();
    });
    map.on('resize', function() {
      //update_map();
    });
    map.on('zoomend', function() {
      update_map();
    });

    function update_map() {
      bounds = map.getBounds();
      minlat = bounds.getSouth();
      minlon = bounds.getWest();
      maxlat = bounds.getNorth();
      maxlon = bounds.getEast();

      // 前のリクエストが完了していなければ中止する
      if (currentRequest && currentRequest.readyState !== 4) {
        currentRequest.abort();
      }

      currentRequest = $.ajax({
        url: '/local.geojson?minlat='+minlat+'&minlon='+minlon+'&maxlat='+maxlat+'&maxlon='+maxlon,
        type: 'GET',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        }
      }).done(function(json) {
        show_marker(json);
        update_markers();      // フィルタリング
      });
    }
  @endif

  window.show_entity = function(id) {
    var url = "/getEntity";
    var data = {id: id};
    $.ajax({
      url: url,
      data: data,
      type: 'POST',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
      }
    }).done(function(html) {

      history.replaceState(null, null, "?x=" + Math.floor(map.getCenter().lng*1000000)/1000000 +
                                       "&y=" + Math.floor(map.getCenter().lat*1000000)/1000000 +
                                       "&z=" + map.getZoom() + 
                                       "&e=" + id);
      $('#entity-header-message').html('データ詳細');
      $('#entity-body').html(html);
      $('#entity').modal('show');
    }).fail(function() {
      // セッションが切れていたらエラーになるのでリロード
      window.location.reload(true);
    });
  };

  L.easyButton('fa fa-info fa-lg',
    function() {
      $('#about').modal('show');
    },
    'このサイトについて',
    null, {
      position:  'bottomright'
    }).addTo(map);

  L.control.slideMenu(
   '<div class="px-2.5 text-base">\
      種類の選択 <span id="filter_type" class="text-sm">（フィルタリング無効）</span>\
    </div>\
    <div class="px-2.5">\
      <button id="uncheck_all_type" class="bg-gray-500 text-white h-6 my-2 w-24 rounded">すべてOFF</button>\
      <button id="check_all_type" class="bg-gray-500 text-white h-6 my-2 w-24 rounded">すべてON</button>\
    </div>\
    <div id="select_type_div">' +
    @component('components.tree-common', [])
    @endcomponent
    + '</div>',
    {"width": "300px",
      "height": "auto",
      "icon": "fa-filter fa-lg",
      "title": "種類の選択",
    }
  ).addTo(map);

  @if($maptype=='all')
    L.control.slideMenu(
      '<div class="px-2.5 text-base">\
        像容の選択 <span id="filter_figure" class="text-sm">（フィルタリング無効）</span>\
      </div>\
      <div class="px-2.5">\
        <button id="uncheck_all_figure" class="bg-gray-500 text-white h-6 my-2 w-24 rounded">すべてOFF</button>\
        <button id="check_all_figure" class="bg-gray-500 text-white h-6 my-2 w-24 rounded">すべてON</button>\
      </div>\
      <div id="select_figure_div">\
        <ul>\
          <li data-jstree=\'{"icon":false}\'>地蔵</li>\
          <li data-jstree=\'{"icon":false}\'>聖観音</li>\
          <li data-jstree=\'{"icon":false}\'>大黒天</li>\
          <li data-jstree=\'{"icon":false}\'>愛染明王</li>\
          <li data-jstree=\'{"icon":false}\'>不動明王</li>\
          <li data-jstree=\'{"icon":false}\'>子安観音</li>\
          <li data-jstree=\'{"icon":false}\'>馬頭観音</li>\
          <li data-jstree=\'{"icon":false}\'>青面金剛</li>\
          <li data-jstree=\'{"icon":false}\'>勢至菩薩</li>\
          <li data-jstree=\'{"icon":false}\'>大日如来</li>\
          <li data-jstree=\'{"icon":false}\'>阿弥陀如来</li>\
          <li data-jstree=\'{"icon":false}\'>如意輪観音</li>\
        </ul>\
      </div>',
      {"width": "300px",
        "height": "auto",
        "icon": "fa-user fa-lg",
        "title": "像容の選択",
      }
    ).addTo(map);

    L.control.slideMenu(
      '<div class="px-2.5 text-base">\
        主尊銘の選択 <span id="filter_principal" class="text-sm">（フィルタリング無効）</span>\
      </div>\
      <div class="px-2.5">\
        <button id="uncheck_all_principal" class="bg-gray-500 text-white h-6 my-2 w-24 rounded">すべてOFF</button>\
        <button id="check_all_principal" class="bg-gray-500 text-white h-6 my-2 w-24 rounded">すべてON</button>\
      </div>\
      <div id="select_principal_div">\
        <ul>\
          <li data-jstree=\'{"icon":false}\'>大黒天</li>\
          <li data-jstree=\'{"icon":false}\'>猿田彦</li>\
          <li data-jstree=\'{"icon":false}\'>帝釈天</li>\
          <li data-jstree=\'{"icon":false}\'>馬頭観音</li>\
          <li data-jstree=\'{"icon":false}\'>青面金剛</li>\
        </ul>\
      </div>',
      {"width": "300px",
        "height": "auto",
        "icon": "fa-font fa-lg",
        "title": "主尊銘の選択",
      }
    ).addTo(map);

    const MIN_YEAR = 1600;
    const MAX_YEAR = 2025;

    L.control.slideMenu(
      '<div class="px-2.5 text-base">\
        年範囲選択 <span id="filter_year" class="text-sm">（フィルタリング無効）</span>\
      </div>\
      <div class="px-2.5">\
          <label for="startYear">開始年:</label>\
          <input type="range" id="sliderStartYear" style="width:250px;" min="' + MIN_YEAR + '" max="' + MAX_YEAR + '" value="' + MIN_YEAR + '">\
          <span id="startYearValue">' + MIN_YEAR + '</span>\
      </div>\
      <div class="px-2.5">\
          <label for="endYear">終了年:</label>\
          <input type="range" id="sliderEndYear" style="width:250px;" min="' + MIN_YEAR + '" max="' + MAX_YEAR + '" value="' + MAX_YEAR + '">\
          <span id="endYearValue">2025</span>\
      </div>\
      <div class="px-2.5 text-sm">\
        造立年の範囲でフィルタリングします。<br>\
        （◀▶キーでスライダーを微調整）<br>\
        <button id="set_year_button" class="bg-blue-500 text-white h-6 my-2 w-24 rounded">設定</button>\
        <button id="reset_year_button" class="bg-blue-500 text-white h-6 my-2 w-24 rounded">リセット</button>\
      </div>\
      </div>',
      {"width": "350px",
        "height": "auto",
        "icon": "fa-clock-o fa-lg",
        "title": "年範囲選択",
      }
    ).addTo(map);

    L.control.slideMenu(
      '<div class="px-2.5 text-base">\
        文字列検索\
      </div>\
      <div class="px-2.5" id="search_comment_div">\
        <textarea id="search_comment" class="w-full"></textarea>\
      </div>\
      <div class="px-2.5 text-sm">\
        備考欄に含まれる文字列でフィルタリングします。正規表現も使えます。\
      <div class="px-2.5">\
        <button id="search_comment_button" class="bg-blue-500 text-white h-6 my-2 w-24 rounded">検索</button>\
        <button id="reset_comment_button" class="bg-blue-500 text-white h-6 my-2 w-24 rounded">リセット</button>\
      </div>\
      </div>',
      {"width": "300px",
        "height": "auto",
        "icon": "fa-search fa-lg",
        "title": "文字列検索",
      }
    ).addTo(map);
  @endif

  L.control.slideMenu(
   '<div class="p-2.5 text-base">\
      マーカーの強調表示\
    </div>\
    <div id="select_marker_div">' +
    @component('components.tree-common', [])
    @endcomponent
    + '</div>',
    {"width": "300px",
      "height": "auto",
      "icon": "fa-map-marker fa-lg",
      "title": "マーカーの強調表示",
    }
  ).addTo(map);

    $('#sliderStartYear').on('input', function() {
      const startYear = parseInt($('#sliderStartYear').val());
      $('#startYearValue').text(startYear);
      updateYearSlider();
    });
    $('#sliderEndYear').on('input', function() {
      const endYear = parseInt($('#sliderEndYear').val());
      $('#endYearValue').text(endYear);
      updateYearSlider();
    });
    function updateYearSlider() {
      const startYear = parseInt($('#sliderStartYear').val());
      const endYear = parseInt($('#sliderEndYear').val());
      if(startYear > endYear) {
        $('#sliderStartYear').val(endYear);
        $('#startYearValue').text(endYear);
      }
      if(endYear < startYear) {
        $('#sliderEndYear').val(startYear);
        $('#endYearValue').text(startYear);
      }
    }
    $('#set_year_button').on('click', function() {
      filter_year = true;
      $('#filter_year').text('（フィルタリング有効）');
      update_markers();
    });
    $('#reset_year_button').on('click', function() {
      filter_year = false;
      $('#filter_year').text('（フィルタリング無効）');
      update_markers();
      $('#sliderStartYear').val(MIN_YEAR);
      $('#startYearValue').text(MIN_YEAR);
      $('#sliderEndYear').val(MAX_YEAR);
      $('#endYearValue').text(MAX_YEAR);
    });

    $('#check_all_type').on('click', function() {
      $.jstree.reference('#select_type_div').check_all(false);
      update_markers();
    });
    $('#check_all_figure').on('click', function() {
      $.jstree.reference('#select_figure_div').check_all(false);
      update_markers();
    });
    $('#check_all_principal').on('click', function() {
      $.jstree.reference('#select_principal_div').check_all(false);
      update_markers();
    });

    $('#uncheck_all_type').on('click', function() {
      $.jstree.reference('#select_type_div').uncheck_all(false);
      update_markers();
    });
    $('#uncheck_all_figure').on('click', function() {
      $.jstree.reference('#select_figure_div').uncheck_all(false);
      update_markers();
    });
    $('#uncheck_all_principal').on('click', function() {
      $.jstree.reference('#select_principal_div').uncheck_all(false);
      update_markers();
    });

    var filter_comment = false;
  @if($maptype=='all')
    $('#search_comment_button').on('click', function() {
      if( $('#search_comment').val().trim() != '' ) {
        filter_comment = true;
        update_markers();
      }
    });
    $('#reset_comment_button').on('click', function() {
      filter_comment = false;
      $('#search_comment').val('');
      update_markers();
    });
  @endif

    $('#select_type_div').jstree({
      'plugins': ['wholerow','checkbox'],
      'core': {
        'themes':{
          'stripes': true,
          'variant': 'large',
        }
      },
      'checkbox': {
        'three_state': false,
        'tie_selection': false,
      'cascade': ''},
    })
    .on('check_node.jstree', function(e, data) {
      update_markers();
    })
    .on('uncheck_node.jstree', function(e, data) {
      update_markers();
    });

  @if($maptype=='all')
    $('#select_figure_div').jstree({
      'plugins': ['wholerow','checkbox'],
      'core': {
        'themes':{
          'stripes': true,
          'variant': 'large',
        }
      },
      'checkbox': {
        'three_state': false,
        'tie_selection': false,
      'cascade': ''},
    })
    .on('check_node.jstree', function(e, data) {
      update_markers();
    })
    .on('uncheck_node.jstree', function(e, data) {
      update_markers();
    });

    $('#select_principal_div').jstree({
      'plugins': ['wholerow','checkbox'],
      'core': {
        'themes':{
          'stripes': true,
          'variant': 'large',
        }
      },
      'checkbox': {
        'three_state': false,
        'tie_selection': false,
      'cascade': ''},
    })
    .on('check_node.jstree', function(e, data) {
      update_markers();
    })
    .on('uncheck_node.jstree', function(e, data) {
      update_markers();
    });
  @endif

    $('#select_marker_div').jstree({
      'plugins': ['wholerow','checkbox'],
      'core': {
        'themes':{
          'stripes': true,
          'variant': 'large',
        }
      },
      'checkbox': {
        'three_state': false,
        'tie_selection': false,
      'cascade': ''},
    })
    .on('check_node.jstree', function(e, data) {
      update_markers();
    })
    .on('uncheck_node.jstree', function(e, data) {
      update_markers();
    });

    $.jstree.reference('#select_type_div').check_all(false);
  @if($maptype=='all')
    $.jstree.reference('#select_figure_div').check_all(false);
    $.jstree.reference('#select_principal_div').check_all(false);
  @endif

    function update_markers() {
      var selected_types = [];
      var selected_figures = [];
      var selected_principals = [];
      var featured_types = [];
      var checked_types = $.jstree.reference('#select_type_div').get_checked(true);
      checked_types.forEach( function(checked_type) {
        selected_types.push((checked_type.text.split(' '))[0]);
      });
  @if($maptype=='all')
      var checked_figures = $.jstree.reference('#select_figure_div').get_checked(true);
      checked_figures.forEach( function(checked_figure) {
        selected_figures.push((checked_figure.text.split(' '))[0]);
      });
      var checked_principals = $.jstree.reference('#select_principal_div').get_checked(true);
      checked_principals.forEach( function(checked_principal) {
        selected_principals.push((checked_principal.text.split(' '))[0]);
      });
  @endif
      var checked_markers = $.jstree.reference('#select_marker_div').get_checked(true);
      checked_markers.forEach( function(featured_type) {
        featured_types.push((featured_type.text.split(' '))[0]);
      });
      // var checked_tags = $('#search_tag').val().trim().replaceAll("　", " ").split(' ');

      var filter_type = filter_figure = filter_principal = true;

      // ★<li>の数は表示状態で変わるため、即値で比較
      if(selected_types.length == 34 || selected_types.length == 0) {
        filter_type = false;
        $('#filter_type').text('（フィルタリング無効）');
      } else {
        $('#filter_type').text('（フィルタリング有効）');
      }
      if(selected_figures.length == 12 || selected_figures.length == 0) {
        filter_figure = false;
        $('#filter_figure').text('（フィルタリング無効）');
      } else {
        $('#filter_figure').text('（フィルタリング有効）');
      }
      if(selected_principals.length == 5 || selected_principals.length == 0) {
        filter_principal = false;
        $('#filter_principal').text('（フィルタリング無効）');
      } else {
        $('#filter_principal').text('（フィルタリング有効）');
      }

      const startYear = parseInt($('#sliderStartYear').val());
      const endYear = parseInt($('#sliderEndYear').val());

      Object.keys(marker_array).forEach( function(key){
        var show_type = show_figure = show_principal = show_comment = show_year = false;
        var marker = marker_array[key];
        if(!filter_type) {
          show_type = true;
        } else {
          if( marker.feature.properties.type ) {
            marker.feature.properties.type.forEach( function(type) {
              if(selected_types.includes(type)) {
                show_type = true;
              }
            });
          }
        }
        if(!filter_figure) {
          show_figure = true;
        } else {
          if( marker.feature.properties.figure ) {
            if(selected_figures.includes(marker.feature.properties.figure)) {
              show_figure = true;
            }
          }
        }
        if(!filter_principal) {
          show_principal = true;
        } else {
          if( marker.feature.properties.principal ) {
            if(selected_principals.includes(marker.feature.properties.principal)) {
              show_principal = true;
            }
          }
        }
        if(filter_comment) {
          if( marker.feature.properties.comment ) {
            marker.feature.properties.comment.forEach( function(comment) {
              var s_comment = new String(comment);  // 備考が数値の場合に対処
              if( s_comment.search( $('#search_comment').val()) !== -1 ) {
                  show_comment = true;
              }
            });
          }
        } else {
          show_comment = true;
        }
        /*
        if(filter_tag) {
          if( marker.feature.properties.tag ) {
            marker.feature.properties.tag.forEach( function(tag) {
              checked_tags.forEach( function(checked_tag) {
                if( tag == checked_tag ) {
                  show_tag = true;
                }
              });
            });
          }
        } else {
          show_tag = true;
        }
        */

        if(filter_year) {
          const builtYear = marker.feature.properties.built_year_ce;
          if( startYear <= builtYear && builtYear <= endYear ) {
            show_year = true;
          }
        } else {
          show_year = true;
        }

        if( !marker.feature.properties.absence ) {
          var marker_color = 'green';
          if( marker.feature.properties.type ) {
            marker.feature.properties.type.forEach( function(type) {
              if(featured_types.includes(type)) {
                marker_color = 'orange-dark'
              }
            });
          }
          marker.setIcon(
            L.ExtraMarkers.icon({
              shape: 'penta',
              markerColor: marker_color,
             })
          );
        }

        if(show_type && show_figure && show_principal && show_comment && show_year) {
          if( !markerCluster.hasLayer(marker) ) {
            markerCluster.addLayer(marker);
          }
        } else {
          if( markerCluster.hasLayer(marker) ) {
            markerCluster.removeLayer(marker);
          }
        }
      });
    }

  @auth
  @if(Auth::user()->email_verified_at)
    L.easyButton('fa fa-edit fa-lg',
    function() {
      var url = "/addEntity";
      var coord = {lat: Math.floor(map.getCenter().lat*1000000)/1000000,
                   lon: Math.floor(map.getCenter().lng*1000000)/1000000,
                   zoom: map.getZoom()};
      $.ajax({
        url: url,
        data: coord,
        type: 'POST',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        }
      }).done(function(html) {
        $('#entity-header-message').html('新規データ登録');
        $('#entity-body').html(html);
        $('#entity').modal('show');
      }).fail(function() {
        // セッションが切れていたらエラーになるのでリロード
        window.location.reload(true);
      });
    },
    '新規データ登録',
    null, {
      position: 'topright'
    }).addTo(map);
  @endif
  @endauth

  @if($suggestions)
    L.easyButton('<span style="color:Tomato;"><i class="fa fa-warning fa-lg"></i></span>',
      function() {
        window.location.href = '/dashboard';
    },
    'お知らせがあります',
    null, {
      position: 'topright'
    }).addTo(map);
  @endif

  /* dropを拾うには dragover の preventDefault が必要 */
  $('#mapdiv').on('dragover', function(e) {
    e.preventDefault();
  });

  $('#mapdiv').on('drop', function(e) {
    e.preventDefault();
    /* jQuery経由では originalEvent が必要 */
    if(e.originalEvent.dataTransfer.files) {
      var file = e.originalEvent.dataTransfer.files[0];
      var reader = new FileReader();
      reader.onload = function(e) {
        var bytes = reader.result;
        var exif = EXIF.readFromBinaryFile(bytes);
        if(exif) {
          var lat = exif["GPSLatitude"];
          var lng = exif["GPSLongitude"];
          var latRef = exif["GPSLatitudeRef"];
          var lngRef = exif["GPSLongitudeRef"];
          if(lat && lng && latRef && lngRef) {
            var latitude = lat[0] + (lat[1] / 60) + (lat[2] / 3600);
            var longitude = lng[0] + (lng[1] / 60) + (lng[2] / 3600);
            if (latRef == "S") {
              latitude = -latitude;
            }
            if (lngRef == "W") {
              longitude = -longitude;
            }
            map.setView([latitude, longitude], 19);
            @if($maptype == 'default')
              update_map();
            @endif
          }
        }
      }
      reader.readAsArrayBuffer(file);
    }
  });

});

</script>

</x-app-layout>
