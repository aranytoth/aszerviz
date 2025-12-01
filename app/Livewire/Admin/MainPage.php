<?php

namespace App\Livewire\Admin;

use App\Enums\PageType;
use App\Models\Page;
use Livewire\Component;
use Livewire\Attributes\On; 

class MainPage extends Component
{
    public $page;
    public $content = [];

    public $contentOptions = [
        'type' => 'blank',
        'layout' => 'blank',
        'data' => []
    ];

    public function mount()
    {
        $this->page = Page::where('type', PageType::MainPage)->orderBy('created_at', 'DESC')->first();
        if(!$this->page){
            $this->page = new Page(['type' => PageType::MainPage]); 
        }

        else {
            $this->content = json_decode($this->page->content);
        }
    }

    public function render()
    {
        return view('livewire.admin.main-page')->extends('layouts.admin.empty');
    }

    public function addBlock()
    {
        $this->content[] = $this->contentOptions;
    }
    #[On('changeLayout')]
    public function changeLayout($key, $data)
    {
        $this->content[$key] = $data;
    }

    
}
