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

    public function subjectUrl(string $key): string
    {
        $opportunitiesUrl = config('app.mph.opportunities_url');
        $purchaseOrdersUrl = config('app.mph.purchase_orders_url');
        $discussionsUrl = config('app.mph.discussions_url');
        $membersUrl = config('app.mph.members_url');

        return match ($key) {
            'create_item',
            'discuss',
            'destroy',
            'update',
            'mark_as_postponed',
            'mark_as_dead',
            'mark_as_lost' => "{$opportunitiesUrl}{$this->action['subject_id']}",
            'cancel' => "{$purchaseOrdersUrl}{$this->action['subject_id']}",
            'comment' => "{$discussionsUrl}{$this->action['subject_id']}",
            'discussion_create' => "{$membersUrl}{$this->action['subject_id']}",
            'erase' => '',
        };
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.action-stream-item');
    }
}
