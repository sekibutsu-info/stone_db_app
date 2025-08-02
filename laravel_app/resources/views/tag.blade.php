<x-app-layout>

  @section('subtitle')- タグ一覧@endsection

  @push('scripts')
    <script type="text/javascript" src="/js/jquery-3.6.3.js"></script>
  @endpush

    <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
          タグ一覧
      </h2>
    </x-slot>

    <div class="py-6">
      <div class="max-w-7xl mx-auto px-6">

      <table class="border border-collapse">
        <tr class="border">
          <th class="border p-2 bg-gray-50">タグ名</th>
          <th class="border p-2 bg-gray-50">タグの説明</th>
          <th class="border p-2 bg-gray-50">データ件数</th>
          <th class="border p-2 bg-gray-50">タグ付与者</th>
        </tr>
        @foreach($tag_list as $tag)
          @php
            if (array_key_exists($tag->tag_name, $tag_count)) {
              $tag_ct = $tag_count[$tag->tag_name];
            } else {
              $tag_ct = 0;
            }
          @endphp
          <tr class="border">
            <td class="border p-2 bg-gray-50 whitespace-nowrap"><a href="/all?tag={{$tag->tag_name}}" class="underline">{{$tag->tag_name}}</a></td>
            <td class="border p-2 bg-gray-50">{{$tag->tag_note}}</td>
            <td class="border p-2 bg-gray-50" align="right">{{$tag_ct}}</td>
            <td class="border p-2 bg-gray-50">{{$tag->nickname}}</td>
          </tr>
        @endforeach
      </table>

      @auth
        @if(Auth::user()->admin)
          <hr style="margin-top:10px;">
          <div style="margin-top:10px;">
            <form method="POST" id="tag_user">
              @csrf
              タグ：
              <select id="add_tag" class="" name="add_tag" >
                <option value=""></option>
                @foreach($all_tag as $tag)
                  <option value="{{$tag->id}}">{{$tag->name}}</option>
                @endforeach
              </select>
              ユーザー：
              <select id="add_user" class="" name="add_user" >
                <option value=""></option>
                @foreach($tag_user as $user)
                  <option value="{{$user->id}}">{{$user->nickname}}</option>
                @endforeach
              </select>
              <div style="margin-top:10px;">
                <input type="button" id="add_button" class="text-white bg-blue-600 font-medium rounded-lg text-sm px-5 py-2 text-center cursor-pointer" value="追加" />
                <span style="margin-top:10px;" id="add_result" />
              </div>
          <hr style="margin-top:10px;">
          <script>
            var added = false;
            $('#add_button').on('click', function() {
              $('#add_button').prop('disabled', true);
              $('#add_button').addClass('bg-blue-200');
              $('#add_button').removeClass('bg-blue-600');
              $('#add_button').addClass('cursor-default');
              $('#add_button').removeClass('cursor-pointer');
              var url = "/addTagUser";
              var formdata = new FormData($('#tag_user').get(0));
              $.ajax({
                url: url,
                data: formdata,
                type: 'POST',
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                processData: false,
                contentType: false,
              }).done(function(html) {
                if(html == 'OK') {
                  $('#add_result').html(' 追加しました');
                } else if(html == 'exist') {
                  $('#add_result').html(' 既に設定済です');
                } else {
                  $('#add_result').html(' 追加できませんでした');
                }
              }).fail(function() {
                $('#add_result').html(' 追加できませんでした');
              });
            });
          </script>

        @endif
      @endauth

      <div class="py-2">
        タグは石造物の分類のために特別なユーザーが付与します。タグ名から、そのタグが付けられた石造物のマップにリンクしています。
        
      </div>

    </div>

</x-app-layout>
