<x-app-layout>
  @push('ogp')
    <meta property="og:image" content="https://map.sekibutsu.info/icon.png" />
    <meta property="og:title" content="みんなで石仏調査" />
  @endpush

  @push('css')
    <link rel="stylesheet" href="/js/themes/default/style.min.css" />
    <link rel="stylesheet" href="/maplibre/maplibre-gl.css" />
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
    <script type="text/javascript" src="/maplibre/maplibre-gl.js"></script>
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
    <img src="/leaflet/icons/MapCenterCoordIcon1.svg" width="36" height="36" style="position: absolute;top:50%;left:50%;transform:translate(-50%,-50%);z-index:1;pointer-events:none;" >
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

  <input type="file" accept=".jpg" id="file_select" style="display:none;">

  <script type="module">
import Spiderfy from '/maplibre/spiderfy.js';

$(function(){

  $.ajaxSetup({ cache: false });

  var lat=0, lon=0, zoom=0;
  var pstr = location.search.substring(1);
  if(pstr) {
    var parr = pstr.split('&');
    var ppair;
    for (var i = 0; i < parr.length; i++) {
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
      }
    }
  }

  var map = new maplibregl.Map({
    container: 'mapdiv',
    style: '/maplibre/pale.json',
    center: [lon, lat], 
    zoom: zoom,
    minZoom: 13,
    maxZoom: 17.9,
    maxPitch: 0
  });

   // スケール表示
   map.addControl(new maplibregl.ScaleControl({
     maxWidth: 150,
     unit: 'metric'
   }));

  const spiderfy = new Spiderfy(map, {
    onLeafClick: function(point) {
                   show_popup(point);
                   return false;
                 },
    closeOnLeafClick: false,
    minZoomLevel: 16,
    zoomIncrement: 2,
  });

  map.on('load', function() {
    if(lat != 0 && lon !=0 && zoom != 0) {
      map.flyTo({
        zoom: zoom,
        center: [lon, lat]
      });
    } else {
      geolocate.trigger();
    }
    map.loadImage('/img/circle-yellow.png', function(error, image) {
      map.addImage('circle_yellow', image);
      show_markers();
    });
  });

  function show_markers() {

    var bounds = map.getBounds();
    var minlat = bounds.getSouth();
    var minlon = bounds.getWest();
    var maxlat = bounds.getNorth();
    var maxlon = bounds.getEast();

    $.ajax({
      url: '/local.geojson?minlat='+minlat+'&minlon='+minlon+'&maxlat='+maxlat+'&maxlon='+maxlon,
      type: 'GET',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
      }
    }).done(function(json) {

      var stones_source = map.getSource('stones_source');
      if(stones_source) {
        stones_source.setData(json);
      } else {
        map.addSource('stones_source', {
          type: 'geojson',
          data: json,
          cluster: true,
          clusterRadius: 20
        });
      }

      var stones_clustered = map.getLayer('stones_clustered');
      if(stones_clustered) {
      } else {
        map.addLayer({
          id: 'stones_clustered',
          type: 'symbol', // must be symbol
          source: 'stones_source',
          filter: ['has', 'point_count'],
          layout: {
            'icon-image': 'circle_yellow',
            'icon-allow-overlap': true // recommended
          }
        });

        map.addLayer({
          "id": "stones_counters",
          "type": "symbol",
          "source": "stones_source",
          "layout": {
            "text-field": ["get", "point_count"],
            "text-font": ["NotoSansCJKjp-Regular"],
            "text-size": 12,
            "text-allow-overlap": true
          }
        })

        spiderfy.applyTo('stones_clustered');
      }

      var stones_unclustered = map.getLayer('stones_unclustered');
      if(stones_unclustered) {
      } else {
        map.addLayer({
          id: 'stones_unclustered',
          type: 'symbol',
          source: 'stones_source',
          filter: ['!', ['has', 'point_count']],
          layout: {
            'icon-image': 'circle_yellow'
          }
        });
      }

    });
  }

  map.on('mouseenter', 'stones_clustered', function () {
    map.getCanvas().style.cursor = 'pointer';
  });
  map.on('mouseleave', 'stones_clustered', function () {
    map.getCanvas().style.cursor = '';
  });
  map.on('mouseenter', 'stones_unclustered', function () {
    map.getCanvas().style.cursor = 'pointer';
  });
  map.on('mouseleave', 'stones_unclustered', function () {
    map.getCanvas().style.cursor = '';
  });

  map.on('click', 'stones_unclustered', function(e) {
    show_popup(e.features[0]);
  });

  function show_popup(point) {
    const coordinates = point.geometry.coordinates.slice();
    const lng = coordinates[0];
    while (Math.abs(lng - coordinates[0]) > 180) {
      coordinates[0] += lng > coordinates[0] ? 360 : -360;
    }
    var text = '<table>';
    if( point.properties.type ) {
      if(typeof(point.properties.type)!='object') {
        var types = JSON.parse(point.properties.type);
      } else {
        var types = point.properties.type;
      }
      text += '<tr><td align="center" class="text-base">' + types.join(',') + '</td></tr>';
    }
    if( point.properties.address ) {
      if(typeof(point.properties.address)!='object') {
        text += '<tr><td>' + JSON.parse(point.properties.address)[0];
      } else {
        text += '<tr><td>' + point.properties.address[0];
      }
      if( point.properties.place ) {
        if(typeof(point.properties.place)!='object') {
          text += '<br/>' + JSON.parse(point.properties.place)[0] + '</td></tr>';
        } else {
          text += '<br/>' + point.properties.place[0] + '</td></tr>';
        }
      } else {
        text += '</td></tr>';
      }
    }
    if( point.properties.built_year ) {
      if(typeof(point.properties.built_year)!='object') {
        text += '<tr><td>' + JSON.parse(point.properties.built_year)[0];
      } else {
        text += '<tr><td>' + point.properties.built_year[0];
      }
      if( point.properties.built_year_ce ) {
        if(typeof(point.properties.built_year_ce)!='object') {
          text += '&nbsp（' + JSON.parse(point.properties.built_year_ce)[0] + '）</td></tr>';
        } else {
          text += '&nbsp（' + point.properties.built_year_ce[0] + '）</td></tr>';
        }
      } else {
        text += '</td></tr>';
      }
    }
    if( point.properties.figure ) {
      if(typeof(point.properties.figure)!='object') {
        text += '<tr><td>像容：' + JSON.parse(point.properties.figure) + '</td></tr>';
      } else {
        text += '<tr><td>像容：' + point.properties.figure + '</td></tr>';
      }
    }
    if( point.properties.principal ) {
      if(typeof(point.properties.principal)!='object') {
        text += '<tr><td>主尊銘：' + JSON.parse(point.properties.principal) + '</td></tr>';
      } else {
        text += '<tr><td>主尊銘：' + point.properties.principal + '</td></tr>';
      }
    }
    var attr = point.properties.contributor;
    text += '<tr><td>&copy;' +  attr + ' (<a href="https://creativecommons.org/licenses/by/4.0/deed.ja" target="_blank">CC BY 4.0</a>)</td></tr>';
    if(point.properties.image) {
      if(typeof(point.properties.image)!='object') {
        var images = JSON.parse(point.properties.image);
      } else {
        var images = point.properties.image;
      }
      text += '<div id="carouselExampleIndicators" class="carousel slide relative" data-bs-ride="carousel">' +
              '<div class="carousel-indicators absolute right-0 bottom-0 left-0 flex justify-center p-0 mb-4">' +
              '<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>';
      if(images[1]) {
        text += '<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2" </button>';
      }
      if(images[2]) {
        text += '<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3" </button>';
      }
      if(images[3]) {
        text += '<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3" aria-label="Slide 4" </button>';
      }
      if(images[4]) {
        text += '<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="4" aria-label="Slide 5" </button>';
      }
      text += '</div>' +
              '<div class="carousel-inner relative w-full overflow-hidden">' +
              '<div class="carousel-item active float-left w-full">' +
              '<img src="/images/' + images[0] + '" class="block w-full">' +
              '</div>';
      if(images[1]) {
        text += '<div class="carousel-item float-left w-full">' +
                '<img src="/images/' + images[1] + '" class="block w-full">' +
                '</div>';
      }
      if(images[2]) {
        text += '<div class="carousel-item float-left w-full">' +
                '<img src="/images/' + images[2] + '" class="block w-full">' +
                '</div>';
      }
      if(images[3]) {
        text += '<div class="carousel-item float-left w-full">' +
                '<img src="/images/' + images[3] + '" class="block w-full">' +
                '</div>';
      }
      if(images[4]) {
        text += '<div class="carousel-item float-left w-full">' +
                '<img src="/images/' + images[4] + '" class="block w-full">' +
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
    new maplibregl.Popup()
      .setLngLat(coordinates)
      .setHTML(text)
      .addTo(map);
  }

  map.on('moveend', function() {
    show_markers();
    history.replaceState(null, null, "?x=" + Math.floor(map.getCenter().lng*1000000)/1000000 +
                                     "&y=" + Math.floor(map.getCenter().lat*1000000)/1000000 + 
                                     "&z=" + map.getZoom());
  });

  @auth
    @if(Auth::user()->email_verified_at)
      class AddButton {
        onAdd(map) {
          const div = document.createElement("div");
          div.className = 'maplibregl-ctrl maplibregl-ctrl-group';
          div.innerHTML = '<button><div title="新規データ登録" class="maplibregl-ctrl-icon button-state" style="text-align:center;line-height:30px;"><span class="fa fa-edit fa-lg" aria-hidden="true"></span></div></button>';
          div.addEventListener("contextmenu", (e) => e.preventDefault());
          div.addEventListener("click", () => add_entity());
          return div;
        }
      }
    @endif
  @endauth

  class AddButton2 {
    onAdd(map) {
      const div = document.createElement("div");
      div.className = 'maplibregl-ctrl maplibregl-ctrl-group';
      div.innerHTML = '<button><div title="画像ファイルの緯度経度に移動" class="maplibregl-ctrl-icon button-state" style="text-align:center;line-height:30px;"><span class="fa fa-file-image-o fa-lg" aria-hidden="true"></span></div></button>';
      div.addEventListener("contextmenu", (e) => e.preventDefault());
      div.addEventListener("click", () => select_file());
      return div;
    }
  }

  function add_entity() {
    var {lng, lat} = map.getCenter();
    var url = "/addEntity";
    var coord = {lat: lat,
                 lon: lng,
                 zoom: map.getZoom()+1};
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
  }

  const bounds = [
    [120, 20], // [west, south]
    [150, 45]  // [east, north]
  ];
  map.setMaxBounds(bounds);

  map.addControl(new maplibregl.NavigationControl(), 'top-left');
  const geolocate = new maplibregl.GeolocateControl({
    positionOptions: {
      enableHighAccuracy: true
    },
    trackUserLocation: false
  });
  map.addControl(geolocate, 'top-right');
  geolocate.on('error', function() {
    map.flyTo({
      zoom: 11,
      center: [139.741357, 35.658099] // 経緯度原点
    });
  });
  geolocate.on('outofmaxbounds', function() {
    map.flyTo({
      zoom: 11,
      center: [139.741357, 35.658099] // 経緯度原点
    });
  });
  geolocate.on('geolocate', function(e) {
    map.flyTo({
      zoom: 17,
      center: [e.coords.longitude, e.coords.latitude]
    });
  });

  @auth
    @if(Auth::user()->email_verified_at)
      map.addControl(new AddButton(), "top-right");
    @endif
  @endauth

  // map.addControl(new AddButton2(), "bottom-left");

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

  /* dropを拾うには dragover の preventDefault が必要 */
  $('#mapdiv').on('dragover', function(e) {
    e.preventDefault();
  });

  $('#mapdiv').on('drop', function(e) {
    e.preventDefault();
    /* jQuery経由では originalEvent が必要 */
    if(e.originalEvent.dataTransfer.files) {
      var file = e.originalEvent.dataTransfer.files[0];
      locate_file(file);
    }
  });

  function select_file() {
    $('#file_select').click();
  }

  $('#file_select').on('change', function (e) {
    var file = $('#file_select')[0].files[0];
    if( file.type == 'image/jpeg') {
      locate_file(file);
    }
  });

  function locate_file(file) {
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
          map.flyTo({
            zoom: 17,
            center: [longitude, latitude]
          });
        }
      }
    }
    reader.readAsArrayBuffer(file);
  }

});

</script>

</x-app-layout>
