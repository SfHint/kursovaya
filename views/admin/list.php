
<?php
unset($p, $status, $opt);
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Админ</title>
  <link rel="stylesheet" href="/styles.css">
</head>
<body>
<div class="container">
  <h1>Админ — Опросы</h1>
  <p>
    <a href="admin.php?action=create" class="button button-green">Создать опрос</a>
    <a href="admin.php?action=logout" class="button button-gray">Выйти</a>
  </p>
  
  <?php foreach($polls as $p): 
    $now = new DateTime();
    $status = 'active';
    if($p['start_time'] && $now < new DateTime($p['start_time'])) $status = 'pending';
    elseif($p['end_time'] && $now > new DateTime($p['end_time'])) $status = 'finished';
  ?>
    <div class="card">
      <h2><?=htmlspecialchars($p['title'])?></h2>
      <p><?=nl2br(htmlspecialchars($p['description']))?></p>
      
      <div class="status-badge status-<?=$status?> admin-status">
        <?php 
          if($status === 'active') echo '▶ Идет';
          elseif($status === 'finished') echo '⏹ Завершен';
          else echo '⏸ Ожидается';
        ?>
      </div>
      
      <p>Доступно: <?= $p['start_time'] ?: 'всегда' ?> — <?= $p['end_time'] ?: 'без ограничений' ?></p>
      
      <p class="button-group">
        <a href="admin.php?action=edit&id=<?=$p['id']?>" class="button button-yellow">Редактировать</a>
        <a href="admin.php?action=delete&id=<?=$p['id']?>" class="button button-red" onclick="return confirm('Удалить опрос?')">Удалить</a>
        <a href="admin.php?action=results&id=<?=$p['id']?>" class="button button-blue">Результаты</a>
        <a href="index.php?action=show&id=<?=$p['id']?>" class="button button-green" target="_blank">Посмотреть</a>
      </p>
    </div>
  <?php endforeach; ?>
  
</div>
</body>
</html>