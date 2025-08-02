<x-app-layout>

  @section('subtitle', ' - 特殊追加履歴')

<div>
  <table class="w-full table-fixed">
    @php
      $odd = true;
    @endphp
    @foreach($add_sp_history as $history)
      @if($odd)
        <tr class="bg-gray-100">
      @else
        <tr class="bg-white">
      @endif
      @php
        $odd = !$odd;

        $prop_names = array(
                        'type'=> '種類',
                        'place' => '場所',
                        'built_year' => '造立年（和暦）',
                        'built_year_ce' => '造立年（西暦）',
                        'figure' => '像容',
                        'principal' => '主尊銘',
                        'comment' => '備考',
                        'ref_url' => '参考URL',
                        'sameas' => '同一物',
                      );

        switch($history['property']) {
          case 'absence':
            $property = '不在種別';
            switch($history['value']) {
              case 'missing':       $value = '所在不明'; break;
              case 'moved':         $value = '移設'; break;
              default:              $value = '？';
            }
            break;
          default:
            if(array_key_exists($history['property'], $prop_names)) {
              $property = $prop_names[$history['property']];
            } else {
              $property = $history['property'];
            }
            $value = $history['value'];
        }
      @endphp
        <td class="w-full">
          {{$history['created_at']->format('Y年m月d日');}}：{{$history['nickname']}}</a> さんが
          <a href="https://map.sekibutsu.info/archive/{{$history['entity_id']}}">https://map.sekibutsu.info/archive/{{$history['entity_id']}}</a>
          の {{$property}} の値 {{$value}} を追加しました
        </td>
      </tr>
    @endforeach
  </table>
</div>

</x-app-layout>
