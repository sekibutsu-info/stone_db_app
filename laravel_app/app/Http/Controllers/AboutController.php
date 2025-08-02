<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Entity;

class AboutController extends Controller
{
    /**
     * About
     */
    public function show(Request $request): View
    {
      return view('about', [
        'num_data' => Entity::where('hidden', 0)->count(),
      ]);
    }

    /**
     * Howto
     */
    public function howto(Request $request): View
    {
      return view('howto', [
      ]);
    }

    /**
     * Usage
     */
    public function usage(Request $request): View
    {
      return view('usage', [
      ]);
    }

}

