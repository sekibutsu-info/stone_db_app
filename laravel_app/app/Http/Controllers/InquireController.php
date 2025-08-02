<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Auth;

use App\Models\Issue;

class InquireController extends Controller
{
    /**
     * Display inquire page.
     */
    public function show(Request $request): View
    {
      return view('inquire', [
        'result' => false,
      ]);
    }

    /**
     * Save inquiry.
     */
    public function save(Request $request): View
    {

      // 必ず認証されている
      $auth = Auth::user();

      $issue = new Issue();

      $issue = $issue->create([
        'user_id' => $auth -> id,
        'content' => htmlspecialchars($request->inquiry, ENT_QUOTES, 'UTF-8'),
      ]);

      return view('inquire', [
        'result' => $request->inquiry,
      ]);
    }
}

