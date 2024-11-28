<?php

namespace App\Http\Controllers\Api\V1\App\Structure;

use App\Http\Controllers\Api\V1\App\Structure\StructureController;
use App\Http\Requests\Api\V1\Dashboard\Structure\AboutUsRequest;
use Illuminate\Http\Request;

class MobileLinkController extends StructureController
{
    protected string $contentKey = 'mobile_link';
    protected array $locales = ['en', 'ar'];

}
