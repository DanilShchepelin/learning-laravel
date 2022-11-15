<?php

namespace App\Models;

use App\Enums\Roles;
use App\Models\Traits\SearchByIdOrSlug;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;


/**
 * @mixin IdeHelperUser
 */
class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use Sluggable;
    use SearchByIdOrSlug;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'biography',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'is_admin',
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'year_of_birth' => 'date',
        'is_admin' => 'boolean'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
                'unique' => true,
                'onUpdate' => true,
            ],
        ];
    }

    protected function password(): Attribute
    {
        return Attribute::make(
            set: fn ($password) => Hash::make($password),
        );
    }

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class, 'author_id');
    }

    /**
     * @param Builder $query
     * @param string|null $name
     * @return Builder
     */
    public function scopeFindAuthor(Builder $query, ?string $name): Builder
    {
        if (!empty($name)) {
            $query->where('name', 'like', "%{$name}%");
        }

        return $query;
    }

//    public static function isAuthorOrAdmin($user, $article) {
//        if (!$user->tokenCan(Roles::Author->getName())) {
//            return response()->json([
//                'message' => 'У вас недостаточно прав'
//            ], 403);
//        }
//
//        if ($user->id !== $article->author_id) {
//            return response()->json([
//                'message' => 'Вы не являетесь автором статьи'
//            ], 403);
//        }
//
//        return true;
//    }
}
