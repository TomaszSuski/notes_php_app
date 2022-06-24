<?php

declare(strict_types=1);

namespace App\Model;

use App\Exception\NotFoundException;
use App\Exception\StorageException;
use PDO;
use Throwable;

class NoteModel extends AbstractModel implements ModelInterface
{

    public function list(array $sort, int $pageSize, int $pageNumber): array
    {
        return $this->findBy($sort, $pageSize, $pageNumber, null);
    }

    public function count(): int
    {
        try {
            $query = "SELECT count(*) AS cn FROM notes";
            $result = $this->connection->query($query, PDO::FETCH_ASSOC);
            $count = $result->fetch();
            if (!$count) {
                throw new StorageException('Błąd przy próbie odczytu listy notatek', 400);
            }
            return (int) $count['cn'];
        } catch (Throwable $e) {
            throw new StorageException('Nie udało się pobrać informacji o liczbie notatek', 400, $e);
        }
    }

    public function get(int $id): array
    {
        try {
            $this->id = $id;
            $query = "SELECT * FROM notes WHERE id = $id";
            $result = $this->connection->query($query);
            $note = $result->fetch(PDO::FETCH_ASSOC);
        } catch (Throwable $e) {
            throw new StorageException('Nie udało się pobrać notatki', 400, $e);
        }
        if (!$note) {
            throw new NotFoundException("Notatka nr $id nie istnieje");
        } else {
            return $note;
        }
    }

    public function search(array $sort, int $pageSize, int $pageNumber, ?string $searchPhrase): array
    {
       return $this->findBy($sort, $pageSize, $pageNumber, $searchPhrase);
    }

    public function searchCount(string $searchPhrase): int
    {
        $phrase = $this->connection->quote('%' . $searchPhrase . '%', PDO::PARAM_STR);
        try {
            $query = "SELECT count(*) AS cn FROM notes WHERE title LIKE $phrase";
            $result = $this->connection->query($query, PDO::FETCH_ASSOC);
            $count = $result->fetch();
            if (!$count) {
                throw new StorageException('Błąd przy próbie odczytu listy notatek', 400);
            }
            return (int) $count['cn'];
        } catch (Throwable $e) {
            throw new StorageException('Nie udało się pobrać informacji o liczbie notatek', 400, $e);
        }
    }

    public function create(array $data): void
    {
        try {

            $title = $this->connection->quote($data['title']);
            $description = $this->connection->quote($data['description']);
            $created = $this->connection->quote(date('Y-m-d H:i:s'));

            $query = "INSERT INTO notes(title, description, created) VALUES ($title, $description, $created)";

            $this->connection->exec($query);
        } catch (Throwable $e) {
            throw new StorageException('Nie udało się utworzyć notatki', 400, $e);
            dump($e);
            exit;
        }
    }

    public function edit(int $id, array $data): void
    {

        try {
            $title = $this->connection->quote($data['title']);
            $description = $this->connection->quote($data['description']);

            $query = "
            UPDATE notes
            SET title = $title, description = $description
            WHERE id = $id
            ";
            $this->connection->exec($query);
        } catch (Throwable $e) {
            throw new StorageException('Nie udało się zaktualizować notatki', 400, $e);
            dump($e);
            exit;
        }
    }

    public function delete(int $id): void
    {

        try {
            $query = "
            DELETE FROM notes
            WHERE id = $id
            LIMIT 1
            ";
            $this->connection->exec($query);
        } catch (Throwable $e) {
            throw new StorageException('Nie udało się usunąć notatki', 400, $e);
            dump($e);
            exit;
        }
    }

    private function findBy(array $sort, int $pageSize, int $pageNumber, ?string $searchPhrase): array
    {
        if (!in_array($sort['by'], ['created', 'title'])) {
            $sortBy = DEFAULT_SORT_BY;
        } else {
            $sortBy = $sort['by'];
        }

        if (!in_array($sort['order'], ['ASC', 'DESC'])) {
            $sortOrder = DEFAULT_SORT_ORDER;
        } else {
            $sortOrder = $sort['order'];
        }

        $offset = ($pageNumber - 1) * $pageSize;

        $wherePart = '';
        if($searchPhrase){
            $phrase = $this->connection->quote('%' . $searchPhrase . '%', PDO::PARAM_STR);
            $wherePart = "WHERE title LIKE $phrase" ;
        }

        try {
            $query = "
            SELECT id, title, created 
            FROM notes 
            $wherePart
            ORDER By $sortBy $sortOrder
            LIMIT $offset, $pageSize
            ";
            $result = $this->connection->query($query);

            return $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (Throwable $e) {
            throw new StorageException('Nie udało się pobrać notatek', 400, $e);
        }
    }
}
