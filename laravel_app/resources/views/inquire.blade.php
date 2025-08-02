<x-app-layout>

    <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
          お問い合わせ
      </h2>
    </x-slot>

    <div class="py-6">
      <div class="max-w-7xl mx-auto px-6">

        @if($result)
          <div style="margin-top:10px;" class="mb-2 text-gray-900">システム管理者に送信しました。</div>
          <div style="">
            <div style="" class="w-full">
              <textarea class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg w-full p-1" name="inquiry" maxlength="1000" disabled>{{$result}}</textarea>
            </div>
          </div>
        @else
          <form method="POST" action="/inquire">

            @csrf
            @method('put')
            <div style="margin-top:10px;" class="mb-2 text-gray-900">システム管理者に送信：</div>
              <div style="">
                <div style="" class="w-full">
                  <textarea class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg w-full p-1" name="inquiry" maxlength="1000"></textarea>
                </div>
              </div>
              <div style="margin-top:10px;">
                <input type="submit" class="text-white bg-blue-600 font-medium rounded-lg text-sm px-5 py-2 text-center cursor-pointer" value="送信" />
              </div>
            </div>
          </form>
        @endif
      </div>
    </div>

</x-app-layout>
