<?php

namespace App\View\Components\Forms;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FormSection extends Component
{
    public $title;
    public $description;

    /**
     * Create a new component instance.
     */
    public function __construct($title, $description = null)
    {
        $this->title = $title;
        $this->description = $description;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.forms.form-section');
    }
}
