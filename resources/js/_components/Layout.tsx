import HermesLogo from "./../../images/hermes-logo.png";
import { create } from "@/actions/App/Http/Controllers/Auth/AuthenticatedSessionController";

export default function Layout({ children }: {
    children: React.ReactNode;
}) {
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
                <div className="w-full p-4">
                    <a href={ create().url } title={ 'Hermes' }>
                        <img
                            src={ HermesLogo }
                            alt={ 'Hermes logo' }
                            className="w-24 mx-auto"
                        />
                    </a>
                </div>
                <ul className="min-h-full p-4 menu bg-base-100 w-80">
                    <li>
                        <a href="/equipment-import" title={ 'Equipment Import' } className="p-3 font-semibold">{ 'Equipment Import' }</a>
                    </li>
                    <li>
                        <a href="/action-stream" title={ 'Action Stream' } className="p-3 font-semibold">{ 'Action Stream' }</a>
                    </li>
                    <li>
                        <a href="/qet" title={ 'QET' } className="p-3 font-semibold">{ 'QET' }</a>
                    </li>
                    <li>
                        <details className="collapse">
                            <summary className="flex items-center justify-between p-3 font-semibold collapse-title text-primary hover:text-primary/90">{ 'Discussions' }</summary>
                            <div className="collapse-content">
                                <ul>
                                    <li>
                                        <a href="/discussions/create" title={ 'Create Discussions' } className="p-3 font-semibold">{ 'Create Discussions' }</a>
                                    </li>
                                    <li>
                                        <a href="/discussions/edit" title={ 'Edit default Discussions' } className="p-3 font-semibold">{ 'Edit default Discussions' }</a>
                                    </li>
                                </ul>
                            </div>
                        </details>
                    </li>
                    <li>
                        <a href="/quarantine/create" title={ 'Quarantine Intake' } className="p-3 font-semibold">{ 'Quarantine Intake' }</a>
                    </li>
                    <li>
                        <details className="collapse">
                            <summary className="flex items-center justify-between p-3 font-semibold collapse-title text-primary hover:text-primary/90">{ 'Role CRUD' }</summary>
                            <div className="collapse-content">
                                <ul>
                                    <li>
                                        <a href="/production-administrators" title={ 'Production Administrators' } className="p-3 font-semibold">{ 'Production Administrators' }</a>
                                    </li>
                                    <li>
                                        <a href="/technical-supervisors" title={ 'Technical Supervisors' } className="p-3 font-semibold">{ 'Technical Supervisors' }</a>
                                    </li>
                                </ul>
                            </div>
                        </details>
                    </li>
                    <li>
                        <a href="/users" title={ 'Users' } className="p-3 font-semibold">{ 'Users' }</a>
                    </li>
                    <li>
                        <a
                            href="https://mphaustralia.sharepoint.com/:w:/r/teams/MPHAdministration/_layouts/15/Doc.aspx?sourcedoc=%7B9d7fb799-bfce-4bd7-964a-9dbceff1b470%7D&action=editnew"
                            className="p-3 font-semibold"
                            target="_blank"
                        >
                            { 'Help' }
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    );
}
