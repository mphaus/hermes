import ForgotPasswordForm from "@/_components/ForgotPasswordForm";
import GuestLayout from "@/layouts/GuestLayout";
import { SharedData } from "@/types";
import { Head, usePage } from "@inertiajs/react";

const ForgotPassword = () => {
    const { title } = usePage<SharedData>().props;
    const status = usePage<SharedData>().props.status as string | null;

    return (
        <>
            <Head title={title} />
            {status ? (
                <div className="alert alert-info">{status}</div>
            ) : (
                <ForgotPasswordForm />
            )}
        </>
    );
}

ForgotPassword.layout = (page: React.ReactNode) => <GuestLayout children={page} />;

export default ForgotPassword;