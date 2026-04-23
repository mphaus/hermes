import OpportunityListItem from "./OpportunityListItem";

export default function OpportunitiesList({ opportunities }: {
    opportunities: Record<string, any>[];
}) {
    return (
        <div className="space-y-4">
            <div className="hidden lg:flex card bg-base-100 card-xs">
                <div className="card-body">
                    <div className="grid font-semibold grid-cols-6">
                        <p className="col-span-4">{'Opportunity'}</p>
                        <p className="text-center">{'Start date'}</p>
                        <p className="text-center">{'End date'}</p>
                    </div>
                </div>
            </div>
            <ul className="list bg-base-100 rounded-lg shadow-sm">
                {opportunities.map(opportunity => (
                    <OpportunityListItem key={opportunity.id} opportunity={opportunity} />
                ))}
            </ul>
        </div>
    );
}
