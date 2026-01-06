import { QuarantineSerialNumberStatus } from "@/types";
import { Info, TriangleAlert } from "lucide-react";
import { useState, useRef } from "react";
import { useCharacterLimit } from "@/hooks";
import clsx from "clsx";

export default function QuarantineReferenceField() {
    const MAX = 256;
    const inputRef = useRef<HTMLInputElement>(null);
    const { remaining, isOverLimit, handleLimitChange } = useCharacterLimit(MAX);
    const [ serialNumberStatus, setSerialNumberStatus ] = useState<QuarantineSerialNumberStatus>('serial-number-exists');
    const serialNumberStatusChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        setSerialNumberStatus(e.target.value as QuarantineSerialNumberStatus);
        handleLimitChange("");
    };

    return (
        <div className="shadow-sm card bg-base-100">
            <div className="card-body">
                <div className="space-y-4">
                    <p className="font-semibold">{ 'Reference' }</p>
                    <div className="flex items-start gap-1">
                        <Info size={ 16 } className="text-secondary shrink-0" />
                        <p className="text-xs">{ 'The Product\'s serial number is used to uniquely identify the faulty Product. Do not confuse this with the Product\'s model number. If the serial number has hyphens (-) or slashes (/), enter them as shown on the serial number label.' }</p>
                    </div>
                    <div className="space-y-4">
                        <div className="flex flex-col gap-2 sm:flex-row sm:items-center sm:gap-4">
                            <div className="flex items-center gap-1">
                                <input
                                    type="radio"
                                    id="serial-number-exists"
                                    value="serial-number-exists"
                                    name="serial_number_status"
                                    defaultChecked
                                    onChange={ e => serialNumberStatusChange(e) }
                                />
                                <label className="cursor-pointer" htmlFor="serial-number-exists">{ 'Serial number' }</label>
                            </div>
                            <div className="flex items-center gap-1">
                                <input
                                    type="radio"
                                    id="missing-serial-number"
                                    value="missing-serial-number"
                                    name="serial_number_status"
                                    onChange={ e => serialNumberStatusChange(e) }
                                />
                                <label className="cursor-pointer" htmlFor="missing-serial-number">{ 'Missing serial number' }</label>
                            </div>
                            <div className="flex items-center gap-1">
                                <input
                                    type="radio"
                                    id="not-serialised"
                                    value="not-serialised"
                                    name="serial_number_status"
                                    onChange={ e => serialNumberStatusChange(e) }
                                />
                                <label className="cursor-pointer" htmlFor="not-serialised">{ 'Equipment is not serialised' }</label>
                            </div>
                        </div>
                        { serialNumberStatus === 'serial-number-exists' && (
                            <div className="space-y-2">
                                <input
                                    type="text"
                                    className="input"
                                    placeholder={ 'Serial number' }
                                    name="serial_number"
                                    ref={ inputRef }
                                    onChange={ () => handleLimitChange(inputRef.current?.value ?? "") }
                                />
                                <p className={ clsx({
                                    'text-xs font-semibold': true,
                                    'text-error': isOverLimit,
                                }) }>
                                    { remaining } { remaining === 1 ? 'character' : 'characters' } { 'left' }
                                </p>
                            </div>
                        ) }
                        { serialNumberStatus === 'missing-serial-number' && <div className="flex items-start gap-1">
                            <TriangleAlert size={ 16 } className="text-warning shrink-0" />
                            <p className="text-xs">
                                { 'This option is selected if this equipment normally has a serial number assigned, but it\'s unreadable or has fallen off. Add \'Assign manual serial number\' to the Fault description field (in addition to other faults this equipment has).' }
                            </p>
                        </div> }
                        { serialNumberStatus === 'not-serialised' && <div className="flex items-start gap-1">
                            <TriangleAlert size={ 16 } className="text-warning shrink-0" />
                            <p className="text-xs">
                                { 'This option is selected if this type of equipment is never serialised at all. Notify the Warehouse and SRMM Managers by email about this (as well as registering it here in Quarantine) - they will plan to serialise this type of equipment.' }
                            </p>
                        </div> }
                    </div>
                </div>
            </div>
        </div>
    );
}
