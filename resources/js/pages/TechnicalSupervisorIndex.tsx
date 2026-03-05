import TechnicalSupervisorsList from "@/_components/TechnicalSupervisorsList";
import { CurrentRMSListValue, SharedData } from "@/types";
import { Deferred, usePage } from "@inertiajs/react";

export default function TechnicalSupervisorIndex() {
    const technicalSupervisorsData = usePage<SharedData>().props.technical_supervisors_data as {
        error: string;
        data: CurrentRMSListValue[];
    } | undefined;
    const { error, data: technicalSupervisors } = technicalSupervisorsData || {};

    return (
        <Deferred data="technical_supervisors_data" fallback={<div>Loading...</div>}>
            {error && (
                <div role="alert" className="alert alert-error">
                    {error}
                </div>
            )}
            {technicalSupervisors && (
                <TechnicalSupervisorsList technicalSupervisors={technicalSupervisors} />
            )}
        </Deferred>
    );
}