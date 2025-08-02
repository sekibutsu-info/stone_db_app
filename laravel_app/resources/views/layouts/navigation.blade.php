<nav x-data="{ open: false }" class="bg-amber-50 border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex justify-between ">

            <div class="flex items-center md:ml-6 h-10">
                <div class="bg-emerald-600 text-white rounded-xl align-middle leading-tight text-center text-xs font-xs px-2 py-1">
                  <span style="white-space:nowrap;">みんなで</span><br/><span class="font-bold" style="white-space:nowrap;">石仏調査</span>
                </div>

                <x-dropdown align="left" width="36">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-1 py-2 border border-transparent text-sm font-medium font-bold rounded-md text-gray-600 bg-amber-50 hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            MAP
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('map')">
                            <span style="white-space:nowrap;">標準</span>
                        </x-dropdown-link>
                        <x-dropdown-link :href="route('all')">
                            <span style="white-space:nowrap;">全国版</span>
                        </x-dropdown-link>
                        <x-dropdown-link :href="route('mobile')">
                            <span style="white-space:nowrap;">モバイル</span>
                        </x-dropdown-link>
                        <x-dropdown-link :href="route('usage')">
                            <span style="white-space:nowrap;">操作方法</span>
                        </x-dropdown-link>
                    </x-slot>
                </x-dropdown>

                <x-dropdown align="left" width="36">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-1 py-2 border border-transparent text-sm font-medium font-bold rounded-md text-gray-600 bg-amber-50 hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            INFO
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('news')">
                            <span style="white-space:nowrap;">新着情報</span>
                        </x-dropdown-link>
                        <x-dropdown-link :href="route('newpics')">
                            <span style="white-space:nowrap;">新着写真</span>
                        </x-dropdown-link>
                        <x-dropdown-link :href="route('tag')">
                            <span style="white-space:nowrap;">タグ一覧</span>
                        </x-dropdown-link>
                        @auth
                          @if(Auth::user()->email_verified_at)
                            <x-dropdown-link :href="route('suggestions')">
                                改善提案
                            </x-dropdown-link>
                          @endif
                        @endauth
                        <x-dropdown-link :href="route('stats')">
                            統計情報
                        </x-dropdown-link>
                        <x-dropdown-link :href="route('howto')">
                            投稿方法
                        </x-dropdown-link>
                        <x-dropdown-link :href="route('about')">
                            About
                        </x-dropdown-link>
                        <x-dropdown-link :href="route('archive')" class="hidden">
                            アーカイブ
                        </x-dropdown-link>
                    </x-slot>
                </x-dropdown>

            </div>

            <!-- Settings Dropdown -->
            @auth
              <div class="flex items-center ml-6 h-10">
                <x-dropdown align="right" width="36">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-2 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-amber-50 hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->nickname }}</div>

                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('dashboard')">
                            <span style="white-space:nowrap;">ダッシュボード</span>
                        </x-dropdown-link>

                        <x-dropdown-link :href="route('mymap')">
                            マイマップ
                        </x-dropdown-link>

                        <x-dropdown-link :href="route('mypage')">
                            マイページ
                        </x-dropdown-link>

                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <x-dropdown-link :href="route('inquire')">
                            お問合せ
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
              </div>
            @else
              <div class="flex items-center ml-6 h-10" style="overflow-y:hidden;">
                <div class="relative items-top justify-center bg-amber-50 sm:items-center py-4 sm:pt-0" style="overflow-y:hidden;">
                  <div class=" top-0 right-0 px-6 py-4 sm:block" style="white-space:nowrap;">
                    <a href="{{ route('login') }}" class="text-sm text-gray-700 underline">ログイン</a>
                    @if (Route::has('register'))
                      <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline">登録</a>
                    @endif
                  </div>
                </div>
              </div>
            @endauth

        </div>
    </div>
</nav>
