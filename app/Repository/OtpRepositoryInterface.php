<?php

namespace App\Repository;

interface OtpRepositoryInterface extends RepositoryInterface
{
    public function generateOtp($user=null);
    public function check($otp, $token);
}
