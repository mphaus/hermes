import hermesLogo from "./../../images/hermes-logo.png";
import { create } from "@/actions/App/Http/Controllers/Auth/AuthenticatedSessionController";
import DrawerMenu from "../_components/DrawerMenu";
import DrawerUser from "../_components/DrawerUser";
import DrawerNavbar from "../_components/DrawerNavbar";
import DrawerDescription from "../_components/DrawerDescription";
import Toast from "../_components/Toast";
import { router, usePage } from "@inertiajs/react";
import { FlashData, SharedData } from "@/types";
import { useEffect, useRef } from "react";

export default function Layout({ children }: {
    children: React.ReactNode;
}) {
    const drawerToggleRef = useRef<HTMLInputElement | null>(null);
    const toast = usePage<SharedData>().flash?.toast as FlashData['toast'];

    useEffect(() => {
        return router.on('navigate', () => {
            if (drawerToggleRef.current) {
                drawerToggleRef.current.checked = false;
            }
        });
    });

    return (
        <>
            <div className="drawer xl:drawer-open">
                <input id="hermes-drawer" ref={drawerToggleRef} type="checkbox" className="drawer-toggle" />
                <div className="flex flex-col drawer-content">
                    <DrawerNavbar />
                    <DrawerDescription />
                    <main className="px-4 mx-auto w-full max-w-7xl pt-6 pb-20 xl:pb-6">
                        {children}
                    </main>
                </div>
                <div className="drawer-side">
                    <label htmlFor="hermes-drawer" aria-label="close sidebar" className="drawer-overlay"></label>
                    <div className="flex flex-col min-h-full bg-base-100">
                        <div className="w-full p-4">
                            <a href={create().url} title={'Hermes'}>
                                <img
                                    src={hermesLogo}
                                    alt={'Hermes logo'}
                                    className="w-24 mx-auto"
                                />
                            </a>
                        </div>
                        <DrawerMenu />
                        <DrawerUser />
                    </div>
                </div>
            </div>
            {toast && <Toast type={toast.type} message={toast.message} />}
        </>
    );
}
