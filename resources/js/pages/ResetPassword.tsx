import ResetPasswordForm from "@/_components/ResetPasswordForm";
import GuestLayout from "@/layouts/GuestLayout";
import { SharedData } from "@/types";
import { Head, usePage } from "@inertiajs/react";

const ResetPassword = () => {
    const { name } = usePage<SharedData>().props;
    const token = usePage<SharedData>().props.token as string;

    return (
        <>
            <Head title={name} />
            <ResetPasswordForm token={token} />
        </>
    );
}

ResetPassword.layout = (page: React.ReactNode) => <GuestLayout children={page} />;

export default ResetPassword;