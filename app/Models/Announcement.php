<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'message',
        'icon',
        'highlight',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Scope: active announcements
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    /**
     * Get formatted message with highlight text
     */
    public function getFormattedMessageAttribute(): string
    {
        if ($this->highlight) {
            return str_replace('{highlight}', '<span class="font-bold text-primary-400">' . $this->highlight . '</span>', $this->message);
        }

        return $this->message;
    }

    /**
     * Get SVG icon path for the announcement
     */
    public function getIconPathAttribute(): string
    {
        return match($this->icon) {
            'truck'       => '<path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"/>',
            'tag'         => '<path fill-rule="evenodd" d="M5 2a1 1 0 011 1v1h1a1 1 0 010 2H6v1a1 1 0 01-2 0V6H3a1 1 0 010-2h1V3a1 1 0 011-1zm0 10a1 1 0 011 1v1h1a1 1 0 110 2H6v1a1 1 0 11-2 0v-1H3a1 1 0 110-2h1v-1a1 1 0 011-1zm7-2a1 1 0 01.967.744L14.146 15H16a1 1 0 110 2h-2a1 1 0 01-.967-.744L12 12.721l-1.033 3.535A1 1 0 0110 17a1 1 0 01-.967-.744L7.854 10H6a1 1 0 110-2h2a1 1 0 01.967.744L10 12.279l1.033-3.535A1 1 0 0112 8z" clip-rule="evenodd"/>',
            'clock'       => '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>',
            'star'        => '<path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>',
            'sparkles'    => '<path fill-rule="evenodd" d="M10.362 1.093a.75.75 0 00-.724 0L2.523 5.018 10 9.143l7.477-4.13-7.115-3.925zM18 6.443l-7.25 4v8.25l6.862-3.786A.75.75 0 0018 14.25V6.443zM9.25 18.693v-8.25l-7.25-4v7.807a.75.75 0 00.388.657l6.862 3.786z" clip-rule="evenodd"/>',
            default       => '<path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"/>',
        };
    }
}
