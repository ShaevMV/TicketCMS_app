<?php

declare(strict_types=1);

namespace App\Ticket\Modules\Auth\Model;

use App\Ticket\Model\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * App\Ticket\Modules\Auth\Model\OauthClientsModel
 *
 * @property int $id
 * @property int|null $user_id
 * @property string $name
 * @property string|null $secret
 * @property string|null $provider
 * @property string $redirect
 * @property int $personal_access_client
 * @property int $password_client
 * @property int $revoked
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|OauthClientsModel newModelQuery()
 * @method static Builder|OauthClientsModel newQuery()
 * @method static Builder|OauthClientsModel query()
 * @method static Builder|OauthClientsModel whereCreatedAt($value)
 * @method static Builder|OauthClientsModel whereId($value)
 * @method static Builder|OauthClientsModel whereName($value)
 * @method static Builder|OauthClientsModel wherePasswordClient($value)
 * @method static Builder|OauthClientsModel wherePersonalAccessClient($value)
 * @method static Builder|OauthClientsModel whereProvider($value)
 * @method static Builder|OauthClientsModel whereRedirect($value)
 * @method static Builder|OauthClientsModel whereRevoked($value)
 * @method static Builder|OauthClientsModel whereSecret($value)
 * @method static Builder|OauthClientsModel whereUpdatedAt($value)
 * @method static Builder|OauthClientsModel whereUserId($value)
 */
final class OauthClientsModel extends Model
{
    protected $table = "oauth_clients";
}
