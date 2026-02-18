import ForgotPasswordForm from "@/_components/ForgotPasswordForm";
import GuestLayout from "@/layouts/GuestLayout";

const ForgotPassword = () => {
    return (
        <ForgotPasswordForm />
    );
}

ForgotPassword.layout = (page: React.ReactNode) => <GuestLayout children={page} />;

export default ForgotPassword;