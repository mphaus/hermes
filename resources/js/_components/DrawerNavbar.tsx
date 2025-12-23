import { Menu } from "lucide-react";

export default function DrawerNavbar() {
    return (
        <div className="navbar bg-base-100 w-full sticky top-0 bg-base-100/80 backdrop-blur-sm">
            <div className="flex-none lg:hidden">
                <label htmlFor="hermes-drawer" aria-label="open sidebar" className="btn btn-square btn-ghost">
                    <Menu />
                </label>
            </div>
            <div className="mx-2 flex-1 px-2">Hermes</div>
        </div>
    );
}
