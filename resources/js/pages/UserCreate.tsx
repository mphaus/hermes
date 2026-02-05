import { Head, usePage } from "@inertiajs/react";
import { SharedData } from "@/types";
import UserForm from "@/_components/UserForm";

export default function UsersCreate() {
    const { title } = usePage<SharedData>().props;

    return (
        <>
            <Head title={title} />
            <UserForm />
        </>
    );
}
