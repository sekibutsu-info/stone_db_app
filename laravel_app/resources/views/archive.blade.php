<x-app-layout>

  @if($id=='all')
    @push('ogp')
      <meta property="og:url" content="https://map.sekibutsu.info/archive" />
      <meta property="og:image" content="https://map.sekibutsu.info/icon.png" />
    @endpush
  @else
    @section('pretitle'){{$address}} {{$place}}の{{$types}} | @endsection
    @push('ogp')
      <meta property="og:url" content="https://map.sekibutsu.info/archive/{{ $id }}" />
      @isset($images[0])
        <meta property="og:image" content="https://map.sekibutsu.info/images/{{ $images[0] }}" />
      @endisset
      <meta property="og:title" content="{{$address}} {{$place}}の{{$types}} | みんなで石仏調査" />
    @endpush
  @endif

  @push('css')
    <link rel="stylesheet" href="/css/font-awesome.min.css" type="text/css" />
  @endpush

  @push('scripts')
    <script type="text/javascript" src="/js/jquery-3.6.3.js"></script>
  @endpush

  <div id="photo-popup" style="z-index:1060;background-color:rgba(0, 0, 0, 0.5);" class="modal fade fixed top-0 left-0 hidden w-full h-full outline-none overflow-x-hidden overflow-y-auto" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered relative w-auto pointer-events-none">
      <div class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none text-current">
        <div id="photo-popup-body" class="modal-body relative p-4" data-bs-dismiss="modal" >
        </div>
      </div>
    </div>
  </div>

  <div class="p-4">
  @if($id=='all')
    @foreach($entities as $entity)
      <a href="https://map.sekibutsu.info/archive/{{$entity['entity_id']}}">
        https://map.sekibutsu.info/archive/{{$entity['entity_id']}}
      </a><br>
    @endforeach
  @else
    @include('get_entity')
  @endif
  </div>

</x-app-layout>
