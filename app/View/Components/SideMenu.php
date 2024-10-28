<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SideMenu extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    public function menuItems(): array
    {
        return [
            [
                'text' => __('Equipment Import'),
                'route' => route('jobs.index'),
                'active' => request()->routeIs('jobs.index'),
                'permission' => 'access-equipment-import',
                'subitems' => [],
            ],
            [
                'text' => __('Action Stream'),
                'route' => route('action-stream.index'),
                'active' => request()->routeIs('action-stream.index'),
                'permission' => 'access-action-stream',
                'subitems' => [],
            ],
            [
                'text' => __('QET'),
                'route' => route('qet.index'),
                'active' => request()->routeIs('qet.index'),
                'permission' => 'access-qet',
                'subitems' => [],
            ],
            [
                'text' => __('Discussions'),
                'route' => null,
                'active' => null,
                'permission' => ['create-default-discussions', 'update-default-discussions'],
                'subitems' => [
                    [
                        'text' => __('Create Discussions'),
                        'route' => route('discussions.create'),
                        'active' => request()->routeIs('discussions.create'),
                        'permission' => 'create-default-discussions',
                    ],
                    [
                        'text' => __('Edit default Discussions'),
                        'route' => route('discussions.edit'),
                        'active' => request()->routeIs('discussions.edit'),
                        'permission' => 'update-default-discussions',
                    ],
                ],
            ],
            [
                'text' => __('Quarantine'),
                'route' => null,
                'active' => null,
                'permission' => ['access-quarantine-intake'],
                'subitems' => [
                    [
                        'text' => __('Quarantine Intake'),
                        'route' => route('quarantine-intake.index'),
                        'active' => request()->routeIs('quarantine-intake.index'),
                        'permission' => 'access-quarantine-intake',
                    ],
                ],
            ],
            [
                'text' => __('Users'),
                'route' => route('users.index'),
                'active' => request()->routeIs('users.index'),
                'permission' => 'crud-users',
                'subitems' => [],
            ],
        ];
    }

    public function canViewItem(string|array $permission): bool
    {
        if (is_array($permission)) {
            $can_view_item = false;

            foreach ($permission as $access) {
                if (usercan($access)) {
                    $can_view_item = true;
                    break;
                }
            }

            return $can_view_item;
        }

        return usercan($permission);
    }

    public function itemExpanded(array $subitems): bool
    {
        $is_expanded = false;

        foreach ($subitems as $item) {
            if ($item['active']) {
                $is_expanded = $item['active'];
                break;
            }
        }

        return $is_expanded;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.side-menu');
    }
}
