<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\MapController;
use App\Http\Controllers\EntityController;
use App\Http\Controllers\GeoJsonController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\StatsController;
use App\Http\Controllers\InquireController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\SuggestionController;
use App\Http\Controllers\UserpageController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\EditController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\GeoCodeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// トップ画面の表示
Route::get('/', [MapController::class, 'show']);
// 標準地図の表示
Route::get('/map', [MapController::class, 'show'])->name('map');
// 「データ詳細」画面（モーダルによる全画面表示）用のデータ取得
Route::post('/getEntity', [EntityController::class, 'get']);
// 「新着情報」ページの表示
Route::get('/news', [EntityController::class, 'get_news'])->name('news');
// 「新着写真」ページの表示
Route::get('/newpics', [EntityController::class, 'get_newpics'])->name('newpics');
// 「ランダム表示」ページの表示
Route::get('/random', [EntityController::class, 'get_random'])->name('random');
// マイマップの表示（ログインしていない場合は標準地図）
Route::get('/mymap', [MapController::class, 'my_show'])->name('mymap');
// /data?id=番号 から /archive/番号 にリダイレクト
Route::get('/data', [DataController::class, 'redirect']);
// 「統計情報 」ページの表示
Route::get('/stats', [StatsController::class, 'show'])->name('stats');
// 全国版地図の表示
Route::get('/all', [MapController::class, 'show_all'])->name('all');
// モバイル版地図の表示
Route::get('/mobile', [MapController::class, 'show_mobile'])->name('mobile');
// 標準地図を表示するためのGeoJSON取得
Route::get('/local.geojson', [GeoJsonController::class, 'get_local']);
// モバイル版地図を表示するためのGeoJSON取得
Route::get('/mobile.geojson', [GeoJsonController::class, 'get_mobile']);
// タグ別地図を表示するためのGeoJSON取得
Route::get('/tags.geojson', [GeoJsonController::class, 'get_tag']);
// ユーザーページの表示
Route::get('/userpage', [UserpageController::class, 'userpage']);
// 「みんなで石仏調査 について」の表示
Route::get('/about', [AboutController::class, 'show'])->name('about');
// 「タグ一覧」ページの表示
Route::get('/tag', [TagController::class, 'show'])->name('tag');
// アーカイブページの表示
Route::get('/archive/{id?}', [ArchiveController::class, 'show'])->name('archive');
// sitemap.txt の表示
Route::get('/sitemap.txt', [SitemapController::class, 'get']);
// 「投稿方法」ページの表示
Route::get('/howto', [AboutController::class, 'howto'])->name('howto');
// 「地図の操作方法」ページの表示
Route::get('/usage', [AboutController::class, 'usage'])->name('usage');

// 以下はログインしているユーザーのみ
Route::middleware('auth')->group(function () {
    // 「アカウント」ページの表示
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // アカウント情報の更新
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // ダッシュボードの表示
    Route::get('/dashboard', [DashboardController::class, 'show'])->name('dashboard');
    // マイマップを表示するためのGeoJSON取得
    Route::get('/my_stone_db.geojson', [GeoJsonController::class, 'get']);
    // システム管理者への問合せページの表示
    Route::get('/inquire', [InquireController::class, 'show'])->name('inquire');;
    // システム管理者への問合せの送信
    Route::put('/inquire', [InquireController::class, 'save']);
});

// 以下はログインしているメール認証済みユーザーのみ
Route::middleware('verified')->group(function () {
    // 「新規データ登録」画面（モーダルによる全画面表示）の表示
    Route::post('/addEntity', [EntityController::class, 'add']);
    // 新規データ登録
    Route::post('/saveEntity', [EntityController::class, 'save']);
    // 「データ詳細」画面で「タグの追加」
    Route::post('/tagEntity', [EntityController::class, 'add_tag']);
    // 「改善提案」ページの表示
    Route::get('/suggestions', [SuggestionController::class, 'show'])->name('suggestions');
    // 「データ詳細」画面で「このデータについて改善を提案」
    Route::post('/suggestEntity', [SuggestionController::class, 'suggest']);
    // 「改善提案」ページで提案への回答
    Route::post('/replySuggestion', [SuggestionController::class, 'reply']);
    // 「改善提案」ページで管理者として回答（admin権限が必要）
    Route::post('/decideSuggestion', [SuggestionController::class, 'decide']);
    // 「改善提案」ページでクローズ（admin権限が必要）
    Route::post('/closeSuggestion', [SuggestionController::class, 'close']);
    // 「データ詳細」画面で「このデータに情報を追加」
    Route::post('/addProperty', [EntityController::class, 'add_prop']);
    // 「プロパティの追加」ページの表示（admin権限が必要）
    Route::get('/addprop', [PropertyController::class, 'add_one_prop']);
    // 「プロパティの追加」ページでプロパティを追加（admin権限が必要）
    Route::put('/addprop', [PropertyController::class, 'add_one_prop']);
    // 「エンティティの削除」ページの表示（admin権限が必要）
    Route::get('/delEntity', [PropertyController::class, 'delete_entity']);
    // 「エンティティの削除」ページでデータを削除（admin権限が必要）
    Route::put('/delEntity', [PropertyController::class, 'delete_entity']);
    // 「マイページ設定」ページの表示
    Route::get('/mypage', [UserpageController::class, 'mypage'])->name('mypage');
    // マイページ設定の更新
    Route::put('/mypage', [UserpageController::class, 'mypage']);
    // 「データの詳細編集」ページの表示
    Route::post('/editData', [EditController::class, 'get']);
    // 「休眠ユーザのデータを改善」ページの表示（manage権限が必要）
    Route::post('/editData2', [EditController::class, 'get2']);
    // 「休眠ユーザのデータを改善」ページでプロパティの追加
    Route::post('/add_prop2', [EditController::class, 'add_prop2']);
    // 「データの詳細編集」「休眠ユーザのデータを改善」ページでプロパティの削除
    Route::post('/del_prop', [EditController::class, 'del_prop']);
    // 「データの詳細編集」「休眠ユーザのデータを改善」ページで位置情報の変更
    Route::post('/move_entity', [EditController::class, 'move_entity']);
    // 「データの詳細編集」「休眠ユーザのデータを改善」ページで特殊プロパティ（不在種別／同一物）の追加
    Route::post('/add_sp_prop', [EditController::class, 'add_sp_prop']);
    // プロパティの削除履歴の表示
    Route::get('/delete_history', [EditController::class, 'delete_history']);
    // 特殊プロパティの追加履歴の表示
    Route::get('/add_sp_history', [EditController::class, 'add_sp_history']);
    // 位置情報の変更履歴の表示
    Route::get('/move_history', [EditController::class, 'move_history']);
    // ユーザーにタグ付けの権限を付与（admin権限が必要）
    Route::post('/addTagUser', [TagController::class, 'add']);
    // 「画像の追加」 ページの表示（admin権限が必要）
    Route::get('/add_photo', [PropertyController::class, 'add_photo']);
    // 投稿に画像を追加（admin権限が必要）
    Route::put('/add_photo', [PropertyController::class, 'add_photo']);
    // 緯度経度から所在地名を取得
    Route::get('/reverseGeoCoder', [GeoCodeController::class, 'reverse']);
});

require __DIR__.'/auth.php';
