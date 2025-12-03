<?php

namespace App\Livewire\Admin\MainPage\Components;

use App\Livewire\Admin\MainPage;
use Livewire\Component;
use Livewire\Attributes\On;

class TextBlock extends Component
{
    public $key;
    public $data;
    public $layout;

    public $element = [
        'image' => null,
        'title' => '',
        'text' => '',
        'url' => ''
    ];


    public function render()
    {
        return view('livewire.admin.components.text-block');
    }

    public function addElement()
    {
        $this->data['data'][] = $this->element;
        $this->dispatch('changeLayout', key: $this->key, data: $this->data);
    }

    public function deleteElement($key)
    {
        unset($this->data['data'][$key]);

        $this->data['data'] = array_values($this->data['data']);
        $this->dispatch('changeLayout', key: $this->key, data: $this->data);
    }

    public function updatedLayout($value)
    {
        $this->data['layout'] = $this->layout;
        $this->dispatch('changeLayout', key: $this->key, data: $this->data);
    }

    public function showGallery()
    {

        $this->gallery = true;
    }

    public function updated($property)
    {
        $this->dispatch('changeLayout', key: $this->key, data: $this->data);
        //$this->dispatch('update-node', nodeId: $this->getId(), newData: $this->data)->to(MainPage::class); // Csak az Editor kapja meg
    }

    #[On('insertMedia')]
    public function insertMedia($response)
    {
        $this->data['data'][$response['obj']['key']]['image'] = $response['image'];
        $this->dispatch('changeLayout', key: $this->key, data: $this->data);
       
    }

}
