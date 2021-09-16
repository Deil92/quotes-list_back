<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;

class tagController extends Controller
{
    public function index() {
        return Tag::all();
    }
}
