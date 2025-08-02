<x-app-layout>

  @section('subtitle', ' - 改善提案')

  @push('css')
    <link rel="stylesheet" href="/css/font-awesome.min.css" type="text/css" />
  @endpush

  @push('scripts')
    <script type="text/javascript" src="/js/jquery-3.6.3.js"></script>
  @endpush

    <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
          改善提案
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

  <div id="reply-popup" style="z-index:1060;background-color:rgba(0, 0, 0, 0.5);" class="modal fade fixed top-0 left-0 hidden w-full h-full outline-none overflow-x-hidden overflow-y-auto" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered relative w-auto pointer-events-none">
      <div class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none text-current">
        <div id="reply-popup-body" class="modal-body relative p-4" >
        </div>
      </div>
    </div>
  </div>

<div class="p-1">
  <table class="w-full table-fixed">
    <tr class="bg-gray-100 border-b border-gray-200">
      <td class="p-2">※一ヶ月を経過しても回答が得られなかった提案は、システム管理者がクローズすることがあります。</td>
    </tr>
    @php
      $odd = false;
    @endphp
    @foreach($suggestions as $suggestion)
      @if($odd)
        <tr class="bg-gray-100 border-b border-gray-200">
      @else
        <tr class="bg-white border-b border-gray-200">
      @endif
      @php
        $odd = !$odd;
      @endphp
      @if($suggestion['closed'])
        <td class="w-full text-gray-600">
          @if($suggestion['useful'])
            <i class="fa fa-check-square-o" aria-hidden="true"></i>
          @else
            <i class="fa fa-minus-square-o" aria-hidden="true"></i>
          @endif
      @else
        <td class="w-full">
          <i class="fa fa-square-o" aria-hidden="true"></i>
      @endif
          @if($suggestion['contributor_id'] == 0)
            {{$suggestion['suggested_at']->format('Y年m月d日');}}：
            {{$suggestion['suggested_nickname']}} さんから
            <a onClick="javascript:show_entity({{$suggestion['entity_id']}});" class="underline cursor-pointer">No.{{$suggestion['entity_id']}}</a>
            にタグ：{{$suggestion['suggestion']}}の提案
          @else
            {{$suggestion['suggested_at']->format('Y年m月d日');}}：
            {{$suggestion['suggested_nickname']}} さんから
            <a onClick="javascript:show_entity({{$suggestion['entity_id']}});" class="underline cursor-pointer">No.{{$suggestion['entity_id']}}</a>
            （{{$suggestion['contribute_nickname']}}さん）へのコメント：
            {{$suggestion['suggestion']}}
          @endif
          @if($suggestion['reply'] === 1)
            <br><i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
            {{$suggestion['replied_at']->format('Y年m月d日');}}：
            {{$suggestion['replied_nickname']}} さんの回答：{{$suggestion['reply_comment']}}
          @elseif($suggestion['reply'] === 0)
            <br><i class="fa fa-thumbs-o-down" aria-hidden="true"></i>
            {{$suggestion['replied_at']->format('Y年m月d日');}}：
            {{$suggestion['replied_nickname']}} さんの回答：{{$suggestion['reply_comment']}}
          @elseif(!$suggestion['closed'])
            @if(Auth::user()->id == $suggestion['contributor_id'])
              <br><a onClick="javascript:show_reply_popup({{$suggestion['suggestion_id']}}, false);" class="underline cursor-pointer">回答する</a>
            @elseif($enabled_tags)
              @if(in_array($suggestion['suggestion'], $enabled_tags, true))
                <br><a onClick="javascript:show_reply_popup({{$suggestion['suggestion_id']}}, false);" class="underline cursor-pointer">回答する</a>
              @endif
            @endif
          @endif
          @if($suggestion['decision'] === 1)
            <br><i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
            {{$suggestion['decided_at']->format('Y年m月d日');}}：
            システム管理者（{{$suggestion['decided_nickname']}}）の回答：{{$suggestion['decision_comment']}}
          @elseif($suggestion['decision'] === 0)
            <br><i class="fa fa-thumbs-o-down" aria-hidden="true"></i>
            {{$suggestion['decided_at']->format('Y年m月d日');}}：
            システム管理者（{{$suggestion['decided_nickname']}}）の回答：{{$suggestion['decision_comment']}}
          @elseif(!$suggestion['closed'] && Auth::user()->admin)
            <br><a onClick="javascript:show_reply_popup({{$suggestion['suggestion_id']}}, true);" class="underline cursor-pointer">管理者として回答する</a>
          @endif
          @if(!$suggestion['closed'] && Auth::user()->admin)
            <br><a onClick="javascript:show_close_popup({{$suggestion['suggestion_id']}});" class="underline cursor-pointer">クローズする</a>
          @endif
        </td>
      </tr>
    @endforeach
  </table>
</div>

