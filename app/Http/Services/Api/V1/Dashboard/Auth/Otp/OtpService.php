<?php

namespace App\Http\Services\Api\V1\Dashboard\Auth\Otp;

use App\Http\Resources\V1\App\Otp\OtpResource;
use App\Http\Traits\Responser;
use App\Repository\OtpRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Twilio\Rest\Client;

class OtpService
{
    use Responser;

    protected $twilio;

    public function __construct(
        private readonly OtpRepositoryInterface $otpRepository,
    )
    {
        $this->twilio = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));
    }

    public function generate($user)
    {
        if($user->type == 'customer')
        {
            $otp = $this->otpRepository->generateOtp($user);
        }
        //TODO:  Send otp via SMS
        if ($user->phone)
        {
            $phone = '+2' . $user->phone;
            $this->sendSms($phone, 'Your OTP From Fixxil is: ' . $otp->otp);
        }
        return $this->responseSuccess(data: OtpResource::make($otp));
    }

    public function generateCreate($user)
    {
        if($user->type == 'customer')
        {
            $otp = $this->otpRepository->generateOtp($user);
        }

        return $this->responseSuccess(data: OtpResource::make($otp));
    }

    public function verify($request)
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();
            if (!$this->otpRepository->check($data['otp'], $data['otp_token']))
                return $this->responseFail(message: __('messages.Wrong OTP code or expired'));
            auth('api-app')->user()?->otp()?->delete();
            DB::commit();
            return $this->responseSuccess(message: __('messages.Your account has been verified successfully'));
        } catch (\Exception $e) {
            // return $e;
            DB::rollBack();
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    public function sendSms($to, $message)
    {
        $this->twilio->messages->create(
            $to,
            [
                'from' => '+16193321344',
                'body' => $message,
            ]
        );
    }

}
