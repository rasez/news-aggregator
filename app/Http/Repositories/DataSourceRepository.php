<?php
namespace App\Http\Repositories;

use App\Models\DataSource;
use App\Http\Repositories\Interfaces\DataSourceRepositoryInterface;
class DataSourceRepository implements DataSourceRepositoryInterface{

    public function getDataSources(){
        return DataSource::all();
    }

}
