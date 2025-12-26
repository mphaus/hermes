export default function QuarantineFormSkeleton() {
    return (
        <div className="card bg-base-100">
            <div className="card-body">
                <div className="space-y-7 animate-pulse">
                    { [ 0, 1, 2 ].map(value => (
                        <div className="space-y-1" key={ value }>
                            <div className="h-5 bg-base-300 rounded-lg"></div>
                            <div className="h-10 bg-base-300 rounded-lg"></div>
                        </div>
                    )) }
                </div>
            </div>
        </div>
    );
}
