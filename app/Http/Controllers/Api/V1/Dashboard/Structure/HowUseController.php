<?php

namespace App\Http\Controllers\Api\V1\Dashboard\Structure;

use App\Http\Requests\Api\V1\Dashboard\Structure\HowUSeRequest;
use Illuminate\Http\Request;

class HowUseController extends ApiStructureController
{
    protected string $contentKey = 'how_use';
    protected array $locales = ['en', 'ar'];

    public function store(HowUSeRequest $request)
    {
        return parent::_store($request);
    }
}
