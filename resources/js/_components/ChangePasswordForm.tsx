import { Form } from "@inertiajs/react";
import FormGroup from "./FormGroup";

export default function ChangePasswordForm() {
    return (
        <div className="card bg-base-100 shadow-sm mx-auto max-w-md">
            <div className="card-body">
                <Form action={'#'} className="space-y-4">
                    {({
                        errors,
                        hasErrors,
                        processing
                    }) => (
                        <>
                            <FormGroup>
                                <label htmlFor="current_password">{'Current password'}</label>
                                <input type="password" name="current_password" id="current_password" className="input" />
                            </FormGroup>
                            <FormGroup>
                                <label htmlFor="password">{'New password'}</label>
                                <input type="password" name="password" id="password" className="input" />
                                <p className="text-xs mt-1 text-info">{'Make sure your new password contains at least 16 characters, including a number and a special character.'}</p>
                            </FormGroup>
                            <FormGroup>
                                <label htmlFor="password_confirmation">{'Confirm new password'}</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" className="input" />
                            </FormGroup>
                            <div className="sm:flex sm:items-center sm:justify-end">
                                <button
                                    type="submit"
                                    className="btn btn-primary btn-block sm:w-auto"
                                    disabled={processing}
                                >
                                    {processing ? 'Changing password...' : 'Change password'}
                                </button>
                            </div>
                        </>
                    )}
                </Form>
            </div>
        </div>
    );
}