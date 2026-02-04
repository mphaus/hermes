import UserForm from "@/_components/UserForm";
import { SharedData, User } from "@/types";
import { Head, usePage } from "@inertiajs/react";

export default function UsersEdit() {
    const { title } = usePage<SharedData>().props;
    const user = usePage<SharedData>().props.user as User;

    return (
        <>
            <Head title={title} />
            <UserForm user={user} />
        </>
    );
}
