<?php

namespace App\View\Components;

use App\Traits\WithActionType;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ActionStreamItem extends Component
{
    use WithActionType;

    /**
     * Create a new component instance.
     */
    public function __construct(public array $action)
    {
        //
    }

    public function actionType(string $key): string
    {
        $types = array_values(array_filter($this->getActionTypes(), fn ($actionType) => $actionType['key'] === $key));

        if (count($types) === 0) {
            return '';
        }

        return $types[0]['value'];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.action-stream-item');
    }
}
