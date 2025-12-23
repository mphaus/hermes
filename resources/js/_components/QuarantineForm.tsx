import { Info, TriangleAlert } from "lucide-react";

export default function QuarantineForm() {
    return (
        <form action="" className="space-y-7">
            <div className="space-y-4">
                <div className="space-y-3">
                    <p className="font-semibold">{ 'Specify the Job this Product was identified as faulty on' }</p>
                    <div className="flex flex-col gap-2 sm:flex-row sm:items-center sm:gap-4">
                        <div className="flex items-center gap-1">
                            <input type="radio" name="opportunity_type" id="production-lighting-hire" />
                            <label htmlFor="production-lighting-hire" className="cursor-pointer">{ 'Production Lighting Hire Job' }</label>
                        </div>
                        <div className="flex items-center gap-1">
                            <input type="radio" name="opportunity_type" id="dry-hire" />
                            <label htmlFor="dry-hire" className="cursor-pointer">{ 'A Dry Hire Job' }</label>
                        </div>
                        <div className="flex items-center gap-1">
                            <input type="radio" name="opportunity_type" id="not-associated" />
                            <label htmlFor="not-associated" className="cursor-pointer">{ 'Not associated with a Job' }</label>
                        </div>
                    </div>
                </div>
                <div className="flex items-center gap-1">
                    <Info size={ 16 } className="text-secondary" />
                    <p className="text-xs">{ 'Enter a few letters from the name of the Job and select from the shortlist.' }</p>
                </div>
                <div className="flex items-center gap-1">
                    <Info size={ 16 } className="text-secondary" />
                    <p className="text-xs">{ 'Enter the Quote number from the Picking List for this Job (shown at the top of the first page of the Picking List).' }</p>
                </div>
                <div className="flex items-start gap-1">
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
                </div>
                <select name="" id="" className="select appearance-none">
                    <option value="">{ '-- Select --' }</option>
                </select>
            </div>
            <div className="space-y-4">
                <label htmlFor="">{ 'Product' }</label>
                <div className="flex items-start gap-1">
                    <Info size={ 16 } className="text-secondary shrink-0" />
                    <p className="text-xs">{ 'Type the first few letters of the Product and pause to let the system get info from CurrentRMS. Select the exact-match Product. If the Product cannot be found in this listing, double-check the spelling of the Product name (per the info plate on the equipment), then ask the SRMM Manager for advice on how to proceed.' }</p>
                </div>
                <select name="" id="" className="select appearance-none">
                    <option value="">{ '-- Select --' }</option>
                </select>
            </div>
            <div className="space-y-4">
                <label htmlFor="">{ 'Owned by' }</label>
                <select name="" id="" className="select appearance-none">
                    <option value="">{ '-- Select --' }</option>
                </select>
            </div>
            <div className="space-y-4">
                <label htmlFor="">{ 'Reference' }</label>
                <div className="flex items-start gap-1">
                    <Info size={ 16 } className="text-secondary shrink-0" />
                    <p className="text-xs">{ 'The Product\'s serial number is used to uniquely identify the faulty Product. Do not confuse this with the Product\'s model number. If the serial number has hyphens (-) or slashes (/), enter them as shown on the serial number label.' }</p>
                </div>
                <div className="space-y-4">
                    <div className="flex flex-col gap-2 sm:flex-row sm:items-center sm:gap-4">
                        <div className="flex items-center gap-1">
                            <input type="radio" id="serial-number-exists" value="serial-number-exists" />
                            <label className="cursor-pointer" htmlFor="serial-number-exists">{ 'Serial number' }</label>
                        </div>
                        <div className="flex items-center gap-1">
                            <input type="radio" id="missing-serial-number" value="missing-serial-number" />
                            <label className="cursor-pointer" htmlFor="missing-serial-number">{ 'Missing serial number' }</label>
                        </div>
                        <div className="flex items-center gap-1">
                            <input type="radio" id="not-serialised" value="not-serialised" />
                            <label className="cursor-pointer" htmlFor="not-serialised">{ 'Equipment is not serialised' }</label>
                        </div>
                    </div>
                    <div className="space-y-2">
                        <input
                            type="text"
                            className="input"
                            placeholder={ 'Serial number' }
                        />
                        <p className="text-xs font-semibold">
                            <span></span>
                        </p>
                        { 'character<span >s</span> left' }
                    </div>
                    <div className="flex items-start gap-1">
                        <TriangleAlert size={ 16 } className="text-warning shrink-0" />
                        <p className="text-xs">
                            { 'This option is selected if this equipment normally has a serial number assigned, but it\'s unreadable or has fallen off. Add \'Assign manual serial number\' to the Fault description field (in addition to other faults this equipment has).' }
                        </p>
                    </div>
                    <div className="flex items-start gap-1">
                        <TriangleAlert size={ 16 } className="text-warning shrink-0" />
                        <p className="text-xs">
                            { 'This option is selected if this type of equipment is never serialised at all. Notify the Warehouse and SRMM Managers by email about this (as well as registering it here in Quarantine) - they will plan to serialise this type of equipment.' }
                        </p>
                    </div>
                </div>
            </div>
        </form>
    );
}
