<x-app-layout>

  @push('ogp')
    <meta property="og:title" content="みんなで石仏調査" />
    <meta property="og:image" content="https://map.sekibutsu.info/icon.png" />
  @endpush

    <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        みんなで石仏調査 について
      </h2>
    </x-slot>

    <div class="p-6">
    <div class="p-6 bg-white">
      @component('components.about-common', ['num_data' => $num_data])
      @endcomponent
    </div>
    </div>

</x-app-layout>
