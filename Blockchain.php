<?php
class Block {
    public $block_index; // Changed from index to block_index
    public $previousHash;
    public $timestamp;
    public $data;
    public $hash;

    public function __construct($block_index, $previousHash, $timestamp, $data) {
        $this->block_index = $block_index; // Changed from index to block_index
        $this->previousHash = $previousHash;
        $this->timestamp = $timestamp;
        $this->data = $data;
        $this->hash = $this->calculateHash();
    }

    public function calculateHash() {
        return hash('sha256', $this->block_index . $this->previousHash . $this->timestamp . json_encode($this->data));
    }
}

class Blockchain {
    private $db;
    public $chain;

    public function __construct($db) {
        $this->db = $db;
        $this->chain = [];
        $this->loadFromDatabase();
    }

    public function createGenesisBlock() {
        $genesisBlock = new Block(0, "0", date('Y-m-d H:i:s'), "Genesis Block");
        $this->chain[] = $genesisBlock;
        $this->saveBlockToDatabase($genesisBlock);
    }

    public function addBlock($data) {
        $previousBlock = end($this->chain);
        $newBlockIndex = $previousBlock->block_index + 1; // Changed from index to block_index
        $newTimestamp = date('Y-m-d H:i:s');
        $newBlock = new Block($newBlockIndex, $previousBlock->hash, $newTimestamp, $data);
        $this->chain[] = $newBlock;
        $this->saveBlockToDatabase($newBlock);
    }

    private function saveBlockToDatabase($block) {
        $stmt = $this->db->prepare("INSERT INTO blockchain (block_index, previous_hash, timestamp, data, hash) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$block->block_index, $block->previousHash, $block->timestamp, json_encode($block->data), $block->hash]);
    }

    private function loadFromDatabase() {
        $stmt = $this->db->query("SELECT * FROM blockchain ORDER BY block_index ASC"); // Changed from index to block_index
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $block = new Block($row['block_index'], $row['previous_hash'], $row['timestamp'], json_decode($row['data'], true));
            $this->chain[] = $block;
        }

        if (empty($this->chain)) {
            $this->createGenesisBlock(); // Create genesis block if no blocks exist
        }
    }
}
?>