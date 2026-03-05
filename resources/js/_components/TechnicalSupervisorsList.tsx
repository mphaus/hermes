import { CurrentRMSListValue } from "@/types";
import TechnicalSupervisorListItem from "./TechnicalSupervisorListItem";

export default function TechnicalSupervisorsList({ technicalSupervisors }: {
    technicalSupervisors: CurrentRMSListValue[];
}) {
    return (
        <ul className="list bg-base-100 rounded-lg shadow-sm max-w-xl mx-auto">
            {technicalSupervisors.map(technicalSupervisor => (
                <TechnicalSupervisorListItem key={technicalSupervisor.id} technicalSupervisor={technicalSupervisor} />
            ))}
        </ul>
    );
}