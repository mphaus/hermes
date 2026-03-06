import { SharedData } from "@/types";
import { Head, usePage } from "@inertiajs/react";

export default function TechnicalSupervisorCreate() {
    const { title } = usePage<SharedData>().props;

    return (
        <>
            <Head title={title} />
            <div>{'TODO: Technical Supervisor Create page'}</div>
        </>
    );
}