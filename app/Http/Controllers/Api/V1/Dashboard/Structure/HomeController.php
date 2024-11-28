<?php

namespace App\Http\Controllers\Api\V1\Dashboard\Structure;

use App\Http\Requests\Api\V1\Dashboard\Structure\HomeRequest;
use App\Http\Requests\Api\V1\Dashboard\Structure\PolicyRequest;
use Illuminate\Http\Request;

class HomeController extends ApiStructureController
{
    protected string $contentKey = 'home';
    protected array $locales = ['en', 'ar'];

    public function store(HomeRequest $request)
    {
        return parent::_store($request);
    }
}
