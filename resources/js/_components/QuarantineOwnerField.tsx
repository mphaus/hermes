import { CurrentRMSMember } from "@/types";
import { Info } from "lucide-react";
import Select from "react-select";

export default function QuarantineOwnerField({ members }: {
    members: CurrentRMSMember[];
}) {
    const formattedMembers = members.map(member => ({
        value: member.id,
        label: member.name,
    }));

    return (
        <div className="shadow-sm card bg-base-100">
            <div className="card-body">
                <div className="space-y-4">
                    <p className="font-semibold">{ 'Owner' }</p>
                    <div className="flex items-start gap-1">
                        <Info size={ 16 } className="text-secondary shrink-0" />
                        <p className="text-xs">{ 'Select the user that will be set as the Quarantine owner.' }</p>
                    </div>
                    <Select
                        isSearchable
                        options={ formattedMembers }
                        name="owner_id"
                        placeholder={ 'Search Owners' }
                    />
                </div>
            </div>
        </div>
    );
}
