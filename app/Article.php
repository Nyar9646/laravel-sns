<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Article extends Model
{
    // fillable 設定。保守性を高め、コーディングをスッキリさせる
    protected $fillable = [
        'title',
        'body',
    ];

    /*
     * Get the user that owns the Article
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    // user データと紐付け
    public function user(): BelongsTo
    {
        return $this->belongsTo('App\User');
    }

    // "いいね" における記事モデルとUsersモデルの関係は、多：多
    public function likes(): BelongsToMany
    {
        return $this->belongsToMany('App\User', 'likes')->withTimestamps();
    }

    // arg1 : Auth::user() : ログイン中のユーザのモデルが渡る。なければnull
    public function isLikedBy(?User $user): bool
    {
        return $user
            ? (bool)$this->likes->where('id', $user->id)->count()
            : false;
    }

    public function getCountLikesAttribute(): int
    {
        return $this->likes->count();
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany('App\Tag')->withTimestamps();
    }
}
