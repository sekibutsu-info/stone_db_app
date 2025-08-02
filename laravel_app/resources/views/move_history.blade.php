<x-app-layout>

  @section('subtitle', ' - 移動履歴')

<div>
  <table class="w-full table-fixed">
    @php
      $odd = true;
    @endphp
    @foreach($move_history as $history)
      @if($odd)
        <tr class="bg-gray-100">
      @else
        <tr class="bg-white">
      @endif
      @php
        $odd = !$odd;
      @endphp
        <td class="w-full">
          {{$history['created_at']->format('Y年m月d日');}}：{{$history['nickname']}}</a> さんが
          <a href="https://map.sekibutsu.info/archive/{{$history['entity_id']}}">https://map.sekibutsu.info/archive/{{$history['entity_id']}}</a>
          を {{$history['old_address']}}［{{$history['old_latitude']}}, {{$history['old_longitude']}}］
          から {{$history['new_address']}}［{{$history['new_latitude']}}, {{$history['new_longitude']}}］
          に移動しました
        </td>
      </tr>
    @endforeach
  </table>
</div>

</x-app-layout>
