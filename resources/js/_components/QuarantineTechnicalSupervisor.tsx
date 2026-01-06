import { CurrentRMSListValue } from "@/types";
import { Info } from "lucide-react";
import { useEffect, useState } from "react";

export default function QuarantineTechnicalSupervisor({ technicalSupervisors, currentTechnicalSupervisor }: {
    technicalSupervisors: CurrentRMSListValue[];
    currentTechnicalSupervisor: number;
}) {
    const [ technicalSupevisorName, setTechnicalSupevisorName ] = useState<string>('');

    useEffect(() => {
        const technicalSupervisor: CurrentRMSListValue | undefined = technicalSupervisors.find(ts => ts.id === currentTechnicalSupervisor);

        if (!technicalSupervisor) {
            return;
        }

        setTechnicalSupevisorName(technicalSupervisor.name);
    }, [ currentTechnicalSupervisor ]);

    if (currentTechnicalSupervisor < 1) {
        return null;
    }

    return (
        <div className="shadow-sm card bg-base-100">
            <div className="card-body">
                <div className="space-y-4">
                    <p className="block font-semibold">{ 'Technical Supervisor' }</p>
                    <div className="flex items-start gap-1 mt-2">
                        <Info size={ 16 } className="text-secondary" />
                        <p className="text-xs">{ 'The Technical Supervisor is specified in Opportunity in CurrentRMS and cannot be edited here.' }</p>
                    </div>
                    <p>{ technicalSupevisorName }</p>
                </div>
            </div>
        </div>
    );
}
