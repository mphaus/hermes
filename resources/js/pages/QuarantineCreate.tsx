import QuarantineForm from "@/_components/QuarantineForm";
import QuarantineFormSkeleton from "@/_components/QuarantineFormSkeleton";
import { SharedData } from "@/types";
import { Deferred, usePage } from "@inertiajs/react";

export default function QuarantineCreate() {
    const { technical_supervisors } = usePage<SharedData>().props;
    console.log(technical_supervisors);

    return (
        <div className="mx-auto max-w-3xl">
            <Deferred data="technical_supervisors" fallback={ <QuarantineFormSkeleton /> }>
                <QuarantineForm />
            </Deferred>
        </div>
    );
}
