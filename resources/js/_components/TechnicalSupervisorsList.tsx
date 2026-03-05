import { CurrentRMSListValue } from "@/types";

export default function TechnicalSupervisorsList({ technicalSupervisors }: {
    technicalSupervisors: CurrentRMSListValue[];
}) {
    return (
        // <ul className="list bg-base-100 rounded-lg shadow-sm">
        //     {technicalSupervisors.map(technicalSupervisor => (
        //         <li className="list-row" key={technicalSupervisor.id}>
        //             {technicalSupervisor.name}
        //         </li>
        //     ))}
        // </ul>
        <div>{JSON.stringify(technicalSupervisors)}</div>
    );
}