import { Form } from "@inertiajs/react";
import FormGroup from "./FormGroup";
import { Eye } from "lucide-react";
import { SharedData } from "@/types";
import { UserPermission } from "@/types";
import { usePage } from "@inertiajs/react";

export default function UserForm() {
    const permissions = usePage<SharedData>().props.permissions as UserPermission[];

    return (
        <div className="card bg-base-100 shadow-sm mx-auto max-w-3xl">
            <div className="card-body">
                <Form action="#" className="space-y-4">
                    <div className="grid gap-4 md:grid-cols-2">
                        <FormGroup>
                            <label htmlFor="first_name">{'First name'}</label>
                            <input type="text" id="first_name" name="first_name" className="input" autoComplete="given-name" />
                        </FormGroup>
                        <FormGroup>
                            <label htmlFor="last_name">{'Last name'}</label>
                            <input type="text" id="last_name" name="last_name" className="input" autoComplete="family-name" />
                        </FormGroup>
                        <FormGroup>
                            <label htmlFor="username">{'Username'}</label>
                            <input type="text" id="username" name="username" className="input" autoComplete="username" />
                        </FormGroup>
                        <FormGroup>
                            <label htmlFor="email">{'Email'}</label>
                            <input type="email" id="email" name="email" className="input" autoComplete="email" />
                        </FormGroup>
                    </div>
                    <FormGroup>
                        <label htmlFor="password">{'Password'}</label>
                        <button type="button" className="btn btn-primary btn-sm btn-soft">{'Generate Password'}</button>
                        <div className="join flex mt-4">
                            <div className="input join-item">
                                <input type="password" id="password" name="password" autoComplete="off" />
                            </div>
                            <button type="button" className="join-item btn btn-info btn-soft">
                                <Eye size={16} />
                                <span>{'Show'}</span>
                            </button>
                        </div>
                    </FormGroup>
                    <div className="space-y-2">
                        <label htmlFor="is_admin" className="label flex">
                            <input type="checkbox" name="is_admin" id="is_admin" className="checkbox checkbox-sm checkbox-primary" />
                            <span className="font-semibold">{'Is admin'}</span>
                        </label>
                        <p className="text-xs">{'Gives the user full access to all current and future functions of Hermes, including CRUD of users. Typically suitable for executive staff.'}</p>
                    </div>
                    <div className="space-y-2">
                        <label htmlFor="is_enabled" className="label flex">
                            <input type="checkbox" name="is_enabled" id="is_enabled" className="checkbox checkbox-sm checkbox-primary" />
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
                                        <input type="checkbox" name="permissions[]" id={permission.value} value={permission.value} className="checkbox checkbox-sm checkbox-primary" />
                                        <span className="font-semibold!">{permission.label}</span>
                                    </label>
                                    <p className="text-xs">{permission.description}</p>
                                </li>
                            ))}
                        </ul>
                    </div>
                    <div className="sm:flex sm:items-center sm:justify-end">
                        <button type="submit" className="btn btn-primary btn-block sm:w-auto">
                            {'Save user'}
                        </button>
                    </div>
                </Form>
            </div >
        </div >
    );
}
