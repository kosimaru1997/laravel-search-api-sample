<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>PHP search api</title>
  </head>
  <body class="">

    <div class="search">
      <form method="GET" action="/search">
      <input class="search-form" name="word" type="text" value="<?php echo $input_word; ?>" placeholder="looking for">
      <input class="search-btn" type="submit" value="Search">
      </form>
    </div>

    <?php if ($items == null) : ?>
      <p>検索ワードを入力してください</p>
    <?php else : ?>
    <div class="contents">
      <?php foreach ($items as $key => $item) : ?>
      <blockquote class="wp-block-quote">
      <a href="<?php echo $item['link']; ?>">
          <?php echo $item['title']; ?>
      </a>
      <p>
          <?php echo $item['snippet']; ?>
      </p>
      </blockquote>
      <?php endforeach; ?>
    </div>

    <div class="page-nate">
      <ul class="page-nate-list">
      <?php if ($previousIndex != null) : ?>
          <a href=<?php echo "/search?word={$word}&start={$previousIndex}" ?>><li>前へ</li></a>
      <?php endif; ?>
      <?php if ($nextIndex != null) : ?>
      <a href=<?php echo "/search?word={$word}&start={$nextIndex}" ?>><li>次へ</li></a>
      <?php endif; ?>
      </ul>
    </div>
    <?php endif; ?>
  </body>
</html>
