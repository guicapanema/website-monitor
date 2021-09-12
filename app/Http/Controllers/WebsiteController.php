<?php

namespace App\Http\Controllers;

use App\Models\Website;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    public function destroy(Website $website)
    {
        $website->delete();

        return redirect()->back();
    }
}
