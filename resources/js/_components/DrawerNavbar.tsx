import { SharedData } from "@/types";
import { usePage } from "@inertiajs/react";
import { Menu } from "lucide-react";

export default function DrawerNavbar() {
    const { name, title } = usePage<SharedData>().props;

    return (
        <div className="navbar bg-base-100 w-full sticky top-0 bg-base-100/80 backdrop-blur-sm">
            <div className="flex-none lg:hidden">
                <label htmlFor="hermes-drawer" aria-label="open sidebar" className="btn btn-square btn-ghost">
                    <Menu />
                </label>
            </div>
            <div className="mx-2 flex-1 px-2">
                { title ?? name }
            </div>
        </div>
    );
}
