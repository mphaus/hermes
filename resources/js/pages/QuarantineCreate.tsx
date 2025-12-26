import QuarantineForm from "@/_components/QuarantineForm";
import QuarantineFormSkeleton from "@/_components/QuarantineFormSkeleton";
import { CurrentRMSListData, SharedData } from "@/types";
import { Deferred, usePage } from "@inertiajs/react";

export default function QuarantineCreate() {
    const technical_supervisors = usePage<SharedData>().props.technical_supervisors as CurrentRMSListData | undefined;
    const errors = technical_supervisors?.errors;
    const list_name = technical_supervisors?.list_name;

    return (
        <div className="mx-auto max-w-3xl">
            <Deferred data="technical_supervisors" fallback={ <QuarantineFormSkeleton /> }>
                { errors && (
                    <div role="alert" className="alert alert-error">
                        { `An unexpected error occurred while fetching the Technical Supervisors list. Please refresh the page and try again. (${errors[ 0 ]})` }
                    </div>
                ) }
                { list_name && !list_name?.list_values.length && (
                    <div role="alert" className="alert alert-warning">
                        { 'In order to create a Quarantine, one or more Technical Supervisors must have been previously created using the Technical Supervisor CRUD. It is also recommended that a Technical Supervisor has been assigned to Opportunities.' }
                    </div>
                ) }
                { list_name && !!list_name?.list_values.length && (
                    <QuarantineForm technicalSupervisors={ list_name?.list_values } />
                ) }
            </Deferred>
        </div>
    );
}
