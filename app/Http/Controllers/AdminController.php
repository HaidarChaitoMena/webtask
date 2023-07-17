<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function Approve(User $user): User
    {
        $user->update(['approved' => 1]);
        return $user;
    }
    public function Disapprove(User $user): User
    {
        $user->update(['approved' => 0]);
        return $user;
    }
}
