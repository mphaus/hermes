import { Form } from "@inertiajs/react";
import FormGroup from "./FormGroup";
import { Eye } from "lucide-react";

export default function UserForm() {
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
                </Form>
            </div >
        </div >
    );
}
