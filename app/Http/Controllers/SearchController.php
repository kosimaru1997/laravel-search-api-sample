<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * 検索コントローラー
 */
class SearchController extends Controller
{
  /**
  * トップページ
  */
  public function top() {
    $input_word = null;
    $items = null;
    return view('top', compact('input_word', 'items'));
  }

  /**
  * 検索実行
  */
  public function search() {

    // formの受け取り(クエリパラメータの取得)
    // 入力内容が、「半角スペース」、「全角スペース」、「+」だけの場合$wordをnullをする
    $input_word =
      (isset($_GET['word']) && !preg_match('/^[\s|\+]+$/u' ,$_GET['word']))
        ? $_GET['word']
        : null;
    $start = (isset($_GET['start'])) ? $_GET['start'] : 1;
    $items = null;
    $word = $this->replace_input_word($input_word);

    if ($word == null) {
      return view('top', compact('input_word', 'items'));
    }

    $url = $this->get_request_url($word, $start);
    $result = $this->get_search_api_res($url);
    list($items, $previousIndex, $nextIndex) = $this->get_search_api_info($result);

    return view('top', compact('input_word', 'word', 'items', 'previousIndex', 'nextIndex'));
  }

  /**
   * 検索ワードの置換
   */
  private function replace_input_word($input_word) {
    $word = null;
    if ($input_word != null) {
      // 半角スペース、全角スペースの置換(URL設定のため)
      $word = str_replace(' ', '+', $input_word);
      $word = str_replace('　', '+', $word);
    }
    return $word;
  }

  /**
   * エンドポイントの取得
   */
  private function get_request_url($word, $start) {
    // 環境変数の読み込み
    $URL = $_ENV['SEARCH_URL'];
    $API_KEY = $_ENV['SEARCH_API_KEY'];
    $CX = $_ENV['SEARCH_CX'];

    $request_url = "{$URL}?key={$API_KEY}&cx={$CX}&q={$word}&start={$start}";

    return $request_url;
  }

  /**
   * カスタム検索APIのレスポンスから、検索結果とインデックスの取得
   */
  private function get_search_api_res($request_url) {
    try {
      // エラー時の処理を登録
      set_error_handler(function(){
      throw new Exception();
    });

    $result_json = file_get_contents($request_url, true);
    $result = json_decode($result_json, true);
    } catch(Exception $e) {
      echo "カスタム検索APIの呼び出し時に予期せぬエラーが発生しました";
    } finally {
      restore_error_handler();
    };
    return $result;
  }

  private function get_search_api_info($result) {

    $items = $result['items'];

    // 前ページのインデックスを取得
    $previousPage =
      array_key_exists('previousPage', $result['queries'])
        ? array_shift($result['queries']['previousPage'])
        : null;
    $previousIndex =
      $previousPage != null && array_key_exists('startIndex', $previousPage)
        ? $previousPage['startIndex']
        : null;
    // 次ページのインデックスを取得
    $nextPage =
      array_key_exists('nextPage', $result['queries'])
        ? array_shift($result['queries']['nextPage'])
        : null;
    $nextIndex =
      $nextPage != null && array_key_exists('startIndex', $nextPage)
        ? $nextPage['startIndex']
        : null;

	return array($items, $previousIndex, $nextIndex);
  }

}
