<?php

namespace App\Livewire\Admin\MainPage\Components;

use Livewire\Component;

class Blank extends Component
{
    public $key;
    public $data;
    public $layout;

    public function render()
    {
        return view('livewire.admin.components.blank');
    }

    public function addElement()
    {
        $this->data['data'][] = [''];
    }

    public function updated($property)
    {
        $this->dispatch('changeLayout', key: $this->key, data: $this->data);
    }
}
