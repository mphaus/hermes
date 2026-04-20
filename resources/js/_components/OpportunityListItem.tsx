import { Link } from "@inertiajs/react";

export default function OpportunityListItem({ opportunity }: {
    opportunity: Record<string, any>;
}) {
    return (
        <li className="list-row grid-cols-1 relative">
            <div className="grid lg:grid-cols-6 gap-2 items-center">
                <Link
                    href={'#'}
                    className="lg:col-span-4 after:absolute after:inset-0 after:z-1"
                    title={opportunity.subject}
                >
                    {opportunity.subject}
                </Link>
                <div className="mt-2 lg:mt-0 lg:text-center">
                    <p className="font-semibold lg:hidden">{'Start date'}</p>
                    <time>{opportunity.starts_at}</time>
                </div>
                <div className="lg:text-center">
                    <p className="font-semibold lg:hidden">{'End date'}</p>
                    <time>{opportunity.ends_at}</time>
                </div>
            </div>
        </li>
    );
}