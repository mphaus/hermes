import { Link } from "@inertiajs/react";

export default function OpportunityListItem({ opportunity }: {
    opportunity: Record<string, any>;
}) {
    return (
        <li className="list-row grid-cols-6">
            <Link href={'#'} className="col-span-4">{opportunity.subject}</Link>
            <p>{opportunity.starts_at}</p>
            <p>{opportunity.ends_at}</p>
        </li>
    );
}