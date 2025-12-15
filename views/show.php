<?php
$hasVoted = false;
if(isset($_COOKIE['voted_polls'])) {
    $votedPolls = json_decode($_COOKIE['voted_polls'], true) ?? [];
    $hasVoted = in_array($poll['id'], $votedPolls);
}
?>
<!--  //////////// -->
<!doctype html>
<html>
<head><meta charset="utf-8"><title><?=htmlspecialchars($poll['title'])?></title>
<link rel="stylesheet" href="/styles.css">  
<?php if($config['recaptcha_site_key']): ?>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<?php endif; ?>
</head>
<body>
<div class="container">
<h1><?=htmlspecialchars($poll['title'])?></h1>
<p><?=nl2br(htmlspecialchars($poll['description']))?></p>
 
<div class="status-panel status-<?=$poll['status']?>">
  <?php if($poll['status'] === 'active'): ?>
    <strong>▶ Голосование активно</strong><br>
    До: <?= $poll['end_time'] ?: 'без ограничений' ?>
  <?php elseif($poll['status'] === 'finished'): ?>
    <strong>⏹ Голосование завершено</strong><br>
    Завершен: <?= $poll['end_time'] ?>
  <?php else: ?>
    <strong>⏸ Ожидается начало</strong><br>
    Начало: <?= $poll['start_time'] ?>
  <?php endif; ?>
</div>

<?php
$options = json_decode($poll['options'], true);
$counts = $counts ?? [];
$total = array_sum($counts);
?>

<?php if(isset($_GET['voted'])): ?>
  <p class="note">Спасибо! Ваш голос учтён.</p>
<?php endif; ?>
<!--  //////////// -->
<?php if($hasVoted): ?>
  <p class="note">Вы уже проголосовали в этом опросе ранее. Результаты доступны ниже.</p>
<?php endif; ?>
<!--  ////////////  и снизу строка-->
<?php if($poll['status'] === 'active' && !$hasVoted): ?>
<form method="post" action="index.php?action=vote&id=<?=$poll['id']?>">
  <?php foreach($options as $opt): ?>
    <div><label><input type="radio" name="option" value="<?=$opt['id']?>" required> <?=htmlspecialchars($opt['text'])?></label></div>
  <?php endforeach; ?>
  <?php if($config['recaptcha_site_key']): ?>
    <div class="g-recaptcha" data-sitekey="<?=$config['recaptcha_site_key']?>"></div>
  <?php endif; ?>
  <button>Голосовать</button>
</form>
<!--  //////////// -->
<?php elseif($poll['status'] !== 'active' && $hasVoted): ?>
  <p class="note">Вы участвовали в этом опросе. Итоги голосования:</p>
<?php elseif($poll['status'] !== 'active'): ?>
  <p>Голосование недоступно в данный момент.</p>
<?php endif; ?>
<!--  //////////// -->
<h3>Результаты</h3>
<?php foreach($options as $opt):
  $c = $counts[$opt['id']] ?? 0;
  $pct = $total ? round($c / $total * 100, 1) : 0;
?>
  <div class="result-row">
    <div class="label"><?=htmlspecialchars($opt['text'])?></div>
    <div class="bar"><div class="bar-inner" style="width:<?=$pct?>%"></div></div>
    <div class="count"><?=$c?> (<?=$pct?>%)</div>
  </div>
<?php endforeach; ?>
    
<p><a href="index.php" class="button button-gray">Назад к списку</a></p>
</div>
</body>
</html>