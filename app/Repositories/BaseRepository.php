<?php

namespace App\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository
{
    /**
     * Основная модель, с которой работает репозиторий.
     */
    protected Model $model;

    /**
     * Конструктор — принимает модель через DI.
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Получить новую инстанцию запроса (Builder).
     */
    protected function query(): Builder
    {
        return $this->model->newQuery();
    }

    /**
     * Получить все записи.
     */
    public function all(array $columns = ['*'], array $relations = []): Collection
    {
        return $this->query()
            ->with($relations)
            ->get($columns);
    }

    /**
     * Получить запись по ID.
     */
    public function find(int $id, array $relations = []): ?Model
    {
        return $this->query()
            ->with($relations)
            ->find($id);
    }

    /**
     * Получить запись по условию (firstOrFail).
     */
    public function findBy(string $field, mixed $value, array $relations = []): ?Model
    {
        return $this->query()
            ->with($relations)
            ->where($field, $value)
            ->first();
    }

    /**
     * Пагинация.
     */
    public function paginate(int $perPage = 15, array $columns = ['*'], string $pageName = 'page', ?int $page = null): LengthAwarePaginator
    {
        return $this->query()->paginate($perPage, $columns, $pageName, $page);
    }

    /**
     * Создать запись.
     */
    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    /**
     * Обновить запись по ID.
     */
    public function update(int $id, array $data): ?Model
    {
        $record = $this->find($id);
        if ($record) {
            $record->update($data);
            return $record->fresh();
        }
        return null;
    }

    /**
     * Удалить запись.
     */
    public function delete(int $id): bool
    {
        $record = $this->find($id);
        return $record ? $record->delete() : false;
    }

    /**
     * Массовое обновление.
     */
    public function updateMany(array $conditions, array $data): int
    {
        return $this->query()
            ->where($conditions)
            ->update($data);
    }

    /**
     * Массовое удаление (soft delete).
     */
    public function deleteMany(array $conditions): int
    {
        return $this->query()
            ->where($conditions)
            ->delete();
    }

    /*
     * Пример общего метода для сложных запросов
     * Наследники могут переопределять
     */
    //    abstract public function getActivePaginated(int $perPage = 15): LengthAwarePaginator;
}
