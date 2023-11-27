<?php
namespace App\Http\DataSources;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use App\Http\DataSources\Interfaces\NewsSourceInterface;
use App\Http\Repositories\Interfaces\ArticleRepositoryInterface;

class NewsApiOrg implements NewsSourceInterface {

    private $apiKey;
    protected $articleRepository;
    private $baseUrl = "https://newsapi.org/v2/top-headlines";

    public function __construct(ArticleRepositoryInterface $articleRepository){
        $this->apiKey = env("NEWS_API_ORG_API_KEY");
        $this->articleRepository = $articleRepository;
    }

    public function fetchArticle($articleData)
    {

        $data = [];
        $data['author'] = $articleData['author'] ? $articleData['author'] : $articleData['source']['name'];
        $data['source'] = $articleData['source']['name'];
        $data['title'] = $articleData['title'];
        $data['content'] = $articleData['content'] ? $articleData['content'] : $articleData['description'];
        $data['categories'] = [];
        $data['published_at'] = $articleData['publishedAt'];

        $this->articleRepository->storeArticle($data);

    }
    public function fetchArticles(): array {
        $response = Http::get($this->baseUrl, [
            'apiKey' => $this->apiKey,
            'pageSize' => 10,
            'country' => 'us'
        ]);
        $data = $response->json();

        return $data['articles'];
    }
}
