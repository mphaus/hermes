export default function DrawerMenu() {
    return (
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
                    <summary className="flex items-center justify-between p-3 font-semibold collapse-title">{ 'Discussions' }</summary>
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
                    <summary className="flex items-center justify-between p-3 font-semibold collapse-title">{ 'Role CRUD' }</summary>
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
    );
}
