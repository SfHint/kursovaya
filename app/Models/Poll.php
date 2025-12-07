<?php
class Poll {
    private $pdo;
    public function __construct($pdo){ $this->pdo = $pdo; }

    public function all(){
        $stmt = $this->pdo->query("SELECT * FROM poll ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id){
        $stmt = $this->pdo->prepare("SELECT * FROM poll WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($title, $description, $optionsJson, $start_time, $end_time){
        $stmt = $this->pdo->prepare("INSERT INTO poll (title, description, options, start_time, end_time) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$title, $description, $optionsJson, $start_time ?: null, $end_time ?: null]);
    }

    public function update($id, $title, $description, $optionsJson, $start_time, $end_time){
        $stmt = $this->pdo->prepare("UPDATE poll SET title=?, description=?, options=?, start_time=?, end_time=? WHERE id=?");
        return $stmt->execute([$title, $description, $optionsJson, $start_time ?: null, $end_time ?: null, $id]);
    }

    public function delete($id){
        $stmt = $this->pdo->prepare("DELETE FROM poll WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
