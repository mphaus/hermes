import HermesLogo from "./../../images/hermes-logo.png";
import { create } from "@/actions/App/Http/Controllers/Auth/AuthenticatedSessionController";
import DrawerMenu from "./DrawerMenu";
import DrawerUser from "./DrawerUser";
import DrawerNavbar from "./DrawerNavbar";
import DrawerDescription from "./DrawerDescription";

export default function Layout({ children }: {
    children: React.ReactNode;
}) {
    return (
        <div className="drawer lg:drawer-open">
            <input id="hermes-drawer" type="checkbox" className="drawer-toggle" />
            <div className="flex flex-col drawer-content">
                <DrawerNavbar />
                <DrawerDescription />
                <main className="px-4 mx-auto w-full max-w-7xl py-6">
                    { children }
                </main>
            </div>
            <div className="drawer-side">
                <label htmlFor="hermes-drawer" aria-label="close sidebar" className="drawer-overlay"></label>
                <div className="flex flex-col min-h-full bg-base-100">
                    <div className="w-full p-4">
                        <a href={ create().url } title={ 'Hermes' }>
                            <img
                                src={ HermesLogo }
                                alt={ 'Hermes logo' }
                                className="w-24 mx-auto"
                            />
                        </a>
                    </div>
                    <DrawerMenu />
                    <DrawerUser />
                </div>
            </div>
        </div>
    );
}
