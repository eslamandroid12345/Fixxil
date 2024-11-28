<?php

namespace App\Http\Controllers\Api\V1\App\Structure;

use App\Http\Controllers\Api\V1\App\Structure\StructureController;
use App\Http\Requests\Api\V1\Dashboard\Structure\AboutUsRequest;
use Illuminate\Http\Request;

class AboutUsController extends StructureController
{
    protected string $contentKey = 'about';
    protected array $locales = ['en', 'ar'];

}
