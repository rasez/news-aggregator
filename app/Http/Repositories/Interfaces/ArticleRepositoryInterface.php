<?php
namespace App\Http\Repositories\Interfaces;

use App\Models\Article;

interface ArticleRepositoryInterface{

    public function storeArticle(array $articleData);

    public function getArticle(int $id): Article;

    public function getArticles($searchQuery, $dateFilter, $categoryFilter, $sourceFilter,$selectedSources, $selectedCategories, $selectedAuthors);

}
