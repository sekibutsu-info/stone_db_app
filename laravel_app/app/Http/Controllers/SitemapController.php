<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Entity;

class SitemapController extends Controller
{
    /**
     * Display sitemap.txt
     */
    public function get()
    {
      $entities = Entity::select('id as entity_id')
                             ->where('hidden', 0)
                             ->orderBy('id', 'asc')->get();

      $sitemap = "https://map.sekibutsu.info\n";
      $sitemap = $sitemap."https://map.sekibutsu.info/archive\n";
      foreach($entities as $entity) {
        $sitemap = $sitemap."https://map.sekibutsu.info/archive/".$entity['entity_id']."\n";
      }

      return response($sitemap, 200)->header('Content-Type', 'text/plain');

    }
}

