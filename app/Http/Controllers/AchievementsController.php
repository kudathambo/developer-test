<?php

namespace App\Http\Controllers;

use App\Http\Resources\AchievementResource;
use App\Models\User;
use Illuminate\Http\Request;

class AchievementsController extends Controller
{
    public function index(User $user)
    {
        return new AchievementResource($user);
    }
}
