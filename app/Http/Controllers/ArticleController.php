<?php

namespace App\Http\Controllers;

use App\Http\Repositories\Interfaces\ArticleRepositoryInterface;
use App\Http\Requests\ArticleRequest;

class ArticleController extends Controller
{
    protected $articleRepository;
    public function __construct(ArticleRepositoryInterface $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    /**
     * return articles
     * @param ArticleRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(ArticleRequest $request)
    {
        $searchQuery = $request->input('search');
        $dateFilter = $request->input('date');
        $categoryFilter = $request->input('category');
        $sourceFilter = $request->input('source');
        $selectedSources = $request->input('sources');
        $selectedCategories = $request->input('categories');
        $selectedAuthors = $request->input('authors');
        $articles = $this->articleRepository->getArticles($searchQuery, $dateFilter, $categoryFilter, $sourceFilter,$selectedSources, $selectedCategories, $selectedAuthors);

        return response()->json($articles);
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id)
    {
        $article = $this->articleRepository->getArticle($id);

        if (!$article) {
            return response()->json(['error' => 'Article not found'], 404);
        }

        return response()->json($article);
    }
}
