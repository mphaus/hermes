import TechnicalSupervisorEditController from "@/actions/App/Http/Controllers/TechnicalSupervisorEditController";
import { CurrentRMSListValue } from "@/types";
import { Link } from "@inertiajs/react";

export default function TechnicalSupervisorListItem({ technicalSupervisor }: {
    technicalSupervisor: CurrentRMSListValue;
}) {
    return (
        <li className="list-row">
            <Link
                href={TechnicalSupervisorEditController(technicalSupervisor.id)}
                title={technicalSupervisor.name}
                className="after:absolute after:inset-0 after:z-1 after:content-['']"
            >
                {technicalSupervisor.name}
            </Link>
        </li>
    );
}