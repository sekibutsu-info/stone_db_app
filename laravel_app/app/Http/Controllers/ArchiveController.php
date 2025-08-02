<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Entity;
use App\Models\Redirect;
use App\Http\Controllers\EntityController;

class ArchiveController extends Controller
{
    /**
     * Display archive page.
     */
    public function show($id = ''): View | RedirectResponse
    {
      if($id == '') {
        $id = 'all';
        $entities = Entity::select('id as entity_id')
                             ->where('hidden', 0)
                             ->orderBy('id', 'asc')->get();
        return view('archive', [
          'id' => $id,
          'entities' => $entities,
        ]);
      } else {

        $redirect = Redirect::where('source', intval($id))->first();
        if($redirect) {
          $id = $redirect->dest;
          return redirect('/archive/' . $id, 301);
        }

        $entityController = new EntityController();
        return $entityController->get_common($id, false, true);
      }
    }
}

