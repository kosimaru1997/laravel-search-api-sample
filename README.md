# laravel_search_api_sample

## 環境

#### 言語
- PHP: 8.0.2

#### フレームワーク
- Laravel Framework: 9.42.2

#### その他
- Node: 16.15.0
- npm: 8.5.5

#### エディタ
- VsCode

## 環境構築

```
git clone https://github.com/kosimaru1997/laravel-search-api-sample.git
cd laravel-search-api-sample

// .envにAPI_KEY、検索IDを設定する(.env.exampleを参考に設定してください)
php artisan serve
npm run dev
```

http://localhost:8000 にアクセスし画面が表示されれば成功です。

## デバッグ

- Xdebugをインストール
https://xdebug.org/docs/install
- 8000ポートでサーバーを起動(php artisan serveを実行)
- VsCode上で 左側のタブから `Run and Debug(実行とデバッグ)`をクリックし、`Listen for Xdebug`を実行

## 参考情報

Custom Search API 
- ドキュメント: https://developers.google.com/custom-search/v1/overview?hl=ja
- 接続情報: https://developers.google.com/custom-search/v1/reference/rest/v1/cse/list#request

