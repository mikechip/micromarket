<?php

namespace Framework\Database;

use Generator;

/**
 * Слой абстракции над базой данных, предоставляющий удобный
 * доступ к строкам в таблице в виде мутабельных классов
 */
class Model
{
    protected int $id;
    protected array $row;

    public function __construct(int $id, array $row = null)
    {
        $this->id = $id;
        $this->row = $row;
    }

    /**
     * Название таблицы. Перезаписывается в дочерних классах-моделях
     */
    public static function getTableName(): string
    {
        return 'test';
    }

    /**
     * Вспомогательная функция для безопасной передачи названия таблицы в запрос.
     * PDO не позволяет сделать это из коробки.
     */
    protected static function bindTableName(string $query): string
    {
        return str_replace(':table',
            str_replace(['\'', '"'], '`', static::getTableName()), $query
        );
    }

    public static function count(): int
    {
        $pdo = PDO::i();
        $query = $pdo->query(
            static::bindTableName('SELECT COUNT(*) FROM :table')
        );
        $query->execute();
        return $query->fetchColumn();
    }

    public static function getAll(int $offset = 0, int $limit = 100): Generator
    {
        $pdo = PDO::i();
        $query = $pdo->prepare(
            static::bindTableName('SELECT * FROM :table WHERE `id` > :offset LIMIT 0,:limit')
        );

        $query->bindValue('limit', $limit, \PDO::PARAM_INT);
        $query->bindValue('offset', $offset, \PDO::PARAM_INT);
        $query->execute();

        while($row = $query->fetch()) {
            yield new Model($row['id'], $row);
        }
    }

    public static function getById(int $id): ?Model
    {
        $pdo = PDO::i();
        $query = $pdo->prepare(
            static::bindTableName('SELECT * FROM :table WHERE `id` = :id')
        );

        $query->execute([
            'id' => $id
        ]);
        $result = $query->fetch();

        if(!$result) {
            return null;
        }

        return new static($id, $result);
    }

    /**
     * Вставить строку на основе массива в базу данных
     */
    public static function insert(array $data): ?int
    {
        $query_parts = [];
        $pdo_params = [];

        foreach($data as $key => $value) {
            $query_parts[] = '`' . $key . '`=:' . $key;
            $pdo_params[ trim($key) ] = $value;
        }

        $pdo = PDO::i();
        $query = $pdo->prepare(
            static::bindTableName('INSERT INTO :table SET '
                . implode(', ', $query_parts)
            )
        );

        $created = $query->execute($pdo_params);

        if($created) {
           return $pdo->lastInsertId();
        } else {
            return null;
        }
    }

    public function __get(string $key)
    {
        return $this->row[$key] ?? '';
    }

    public function remove(): bool
    {
        $pdo = PDO::i();
        $query = $pdo->prepare(
            static::bindTableName('DELETE FROM :table WHERE id = :id')
        );

        return $query->execute(['id' => $this->id]);
    }
}
