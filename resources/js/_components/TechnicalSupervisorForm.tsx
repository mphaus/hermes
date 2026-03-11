import { Form } from "@inertiajs/react";
import FormGroup from "./FormGroup";
import FormError from "./FormError";
import TechnicalSupervisorStoreController from "@/actions/App/Http/Controllers/TechnicalSupervisorStoreController";
import TechnicalSupervisorUpdateController from "@/actions/App/Http/Controllers/TechnicalSupervisorUpdateController";

export default function TechnicalSupervisorForm({ technicalSupervisor }: {
    technicalSupervisor: {
        id: number;
        first_name: string;
        last_name: string;
    } | undefined;
}) {
    return (
        <div className="card bg-base-100 shadow-sm mx-auto max-w-2xl">
            <div className="card-body gap-4">
                <h2 className="card-title">{'Technical Supervisor'}</h2>
                <Form
                    action={technicalSupervisor ? TechnicalSupervisorUpdateController(technicalSupervisor.id) : TechnicalSupervisorStoreController()}
                    className="space-y-4"
                >
                    {({
                        errors,
                        processing
                    }) => (
                        <>
                            <div className="grid gap-4 md:grid-cols-2">
                                <FormGroup>
                                    <label htmlFor="first_name">{'First name'}</label>
                                    <input
                                        type="text"
                                        id="first_name"
                                        name="first_name"
                                        className="input"
                                        defaultValue={technicalSupervisor?.first_name ?? ""}
                                    />
                                    {errors.first_name && <FormError message={errors.first_name} />}
                                </FormGroup>
                                <FormGroup>
                                    <label htmlFor="last_name">{'Last name'}</label>
                                    <input
                                        type="text"
                                        id="last_name"
                                        name="last_name"
                                        className="input"
                                        defaultValue={technicalSupervisor?.last_name ?? ""}
                                    />
                                    {errors.last_name && <FormError message={errors.last_name} />}
                                </FormGroup>
                            </div>
                            <div className="sm:flex sm:items-center sm:justify-end">
                                <button
                                    type="submit"
                                    className="btn btn-primary btn-block sm:w-auto"
                                    disabled={processing}
                                >
                                    {processing ? 'Saving...' : 'Save'}
                                </button>
                            </div>
                            {errors.message && (
                                <div role="alert" className="alert alert-error mt-6">
                                    {errors.message}
                                </div>
                            )}
                        </>
                    )}
                </Form>
            </div>
        </div>
    );
}