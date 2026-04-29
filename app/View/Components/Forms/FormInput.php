<?php

namespace App\View\Components\Forms;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FormInput extends Component
{
    public $name;
    public $label;
    public $type;
    public $value;
    public $placeholder;
    public $required;
    public $icon;
    public $help;
    public $options;
    public $rows;
    public $accept;
    public $multiple;
    public $colSpan;

    /**
     * Create a new component instance.
     */
    public function __construct(
        $name,
        $label,
        $type = 'text',
        $value = null,
        $placeholder = null,
        $required = false,
        $icon = null,
        $help = null,
        $options = [],
        $rows = 3,
        $accept = null,
        $multiple = false,
        $colSpan = null
    ) {
        $this->name = $name;
        $this->label = $label;
        $this->type = $type;
        $this->value = $value;
        $this->placeholder = $placeholder;
        $this->required = $required;
        $this->icon = $icon;
        $this->help = $help;
        $this->options = $options;
        $this->rows = $rows;
        $this->accept = $accept;
        $this->multiple = $multiple;
        $this->colSpan = $colSpan;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.forms.form-input');
    }
}
