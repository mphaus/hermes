export default function TechnicalSupervisorEditSkeleton() {
    return (
        <div className="card bg-base-100 shadow-sm mx-auto max-w-2xl">
            <div className="card-body gap-4">
                <h2 className="card-title skeleton skeleton-text">{'Technical Supervisor'}</h2>
                <div className="grid gap-4 md:grid-cols-2">
                    <div className="space-y-2">
                        <div className="h-5 bg-base-200 rounded-lg skeleton"></div>
                        <div className="h-10 bg-base-200 rounded-lg skeleton"></div>
                    </div>
                    <div className="space-y-2">
                        <div className="h-5 bg-base-200 rounded-lg skeleton"></div>
                        <div className="h-10 bg-base-200 rounded-lg skeleton"></div>
                    </div>
                </div>
                <div className="sm:flex sm:justify-end sm:items-center">
                    <div className="h-10 bg-base-200 rounded-lg skeleton w-full sm:max-w-16"></div>
                </div>
            </div>
        </div>
    );
}