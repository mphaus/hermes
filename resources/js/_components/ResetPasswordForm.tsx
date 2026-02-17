import { Form } from "@inertiajs/react";
import FormGroup from "./FormGroup";

export default function ResetPasswordForm({ token }: {
    token: string;
}) {
    return (
        <div className="bg-base-100 card shadow-sm">
            <div className="card-body">
                <Form
                    action={'#'}
                    className="space-y-4"
                >
                    {({
                        processing,
                        errors,
                        hasErrors,
                    }) => (
                        <>
                            <input type="hidden" name="token" value={token} />
                            <FormGroup>
                                <label htmlFor="email">{'Email'}</label>
                                <input
                                    type="email"
                                    name="email"
                                    id="email"
                                    className="input input-bordered w-full"
                                    required
                                    autoComplete="off"
                                />
                            </FormGroup>
                            <FormGroup>
                                <label htmlFor="password">{'Password'}</label>
                                <input
                                    type="password"
                                    name="password"
                                    id="password"
                                    className="input"
                                    required
                                />
                            </FormGroup>
                            <FormGroup>
                                <label htmlFor="password_confirmation">{'Confirm Password'}</label>
                                <input
                                    type="password"
                                    name="password_confirmation"
                                    id="password_confirmation"
                                    className="input"
                                    required
                                />
                            </FormGroup>
                            <div className="space-y-4 text-xs">
                                <div className="flex items-center gap-2">
                                    <p>{'A unique and secure password is required.'}</p>
                                </div>
                                <ul className="pl-5 space-y-1 list-disc">
                                    <li className="text-error">{'Minimum 16 characters'}</li>
                                    <li>
                                        {'At least'}
                                        <ul className="list-[circle] pl-7 space-y-1 mt-1">
                                            <li className="text-error">{'2 uppercase letters'}</li>
                                            <li className="text-error">{'2 lowercase letters'}</li>
                                            <li className="text-error">{'2 numbers'}</li>
                                            <li className="text-error">{'2 special characters (!@#$%^&*()-_+=)'}</li>
                                        </ul>
                                    </li>
                                </ul>
                                <p>{'Passwords suggested by Password Managers (eg, 1Password) are ideal - be sure to save the password in your Password Manager as well!'}</p>
                            </div>
                            <div className="sm:flex sm:justify-end">
                                <button
                                    type="submit"
                                    className="btn btn-primary btn-block sm:w-auto"
                                >
                                    {'Reset Password'}
                                </button>
                            </div>
                        </>
                    )}
                </Form>
            </div>
        </div>
    );
}