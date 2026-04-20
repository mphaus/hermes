export default function EquipmentImportSkeleton() {
    return (
        <div className="space-y-4">
            <div className="card bg-base-100 card-xs hidden lg:flex">
                <div className="card-body">
                    <div className="grid font-semibold grid-cols-6">
                        <p className="col-span-4 skeleton skeleton-text">{'Opportunity'}</p>
                        <p className="text-center skeleton skeleton-text">{'Start date'}</p>
                        <p className="text-center skeleton skeleton-text">{'End date'}</p>
                    </div>
                </div>
            </div>
            <ul className="list bg-base-100 rounded-lg shadow-sm">
                {[0, 1, 2].map((index) => (
                    <li key={index} className="list-row grid-cols-1">
                        <div className="grid lg:grid-cols-6 gap-2 items-center">
                            <div className="lg:col-span-4 skeleton h-5"></div>
                            <div className="skeleton h-5"></div>
                            <div className="skeleton h-5"></div>
                        </div>
                    </li>
                ))}
            </ul>
        </div>
    );
}