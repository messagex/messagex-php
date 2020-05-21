<?php


namespace PhpApiClient\Models\AuthModel;

use PhpApiClient\Models\BaseModel;

class Auth extends BaseModel
{
    public $id;
    public $bearerToken;
    public $refreshToken;
    public $expiresAt;
    public $createdAt;
    public $updatedAt;
}