<script>

  $('#reply-popup').on('hidden.bs.modal', function () {
    window.location.reload(true);
  })

  window.show_reply_popup = function(id, admin) {
    $('#reply-popup-body').html(
      '<div class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 rounded-t-md" id="entity-header">' +
        '提案への回答' +
        '<button type="button" class="btn-close box-content w-4 h-4 p-1 text-black border-none rounded-none opacity-50 focus:shadow-none focus:outline-none focus:opacity-100 hover:text-black hover:opacity-75 hover:no-underline" data-bs-dismiss="modal" aria-label="閉じる"></button>' +
      '</div>' +
        '<form method="POST" id="reply_suggestion">' +
          '<div style="margin-top:10px;">' +
            '<input type="radio" name="reply_agreement" id="reply_agreement0" value="1" checked> <i class="fa fa-thumbs-o-up" aria-hidden="true"></i> 同意する ' +
            '<input type="radio" name="reply_agreement" id="reply_agreement0" value="0"> <i class="fa fa-thumbs-o-down" aria-hidden="true"></i> 同意しない' +
          '</div>' +
          '<div style="margin-top:10px;">' +
            '<textarea id="reply_comment" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg w-full p-1" name="reply_comment" maxlength="1000"></textarea>' +
            '<div style="margin-top:10px;">' +
              '<input type="button" id="reply_suggestion_button" class="text-white bg-blue-200 font-medium rounded-lg text-sm px-5 py-2 text-center cursor-default" value="回答" disabled />' +
              '<span style="margin-top:10px;" id="reply_result" />' + 
            '</div>' +
            '<input type="hidden" id="reply_suggestion_id" name="reply_suggestion_id" value="' + id + '" />' +
          '</div>' +
        '</form>' +
      '</div>' +
      '<div class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-end p-4 border-t border-gray-200 rounded-b-md" style="margin-top:10px;">' +
        '<button type="button" class="inline-block px-6 py-2.5 bg-gray-700 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-gray-900 hover:shadow-lg focus:bg-gray-900 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-gray-900 active:shadow-lg transition duration-150 ease-in-out" data-bs-dismiss="modal">閉じる</button>' +
      '</div>'
    );
    $('#reply-popup').modal('show');

    var replied = false;

    $('#reply_comment').on('keyup', function() {
      change_reply_suggestion_button_status();
    });

    $('#reply_suggestion_button').on('click', function() {
      reply_suggestion();
    });

    function reply_suggestion() {
      $('#reply_suggestion_button').prop('disabled', true);
      $('#reply_suggestion_button').addClass('bg-blue-200');
      $('#reply_suggestion_button').removeClass('bg-blue-600');
      $('#reply_suggestion_button').addClass('cursor-default');
      $('#reply_suggestion_button').removeClass('cursor-pointer');

      if(admin) {
        var url = "/decideSuggestion";
      } else {
        var url = "/replySuggestion";
      }
      var formdata = new FormData($('#reply_suggestion').get(0));
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
          $('#reply_result').html(' 回答ありがとうございます');
          replied = true;
        } else {
          $('#reply_result').html(' 回答できませんでした');
        }
      }).fail(function() {
        $('#reply_result').html(' 回答できませんでした');
      });
    }

    function change_reply_suggestion_button_status () {
      if( $('#reply_comment').val() != '' && !replied) {
        $('#reply_suggestion_button').prop('disabled', false);
        $('#reply_suggestion_button').removeClass('bg-blue-200');
        $('#reply_suggestion_button').addClass('bg-blue-600');
        $('#reply_suggestion_button').removeClass('cursor-default');
        $('#reply_suggestion_button').addClass('cursor-pointer');
      } else {
        $('#reply_suggestion_button').prop('disabled', true);
        $('#reply_suggestion_button').addClass('bg-blue-200');
        $('#reply_suggestion_button').removeClass('bg-blue-600');
        $('#reply_suggestion_button').addClass('cursor-default');
        $('#reply_suggestion_button').removeClass('cursor-pointer');
      }
    }
  }

  window.show_close_popup = function(id) {
    $('#reply-popup-body').html(
      '<div class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 rounded-t-md" id="entity-header">' +
        '提案をクローズ' +
        '<button type="button" class="btn-close box-content w-4 h-4 p-1 text-black border-none rounded-none opacity-50 focus:shadow-none focus:outline-none focus:opacity-100 hover:text-black hover:opacity-75 hover:no-underline" data-bs-dismiss="modal" aria-label="閉じる"></button>' +
      '</div>' +
        '<form method="POST" id="close_suggestion">' +
          '<div style="margin-top:10px;">' +
            '<input type="radio" name="useful" id="useful" value="1" checked> <i class="fa fa-thumbs-o-up" aria-hidden="true"></i> 有用 ' +
            '<input type="radio" name="useful" id="useful" value="0"> <i class="fa fa-thumbs-o-down" aria-hidden="true"></i> 無用' +
          '</div>' +
          '<div style="margin-top:10px;">' +
            '<div style="margin-top:10px;">' +
              '<input type="button" id="close_suggestion_button" class="text-white bg-blue-600 font-medium rounded-lg text-sm px-5 py-2 text-center cursor-pointer" value="クローズ" />' +
              '<span style="margin-top:10px;" id="close_result" />' + 
            '</div>' +
            '<input type="hidden" id="close_suggestion_id" name="close_suggestion_id" value="' + id + '" />' +
          '</div>' +
        '</form>' +
      '</div>' +
      '<div class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-end p-4 border-t border-gray-200 rounded-b-md" style="margin-top:10px;">' +
        '<button type="button" class="inline-block px-6 py-2.5 bg-gray-700 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-gray-900 hover:shadow-lg focus:bg-gray-900 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-gray-900 active:shadow-lg transition duration-150 ease-in-out" data-bs-dismiss="modal">閉じる</button>' +
      '</div>'
    );
    $('#reply-popup').modal('show');

    $('#close_suggestion_button').on('click', function() {
      close_suggestion();
    });

    function close_suggestion() {
      var url = "/closeSuggestion";
      var formdata = new FormData($('#close_suggestion').get(0));
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
          $('#close_result').html(' クローズしました');
          replied = true;
        } else {
          $('#close_result').html(' クローズできませんでした');
        }
      }).fail(function() {
        $('#close_result').html(' クローズできませんでした');
      });
    }
  }

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
