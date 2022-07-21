<?php

namespace App\Services;

use App\Http\Controllers\Controller;
use App\Interfaces\RepositoryInterfaces\Users\User\UserRepositoryInterface;
use Illuminate\Http\Request;

class BaseService extends Controller
{
    /**
     * @var
     */
    protected $repository;

    /**
     * @param $repository
     */
    public function __construct($repository)
    {
        $this->repository = $repository;
    }
}
