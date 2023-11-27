<?php
namespace App\Http\DataSources;

use Illuminate\Support\Facades\Http;
use App\Http\DataSources\Interfaces\NewsSourceInterface;
use App\Http\Repositories\Interfaces\ArticleRepositoryInterface;

class Guardian implements NewsSourceInterface {

    private $apiKey;
    private $baseUrl = "https://content.guardianapis.com/";
    protected $articleRepository;

    public function __construct(ArticleRepositoryInterface $articleRepository){
        $this->apiKey = env("GUARDIAN_API_KEY");
        $this->articleRepository = $articleRepository;
    }

    public function fetchArticle($articleData)
    {
        $response = Http::get($this->baseUrl.$articleData['id'], [
            'api-key' => $this->apiKey,
            'show-blocks' => 'body',
            'show-references' => 'author',
        ]);
        $content = $response->json();
        $articleContent = $content['response']['content'];
        $data = [];
        $data['author'] = $articleContent['references'] ? $articleContent['references']['author'] : "Guardian";
        $data['source'] = 'theguardian';
        $data['title'] = $articleContent['webTitle'];
        $data['content'] = $articleContent['blocks']['body'][0]['bodyHtml'];
        $data['categories'] = [$articleContent['sectionName']];
        $data['published_at'] = $articleContent['webPublicationDate'];

        $this->articleRepository->storeArticle($data);
    }

    public function fetchArticles() : array{
        $response = Http::get($this->baseUrl."search", [
            'api-key' => $this->apiKey,
        ]);

        $data = $response->json();
        return $data['response']['results'];
    }
}
