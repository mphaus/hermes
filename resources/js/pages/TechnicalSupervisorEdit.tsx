import { Deferred, Head } from "@inertiajs/react";
import { SharedData } from "@/types";
import { usePage } from "@inertiajs/react";

export default function TechnicalSupervisorEdit() {
    const { title } = usePage<SharedData>().props;
    const technicalSupervisorData = usePage<SharedData>().props.technical_supervisor as {
        error: string;
        data: {
            id: number;
            first_name: string;
            last_name: string;
        };
    } | undefined;

    const { error, data: technicalSupervisor } = technicalSupervisorData || {};

    return (
        <>
            <Head title={title} />
            <Deferred data="technical_supervisor" fallback={<div>{'Loading...'}</div>}>
                {error && (
                    <div role="alert" className="alert alert-error">
                        {error}
                    </div>
                )}
                {technicalSupervisor && JSON.stringify(technicalSupervisor)}
            </Deferred>
        </>
    );
}