import { destroy } from "@/actions/App/Http/Controllers/InertiaAuthenticatedSessionController";
import { SharedData } from "@/types";
import { Form, usePage } from "@inertiajs/react";

export default function DrawerUser() {
    const { auth } = usePage<SharedData>().props;

    return (
        <div className="dropdown dropdown-top">
            <div tabIndex={ 0 } role="button" className="cursor-pointer px-7 py-4 text-primary hover:text-base-content font-semibold">{ `${auth.user?.first_name} ${auth.user?.last_name}` }</div>
            <ul tabIndex={ -1 } className="dropdown-content menu bg-base-100 rounded-box z-1 w-52 p-2 shadow-sm">
                <li>
                    <Form action={ destroy() } method="POST" className="block">
                        <button type="submit" className="block w-full cursor-pointer text-left">{ 'Logout' }</button>
                    </Form>
                </li>
            </ul>
        </div>
    );
}
