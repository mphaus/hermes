export default function EquipmentImportShowSkeleton() {
    return (
        <div className="card bg-base-100 shadow-sm">
            <div className="card-body space-y-4">
                <h2 className="card-title skeleton skeleton-text">{'Loading...'}</h2>
                <div className="grid gap-4 grid-cols-2 md:grid-cols-4 md:text-sm items-start md:gap-6">
                    {[0, 1, 2, 3].map(i => (
                        <div className="flex flex-col gap-1" key={i}>
                            <div className="h-5 skeleton"></div>
                            <div className="h-5 skeleton"></div>
                        </div>
                    ))}
                </div>
            </div>
        </div>
    );
}   