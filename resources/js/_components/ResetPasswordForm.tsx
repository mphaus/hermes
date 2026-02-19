import { Form } from "@inertiajs/react";
import FormGroup from "./FormGroup";
import clsx from "clsx";
import { useMemo, useReducer, useRef } from "react";
import { store } from "@/actions/App/Http/Controllers/Auth/NewPasswordController";
import FormError from "./FormError";

const lengthPattern = /.{16,24}/;
const twoUppercaseLettersPattern = /(?=.*[A-Z].*[A-Z])/;
const twoLowercaseLettersPattern = /(?=.*[a-z].*[a-z])/;
const twoNumbersPattern = /(?=.*\d.*\d)/;
const twoSpecialCharactersPattern = /(?=.*[!@#$%^&*].*[!@#$%^&*])/;

export default function ResetPasswordForm({ token, email }: {
    token: string;
    email: string;
}) {
    const passwordRef = useRef<HTMLInputElement | null>(null);
    const passwordConfirmationRef = useRef<HTMLInputElement | null>(null);
    const [renderTick, forceRender] = useReducer((x) => x + 1, 0);

    const password = passwordRef.current?.value ?? "";
    const passwordConfirmation = passwordConfirmationRef.current?.value ?? "";
    const passwordsMatch = password === passwordConfirmation;

    const matchesAndHasValidLength = useMemo(() => {
        return passwordsMatch && lengthPattern.test(password);
    }, [passwordsMatch, password, renderTick]);

    const matchesAndHasTwoUppercase = useMemo(() => {
        return passwordsMatch && twoUppercaseLettersPattern.test(password);
    }, [passwordsMatch, password, renderTick]);

    const matchesAndHasTwoLowercase = useMemo(() => {
        return passwordsMatch && twoLowercaseLettersPattern.test(password);
    }, [passwordsMatch, password, renderTick]);

    const matchesAndHasTwoNumbers = useMemo(() => {
        return passwordsMatch && twoNumbersPattern.test(password);
    }, [passwordsMatch, password, renderTick]);

    const matchesAndHasTwoSpecialCharacters = useMemo(() => {
        return passwordsMatch && twoSpecialCharactersPattern.test(password);
    }, [passwordsMatch, password, renderTick]);

    const isPasswordValid = useMemo(() => {
        return (
            matchesAndHasValidLength &&
            matchesAndHasTwoUppercase &&
            matchesAndHasTwoLowercase &&
            matchesAndHasTwoNumbers &&
            matchesAndHasTwoSpecialCharacters
        );
    }, [
        matchesAndHasValidLength,
        matchesAndHasTwoUppercase,
        matchesAndHasTwoLowercase,
        matchesAndHasTwoNumbers,
        matchesAndHasTwoSpecialCharacters,
    ]);

    return (
        <div className="bg-base-100 card shadow-sm">
            <div className="card-body">
                <Form
                    action={store()}
                    className="space-y-4"
                >
                    {({
                        processing,
                        errors
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
                                    defaultValue={email}
                                />
                                <FormError message={errors.email} />
                            </FormGroup>
                            <FormGroup>
                                <label htmlFor="password">{'Password'}</label>
                                <input
                                    type="password"
                                    name="password"
                                    id="password"
                                    className="input"
                                    required
                                    ref={passwordRef}
                                    onInput={forceRender}
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
                                    ref={passwordConfirmationRef}
                                    onInput={forceRender}
                                />
                            </FormGroup>
                            <div className="space-y-4 text-xs">
                                <div className="flex items-center gap-2">
                                    <p>{'A unique and secure password is required.'}</p>
                                </div>
                                <ul className="pl-5 space-y-1 list-disc">
                                    <li className={clsx({
                                        'text-error': !matchesAndHasValidLength,
                                        'text-success': matchesAndHasValidLength,
                                    })}>{'16 to 24 characters'}</li>
                                    <li>
                                        {'At least'}
                                        <ul className="list-[circle] pl-7 space-y-1 mt-1">
                                            <li className={clsx({
                                                'text-error': !matchesAndHasTwoUppercase,
                                                'text-success': matchesAndHasTwoUppercase,
                                            })}>{'2 uppercase letters'}</li>
                                            <li className={clsx({
                                                'text-error': !matchesAndHasTwoLowercase,
                                                'text-success': matchesAndHasTwoLowercase,
                                            })}>{'2 lowercase letters'}</li>
                                            <li className={clsx({
                                                'text-error': !matchesAndHasTwoNumbers,
                                                'text-success': matchesAndHasTwoNumbers,
                                            })}>{'2 numbers'}</li>
                                            <li className={clsx({
                                                'text-error': !matchesAndHasTwoSpecialCharacters,
                                                'text-success': matchesAndHasTwoSpecialCharacters,
                                            })}>{'2 special characters (!@#$%^&*)'}</li>
                                        </ul>
                                    </li>
                                </ul>
                                <p>{'Passwords suggested by Password Managers (eg, 1Password) are ideal - be sure to save the password in your Password Manager as well!'}</p>
                            </div>
                            <div className="sm:flex sm:justify-end">
                                <button
                                    type="submit"
                                    className="btn btn-primary btn-block sm:w-auto"
                                    disabled={processing || !isPasswordValid}
                                >
                                    {processing ? 'Resetting...' : 'Reset Password'}
                                </button>
                            </div>
                        </>
                    )}
                </Form>
            </div>
        </div>
    );
}