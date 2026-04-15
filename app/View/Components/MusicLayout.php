<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Facades\DB;

class MusicLayout extends Component
{
    /**
     * Create a new component instance.
     */
    public $categories;
 
    public function __construct()
    {
        //
        $this->categories = DB::table("danh_muc_am_nhac")->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.music-layout');
    }
}
