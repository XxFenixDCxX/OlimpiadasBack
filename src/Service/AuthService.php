<?php

namespace App\Service;

use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Validation\Constraint\PermittedFor;
use Lcobucci\JWT\Validation\Constraint\ValidAt;
use Lcobucci\Clock\SystemClock;

class AuthService
{
    private $audience = 'https://olimpiadas.eu.auth0.com/api/v2/';

    public function __construct() {}

    public function validateToken(string $token): bool
    {
        $configuration = Configuration::forUnsecuredSigner();

        try {
            $token = $configuration->parser()->parse($token);
            $constraints = [
                new PermittedFor($this->audience),
                new ValidAt(new SystemClock(new \DateTimeZone('UTC')))
            ];

            $configuration->validator()->assert($token, ...$constraints);
            return true;
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }
}