<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

use App\Models\Entity;
use App\Models\Property;

class StatsController extends Controller
{
    /**
     * Display Statistics.
     */
    public function show(Request $request): View
    {

      // 日別集計（30日）
      $daily_stats = Entity::groupBy('e_day')
                             ->select(DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d") AS e_day'), DB::raw('count(id) AS e_count'))
                             ->where(DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d")'), '>', DB::raw('CURDATE() - INTERVAL 30 day'))
                             ->orderBy('e_day', 'asc')->get();

      // 月別集計（12ヶ月）
      $monthly_stats = Entity::groupBy('e_month')
                               ->select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") AS e_month'), DB::raw('count(id) AS e_count'))
                               ->where(DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d")'), '>=', DB::raw('CURDATE() - INTERVAL 12 month'))
                               ->orderBy('e_month', 'desc')->take(12)->get();

      // 種類別投稿数
      $type_stats = Property::
                            groupBy('type')
                            ->selectRaw('CASE WHEN value = "八大龍王塔" THEN "龍神塔"
                                              WHEN value = "倶利伽羅龍王塔" THEN "龍神塔"
                                              WHEN value = "九頭龍神塔" THEN "龍神塔"
                                              ELSE value
                                         END AS type')
                            ->selectRaw('COUNT(id) AS p_count')
                            ->where('property', 'type')
                            ->whereNotIn('value', ['月待塔', '日待塔'])
                            ->orderBy('p_count', 'DESC')->take(20)->get();

      // 県別投稿数
      $pref_stats = Property::leftjoin('pref_code', 'pname', '=', DB::raw('LEFT(value, 3)'))
                              ->groupBy('pcode')
                              ->select('pcode', DB::raw('COUNT(properties.id) AS p_count'))
                              ->where('property', '=', 'address')
                              ->orderBy('p_count', 'DESC')->get();

      // 庚申メーター（削除済みアカウントは対象外）
      $koshin_stats = Property::join('users', 'properties.user_id', '=', 'users.id')
                                ->groupBy('nickname')
                                ->select('nickname', DB::raw('count(properties.id) AS p_count'))
                                ->where('properties.value', '庚申塔')
                                ->orderBy('p_count', 'desc')->get();

      return view('stats', [
        'daily_stats' => $daily_stats,
        'monthly_stats' => $monthly_stats,
        'type_stats' => $type_stats,
        'pref_stats' => $pref_stats,
        'koshin_stats' => $koshin_stats,
      ]);

    }
}

