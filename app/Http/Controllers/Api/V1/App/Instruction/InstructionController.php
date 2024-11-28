<?php

namespace App\Http\Controllers\Api\V1\App\Instruction;
use App\Http\Controllers\Controller;
use App\Http\Services\Api\V1\App\Instruction\InstructionService;
use Illuminate\Http\Request;

class InstructionController extends Controller
{
    public function __construct(
        private readonly InstructionService $instruction,
    )
    {
        $this->middleware('auth:api-app');
    }

    public function instructions(Request $request)
    {
        return $this->instruction->instructions($request);
    }

    public function instructionsUser(Request $request)
    {
        return $this->instruction->instructionsUser($request);
    }
}
