<?php

namespace App\Http\Controllers\Api\V1\Dashboard\Structure;

use App\Http\Requests\Api\V1\Dashboard\Structure\PolicyRequest;
use Illuminate\Http\Request;

class PolicyController extends ApiStructureController
{
    protected string $contentKey = 'policy';
//    protected array $locales = ['en', 'ar'];

    public function store(PolicyRequest $request)
    {
        return parent::_store($request);
    }
}
