<?php
namespace App\Http\Repositories;

use App\Models\Article;
use App\Models\Author;
use App\Models\Source;
use App\Models\Category;
use App\Http\Repositories\Interfaces\ArticleRepositoryInterface;

class ArticleRepository implements ArticleRepositoryInterface {

    public function storeArticle(array $data) {
        $author = Author::firstOrCreate(['name' => $data['author']]);
        $source = Source::firstOrCreate(['name' => $data['source']]);

        $article = Article::create([
            'title' => $data['title'],
            'content' => $data['content'],
            'published_at' => $data['published_at'], // You might want to adjust this based on your actual requirements
            'author_id' => $author->id,
            'source_id' => $source->id,
        ]);

        // Assuming 'categories' is an array of category names
        foreach ($data['categories'] as $categoryName) {
            $category = Category::firstOrCreate(['name' => $categoryName]);
            $article->categories()->attach($category->id);
        }

    }

    public function getArticle(int $id): Article {
        return Article::find($id);
    }

    public function getArticles($searchQuery, $dateFilter, $categoryFilter, $sourceFilter,$selectedSources, $selectedCategories, $selectedAuthors) {
        return Article::search($searchQuery)
            ->filter($dateFilter, $categoryFilter, $sourceFilter)
            ->userPreferences($selectedSources, $selectedCategories, $selectedAuthors)
            ->get();
    }
}
