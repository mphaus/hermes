import { CurrentRMSMember } from "@/types";
import Select from "react-select";

export default function QuarantineOwnerField({ members }: {
    members: CurrentRMSMember[];
}) {
    const formattedMembers = members.map(member => ({
        value: member.id,
        label: member.name,
    }));

    return (
        <div className="space-y-4">
            <p className="font-semibold">{ 'Owner' }</p>
            <Select
                isSearchable
                options={ formattedMembers }
                name="owner_id"
                placeholder={ 'Search Owners' }
            />
        </div>
    );
}
