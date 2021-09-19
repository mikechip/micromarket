<?php

namespace Framework\Database;

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
     * @return string
     */
    public static function getTableName(): string
    {
        return 'test';
    }

    /**
     * Вспомогательная функция для безопасной передачи названия таблицы в запрос.
     * PDO не позволяет сделать это из коробки.
     * @param string $query
     * @return string
     */
    protected static function bindTableName(string $query): string
    {
        return str_replace(':table',
            str_replace(['\'', '"'], '`', self::getTableName()), $query
        );
    }

    public static function getById(int $id): ?Model
    {
        $pdo = PDO::i();
        $query = $pdo->prepare(
            self::bindTableName('SELECT * FROM :table WHERE `id` = :id')
        );

        $result = $query->execute([
            'id' => $id
        ]);

        if(!$result) {
            return null;
        }

        return new Model($id, $query->fetch());
    }

    public function __get(string $key)
    {
        return $this->row[$key] ?? '';
    }
}
