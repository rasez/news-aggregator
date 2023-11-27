<?php
namespace App\Http\Services;

use App\Http\DataSources\NewsApiAi;
use App\Http\DataSources\NewsApiOrg;
use App\Http\DataSources\Guardian;
use App\Http\Repositories\Interfaces\ArticleRepositoryInterface;
use App\Http\Repositories\Interfaces\DataSourceRepositoryInterface;

class ArticleFetcherService
{
    protected $articleRepository;
    protected $dataSourceRepository;


    public function __construct(ArticleRepositoryInterface $articleRepository, DataSourceRepositoryInterface $dataSourceRepository) {
        $this->articleRepository = $articleRepository;
        $this->dataSourceRepository = $dataSourceRepository;

    }

    public function fetchAndStoreArticles()
    {
        $dataSources = $this->dataSourceRepository->getDataSources();
        $dataSource = null;
        // using strategy design pattern for select data source
        foreach ($dataSources as $source) {
            switch ($source->name) {
                case 'NewsApiOrg':
                    $dataSource = new NewsApiOrg($this->articleRepository);
                    break;
                case 'NewsApiAi':
                    $dataSource = new NewsApiAi($this->articleRepository);
                    break;
                case 'Guardian':
                    $dataSource = new Guardian($this->articleRepository);
                    break;
            }
            $articles = $dataSource->fetchArticles();

            foreach ($articles as $articleData) {
                $dataSource->fetchArticle($articleData);
            }
        }
    }
}
