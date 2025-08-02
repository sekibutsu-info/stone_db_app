<x-app-layout>

    <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
          プロパティの追加
      </h2>
    </x-slot>

    <div class="py-6">
      <div class="max-w-7xl mx-auto px-6">

        @if(isset($message))
          <div style="margin-top:10px;" class="mb-2 text-lg">{{$message}}
          </div>
          <div style="margin-top:10px;">
            <a href="/addprop" class="text-white bg-blue-600 font-medium rounded-lg text-sm px-5 py-2 text-center cursor-pointer">戻る</a>
          </div>
        @else
        <form method="POST" action="/addprop">

          @csrf
          @method('put')

          <div style="margin-top:10px;">
            <label for="entity_id" class="mb-2 text-gray-900">entity ID：</label>
            <input id="entity_id" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg w-48 p-1" type="text" name="entity_id" />
          </div>
          <div style="margin-top:10px;display:table;">
            <div style="display:table-cell;vertical-align:middle;white-space:nowrap;" class="mb-2 text-gray-900">プロパティ：</div>
            <div style="display:table-cell;">
              <select id="property" class="" name="property" >
                @php
                  $props = [['',''],
                            ['place','場所'],
                            ['type','種類'],
                            ['built_year','造立年（和暦）'],
                            ['built_year_ce','造立年（西暦）'],
                            ['figure','像容'],
                            ['principal','主尊銘'],
                            ['sameas','同一物'],
                            ['absence','不在種別'],
                            ['project','プロジェクト'],
                            ['tag','タグ'],
                            ['ref_url','参考URL'],
                            ['comment','備考']];
                  foreach($props as $prop) {
                    echo '<option name="property" value="'.$prop[0].'">'.$prop[1].'</option>';
                  }
                @endphp
              </select>
            </div>
          </div>
          <div style="margin-top:10px;display:table;">
            <div style="display:table-cell;vertical-align:middle;white-space:nowrap;" class="mb-2 text-gray-900">値：</div>
            <div style="display:table-cell;" class="w-full">
              <textarea id="prop_value" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg w-full p-1" name="value" maxlength="1000"></textarea>
            </div>
          </div>
          <div style="margin-top:10px;">
            <input type="submit" class="text-white bg-blue-600 font-medium rounded-lg text-sm px-5 py-2 text-center cursor-pointer" value="追加" id="add_prop_button" />
          </div>
        </form>
        @endif
      </div>
    </div>

</x-app-layout>
