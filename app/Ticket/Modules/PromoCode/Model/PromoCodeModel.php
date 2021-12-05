<?php

namespace App\Ticket\Modules\PromoCode\Model;

use App\Ticket\Model\Model;
use App\Ticket\Modules\Festival\Model\FestivalModel;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * App\Ticket\Modules\PromoCode\Model\PromoCodeModel
 *
 * Модель промо кода
 *
 * @property string $id
 * @property string $name Наименования промо кода
 * @property string|null $date_start Дата начала проведения промо кода, null бессрочно
 * @property string|null $date_end Дата начала окончание промо кода, null бессрочно
 * @property int $delta_price Изменения цены
 * @property string $delta_type Тип изменения цены
 * @property int $active Активность промо кода
 * @property string $festival_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read FestivalModel|null $festival
 * @method static Builder|PromoCodeModel newModelQuery()
 * @method static Builder|PromoCodeModel newQuery()
 * @method static Builder|PromoCodeModel query()
 * @method static Builder|PromoCodeModel whereActive($value)
 * @method static Builder|PromoCodeModel whereCreatedAt($value)
 * @method static Builder|PromoCodeModel whereDateEnd($value)
 * @method static Builder|PromoCodeModel whereDateStart($value)
 * @method static Builder|PromoCodeModel whereDeltaPrice($value)
 * @method static Builder|PromoCodeModel whereDeltaType($value)
 * @method static Builder|PromoCodeModel whereFestivalId($value)
 * @method static Builder|PromoCodeModel whereId($value)
 * @method static Builder|PromoCodeModel whereName($value)
 * @method static Builder|PromoCodeModel whereUpdatedAt($value)
 * @mixin Eloquent
 */
class PromoCodeModel extends Model
{
    protected $table = "promo_codes";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'date_start',
        'date_end',
        'delta_price',
        'delta_type',
        'festival_id',
        'status',
    ];

    /**
     * @return HasOne
     */
    public function festival()
    {
        return $this->hasOne(FestivalModel::class, 'id', 'festival_id');
    }
}
