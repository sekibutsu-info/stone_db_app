<x-app-layout>

  @section('subtitle', ' - 統計情報')

  @push('scripts')
    <script type="text/javascript" src="/js/jquery-3.6.3.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.2.1/dist/chart.umd.min.js"></script>
  @endpush

    <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
          統計情報
      </h2>
    </x-slot>

    <div class="py-6">
      <div class="max-w-7xl mx-auto px-6">
        <div class="text-lg p-2">
          直近30日間の投稿数推移
        </div>
        <div class="text-base bg-white rounded-lg p-2">
          <canvas id="dailyChart"></canvas>
          <script>
            var daily_stats = @json($daily_stats);

            const dailyCtx = document.getElementById('dailyChart');
            const dailyLabel = [];
            const dailyData = [];
            for(var i = 0; i < daily_stats.length; i++){
              dailyLabel.push(daily_stats[i]['e_day']);
              dailyData.push(daily_stats[i]['e_count']);
            }
            new Chart(dailyCtx, {
              type: 'bar',
              data: {
                labels: dailyLabel,
                datasets: [{
                  label: '投稿件数',
                  data:  dailyData,
                }],
              }
            });
          </script>
        </div>

        <div class="text-lg p-2">
          月別投稿数推移
        </div>
        <div class="text-base bg-white rounded-lg p-2">
          <canvas id="monthlyChart"></canvas>
          <script>
            var monthly_stats = @json($monthly_stats);
            const monthlyCtx = document.getElementById('monthlyChart');
            const monthlyLabel = [];
            const monthlyData = [];
            for(var i = monthly_stats.length-1 ; 0 <= i ; i--){
              monthlyLabel.push(monthly_stats[i]['e_month']);
              monthlyData.push(monthly_stats[i]['e_count']);
            }
            new Chart(monthlyCtx, {
              type: 'bar',
              data: {
                labels: monthlyLabel,
                datasets: [{
                  label: '投稿件数',
                  data:  monthlyData,
                }],
              }
            });
          </script>
        </div>

        <div class="text-lg p-2">
          種類別・投稿数ベスト20
        </div>
        <div class="text-base bg-white rounded-lg p-2">
          <canvas id="typeChart"></canvas>
          <div class="text-sm text-gray-600 pl-4">※月待塔、日待塔は除く（下位分類のみ集計）</div>
          <div class="text-sm text-gray-600 pl-4">※八大龍王塔、倶利伽羅龍王塔、九頭龍神塔は上位分類の龍神塔に含めて集計</div>
          <script>
            var type_stats = @json($type_stats);
            const typeCtx = document.getElementById('typeChart');
            const typeLabel = [];
            const typeData = [];
            for(var i = 0; i < type_stats.length; i++){
              typeLabel.push(type_stats[i]['type']);
              typeData.push(type_stats[i]['p_count']);
            }
            new Chart(typeCtx, {
              type: 'bar',
              data: {
                labels: typeLabel,
                datasets: [{
                  label: '投稿件数',
                  data:  typeData,
                }],
              },
              options: {
                scales: {
                  y: {
                    type: 'logarithmic',
                  }
                }
              }
            });
          </script>
        </div>

        <div class="text-lg p-2">
          県別投稿数マップ
        </div>
        <div class="text-base bg-white rounded-lg p-4">
          @component('components.japan-simple-map', ['pref_stats' => $pref_stats])
          @endcomponent
        </div>

        <div class="text-lg p-2">
          めざせ千庚申！ 庚申メーター
        </div>
        <div class="text-base bg-white rounded-lg p-2">
          <canvas id="tKoshinChart" height="200"></canvas>
          <canvas id="hKoshinChart"></canvas>
          <script>
            var koshin_stats = @json($koshin_stats);
            const tKoshinCtx = document.getElementById('tKoshinChart');
            const tKoshinLabel = [];
            const tKoshinData = [];
            const hKoshinCtx = document.getElementById('hKoshinChart');
            const hKoshinLabel = [];
            const hKoshinData = [];
            for(var i = 0; i < koshin_stats.length; i++){
              if(koshin_stats[i]['p_count'] > 100) {
                tKoshinLabel.push(koshin_stats[i]['nickname']);
                if(koshin_stats[i]['p_count'] > 1000) {
                  tKoshinData.push(1000);
                } else {
                  tKoshinData.push(koshin_stats[i]['p_count']);
                }
              } else if (koshin_stats[i]['p_count'] > 10) {
                hKoshinLabel.push(koshin_stats[i]['nickname']);
                hKoshinData.push(koshin_stats[i]['p_count']);
              }
            }
            new Chart(tKoshinCtx, {
              type: 'bar',
              data: {
                labels: tKoshinLabel,
                datasets: [{
                  label: '千庚申',
                  data:  tKoshinData,
                }],
              },
              options: {
                indexAxis: 'y',
                scales: {
                  x: {
                    min: 0,
                    max: 1000
                  },
                  y: {
                    ticks: {
                      autoSkip: false
                    }
                  }
                }
              }
            });
            /*
            new Chart(hKoshinCtx, {
              type: 'bar',
              data: {
                labels: hKoshinLabel,
                datasets: [{
                  label: '百庚申',
                  data:  hKoshinData,
                }],
              },
              options: {
                indexAxis: 'y',
                scales: {
                  x: {
                    min: 0,
                    max: 100
                  },
                  y: {
                    ticks: {
                      autoSkip: false
                    }
                  }
                }
              }
            });
            */
          </script>
        </div>
      </div>
    </div>

</x-app-layout>
