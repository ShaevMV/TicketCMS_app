<?php

declare(strict_types=1);

namespace App\Ticket\Model;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Webpatser\Uuid\Uuid;

/**
 * Class Model
 *
 * Общий класс для модели
 *
 * @package App\Ticket\Model
 * @property string $id
 * @method static Builder whereId($value)
 * @method static Builder getQuery()
 * @method static int count($columns = '*')
 * @method static bool insert($values)
 * @method static Builder whereHas($relation, $callback = null, $operator = '>=', $count = 1)
 * @method static Builder|Model create($attributes = [])
 * @method static BaseModel|Collection|static|static[] findOrFail($id, $columns = [])
 * @method static QueryBuilder leftJoin($table, $first, $operator = null, $second = null)
 * @method static BaseModel|Collection|static[]|static|null find($id, $columns = [])
 * @method static Builder where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static Builder|Model newModelQuery()
 * @method static Builder|Model newQuery()
 * @method static Builder|Model query()
 * @mixin Eloquent
 */
class Model extends BaseModel
{
    /**
     * Перевод primary key в Uuid
     */
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (BaseModel $post) {
            $post->{$post->getKeyName()} = (string)Uuid::generate();
        });
    }

    /**
     * Отключить увеличения идентификатора
     *
     * @return bool
     */
    public function getIncrementing(): bool
    {
        return false;
    }

    /**
     * Перевод идентификатора в строку
     *
     * @return string
     */
    public function getKeyType(): string
    {
        return 'string';
    }
}
