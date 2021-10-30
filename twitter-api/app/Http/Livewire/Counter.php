<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Counter extends Component
{
    public $counter = 1;

    public function increment()
    {
        return $this->counter +=1;
    }

    public function decrement()
    {
        return $this->counter -= 1;
    }

    public function render()
    {
        return view('livewire.counter', ['counter' => $this->counter]);
    }
}
