<?php

namespace App\Http\Controllers\Api\V1\Dashboard\Structure;

use App\Http\Requests\Api\V1\Dashboard\Structure\PolicyRequest;
use Illuminate\Http\Request;

class InstructionUserController extends ApiStructureController
{
    protected string $contentKey = 'order_used';
    protected array $locales = ['en', 'ar'];

    public function store(PolicyRequest $request)
    {
        return parent::_store($request);
    }
}
