<?php

namespace App\Http\Controllers\Api\V1\Dashboard\Structure;

use App\Http\Requests\Api\V1\Dashboard\Structure\AboutUsRequest;
use Illuminate\Http\Request;

class AboutUsController extends ApiStructureController
{
    protected string $contentKey = 'about';
    protected array $locales = ['en', 'ar'];

    public function store(AboutUsRequest $request)
    {
        return parent::_store($request);
    }
}
