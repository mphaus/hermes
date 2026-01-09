import QuarantineForm from "@/_components/QuarantineForm";
import QuarantineFormSkeleton from "@/_components/QuarantineFormSkeleton";
import { CurrentRMSListValue, CurrentRMSMember, SharedData } from "@/types";
import { Deferred, Head, usePage } from "@inertiajs/react";

export default function QuarantineCreate() {
    const technicalSupervisorsData = usePage<SharedData>().props.technical_supervisors_data as {
        error: string;
        data: CurrentRMSListValue[];
    } | undefined;
    const { error: tsError, data: technicalSupervisors } = technicalSupervisorsData || {};

    const membersData = usePage<SharedData>().props.members_data as {
        error: string;
        data: CurrentRMSMember[];
    } | undefined;
    const { error: mError, data: members } = membersData || {};

    return (
        <>
            <Head title={ 'Quarantine Intake' } />
            <div className="mx-auto max-w-3xl space-y-4">
                <Deferred data={ [ 'technical_supervisors_data', 'members_data' ] } fallback={ <QuarantineFormSkeleton /> }>
                    { tsError && (
                        <div role="alert" className="alert alert-error">
                            { tsError }
                        </div>
                    ) }
                    { mError && (
                        <div role="alert" className="alert alert-error">
                            { mError }
                        </div>
                    ) }
                    { !tsError && !technicalSupervisors?.length && (
                        <div role="alert" className="alert alert-warning">
                            { 'In order to create a Quarantine, one or more Technical Supervisors must have been previously created using the Technical Supervisor CRUD. It is also recommended that a Technical Supervisor has been assigned to Opportunities.' }
                        </div>
                    ) }
                    { !!technicalSupervisors?.length && !!members?.length && (
                        <QuarantineForm
                            technicalSupervisors={ technicalSupervisors }
                            members={ members }
                        />
                    ) }
                </Deferred>
            </div>
        </>
    );
}
