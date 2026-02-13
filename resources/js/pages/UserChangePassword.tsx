import ChangeUserPasswordForm from "@/_components/ChangeUserPasswordForm";
import { SharedData, User } from "@/types";
import { Head, usePage } from "@inertiajs/react"

export default function UserChangePassword() {
    const { title } = usePage<SharedData>().props;
    const user = usePage<SharedData>().props.user as User;

    return (
        <>
            <Head title={title} />
            <ChangeUserPasswordForm user={user} />
        </>
    );
}