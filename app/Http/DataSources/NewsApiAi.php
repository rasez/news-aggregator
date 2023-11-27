<?php
namespace App\Http\DataSources;

use Illuminate\Support\Facades\Http;
use App\Http\DataSources\Interfaces\NewsSourceInterface;
use App\Http\Repositories\Interfaces\ArticleRepositoryInterface;

class NewsApiAi implements NewsSourceInterface {

    protected $articleRepository;
    private $apiKey;
    private $baseUrl = "http://eventregistry.org/api/v1/article/getArticles/";

    public function __construct(ArticleRepositoryInterface $articleRepository){
        $this->apiKey = env("NEWS_API_AI_API_KEY");
        $this->articleRepository = $articleRepository;
    }

    public function fetchArticle($articleData)
    {
        $data = [];
        $data['author'] = $articleData['authors'] ? $articleData['authors'][0]['name'] : $articleData['source']['title'];
        $data['source'] = $articleData['source']['title'];
        $data['title'] = $articleData['title'];
        $data['content'] = $articleData['body'];
        $data['categories'] = [$articleData['dataType']];
        $data['published_at'] = $articleData['dateTimePub'];

        $this->articleRepository->storeArticle($data);

    }

    public function fetchArticles(): array {
        $response = Http::get($this->baseUrl, [
            'apiKey' => $this->apiKey,
            "action" => "getArticles",
            "keyword" => "Barack Obama",
            "articlesPage" => 1,
            "articlesCount" => 10,
            "articlesSortBy" => "date",
            "articlesSortByAsc" => false,
            "articlesArticleBodyLen" => -1,
            "resultType" => "articles",
            "dataType" => [
              "news",
              "pr"
            ],
            "forceMaxDataTimeWindow" => 31
        ]);

        $data = $response->json();
        return $data['articles']['results'];
    }
}
