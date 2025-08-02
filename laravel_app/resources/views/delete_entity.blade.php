<x-app-layout>

    <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
          エンティティの削除
      </h2>
    </x-slot>

    <div class="py-6">
      <div class="max-w-7xl mx-auto px-6">

        @if(isset($message))
          <div style="margin-top:10px;" class="mb-2 text-lg">{{$message}}
          </div>
          <div style="margin-top:10px;">
            <a href="/delEntity" class="text-white bg-blue-600 font-medium rounded-lg text-sm px-5 py-2 text-center cursor-pointer">戻る</a>
          </div>
        @else
        <form method="POST" action="/delEntity">

          @csrf
          @method('put')

          <div style="margin-top:10px;">
            <label for="entity_id" class="mb-2 text-gray-900">entity ID：</label>
            <input id="entity_id" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg w-48 p-1" type="text" name="entity_id" />
          </div>
          <div style="margin-top:10px;">
            <input type="submit" class="text-white bg-blue-600 font-medium rounded-lg text-sm px-5 py-2 text-center cursor-pointer" value="削除" />
          </div>
        </form>
        @endif
      </div>
    </div>

</x-app-layout>
