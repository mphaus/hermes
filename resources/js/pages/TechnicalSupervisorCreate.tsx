import { SharedData } from "@/types";
import { Head, usePage } from "@inertiajs/react";
import TechnicalSupervisorForm from "@/_components/TechnicalSupervisorForm";

export default function TechnicalSupervisorCreate() {
    const { title } = usePage<SharedData>().props;

    return (
        <>
            <Head title={title} />
            <TechnicalSupervisorForm />
        </>
    );
}