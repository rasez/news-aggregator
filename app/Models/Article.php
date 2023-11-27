<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content', 'source_id', 'author_id', 'published_at'];

    public function source()
    {
        return $this->belongsTo(Source::class);
    }

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'article_category');
    }

    public function scopeSearch($query, $searchQuery)
    {
        return $query->where('title', 'like', "%$searchQuery%")
            ->orWhere('content', 'like', "%$searchQuery%");
    }

    public function scopeFilter($query, $dateFilter, $categoryFilter, $sourceFilter)
    {
        if ($dateFilter) {
            $query->whereDate('published_at', $dateFilter);
        }

        if ($categoryFilter) {
            $query->whereHas('categories', function ($q) use ($categoryFilter) {
                $q->where('name', $categoryFilter);
            });
        }

        if ($sourceFilter) {
            $query->whereHas('source', function ($q) use ($sourceFilter) {
                $q->where('name', $sourceFilter);
            });
        }

        return $query;
    }

    public function scopeUserPreferences($query, $selectedSources, $selectedCategories, $selectedAuthors)
    {
        if ($selectedSources) {
            $query->whereIn('source_id', $selectedSources);
        }

        if ($selectedCategories) {
            $query->whereHas('categories', function ($q) use ($selectedCategories) {
                $q->whereIn('name', $selectedCategories);
            });
        }

        if ($selectedAuthors) {
            $query->whereIn('author_id', $selectedAuthors);
        }

        return $query;
    }

}
