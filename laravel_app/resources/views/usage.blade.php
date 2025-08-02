<x-app-layout>

  @section('subtitle')- 操作方法
  @endsection

  @push('ogp')
    <meta property="og:title" content="みんなで石仏調査 - 操作方法" />
    <meta property="og:image" content="https://map.sekibutsu.info/icon.png" />
  @endpush

  @push('css')
    <link rel="stylesheet" href="/css/font-awesome.min.css" type="text/css" />
  @endpush

  <style>
  .button-like {
    border: solid 1px;
    border-radius: 5px;
    padding: 0 3px 0 3px;
    margin: 0 2px 0 2px;
  }
  .button-like2 {
    border: solid 1px;
    border-radius: 5px;
    margin: 0 2px 0 2px;
  }
  </style>

    <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        地図の操作方法
      </h2>
    </x-slot>

    <div class="p-6">
      <div class="p-6 bg-white">

        <p class="text-xl p-2">目次</p>
        <p class="p-2">
          <span class="p-1">・</span><a href="#map">地図の種類</a><br>
          <span class="p-1">・</span><a href="#base">背景地図の変更</a><br>
          <span class="p-1">・</span><a href="#search">地名検索</a><br>
          <span class="p-1">・</span><a href="#lonlat">緯度経度への移動</a><br>
          <span class="p-1">・</span><a href="#photo">画像ファイルを用いた移動</a><br>
          <span class="p-1">・</span><a href="#filter">データのフィルタリング</a><br>
        </p>

        <p id="map" class="text-xl p-2 mt-2">地図の種類</p>
        <p class="p-2">
        みんなで石仏調査には4種類の地図があります。<br>
        <span class="p-1">・</span>標準 - ズームレベル12から19までの範囲を表示できる地図です。<br>
        <span class="p-1">・</span>全国版 - ズームレベル5から19までの範囲を表示できる地図です。すべてのデータを読み込むため最初の表示には時間がかかります。<br>
        <span class="p-1">・</span>モバイル - 回転できる地図です。パソコンではマウスを右クリックしたまま移動し、スマホ等では二本指で操作します。<br>
        <span class="p-1">・</span>マイマップ - ログインしているユーザーが投稿したデータのみ表示する地図です。<br>
        全国版以外の地図には投稿がすぐに反映されますが、全国版のデータは1時間に1回の更新のため、投稿が反映表示されるまで時間がかかることがあります。
        </p>

        <p id="base" class="text-xl p-2 mt-2">背景地図の変更</p>
        <p class="p-2">
        モバイル以外の地図の右上にある<span class="button-like2" style="display:inline-block;padding:2px;"><img src="/leaflet/images/layers.png" width="16" height="16"></span>ボタンをクリックし、背景地図を［標準］と［写真］から選択することができます。
        </p>

        <p id="search" class="text-xl p-2 mt-2">地名検索</p>
        <p class="p-2">
        モバイル以外の地図の右上にある<span class="button-like2" style="display:inline-block;padding:0px;"><img src="/leaflet/images/geocoder.png" width="20" height="20"></span>ボタンをクリックし、テキストボックスに地名を入力します。候補が複数ある場合はリストが表示されるので選択します。決定すると、その地名の場所を中心に地図が移動します。
        </p>

        <p id="lonlat" class="text-xl p-2 mt-2">緯度経度への移動</p>
        <p class="p-2">
        モバイル以外の地図の右上にある<span class="button-like2" style="display:inline-block;padding:0px;"><img src="/leaflet/images/geocoder.png" width="20" height="20"></span>ボタンをクリックし、テキストボックスに緯度経度を 35.658099,139.741357 の形式で入力すると、その緯度経度の位置を中心に地図が移動します。
        </p>

        <p id="photo" class="text-xl p-2 mt-2">画像ファイルを用いた移動</p>
        <p class="p-2">
        緯度経度の情報を持つ画像ファイルをモバイル以外の地図にドロップすると、その緯度経度の位置を中心に地図が移動します。<br>
        モバイル地図の場合は、左下の<span class="button-like"><span class="fa fa-file-image-o"></span></span>ボタンをクリックしてファイルを選択します。
        </p>

        <p id="filter" class="text-xl p-2 mt-2">データのフィルタリング</p>
        <p class="p-2">
        全国版地図の左上にある<span class="p-1 button-like"><span class="fa fa-filter" style="padding: 0 1px 0 1px;"></span></span><span class="button-like><span class="fa fa-filter" style="padding: 0 1px 0 1px;"></span></span><span class="button-like"><span class="fa fa-user" style="padding: 0 2px 0 2px;"></span></span><span class="button-like"><span class="fa fa-font"></span></span><span class="button-like"><span class="fa fa-clock-o" style="padding: 0 1px 0 1px;"></span></span><span class="button-like"><span class="fa fa-search"></span></span><span class="button-like"><span class="fa fa-map-marker" style="padding: 0 3px 0 3px;"></span></span>ボタンで、表示するデータをフィルタリングできます。<br>
        <span class="p-1 button-like"><span class="fa fa-filter" style="padding: 0 1px 0 1px;"></span></span> 石造物の種類でフィルタリングします。<br>
        <span class="p-1 button-like"><span class="fa fa-user" style="padding: 0 2px 0 2px;"></span></span> 石造物の像容（刻像）でフィルタリングします。<br>
        <span class="p-1 button-like"><span class="fa fa-font"></span></span> 石造物の主尊銘でフィルタリングします。<br>
        <span class="button-like"><span class="fa fa-clock-o" style="padding: 0 1px 0 1px;"></span></span> 造立年の範囲でフィルタリングします。（全国版地図のみ）<br>
        <span class="p-1 button-like"><span class="fa fa-search"></span></span> 備考欄に含まれる文字列でフィルタリングします。正規表現も使えます。（全国版地図のみ）<br>
        <span class="p-1 button-like"><span class="fa fa-map-marker" style="padding: 0 3px 0 3px;"></span></span> 選択した種類の石造物を赤いマーカーで強調表示します。
        </p>

      </div>
    </div>

</x-app-layout>
