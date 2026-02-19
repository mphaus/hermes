import { SharedData } from "@/types";
import { Form, usePage } from "@inertiajs/react";
import FormGroup from "./FormGroup";
import { store } from "@/actions/App/Http/Controllers/Auth/PasswordResetLinkController";
import FormError from "./FormError";

export default function ForgotPasswordForm() {
    const { name } = usePage<SharedData>().props;

    return (
        <div className="card bg-base-100 shadow-sm">
            <div className="card-body space-y-4">
                <p className="text-sm text-info">{`Enter the email address associated with ${name} and the system will email you a password reset link. This message should arrive in under five minutes, but may be in your spam folder.`}</p>
                <Form action={store()} className="space-y-4">
                    {({
                        processing,
                        errors
                    }) => (
                        <>
                            <FormGroup>
                                <label htmlFor="email" className="label">{'Email'}</label>
                                <input type="email" name="email" id="email" className="input" />
                                <FormError message={errors.email} />
                            </FormGroup>
                            <div>
                                <button
                                    type="submit"
                                    className="btn btn-primary btn-block"
                                    disabled={processing}
                                >
                                    {processing ? 'Sending...' : 'Email Password Reset Link'}
                                </button>
                            </div>
                        </>
                    )}
                </Form>
            </div>
        </div>
    );
}