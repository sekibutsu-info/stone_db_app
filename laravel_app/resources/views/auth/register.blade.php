<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div>
          <input type="checkbox" id="license_agreement" />
          <label for="license_agreement">投稿した画像を<a href="https://creativecommons.org/licenses/by/4.0/deed.ja" target="_blank" class="underline">CC BY 4.0ライセンス</a>で、石造物データを<a href="https://creativecommons.org/publicdomain/zero/1.0/deed.ja" target="_blank" class="underline">CC 0ライセンス</a>で公開することに同意してアカウント登録します。</label>
        </div>
        <br/>

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- ニックネーム -->
        <div class="mt-4">
            <x-input-label for="nickname" :value="__('Nickname')" />
            <x-text-input id="nickname" class="block mt-1 w-full" type="text" name="nickname" :value="old('nickname')" required autofocus />
            <x-input-error :messages="$errors->get('nickname')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- 招待コード -->
        <div class="mt-4">
            <x-input-label for="invitation_code" :value="__('Invitaion Code')" />
            <x-text-input id="invitation_code" class="block mt-1 w-full" type="text" name="invitation_code" :value="old('invitation_code')" required autofocus />
            <x-input-error :messages="$errors->get('invitation_code')" class="mt-2" />
        </div>

        <div style="margin-top:10px;">
          ※ユーザー名はログイン時に使用します。ニックネームはデータ作成者名の表示に使用します。
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ml-4" id="submit_button" disabled>
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>

    <script>
    $('#license_agreement').change(function() {
      if( $('#license_agreement').prop('checked') ) {
        $('#submit_button').prop('disabled', false);
      } else {
        $('#submit_button').prop('disabled', true);
      }
    });
    </script>

</x-guest-layout>
