<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Livestream extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'description',
        'embed_url',
        'thumbnail',
        'is_active',
    ];
    public static function uploadThumbnail($file)
    {
        return $file->store('thumbnails', 'public');
    }

    public function deleteThumbnail()
    {
        if ($this->thumbnail && \Storage::disk('public')->exists($this->thumbnail)) {
            \Storage::disk('public')->delete($this->thumbnail);
        }
    }

    public static function generateUniqueSlug($title, $ignoreId = null)
    {
        $slug = Str::slug($title);
        $original = $slug;
        $i = 1;

        while (self::where('slug', $slug)->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = $original . '-' . $i++;
        }

        return $slug;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
