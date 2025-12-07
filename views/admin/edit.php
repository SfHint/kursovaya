
<!doctype html>
<html><head><meta charset="utf-8"><title>Редактирование</title><link rel="stylesheet" href="../styles.css"></head><body>
<div class="container"><h1>Редактирование опроса</h1>
<form method="post">
  <input name="title" value="<?=htmlspecialchars($poll['title'])?>" required><br>
  <textarea name="description"><?=htmlspecialchars($poll['description'])?></textarea><br>
  <textarea name="options"><?php
    $opts = json_decode($poll['options'], true);
    foreach($opts as $o) echo htmlspecialchars($o['text']) . "\n";
    unset($o);
  ?></textarea><br>
  Время начала: <input name="start_time" value="<?=htmlspecialchars($poll['start_time'])?>"><br>
  Время конца: <input name="end_time" value="<?=htmlspecialchars($poll['end_time'])?>"><br>
  <button>Сохранить</button>
</form>
<p><a href="admin.php" class="button button-gray">Назад</a></p>
</div></body></html>
