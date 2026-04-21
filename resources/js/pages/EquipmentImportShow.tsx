import { SharedData } from "@/types";
import { Head, usePage } from "@inertiajs/react";
import { useState } from "react";

export default function EquipmentImportShow() {
    const { title } = usePage<SharedData>().props;
    const [pageTitle, setPageTitle] = useState<string | undefined>(title);

    return (
        <>
            <Head title={pageTitle} />
        </>
    );
}