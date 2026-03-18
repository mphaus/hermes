import ProductionAdministratorForm from "@/_components/ProductionAdministratorForm";
import { SharedData } from "@/types";
import { Head, usePage } from "@inertiajs/react";


export default function ProductionAdministratorCreate() {
    const { title } = usePage<SharedData>().props;

    return (
        <>
            <Head title={title} />
            <ProductionAdministratorForm />
        </>
    );
}
