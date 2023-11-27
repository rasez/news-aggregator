<?php
namespace App\Http\DataSources\Interfaces;

interface NewsSourceInterface {
    public function fetchArticle($article);
    public function fetchArticles(): array;
}
