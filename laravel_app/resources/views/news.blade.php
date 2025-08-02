<x-app-layout>

  @section('subtitle', ' - 新着情報')

  @push('ogp')
    <meta property="og:image" content="https://map.sekibutsu.info/icon.png" />
    <meta property="og:title" content="みんなで石仏調査 - 新着情報" />
  @endpush

  @push('css')
    <link rel="stylesheet" href="/css/font-awesome.min.css" type="text/css" />
  @endpush

  @push('scripts')
    <script type="text/javascript" src="/js/jquery-3.6.3.js"></script>
  @endpush

    <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
          新着情報
      </h2>
    </x-slot>

  <div id="entity" class="modal fade fixed top-0 left-0 hidden w-full h-full outline-none overflow-x-hidden overflow-y-auto" tabindex="-1">
    <div class="modal-dialog modal-fullscreen relative w-auto pointer-events-none">
      <div class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none text-current">
        <div class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 rounded-t-md" id="entity-header">
          <div id="entity-header-message"></div>
          <button type="button"
                  class="btn-close box-content w-4 h-4 p-1 text-black border-none rounded-none opacity-50 focus:shadow-none focus:outline-none focus:opacity-100 hover:text-black hover:opacity-75 hover:no-underline"
                  data-bs-dismiss="modal" aria-label="閉じる"></button>
        </div>
        <div id="entity-body" class="modal-body relative p-4">
        </div>
        <div class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-end p-4 border-t border-gray-200 rounded-b-md">
          <button type="button"
                  class="inline-block px-6 py-2.5 bg-gray-700 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-gray-900 hover:shadow-lg focus:bg-gray-900 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-gray-900 active:shadow-lg transition duration-150 ease-in-out"
                  data-bs-dismiss="modal">閉じる</button>
        </div>
      </div>
    </div>
  </div>

  <div id="photo-popup" style="z-index:1060;background-color:rgba(0, 0, 0, 0.5);" class="modal fade fixed top-0 left-0 hidden w-full h-full outline-none overflow-x-hidden overflow-y-auto" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered relative w-auto pointer-events-none">
      <div class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none text-current">
        <div id="photo-popup-body" class="modal-body relative p-4" data-bs-dismiss="modal" >
        </div>
      </div>
    </div>
  </div>

<div class="p-1">
  <table class="w-full table-fixed">
    @php
      $odd = true;
    @endphp
    @foreach($entities as $entity)
      @if($odd)
        <tr class="bg-gray-100">
      @else
        <tr class="bg-white">
      @endif
      @php
        $odd = !$odd;
        $info = '';
        if( $entity['figures'] ) {
          $info = $info.'（像容：'.$entity['figures'];
        }
        if( $entity['principals'] ) {
          if($info == '') {
            $info = $info.'（';
          } else {
            $info = $info.' ';
          }
          $info = $info.'主尊銘：'.$entity['principals'];
        }
        if( $entity['tags'] ) {
          if($info == '') {
            $info = $info.'（';
          } else {
            $info = $info.' ';
          }
          $info = $info.'タグ：'.$entity['tags'];
        }
        if($info != '') {
          $info = $info.'）';
        }
      @endphp
        <td class="w-full">
          {{$entity['created_at']->format('Y年m月d日');}}：<a href="/userpage?id={{$entity['user_id']}}" class="underline cursor-pointer" >{{$entity['nickname']}}</a> さんが {{$entity['address']}}{{$entity['place']}} の
          {{$entity['types']}}{{$info}}を投稿しました
          （<a class="underline cursor-pointer" onClick="javascript:show_entity('{{$entity['entity_id']}}');">データ詳細</a>／<a href="/?x={{$entity['longitude']}}&y={{$entity['latitude']}}&z=16&e={{$entity['entity_id']}}" class="underline">マップ</a>）
        </td>
      </tr>
    @endforeach
  </table>
</div>

<script>
  window.show_entity = function(id) {
    var url = "/getEntity";
    var data = {id: id};
    $.ajax({
      url: url,
      data: data,
      type: 'POST',
      async: false,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
      }
    }).done(function(html) {
      $('#entity-header-message').html('データ詳細');
      $('#entity-body').html(html);
      $('#entity').modal('show');
    }).fail(function(jqXHR, textStatus, errorThrown) {
     //window.location.reload(true);
    });
  }
</script>

</x-app-layout>
