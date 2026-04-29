<?php

namespace App\View\Components\Forms;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CrudForm extends Component
{
    public $title;
    public $action;
    public $method;
    public $submitText;
    public $cancelUrl;
    public $enctype;
    public $model;

    /**
     * Create a new component instance.
     */
    public function __construct(
        $title = 'Form',
        $action = '#',
        $method = 'POST',
        $submitText = 'Save',
        $cancelUrl = '#',
        $enctype = null,
        $model = null
    ) {
        $this->title = $title;
        $this->action = $action;
        $this->method = strtoupper($method);
        $this->submitText = $submitText;
        $this->cancelUrl = $cancelUrl;
        $this->enctype = $enctype;
        $this->model = $model;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.forms.crud-form');
    }
}
