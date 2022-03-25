<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    protected $fillable = [
        'name',
    ];

    public function getHashtagAttribute(): string
    {
        return '#' . $this->name;
    }

    /**
     * タグモデルに記事モデルのリレーションを追加
     */
    public function articles(): BelongsToMany
    {
        return $this->belongsToMany('App\Article')->withTimestamps();
    }
}
