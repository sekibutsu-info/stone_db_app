<x-app-layout>

  @section('subtitle', ' - 削除履歴')

<div>
  <table class="w-full table-fixed">
    @php
      $odd = true;
    @endphp
    @foreach($delete_history as $history)
      @if($odd)
        <tr class="bg-gray-100">
      @else
        <tr class="bg-white">
      @endif
      @php
        $odd = !$odd;
        $value = $history['value'];
        switch($history['property']) {
          case 'place':         $property = '場所'; break;
          case 'type':          $property = '種類'; break;
          case 'built_year':    $property = '造立年（和暦）'; break;
          case 'built_year_ce': $property = '造立年（西暦）'; break;
          case 'figure':        $property = '像容'; break;
          case 'principal':     $property = '主尊銘'; break;
          case 'comment':       $property = '備考'; break;
          case 'project':       $property = 'プロジェクト'; break;
          case 'sameas' :       $property = '同一物'; break;
          case 'photo_date' :   $property = '写真撮影日'; break;
          case 'absence':       $property = '不在種別';
                                if($value == 'missing') {$value = '所在不明';}
                                else if($value == 'moved') {$value = '移設';}
                                break;
          default:              $property = '？';
        }
      @endphp
        <td class="w-full">
          {{$history['created_at']->format('Y年m月d日');}}：{{$history['nickname']}}</a> さんが
          <a href="https://map.sekibutsu.info/archive/{{$history['entity_id']}}">https://map.sekibutsu.info/archive/{{$history['entity_id']}}</a>
          の {{$property}} の値 {{$value}} を削除しました
        </td>
      </tr>
    @endforeach
  </table>
</div>

</x-app-layout>
