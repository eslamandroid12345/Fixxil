<?php

namespace App\Http\Controllers\Api\V1\Dashboard\Structure;

use App\Http\Requests\Api\V1\Dashboard\Structure\SeoRequest;
use Illuminate\Http\Request;

class SeoController extends ApiStructureController
{
    protected string $contentKey = 'seo';
    protected array $locales = ['en', 'ar'];

    public function store(SeoRequest $request)
    {
        return parent::_store($request);
    }
}
