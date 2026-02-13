import { Form } from "@inertiajs/react";
import UserPasswordField from "./UserPasswordField";
import UserUpdatePasswordController from "@/actions/App/Http/Controllers/UserUpdatePasswordController";
import { User } from "@/types";

export default function ChangeUserPasswordForm({ user }: {
    user: User;
}) {
    return (
        <div className="card bg-base-100 shadow-sm mx-auto max-w-3xl">
            <div className="card-body">
                <Form
                    action={UserUpdatePasswordController(user.id)}
                    className="space-y-4"
                >
                    {({
                        errors,
                        hasErrors,
                        processing
                    }) => (
                        <>
                            {hasErrors && <div role="alert" className="alert alert-error">
                                <span>{'Some fields need your attention. Please review the form and correct the highlighted errors.'}</span>
                            </div>}
                            <UserPasswordField error={errors.password} />
                            <div className="sm:flex sm:items-center sm:justify-end">
                                <button
                                    type="submit"
                                    className="btn btn-primary btn-block sm:w-auto"
                                    disabled={processing}
                                >
                                    {processing ? 'Changing...' : 'Change Password'}
                                </button>
                            </div>
                        </>
                    )}
                </Form>
            </div>
        </div>
    );
}