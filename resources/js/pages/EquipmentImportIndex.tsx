import OpportunitiesList from "@/_components/OpportunitiesList";
import { SharedData } from "@/types";
import { Deferred, Head, usePage } from "@inertiajs/react";

export default function EquipmentImportIndex() {
    const opportunitiesData = usePage<SharedData>().props.opportunities_data as {
        error: string;
        data: Record<string, any>[];
    } | undefined;
    const { error, data: opportunities } = opportunitiesData || {};

    return (
        <>
            <Head title={'Equipment Import'} />
            <Deferred data="opportunities_data" fallback={<div>Loading...</div>}>
                {!!opportunities?.length && (
                    <OpportunitiesList opportunities={opportunities} />
                )}
            </Deferred>
        </>
    );
}