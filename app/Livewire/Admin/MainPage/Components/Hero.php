<?php

namespace App\Livewire\Admin\MainPage\Components;

use Livewire\Component;
use Livewire\Attributes\On;

class Hero extends Component
{
    public $key;
    public $data;
    public $test = '';
    public $layout;
    public $gallery = false;
    public $element = [
        'image' => null,
        'title' => '',
        'url' => ''
    ];

    public function render()
    {
        return view('livewire.admin.components.hero');
    }

    public function addElement()
    {
        $this->data['data'][] = $this->element;
        $this->dispatch('changeLayout', key: $this->key, data: $this->data);
    }

    public function showGallery()
    {
        
        $this->gallery = true;
    }
    #[On('insertFromPage')]
    public function insertFromPage($page)
    {

    }

    #[On('insertMedia')]
    public function insertMedia($response)
    {
        $this->data['data'][$response['obj']['key']]['image'] = $response['image'];
        $this->dispatch('changeLayout', key: $this->key, data: $this->data);
    }
}
