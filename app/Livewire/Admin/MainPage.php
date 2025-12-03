<?php

namespace App\Livewire\Admin;

use App\Enums\PageType;
use App\Models\Page;
use Illuminate\Support\Str;
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
        if (!$this->page) {
            $this->page = new Page(['type' => PageType::MainPage]);
        } else {
            
            $this->content = $this->page->content;
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
    #[On('deleteBlock')]
    public function deleteBlock($key)
    {
        unset($this->content[$key]);

        $this->content = array_values($this->content);
    }

    #[On('reArrange')]
    public function arrange($key, $pos)
    {
        
        if($key + $pos < 0){
            return;
        }
        $elem = $this->content[$key];
        
        unset($this->content[$key]);

        $this->content = array_values($this->content);
        
        array_splice($this->content, ($key + $pos), 0, [$elem]);

        
    }

    #[On('update-node')]
    public function updateNode($nodeId, $newData)
    {
        // Itt megkeresed a tömbben az ID alapján az elemet és frissíted
        data_set($this->content, $nodeId, $newData);
    }

    public function save()
    {
        if(!$this->page->exists){
            $this->page->title = 'Címlap';
            $this->page->type = PageType::MainPage;
            $this->page->slug = 'mainpage-'.time();

        }
        $this->page->content = $this->content;
        $this->page->save();

    }


}
