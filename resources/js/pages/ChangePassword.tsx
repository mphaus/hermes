import ChangePasswordForm from "@/_components/ChangePasswordForm";
import { SharedData } from "@/types";
import { Head, usePage } from "@inertiajs/react";

export default function ChangePassword() {
    const { title } = usePage<SharedData>().props;

    return (
        <>
            <Head title={title} />
            <ChangePasswordForm />
        </>
    );
}