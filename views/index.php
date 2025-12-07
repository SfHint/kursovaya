<!doctype html>
<html>
<head><meta charset="utf-8"><title>Опросы</title>
<link rel="stylesheet" href="/styles.css">
</head>
<body>
<div class="container">
  <div class="header">
    <h1>Опросы</h1>
    <a href="admin.php" class="admin-link">Вход</a>
  </div>

<?php foreach($polls as $p): ?>
  <div class="card">
    <h2><?=htmlspecialchars($p['title'])?></h2>
    <p><?=nl2br(htmlspecialchars($p['description']))?></p>
   
    <div class="status-badge status-<?=$p['status']?>">
      <?php 
        if($p['status'] === 'active') echo '▶ Идет';
        elseif($p['status'] === 'finished') echo '⏹ Завершен';
        else echo '⏸ Ожидается';
      ?>
    </div>
    
    <p>Доступно: <?= $p['start_time'] ?: 'всегда' ?> — <?= $p['end_time'] ?: 'без ограничений' ?></p>
    
    <p>
      <?php if($p['status'] === 'active'): ?>
        <a href="index.php?action=show&id=<?=$p['id']?>" class="button button-green">Проголосовать</a>
      <?php else: ?>
        <a href="index.php?action=show&id=<?=$p['id']?>" class="button button-gray">Посмотреть результаты</a>
      <?php endif; ?>
    </p>
  </div>
<?php endforeach; ?>

</div>
</body>
</html>