<?php
class Vote {
    private $pdo;
    public function __construct($pdo){ $this->pdo = $pdo; }

    public function add($poll_id, $option_id){
        $stmt = $this->pdo->prepare("INSERT INTO vote (poll_id, option_id) VALUES (?, ?)");
        return $stmt->execute([$poll_id, $option_id]);
    }

    public function counts($poll_id){
        $stmt = $this->pdo->prepare("SELECT option_id, COUNT(*) as cnt FROM vote WHERE poll_id = ? GROUP BY option_id");
        $stmt->execute([$poll_id]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $out = [];
        foreach($rows as $r) $out[$r['option_id']] = (int)$r['cnt'];
        return $out;
    }
}
