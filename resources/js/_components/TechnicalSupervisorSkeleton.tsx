export default function TechnicalSupervisorSkeleton() {
    return (
        <ul className="list bg-base-100 rounded-lg shadow-sm max-w-xl mx-auto">
            {[0, 1, 2, 3].map(value => (
                <li className="list-row" key={value}>
                    <div className="skeleton list-col-grow h-5 bg-base-200 rounded-lg"></div>
                </li>
            ))}
        </ul>
    );
}