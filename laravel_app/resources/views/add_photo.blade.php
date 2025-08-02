<x-app-layout>

    <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
          画像の追加
      </h2>
    </x-slot>

    <div class="py-6">
      <div class="max-w-7xl mx-auto px-6">

        @if(isset($message))
          <div style="margin-top:10px;" class="mb-2 text-lg">{{$message}}
          </div>
          <div style="margin-top:10px;">
            <a href="/add_photo" class="text-white bg-blue-600 font-medium rounded-lg text-sm px-5 py-2 text-center cursor-pointer">戻る</a>
          </div>
        @else
        <form method="POST" action="/add_photo" enctype="multipart/form-data">

          @csrf
          @method('put')

          <div style="margin-top:10px;">
            <label for="entity_id" class="mb-2 text-gray-900">entity ID：</label>
            <input id="entity_id" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg w-48 p-1" type="text" name="entity_id" />
          </div>

          <div style="margin-top:10px;">
            <label class="mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file1">画像：</label>
            <input class="w-64 text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none" id="file1" name="file1" type="file" accept=".jpg"/>
          </div>

          <div style="margin-top:10px;">
            <input type="submit" class="text-white bg-blue-600 font-medium rounded-lg text-sm px-5 py-2 text-center cursor-pointer" value="追加" id="add_prop_button" />
          </div>
        </form>
        @endif
      </div>
    </div>

</x-app-layout>
