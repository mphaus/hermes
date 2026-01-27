import { Form } from "@inertiajs/react";
import FormGroup from "./FormGroup";
import { SharedData } from "@/types";
import { UserPermission } from "@/types";
import { usePage } from "@inertiajs/react";
import UserPasswordField from "./UserPasswordField";
import { useRef } from "react";
import UserStoreController from "@/actions/App/Http/Controllers/UserStoreController";
import { normalizeString } from "@/utils";
import FormError from "./FormError";

export default function UserForm() {
    const permissions = usePage<SharedData>().props.permissions as UserPermission[];
    const isAdminRef = useRef<HTMLInputElement>(null);
    const permissionRefs = useRef<Map<string, HTMLInputElement>>(new Map());
    const firstNameRef = useRef<HTMLInputElement>(null);
    const lastNameRef = useRef<HTMLInputElement>(null);
    const usernameRef = useRef<HTMLInputElement>(null);

    const syncUsername = () => {
        const first = firstNameRef.current?.value ?? "";
        const last = lastNameRef.current?.value ?? "";
        const username = normalizeString(first, last);
        if (usernameRef.current) {
            usernameRef.current.value = username;
        }
    };

    const handleIsAdminChange = () => {
        const isAdminChecked = isAdminRef.current?.checked ?? false;
        permissionRefs.current.forEach((ref) => {
            if (ref) {
                ref.checked = isAdminChecked;
            }
        });
    };

    const handlePermissionChange = () => {
        const allChecked = Array.from(permissionRefs.current.values()).every(
            (ref) => ref?.checked ?? false
        );
        if (isAdminRef.current) {
            isAdminRef.current.checked = allChecked;
        }
    };

    const setPermissionRef = (permissionValue: string) => (ref: HTMLInputElement | null) => {
        if (ref) {
            permissionRefs.current.set(permissionValue, ref);
        } else {
            permissionRefs.current.delete(permissionValue);
        }
    };

    return (
        <div className="card bg-base-100 shadow-sm mx-auto max-w-3xl">
            <div className="card-body">
                <Form
                    action={UserStoreController()}
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
                            <div className="grid gap-4 md:grid-cols-2">
                                <FormGroup>
                                    <label htmlFor="first_name">{'First name'}</label>
                                    <input
                                        type="text"
                                        id="first_name"
                                        name="first_name"
                                        ref={firstNameRef}
                                        onInput={syncUsername}
                                        className="input"
                                        autoComplete="given-name"
                                    />
                                    {errors.first_name && <FormError message={errors.first_name} />}
                                </FormGroup>
                                <FormGroup>
                                    <label htmlFor="last_name">{'Last name'}</label>
                                    <input
                                        type="text"
                                        id="last_name"
                                        name="last_name"
                                        ref={lastNameRef}
                                        onInput={syncUsername}
                                        className="input"
                                        autoComplete="family-name"
                                    />
                                    {errors.last_name && <FormError message={errors.last_name} />}
                                </FormGroup>
                                <FormGroup>
                                    <label htmlFor="username">{'Username'}</label>
                                    <input
                                        type="text"
                                        id="username"
                                        name="username"
                                        ref={usernameRef}
                                        className="input"
                                        autoComplete="username"
                                    />
                                    {errors.username && <FormError message={errors.username} />}
                                </FormGroup>
                                <FormGroup>
                                    <label htmlFor="email">{'Email'}</label>
                                    <input type="email" id="email" name="email" className="input" autoComplete="email" />
                                    {errors.email && <FormError message={errors.email} />}
                                </FormGroup>
                            </div>
                            <UserPasswordField error={errors.password} />
                            <div className="space-y-2">
                                <label htmlFor="is_admin" className="label flex">
                                    <input
                                        type="checkbox"
                                        name="is_admin"
                                        id="is_admin"
                                        value={'1'}
                                        ref={isAdminRef}
                                        onChange={handleIsAdminChange}
                                        className="checkbox checkbox-sm checkbox-primary"
                                    />
                                    <span className="font-semibold">{'Is admin'}</span>
                                </label>
                                <p className="text-xs">{'Gives the user full access to all current and future functions of Hermes, including CRUD of users. Typically suitable for executive staff.'}</p>
                            </div>
                            <div className="space-y-2">
                                <label htmlFor="is_enabled" className="label flex">
                                    <input
                                        type="checkbox"
                                        name="is_enabled"
                                        id="is_enabled"
                                        value={'1'}
                                        className="checkbox checkbox-sm checkbox-primary"
                                        defaultChecked
                                    />
                                    <span className="font-semibold">{'Is enabled'}</span>
                                </label>
                                <p className="text-xs">{'Allows this user to log in when checked.'}</p>
                            </div>
                            <div className="mt-8">
                                <p className="font-semibold">{'User permissions'}</p>
                                <p className="mt-2 text-xs">
                                    <span>{'See the '}</span>
                                    <a href="https://mphaustralia.sharepoint.com/:w:/r/teams/MPHAdministration/_layouts/15/Doc.aspx?sourcedoc=%7B9d7fb799-bfce-4bd7-964a-9dbceff1b470%7D&action=editnew" target="_blank" rel="nofollow">{'Hermes Guide'}</a>
                                    <span>{' for more info on Hermes permissions.'}</span>
                                </p>
                                <ul className="space-y-8 mt-4">
                                    {permissions.map((permission) => (
                                        <li key={permission.value} className="space-y-2">
                                            <label htmlFor={permission.value} className="label flex">
                                                <input
                                                    type="checkbox"
                                                    name="permissions[]"
                                                    id={permission.value}
                                                    value={permission.value}
                                                    ref={setPermissionRef(permission.value)}
                                                    onChange={handlePermissionChange}
                                                    className="checkbox checkbox-sm checkbox-primary"
                                                />
                                                <span className="font-semibold!">{permission.label}</span>
                                            </label>
                                            <p className="text-xs">{permission.description}</p>
                                        </li>
                                    ))}
                                </ul>
                                {errors.permissions && <div className="mt-3">
                                    <FormError message={errors.permissions} />
                                </div>}
                            </div>
                            <div className="sm:flex sm:items-center sm:justify-end">
                                <button type="submit" className="btn btn-primary btn-block sm:w-auto" disabled={processing}>
                                    {processing ? 'Saving...' : 'Save user'}
                                </button>
                            </div>
                        </>
                    )}
                </Form>
            </div >
        </div >
    );
}
