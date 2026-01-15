import { SharedData } from "@/types";
import { Head, Link, usePage } from "@inertiajs/react";
import QuarantineCreateController from "@/actions/App/Http/Controllers/QuarantineCreateController";

interface Quarantine {
    id: number;
    name: string;
    reference: string;
    description: string;
    created_at: string;
    ready_for_repairs: string;
    primary_fault_classification: string;
    custom_fields: {
        intake_location: string;
        opportunity: string;
    };
}

export default function QuarantineSuccess() {
    const { auth: { user }, title } = usePage<SharedData>().props;
    const quarantine = usePage<SharedData>().props.quarantine as Quarantine;

    return (
        <>
            <Head title={title} />
            <div className="mx-auto xl:grid xl:gap-4 xl:grid-cols-7 max-w-(--breakpoint-2xl)">
                <div className="space-y-4 xl:col-span-5">
                    <div className="card bg-base-100 shadow-sm">
                        <div className="card-body">
                            <p>
                                Your quarantine submission has been received and is logged in CurrentRMS - see{' '}
                                <a
                                    href={`https://mphaustralia.current-rms.com/quarantines/${quarantine?.id}`}
                                    target="_blank"
                                    rel="nofollow"
                                >
                                    submission {quarantine?.id}
                                </a>. This link will only work for full-time MPH employees logged in to CurrentRMS. It's also possible for Casuals to access this from the Quarantine Intake Station in the warehouse.
                            </p>
                        </div>
                    </div>
                    {quarantine?.custom_fields.intake_location !== 'NtYtAvail' && (
                        <div className="card shadow-sm space-y-4 bg-accent text-accent-content xl:hidden text-center">
                            <div className="card-body">
                                <h2 className="text-3xl font-semibold 2xl:text-4xl">Intake Location</h2>
                                <p className={
                                    quarantine?.custom_fields.intake_location !== 'Bulky Products area'
                                        ? 'font-bold text-7xl 2xl:text-9xl'
                                        : 'font-bold text-3xl sm:text-4xl'
                                }>
                                    {quarantine?.custom_fields.intake_location}
                                </p>
                                <p className="text-sm sm:text-lg">Place the Product here right away!</p>
                            </div>
                        </div>
                    )}
                    <div className="card bg-base-100 shadow-sm">
                        <div className="card-body">
                            <p className="font-semibold">Submitted Quarantine Product details</p>
                            <ul className="space-y-3 md:pl-4">
                                <li className="flex flex-col">
                                    <span className="font-semibold">Submitter:</span>
                                    <span>{user?.first_name}</span>
                                </li>
                                <li className="flex flex-col">
                                    <span className="font-semibold">Submitted:</span>
                                    <time dateTime={new Date(quarantine?.created_at || '').toISOString()}>
                                        {new Date(quarantine?.created_at || '').toLocaleString('en-AU', {
                                            day: '2-digit',
                                            month: 'short',
                                            year: 'numeric',
                                            hour: '2-digit',
                                            minute: '2-digit',
                                            hour12: false
                                        })}
                                    </time>
                                </li>
                                <li className="flex flex-col">
                                    <span className="font-semibold">CurrentRMS Quarantine ID:</span>
                                    <span>{quarantine?.id}</span>
                                </li>
                                <li className="flex flex-col">
                                    <span className="font-semibold">Job:</span>
                                    <span>{quarantine?.custom_fields.opportunity}</span>
                                </li>
                                <li className="flex flex-col">
                                    <span className="font-semibold">Product:</span>
                                    <span>{quarantine?.name}</span>
                                </li>
                                <li className="flex flex-col">
                                    <span className="font-semibold">Serial:</span>
                                    <span>{quarantine?.reference}</span>
                                </li>
                                <li className="flex flex-col">
                                    <span className="font-semibold">Ready for repairs:</span>
                                    {quarantine?.ready_for_repairs === 'Now' ? (
                                        <span>{quarantine?.ready_for_repairs}</span>
                                    ) : (
                                        <time dateTime={new Date(quarantine?.ready_for_repairs || '').toISOString()}>
                                            {new Date(quarantine?.ready_for_repairs || '').toLocaleString('en-AU', {
                                                day: '2-digit',
                                                month: 'short',
                                                year: 'numeric',
                                                hour: '2-digit',
                                                minute: '2-digit',
                                                hour12: false
                                            })}
                                        </time>
                                    )}
                                </li>
                                <li className="flex flex-col">
                                    <span className="font-semibold">Primary fault classification:</span>
                                    <span>{quarantine?.primary_fault_classification}</span>
                                </li>
                                <li className="flex flex-col gap-2">
                                    <span className="font-semibold">Fault description:</span>
                                    <div style={{ whiteSpace: 'pre-wrap' }}>{quarantine?.description}</div>
                                </li>
                            </ul>
                            <Link
                                href={QuarantineCreateController().url}
                                className="btn btn-primary mt-8"
                                title={'Create a new Quarantine'}
                            >
                                {'Create a new Quarantine'}
                            </Link>
                        </div>
                    </div>
                </div>
                {quarantine?.custom_fields.intake_location !== 'NtYtAvail' && (
                    <div className="card bg-accent text-accent-content hidden xl:block xl:col-span-2 xl:self-start text-center">
                        <div className="card-body">
                            <h2 className="text-3xl 2xl:text-4xl">Intake Location</h2>
                            <p className={
                                quarantine?.custom_fields.intake_location !== 'Bulky Products area'
                                    ? 'font-bold text-7xl 2xl:text-9xl'
                                    : 'font-bold text-3xl 2xl:text-4xl'
                            }>
                                {quarantine?.custom_fields.intake_location}
                            </p>
                            <p className="2xl:text-lg">Place the Product here right away!</p>
                        </div>
                    </div>
                )}
            </div>
        </>
    );
}
