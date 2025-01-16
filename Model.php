<?php

require_once "model/Request.php";
require_once "model/User.php";


class Model {

    private PDO $pdo;

    public function __construct(string $dsn) {
        $this->pdo = new PDO($dsn);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function fetchAll(string $query, array $data = []): array | bool {
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute($data);
            return $stmt->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_CLASSTYPE);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function fetchOne(string $query, array $data = []): object | bool {
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute($data);
            return $stmt->fetch(PDO::FETCH_CLASS | PDO::FETCH_CLASSTYPE);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function execute(string $query, array $data = []): int | bool {
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute($data);
            return $stmt->rowCount();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function count(string $query, array $data): int {
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute($data);
            return (int)$stmt->fetch(PDO::FETCH_NUM)[0];
        } catch (PDOException $e) {
            return 0;
        }
    }

    public function lastRowId(): int {
        return $this->pdo->lastInsertId();
    }
}
