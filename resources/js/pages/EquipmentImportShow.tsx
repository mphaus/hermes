import { SharedData } from "@/types";
import { Deferred, Head, usePage } from "@inertiajs/react";
import { useEffect, useState } from "react";

export default function EquipmentImportShow() {
    const { title } = usePage<SharedData>().props;
    const opportunity_data = usePage<SharedData>().props.opportunity_data as Record<string, any> | undefined;
    const opportunities_url = usePage<SharedData>().props.opportunities_url as string;

    const { error, data: opportunity } = opportunity_data || {};

    const [pageTitle, setPageTitle] = useState<string | undefined>(title);

    useEffect(() => {
        if (!error && opportunity) {
            setPageTitle(`${title} > ${opportunity.subject}`);
        }
    }, [error, opportunity]);

    return (
        <>
            <Head title={pageTitle} />
            <Deferred data="opportunity_data" fallback={<div>Loading...</div>}>
                {!error && opportunity && (
                    <div className="card bg-base-100 shadow-sm">
                        <div className="card-body space-y-4">
                            <h2 className="card-title">
                                <a
                                    href={`${opportunities_url}${opportunity.id}`}
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    className="text-primary font-semibold"
                                >
                                    {opportunity.subject}
                                </a>
                            </h2>
                            <div className="text-xs grid gap-2 grid-cols-2 md:grid-cols-4 md:text-sm items-start">
                                <div className="flex flex-col gap-1">
                                    <p className="font-semibold">{'Start Date'}</p>
                                    <time dateTime={opportunity.starts_at}>{opportunity.starts_at_formatted}</time>
                                </div>
                                <div className="flex flex-col gap-1">
                                    <p className="font-semibold">{'End Date'}</p>
                                    <time dateTime={opportunity.ends_at}>{opportunity.ends_at_formatted}</time>
                                </div>
                                <div className="flex flex-col gap-1">
                                    <p className="font-semibold">{'Revenue'}</p>
                                    <p>{opportunity.charge_total_formatted}</p>
                                </div>
                                <div className="flex flex-col gap-1">
                                    <p className="font-semibold">{'Participants'}</p>
                                    <ul className="space-y-1">
                                        {opportunity.participants.map((participant: Record<string, any>) => (
                                            <li key={participant.id}>{participant.member_name}</li>
                                        ))}
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                )}
            </Deferred>
        </>
    );
}