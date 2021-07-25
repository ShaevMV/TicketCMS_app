<?php

namespace App\Ticket\Modules\Festival\Model;

use App\Ticket\Model\Model;
use App\Ticket\Modules\TypeRegistration\Model\TypeRegistrationModule;
use Database\Factories\FestivalModelFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

/**
 * App\Ticket\Festival\Model\FestivalModel
 *
 * Модель фестиваля
 *
 * @property string $title Название фестиваля
 * @property string $date_start Начала фестиваля
 * @property string $date_end Окончание фестиваля
 * @property int $status Статус фестиваля
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $id
 * @method static Builder|FestivalModel newModelQuery()
 * @method static Builder|FestivalModel newQuery()
 * @method static Builder|FestivalModel query()
 * @method static Builder|FestivalModel whereCreatedAt($value)
 * @method static Builder|FestivalModel whereDateEnd($value)
 * @method static Builder|FestivalModel whereDateStart($value)
 * @method static Builder|FestivalModel whereId($value)
 * @method static Builder|FestivalModel whereStatus($value)
 * @method static Builder|FestivalModel whereTitle($value)
 * @method static Builder|FestivalModel whereUpdatedAt($value)
 * @property-read Collection|TypeRegistrationModule[] $typeRegistration
 * @property-read int|null $type_registration_count
 * @property string|null $description Описание фестиваля
 * @method static Builder|FestivalModel whereDescription($value)
 */
class FestivalModel extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = "festivals";

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'title',
        'date_start',
        'date_end',
        'status',
        'description'
    ];

    /**
     * @return FestivalModelFactory
     */
    protected static function newFactory(): FestivalModelFactory
    {
        return FestivalModelFactory::new();
    }

    /**
     * @return BelongsToMany
     */
    public function typeRegistration(): BelongsToMany
    {
        return $this->belongsToMany(
            TypeRegistrationModule::class,
            'type_registration_festival',
            'festival_id',
            'type_registration_id'
        )->withPivot([
            'price',
            'params'
        ]);
    }
}
