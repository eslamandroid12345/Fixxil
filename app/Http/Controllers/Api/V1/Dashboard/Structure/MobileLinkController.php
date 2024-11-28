<?php

namespace App\Http\Controllers\Api\V1\Dashboard\Structure;

use App\Http\Requests\Api\V1\Dashboard\Structure\MobileLinkRequest;
use Illuminate\Http\Request;

class MobileLinkController extends ApiStructureController
{
    protected string $contentKey = 'mobile_link';
    protected array $locales = ['en', 'ar'];

    public function store(MobileLinkRequest $request)
    {
        return parent::_store($request);
    }
}
