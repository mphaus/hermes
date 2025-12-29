import { QuarantineOpportunityType } from "@/types";
import { Info } from "lucide-react";
import { useState } from "react";
import OpportunitySearchSelect from "./OpportunitySearchSelect";

export default function QuarantineOpportunityField() {
    const [ opportunityType, setOpportunityType ] = useState<QuarantineOpportunityType>('production-lighting-hire');

    return (
        <div className="space-y-4">
            <p className="font-semibold">{ 'Opportunity' }</p>
            <div className="space-y-3">
                <p>{ 'Specify the Job this Product was identified as faulty on' }</p>
                <div className="flex flex-col gap-2 sm:flex-row sm:items-center sm:gap-4">
                    <div className="flex items-center gap-1">
                        <input
                            type="radio"
                            name="opportunity_type"
                            id="production-lighting-hire"
                            value="production-lighting-hire"
                            defaultChecked
                            onChange={ e => setOpportunityType(e.target.value as QuarantineOpportunityType) }
                        />
                        <label htmlFor="production-lighting-hire" className="cursor-pointer">{ 'Production Lighting Hire Job' }</label>
                    </div>
                    <div className="flex items-center gap-1">
                        <input
                            type="radio"
                            name="opportunity_type"
                            id="dry-hire"
                            value="dry-hire"
                            onChange={ e => setOpportunityType(e.target.value as QuarantineOpportunityType) }
                        />
                        <label htmlFor="dry-hire" className="cursor-pointer">{ 'A Dry Hire Job' }</label>
                    </div>
                    <div className="flex items-center gap-1">
                        <input
                            type="radio"
                            name="opportunity_type"
                            id="not-associated"
                            value="not-associated"
                            onChange={ e => setOpportunityType(e.target.value as QuarantineOpportunityType) }
                        />
                        <label htmlFor="not-associated" className="cursor-pointer">{ 'Not associated with a Job' }</label>
                    </div>
                </div>
            </div>
            { opportunityType === 'production-lighting-hire' && <div className="space-y-4">
                <div className="flex items-center gap-1">
                    <Info size={ 16 } className="text-secondary" />
                    <p className="text-xs">{ 'Enter a few letters from the name of the Job and select from the shortlist.' }</p>
                </div>
                <OpportunitySearchSelect
                    name="opportunity"
                    placeholder={ 'Search Opportunities' }
                    params={ {
                        'per_page': 25,
                        'q[subject_cont]': '?',
                    } }
                />
            </div> }
            { opportunityType === 'dry-hire' && <div className="flex items-center gap-1">
                <Info size={ 16 } className="text-secondary" />
                <p className="text-xs">{ 'Enter the Quote number from the Picking List for this Job (shown at the top of the first page of the Picking List).' }</p>
            </div> }
            { opportunityType === 'not-associated' && <div className="flex items-start gap-1">
                <Info size={ 16 } className="text-secondary" />
                <div className="space-y-2">
                    <p className="text-xs">{ 'Enter the Quote number from the Picking List for this Job (shown at the top of the first page of the Picking List).' }</p>
                    <ul className="pl-5 space-y-1 text-xs list-disc">
                        <li>{ 'The correct Job name cannot be found and allocated' }</li>
                        <li>{ 'This fault was discovered after the Product had been de-prepped' }</li>
                        <li>{ 'This fault was discovered while being Picked for a Job' }</li>
                        <li>{ 'This fault was discovered during Prep (that is, before the equipment was loaded onto a truck)' }</li>
                    </ul>
                </div>
            </div> }
        </div >
    );
}
