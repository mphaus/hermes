import EquipmentImportForm from "@/_components/EquipmentImportForm";
import EquipmentImportOpportunityDetails from "@/_components/EquipmentImportOpportunityDetails";
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
                {error && (
                    <div role="alert" className="alert alert-error">
                        {error}
                    </div>
                )}
                {!error && opportunity && (
                    <div className="space-y-4">
                        <EquipmentImportOpportunityDetails
                            opportunity={opportunity}
                            opportunities_url={opportunities_url}
                        />
                        <EquipmentImportForm />
                    </div>
                )}
            </Deferred>
        </>
    );
}