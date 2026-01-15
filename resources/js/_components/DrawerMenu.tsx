import { SharedData, User } from "@/types";
import { Link, usePage } from "@inertiajs/react";
import clsx from "clsx";

interface MenuSubItem {
    id: number;
    text: string;
    href: string;
    inertia_ready: boolean;
    permissions: string[];
}

interface MenuItem {
    id: number;
    text: string;
    href: string;
    inertia_ready: boolean;
    permissions: string[];
    subitems: MenuSubItem[];
}

const menuItems: MenuItem[] = [
    {
        id: 1,
        text: 'Equipment Import',
        href: '/equipment-import',
        inertia_ready: false,
        permissions: ['access-equipment-import'],
        subitems: [],
    },
    {
        id: 2,
        text: 'Action Stream',
        href: '/action-stream',
        inertia_ready: false,
        permissions: ['access-action-stream'],
        subitems: [],
    },
    {
        id: 3,
        text: 'QET',
        href: '/qet',
        inertia_ready: false,
        permissions: ['access-qet'],
        subitems: [],
    },
    {
        id: 4,
        text: 'Discussions',
        href: '',
        inertia_ready: false,
        permissions: ['create-default-discussions', 'update-default-discussions'],
        subitems: [
            {
                id: 1,
                text: 'Create Discussions',
                href: '/discussions/create',
                inertia_ready: false,
                permissions: ['create-default-discussions'],
            },
            {
                id: 2,
                text: 'Edit default Discussions',
                href: '/discussions/edit',
                inertia_ready: false,
                permissions: ['update-default-discussions'],
            },
        ],
    },
    {
        id: 5,
        text: 'Quarantine Intake',
        href: '/inertia/quarantine/create',
        inertia_ready: true,
        permissions: ['access-quarantine-intake'],
        subitems: [],
    },
    {
        id: 6,
        text: 'Role CRUD',
        href: '',
        inertia_ready: false,
        permissions: ['crud-production-administrators', 'crud-technical-supervisors'],
        subitems: [
            {
                id: 1,
                text: 'Production Administrators',
                href: '/production-administrators',
                inertia_ready: false,
                permissions: ['crud-production-administrators'],
            },
            {
                id: 2,
                text: 'Technical supervisors',
                href: '/technical-supervisors',
                inertia_ready: false,
                permissions: ['crud-technical-supervisors'],
            },
        ],
    },
    {
        id: 7,
        text: 'Users',
        href: '/users',
        inertia_ready: false,
        permissions: ['crud-users'],
        subitems: [],
    },
];

const DrawerMenuItem = ({ item, url }: {
    item: MenuItem | MenuSubItem;
    url: string;
}) => {
    return (item.inertia_ready ? (
        <Link
            href={item.href}
            title={item.text}
            className={clsx({
                'p-3 font-semibold hover:text-primary': true,
                'text-base-content': !url.startsWith(item.href),
                'text-primary': url.startsWith(item.href),
            })}
        >
            {item.text}
        </Link>
    ) : (
        <a
            href={item.href}
            title={item.text}
            className={clsx({
                'p-3 font-semibold hover:text-primary': true,
                'text-base-content': !url.startsWith(item.href),
                'text-primary': url.startsWith(item.href),
            })}
        >
            {item.text}
        </a>
    )
    );
}

export default function DrawerMenu() {
    const { url } = usePage();
    const { auth: { user } } = usePage<SharedData>().props;

    const canViewItem = (item: MenuItem | MenuSubItem, user: User | null) => {
        if (user?.is_admin) {
            return true;
        }

        if (item.permissions.length > 0) {
            return item.permissions.some((permission: string) => user?.permissions.includes(permission));
        }

        return false;
    }

    return (
        <ul className="p-4 menu bg-base-100 flex-1 sm:w-80 w-64">
            {menuItems.map((item) => canViewItem(item, user) && (
                <li key={item.id}>
                    {!item.subitems.length && <DrawerMenuItem item={item} url={url} />}
                    {item.subitems.length > 0 && (
                        <details
                            className="collapse group"
                            open={item.subitems.some((subitem) => url.startsWith(subitem.href))}
                        >
                            <summary className="flex items-center justify-between p-3 font-semibold collapse-title text-base-content hover:text-primary group-open:text-primary">{item.text}</summary>
                            <div className="collapse-content">
                                <ul>
                                    {item.subitems.map((subitem) => canViewItem(subitem, user) && (
                                        <li key={subitem.id}>
                                            <DrawerMenuItem item={subitem} url={url} />
                                        </li>
                                    ))}
                                </ul>
                            </div>
                        </details>
                    )}
                </li>
            ))
            }
            <li>
                <a
                    href="https://mphaustralia.sharepoint.com/:w:/r/teams/MPHAdministration/_layouts/15/Doc.aspx?sourcedoc=%7B9d7fb799-bfce-4bd7-964a-9dbceff1b470%7D&action=editnew"
                    className="p-3 font-semibold hover:text-primary text-base-content"
                    target="_blank"
                >
                    {'Help'}
                </a>
            </li>
        </ul >
    );
}
