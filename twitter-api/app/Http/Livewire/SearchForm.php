<?php

namespace App\Http\Livewire;

use App\Models\Sofascore;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class SearchForm extends Component
{
    public $success = true;
    public $home = '3.4';
    public $away = '';
    public $competition = '';
    public $records_count = 0;

    public function render()
    {
        sleep(1);
        $this->competition = Sofascore::all('competition')->unique('competition');
        $records = Sofascore::where(
            [
                'home_odd' => $this->home
            ]
        )->get();

        return view(
            'livewire.search-form',
            [
                'records' => $records
            ]
        );
    }
}
