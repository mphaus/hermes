import { Deferred, Head } from "@inertiajs/react";
import { SharedData } from "@/types";
import { usePage } from "@inertiajs/react";
import TechnicalSupervisorEditSkeleton from "@/_components/TechnicalSupervisorEditSkeleton";
import TechnicalSupervisorForm from "@/_components/TechnicalSupervisorForm";

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
            <Deferred data="technical_supervisor" fallback={<TechnicalSupervisorEditSkeleton />}>
                {error && (
                    <div role="alert" className="alert alert-error">
                        {error}
                    </div>
                )}
                {technicalSupervisor && <TechnicalSupervisorForm technicalSupervisor={technicalSupervisor} />}
            </Deferred>
        </>
    );
}