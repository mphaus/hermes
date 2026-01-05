import QuarantineForm from "@/_components/QuarantineForm";
import QuarantineFormSkeleton from "@/_components/QuarantineFormSkeleton";
import { CurrentRMSListData, CurrentRMSMemberData, SharedData } from "@/types";
import { Deferred, usePage } from "@inertiajs/react";

export default function QuarantineCreate() {
    const technicalSupervisorsData = usePage<SharedData>().props.technical_supervisors_data as CurrentRMSListData | undefined;
    const { errors: tsErrors, list_name: tsListName } = technicalSupervisorsData || {};
    const { list_values: technicalSupervisors } = tsListName || {};

    const membersData = usePage<SharedData>().props.members_data as CurrentRMSMemberData | undefined;
    const { errors: mErrors, members } = membersData || {};

    return (
        <div className="mx-auto max-w-3xl space-y-4">
            <Deferred data={ [ 'technical_supervisors_data', 'members_data' ] } fallback={ <QuarantineFormSkeleton /> }>
                { tsErrors && (
                    <div role="alert" className="alert alert-error">
                        { `An unexpected error occurred while fetching the Technical Supervisors list. Please refresh the page and try again. (${tsErrors[ 0 ]})` }
                    </div>
                ) }
                { mErrors && (
                    <div role="alert" className="alert alert-error">
                        { `An unexpected error occurred while fetching the Members list that can be used to select the owner of the Quarantine . Please refresh the page and try again. (${mErrors[ 0 ]})` }
                    </div>
                ) }
                { !tsErrors && !technicalSupervisors?.length && (
                    <div role="alert" className="alert alert-warning">
                        { 'In order to create a Quarantine, one or more Technical Supervisors must have been previously created using the Technical Supervisor CRUD. It is also recommended that a Technical Supervisor has been assigned to Opportunities.' }
                    </div>
                ) }
                { technicalSupervisors && members && (
                    <QuarantineForm
                        technicalSupervisors={ technicalSupervisors }
                        members={ members }
                    />
                ) }
            </Deferred>
        </div>
    );
}
