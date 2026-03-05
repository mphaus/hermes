import TechnicalSupervisorSkeleton from "@/_components/TechnicalSupervisorSkeleton";
import TechnicalSupervisorsList from "@/_components/TechnicalSupervisorsList";
import { CurrentRMSListValue, SharedData } from "@/types";
import { Deferred, Head, usePage } from "@inertiajs/react";

export default function TechnicalSupervisorIndex() {
    const { title } = usePage<SharedData>().props;
    const technicalSupervisorsData = usePage<SharedData>().props.technical_supervisors_data as {
        error: string;
        data: CurrentRMSListValue[];
    } | undefined;
    const { error, data: technicalSupervisors } = technicalSupervisorsData || {};

    return (
        <>
            <Head title={title} />
            <Deferred data="technical_supervisors_data" fallback={<TechnicalSupervisorSkeleton />}>
                {error && (
                    <div role="alert" className="alert alert-error">
                        {error}
                    </div>
                )}
                {!technicalSupervisors?.length && (
                    <div role="alert" className="alert alert-info max-w-3xl mx-auto">
                        {'You have not added any Technical Supervisors yet.'}
                    </div>
                )}
                {!!technicalSupervisors?.length && (
                    <TechnicalSupervisorsList technicalSupervisors={technicalSupervisors} />
                )}
            </Deferred>
        </>
    );
}