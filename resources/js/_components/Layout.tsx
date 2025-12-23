import { usePage, Form } from "@inertiajs/react";
import HermesLogo from "./../../images/hermes-logo.png";
import { create } from "@/actions/App/Http/Controllers/Auth/AuthenticatedSessionController";
import { destroy } from "@/actions/App/Http/Controllers/InertiaAuthenticatedSessionController";
import { SharedData } from "@/types";

export default function Layout({ children }: {
    children: React.ReactNode;
}) {
    const { auth } = usePage<SharedData>().props;

    return (
        <div className="drawer lg:drawer-open">
            <input id="my-drawer-3" type="checkbox" className="drawer-toggle" />
            <div className="flex flex-col items-center justify-center drawer-content">
                { children }
                <label htmlFor="my-drawer-3" className="btn drawer-button lg:hidden">
                    Open drawer
                </label>
            </div>
            <div className="drawer-side">
                <label htmlFor="my-drawer-3" aria-label="close sidebar" className="drawer-overlay"></label>
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
                    <ul className="p-4 menu bg-base-100 flex-1 sm:w-80 w-64">
                        <li>
                            <a href="/equipment-import" title={ 'Equipment Import' } className="p-3 font-semibold hover:text-base-content">{ 'Equipment Import' }</a>
                        </li>
                        <li>
                            <a href="/action-stream" title={ 'Action Stream' } className="p-3 font-semibold hover:text-base-content">{ 'Action Stream' }</a>
                        </li>
                        <li>
                            <a href="/qet" title={ 'QET' } className="p-3 font-semibold hover:text-base-content">{ 'QET' }</a>
                        </li>
                        <li>
                            <details className="collapse">
                                <summary className="flex items-center justify-between p-3 font-semibold collapse-title text-primary hover:text-base-content">{ 'Discussions' }</summary>
                                <div className="collapse-content">
                                    <ul>
                                        <li>
                                            <a href="/discussions/create" title={ 'Create Discussions' } className="p-3 hover:text-base-content">{ 'Create Discussions' }</a>
                                        </li>
                                        <li>
                                            <a href="/discussions/edit" title={ 'Edit default Discussions' } className="p-3 hover:text-base-content">{ 'Edit default Discussions' }</a>
                                        </li>
                                    </ul>
                                </div>
                            </details>
                        </li>
                        <li>
                            <a href="/quarantine/create" title={ 'Quarantine Intake' } className="p-3 font-semibold hover:text-base-content">{ 'Quarantine Intake' }</a>
                        </li>
                        <li>
                            <details className="collapse">
                                <summary className="flex items-center justify-between p-3 font-semibold collapse-title text-primary hover:text-base-content">{ 'Role CRUD' }</summary>
                                <div className="collapse-content">
                                    <ul>
                                        <li>
                                            <a href="/production-administrators" title={ 'Production Administrators' } className="p-3 hover:text-base-content">{ 'Production Administrators' }</a>
                                        </li>
                                        <li>
                                            <a href="/technical-supervisors" title={ 'Technical Supervisors' } className="p-3 hover:text-base-content">{ 'Technical Supervisors' }</a>
                                        </li>
                                    </ul>
                                </div>
                            </details>
                        </li>
                        <li>
                            <a href="/users" title={ 'Users' } className="p-3 font-semibold hover:text-base-content">{ 'Users' }</a>
                        </li>
                        <li>
                            <a
                                href="https://mphaustralia.sharepoint.com/:w:/r/teams/MPHAdministration/_layouts/15/Doc.aspx?sourcedoc=%7B9d7fb799-bfce-4bd7-964a-9dbceff1b470%7D&action=editnew"
                                className="p-3 font-semibold hover:text-base-content"
                                target="_blank"
                            >
                                { 'Help' }
                            </a>
                        </li>
                    </ul>
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
                </div>
            </div>
        </div>
    );
}
