<x-app-layout>

  @section('subtitle')- 投稿方法@endsection

  @push('ogp')
    <meta property="og:title" content="みんなで石仏調査 - 投稿方法" />
    <meta property="og:image" content="https://map.sekibutsu.info/icon.png" />
  @endpush

  @push('css')
    <link rel="stylesheet" href="/css/font-awesome.min.css" type="text/css" />
  @endpush

  <style>
  .button-like {
    border: solid 1px;
    border-radius: 5px;
    padding: 0 3px 0 3px;
    margin: 0 2px 0 2px;
  }
  </style>

    <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        投稿方法
      </h2>
    </x-slot>

    <div class="p-6">
      <div class="p-6 bg-white">

        <p class="text-xl p-2">目次</p>
        <p class="p-2">
          <span class="p-1">・</span><a href="#mindset">心構え</a><br>
          <span class="p-1">・</span><a href="#register">ユーザー登録</a><br>
          <span class="p-1">・</span><a href="#stone">データ収集対象の石造物</a><br>
          <span class="p-1">・</span><a href="#post">投稿方法</a><br>
          <span class="p-1">・</span><a href="#attribute">属性情報</a><br>
          <span class="p-1">・</span><a href="#photo">写真</a><br>
          <span class="p-1">・</span><a href="#file">画像ファイル</a><br>
          <span class="p-1">・</span><a href="#license">写真の著作権とライセンス</a><br>
          <span class="p-1">・</span><a href="#duplicate">重複投稿</a><br>
          <span class="p-1">・</span><a href="#detail">詳細編集</a><br>
          <span class="p-1">・</span><a href="#move">位置の移動</a><br>
          <span class="p-1">・</span><a href="#special">特別な属性情報</a><br>
          <span class="p-1">・</span><a href="#support">サポート</a><br>
        </p>

        <p id="mindset" class="text-xl p-2 mt-2">心構え</p>
        <p class="p-2">
        <b>みんなで石仏調査</b>は、石造物データの収集と公開のための、市民ボランティアによる「<b>プロジェクト</b>」です。決して、「無料で使える便利なWebサービス」ではありません。<br>
       「自分がやりたい事をやるために、このシステムをどう使うか」を考えるのではなく、「自分は何をすればこのプロジェクトに貢献できるか」を考えて行動する必要があります。<br>
        そのような考え方をできない場合は、プロジェクトの一員として相応しくありません。
        </p>

        <p id="register" class="text-xl p-2 mt-2">ユーザー登録</p>
        <p class="p-2">
        データの投稿には、画像ファイルを<a href="https://creativecommons.org/licenses/by/4.0/deed.ja" target="_blank" class="underline">CC BY 4.0ライセンス</a>で、
        石造物データを<a href="https://creativecommons.org/publicdomain/zero/1.0/deed.ja" target="_blank" class="underline">CC 0ライセンス</a>で公開することに同意した上で
        <a href="/register" class="underline">アカウント登録</a>して頂く必要があります。アカウント登録には、メールアドレスが必要です。<br>
        アカウントを登録すると、「メールアドレスの確認」という件名のメールが届きますので、メール本文に表示された<span class="button-like">メールアドレスの確認</span>ボタンまたはURLをクリックします。<br>
        アカウント登録しても、メールアドレスの確認が済んでいないと投稿できません。登録後1ヶ月を経過してもメールアドレスの確認が済んでいないアカウントは削除します。<br>
        <span style="color:#FF0000;">※ユーザー登録には招待コードが必要になりました。</span>招待コードは100件以上の投稿実績のある参加者に配布しています。<br>
        </p>

        <p id="stone" class="text-xl p-2 mt-2">データ収集対象の石造物</p>
        <p class="p-2">
        現在、データ収集の対象としている石造物は、<br>
        <span class="p-1">・</span>月待塔<br>
        <span class="p-1">・</span>日待塔（庚申塔、甲子塔、巳待塔）<br>
        <span class="p-1">・</span>地神塔（社日塔）<br>
        <span class="p-1">・</span>出羽三山塔（湯殿山塔、八日塔）<br>
        <span class="p-1">・</span>御嶽山塔（注：木曽御嶽山のみ。武蔵御岳山や霊神碑は除く）<br>
        <span class="p-1">・</span>道標（注：昭和20年までの造立に限る）<br>
        <span class="p-1">・</span>養蚕信仰塔（蚕神碑）<br>
        <span class="p-1">・</span>疫神塔（注：疫病そのものを神仏として祀るもの。疫病除けや病歿者供養全般ではない）<br>
        <span class="p-1">・</span>龍神塔（八大龍王、九頭龍神、倶利伽羅龍王）<br>
        <span class="p-1">・</span>大六天（第六天）塔<br>
        <span class="p-1">・</span>道祖神塔<br>
        です。<span style="color:#FF0000;border-bottom:solid 1px #FF0000;">対象外の石造物は登録できません</span>ので、注意して下さい。例えば馬頭観音塔や念仏塔などは、道標などを兼ねている場合を除いてデータ登録できません。対象外の石造物が投稿された場合は、システム管理者が削除します。
        </p>

        <p id="post" class="text-xl p-2 mt-2">投稿方法</p>
        <p class="p-2">
        ログインした状態のときにマップを表示すると、右上に<span class="button-like"><span class="fa fa-edit"></span></span>ボタンが表示されます。石造物のある位置をマップの中心にして<span class="button-like"><span class="fa fa-edit"></span></span>ボタンをクリックすると、［新規データ登録］画面が表示されます。
        </p>

        <p class="p-2">
        ［新規データ登録］画面では、位置を決定し、<a href="#attribute" class="underline">属性情報</a>の選択や入力、<a href="#photo" class="underline">写真</a>の添付、<a href="#license" class="underline">写真の著作権とライセンス</a>の確認と許諾をして<span class="button-like">登録</span>ボタンをクリックします。写真が添付されていなかったり、ライセンス許諾にチェックが付いていないときには、<span class="button-like">登録</span>ボタンは無効になっています。
        </p>
        <p class="p-2">
        原則的に、<b><span style="color:#FF0000;border-bottom:solid 1px #FF0000;">1件の投稿は1基のみの石造物を対象</span></b>として下さい。ただし、以下のような場合は例外です。<br>
        <span class="p-1">・</span>複数の丸石が集められた丸石道祖神は、個別の丸石を投稿せずに、全体を1つの投稿として下さい。五輪塔や宝篋印塔の残欠を積み重ねた多重塔道祖神が複数ある場合も1つの投稿として構いません（→<a href="https://map.sekibutsu.info/archive/33917" target="_blank" class="underline">投稿例</a>）<br>
        <span class="p-1">・</span>百庚申のように同じ形の石造物が集められている場合はまとめてしまって構いません（→<a href="https://map.sekibutsu.info/archive/14420" target="_blank" class="underline">投稿例</a>）。<br>
        <span class="p-1">・</span>灯籠型の石造物では、同じ形で同じ造立年の2基がセットになっている場合があり、そのようなものは1つの投稿として構いません（→<a href="https://map.sekibutsu.info/archive/13023" target="_blank" class="underline">投稿例</a>）。<br>
        <span class="p-1">・</span>七夜待塔は十七夜から二十三夜までの7基が独立している場合があり、そのような場合は7基セットで1つの投稿として構いません（→<a href="https://map.sekibutsu.info/archive/44" target="_blank" class="underline">投稿例</a>）。<br>
        <span class="p-1">・</span>出羽三山塔や御嶽山塔では、3つの山名が別の石に刻まれている場合があります。そのようなものは個別に投稿せず、1つの投稿にまとめるのが望ましいです（→<a href="https://map.sekibutsu.info/archive/25800" target="_blank" class="underline">投稿例</a>）。<br>
        </p>
        <p class="p-2">
        庚申塔と地神塔のように種類の異なる複数の石造物を1つの投稿にまとめてしまうと混在データになります。そのような投稿は推奨しません。
        </p>

        <p class="p-2">
        <span style="color:#FF0000">毎日AM 3:00～AM 4:00はシステムメンテナンスのため、この時間帯には投稿しないで下さい。</span>
        </p>

        <p id="attribute" class="text-xl p-2 mt-2">属性情報</p>

        <p class="p-2">
        <span class="p-1">・</span>緯度・経度<br>
        緯度経度は、マップの中心座標の値が自動的に入ります。
        </p>

        <p class="p-2">
        <span class="p-1">・</span>所在地<br>
        所在地は、マップの中心座標から取得した地名が自動的に入ります。地名の境界付近や飛び地などでは正しい地名が入らない場合もありますが、地名よりも緯度経度の方が重要ですので、マップ上での正しい位置を指定して下さい。地名のあとに表示される5桁の数字は市町村コードです。
        </p>

        <p class="p-2">
        <span class="p-1">・</span>場所<br>
        石造物の所在地について、地名よりも詳しい情報を記入します。路傍にある場合は「路傍」、神社や寺にある場合は「〇〇神社」「□□寺」などです。もう少し詳しく、「〇〇神社 拝殿脇」「□□寺 山門前」と記入するのも有用です。
        </p>

        <p class="p-2">
        <span class="p-1">・</span>種類<br>
        種類は、当てはまるものをチェックして下さい。複数選択可能ですので、道標を兼ねる地神塔の場合は「地神塔」と「道標」の2箇所にチェックを付けることになります。<br>
        種類が階層化されているものについては、下位の種類に当てはまるときは下位の種類にチェックして下さい。このとき、上位の種類にチェックを付けるかどうかは任意です。つまり、庚申塔の場合には「庚申塔」のチェックは必須で「日待塔」のチェックは任意です。ただし、龍神塔は下位の分類（八大龍王塔、九頭龍神塔、倶利伽羅龍王塔）のいずれにも当てはまらない場合のみ選択して下さい。
        </p>

        <p class="p-2">
        <span class="p-1">・</span>造立年（和暦）<br>
        和暦の造立年を入力します。「寛政十二庚申年」のように干支を付けて入力しても構いません。<br>
        造立年（和暦）を入力すると造立年（西暦）を自動的に登録する機能があります。ただし、漢数字の種類や異体字などの全てには対応していないので、使用する文字種や記法によっては正しく西暦に変換できない場合もあります。また、月日を考慮しない変換ですので、暦法の違いによって1年ズレる可能性もあります。<br>
        <span class="underline">再建塔は、（再建年が分かる場合は）再建年の方を入力します。</span>
        </p>

        <p class="p-2">
        <span class="p-1">・</span>造立年（西暦）<br>
        西暦での造立年を4桁の半角数字で入力します。
        </p>

        <p class="p-2">
        <span class="p-1">・</span>像容（刻像塔のみ）<br>
        刻像塔の場合、その像容をリストから選択します。リストに含まれていない像容の場合は、備考欄に「像容：弁財天」のように記入します。<br>
        複数の刻像がある場合は、代表的なものを1つ選択し、他は備考に記入します。<br>
        混在データでない限り、像容と主尊銘の両方が選択されることはありません。
        </p>

        <p class="p-2">
        <span class="p-1">・</span>主尊銘（文字塔のみ）<br>
        主尊銘が刻まれている文字塔では、その主尊名をリストから選択します。リストに含まれていない主尊銘の場合は、備考欄に「主尊銘：弁財天」のように記入します。<br>
        複数の主尊銘がある場合は、代表的なものを1つ選択し、他は備考に記入します。<br>
        混在データでない限り、像容と主尊銘の両方が選択されることはありません。
        </p>

        <p class="p-2">
        <span class="p-1">・</span>写真撮影日<br>
        添付した写真の撮影日を入力します。その写真がいつ時点での石造物を写したものであるかは重要な情報ですので、分かる限り入力して下さい。
        </p>

        <p class="p-2">
        <span class="p-1">・</span>プロジェクト<br>
        <a href="https://moon.sekibutsu.info/" class="underline" target="_blank">月待ビンゴ プロジェクト</a>の参加者が月待塔を投稿するときにチェックを付けます。
        </p>

        <p class="p-2">
        <span class="p-1">・</span>備考<br>
        以上の既定の属性情報では入力できない情報を記入します。石造物の情報として有用な内容のみ記載して下さい。<br>
        例えば、道標の場合には「従是右〇〇道」のような道標銘の情報は有用です（→<a href="https://map.sekibutsu.info/archive/12792" target="_blank" class="underline">入力例</a>）。また、文献を参考にした場合、その書籍名やページ番号の情報も有用です。
        </p>

        <p id="photo" class="text-xl p-2 mt-2">写真</p>
        <p class="p-2">
        1つの投稿に最大で5枚までの写真を添付することができます。6枚以上の写真を添付するために複数の投稿に分割するのは不可です。また、原則的に1つの投稿には同じ日に撮影した写真のみを添付して下さい。<br>
        写真は、全体写真、部分写真、状況写真、補足写真の4つに分類することができます。<br>
        </p>

        <p class="p-2">
        <span class="p-1">・</span>全体写真<br>
        投稿の1枚目の写真には、石造物の全体が過不足なく写った全体写真を添付して下さい。<br>
        <span style="color:#FF0000;">複数の石造物を1枚の写真に収めて複数の投稿で使い回すのは不可</span>です。<br>
        石造物があまりにも小さい写真、複数の石造物が写っていてデータの対象がどれか分からない写真は不適切です。<br>
        障害物があって石造物の一部が隠れてしまうのは仕方ありません。隠れた部分を別のアングルから撮影できれば、部分写真として添付するというのも良い方法です。<br>
        </p>

        <p class="p-2">
        <span class="p-1">・</span>部分写真<br>
        紀年銘や道標銘などの重要な情報は、必要に応じて部分写真として添付して下さい。<br>
        正面から撮影した全体写真には写らなかった側面や背面の写真や、全体写真では小さくて判読しにくい場合のクローズアップなどの部分写真は有用です。<br>
        </p>

        <p class="p-2">
        <span class="p-1">・</span>状況写真<br>
        石造物が置かれた状況がわかる状況写真は、必要に応じて添付して下さい。<br>
        例えば覆屋に入っている場合、その覆屋の置かれた状況が分かる写真は有用です。<br>
        同じ場所にある複数の石造物を投稿する場合に、同じ状況写真を複数の投稿に重複して添付しないで下さい。この場合、どれか1つの投稿に添付すれば十分です。<br>
        </p>

        <p class="p-2">
        <span class="p-1">・</span>補足写真<br>
        石造物の近くに、その石造物について説明した解説版が立っていることがあります。必要に応じて、補足写真として添付すると有用です。<br>
        ただし、石造物について説明した書籍のページを撮影して添付することは禁止します。<br>
        </p>

        <p class="p-2">
        <span class="p-1">・</span>不要な写真<br>
        石造物とは無関係な写真は添付しないで下さい。石造物が寺や神社にある場合でも、寺や神社の建物の写真で石造物が写っていないものは不要です。<br>
        </p>

        <p class="p-2">
        不要な写真、禁止事項に違反した写真はシステム管理者が削除します。
        </p>

        <p id="file" class="text-xl p-2">画像ファイル</p>
        <p class="p-2">投稿に添付する画像ファイルはJPEG形式で、解像度はフルHD（1,920×1,080）から4K（3,840×2,160）程度を目安として下さい。<br>
        最低でも800×600以上の大きさでないと添付できません。4Kを超える画像は4Kに収まるサイズに縮小されます。<br>
        複数の写真を合成した画像、<span style="color:#FF0000;">露出補正や色補正以外の加工をした画像の投稿は禁止</span>します。そのような写真はシステム管理者が削除します。
        </p>

        <p id="license" class="text-xl p-2">写真の著作権とライセンス</p>
        <p class="p-2">著作権を持たない写真は決して添付しないで下さい。投稿した写真の著作権は投稿者に帰属しますが、<a href="https://creativecommons.org/licenses/by/4.0/deed.ja" target="_blank" class="underline">CC BY 4.0ライセンス</a>で公開され、一度許諾したライセンスは取り消すことはできません。
        </p>

        <p id="duplicate" class="text-xl p-2 mt-2">重複投稿</p>
        <p class="p-2">
        既に投稿されている石造物を重複して投稿する場合は、アップデートまたはアップグレードの基準を満たしている場合に限定して下さい。
        </p>

        <p class="p-2">
        <span class="p-1">・</span>アップデート<br>
        アップデートとは、最新の情報への更新です。例えば、石造物の置かれた位置が変更されたり、露座だったものが覆屋に入れられたりという変化があった場合に、最新状況へのアップデート投稿は有用です。
        </p>

        <p class="p-2">
        <span class="p-1">・</span>アップグレード<br>
        アップグレードは、情報の追加（詳細化）です。例えば、既存の投稿には紀年銘の情報がなかった場合に、紀年銘の部分写真を添付してアップグレード投稿するのは有用です。<br>
        ただし、<span style="color:#FF0000;">全体写真なしに部分写真や状況写真、補足写真のみを投稿するのは不可</span>です。また、添付し忘れた写真や、6枚以上の写真を添付するために重複投稿するのは不可です。
        </p>

        <p id="detail" class="text-xl p-2 mt-2">詳細編集</p>
        <p class="p-2">
        ログインした状態のときに、自分が投稿した石造物の［データ詳細］画面を表示すると、画面の一番下に「このデータを詳細編集」というリンクが表示されます。リンクをクリックすると［データの詳細編集］画面が表示され、位置情報の修正や、属性情報の削除などが可能です。
        </p>

        <p id="move" class="text-xl p-2 mt-2">位置の移動</p>
        <p class="p-2">
       ［データの詳細編集］画面での移動は、位置情報が正確でなかった場合の修正のためのものです。<br>
        石造物が移設されて位置が変わった場合には、位置情報を修正するのではなく、「不在種別」を「移設」にします。移設後の位置で再登録する際には、移設後に撮影した写真を使用しなければなりません。
        </p>

        <p id="special" class="text-xl p-2 mt-2">特別な属性情報</p>
        <p class="p-2">
        ［新規データ登録］画面では入力できない、特別な属性情報があります。
        </p>

        <p class="p-2">
        <span class="p-1">・</span>タグ<br>
        タグは、特別な権限を持つユーザーだけが付与することのできる情報です。タグの種類は<a href="/tag" class="underline" target="_blank">タグ一覧</a>を参照して下さい。<br>
        データにタグを付けて欲しい場合には、「タグ付けの提案」でタグを選択します。
        </p>

        <p class="p-2">
        <span class="p-1">・</span>参考URL<br>
        当該石造物についての情報が記載されたWebページのURLを［データ詳細］画面で追加することができます（→<a href="https://map.sekibutsu.info/archive/6445" target="_blank" class="underline">入力例</a>）。サイトのトップベージなど、当該石造物についての情報が直ぐに得られないURLでは役に立たないので不可です。
        </p>

        <p class="p-2">
        <span class="p-1">・</span>3Dモデル<br>
        当該石造物の3Dモデル（メッシュデータ）のURLを［データ詳細］画面で追加することができます（→<a href="https://map.sekibutsu.info/archive/3075" target="_blank" class="underline">入力例</a>）。リンク先の3Dモデルは投稿者が作成したものに限ります。
        </p>

        <p class="p-2">
        <span class="p-1">・</span>不在種別<br>
        マップに示される所在地に当該石造物が現存しない場合に、［データの詳細編集］画面で「所在不明」または「移設」を選択します（→<a href="https://map.sekibutsu.info/archive/9909" target="_blank" class="underline">入力例</a>）。データに不在種別が入力されると、全国版マップには白いマーカーで表示されます。
        </p>

        <p class="p-2">
        <span class="p-1">・</span>同一物<br>
        当該石造物が既に登録されている場合、そのデータのIDを［データの詳細編集］画面で入力します。データのIDは、<br>
        https://map.sekibutsu.info/archive/<i>数字</i><br>
        という形式のPermalinkの<i>数字</i>の部分です。

        <p id="support" class="text-xl p-2 mt-2">サポート</p>
        <p class="p-2">
        ご不明な点がありましたら、X（旧・ツイッター）アカウント <a href="https://twitter.com/tsukimachito" target="_blank" class="underline">@tsukimachito</a> に問い合わせて下さい。
        </p>

      </div>
    </div>

</x-app-layout>
