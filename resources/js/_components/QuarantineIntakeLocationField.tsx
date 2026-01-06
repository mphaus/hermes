import { QuarantineIntakeLocation } from "@/types";
import { Info, TriangleAlert } from "lucide-react";
import { useState } from "react";
import { IMaskInput } from "react-imask";

export default function QuarantineIntakeLocationField() {
    const [ intakeLocation, setintakeLocation ] = useState<QuarantineIntakeLocation>('on-a-shelf');

    return (
        <div className="shadow-sm card bg-base-100">
            <div className="card-body">
                <div className="space-y-4">
                    <p className="font-semibold">{ 'Intake location' }</p>
                    <div className="flex items-start gap-1 mt-2">
                        <Info size={ 16 } className="text-secondary shrink-0" />
                        <p className="text-xs ">{ 'Indicate where this Product will be stored in the Quarantine Intake Area.' }</p>
                    </div>
                    <div className="flex flex-col gap-2 sm:flex-row sm:items-center sm:gap-4">
                        <div className="flex items-center gap-1">
                            <input
                                type="radio"
                                id="on-a-shelf"
                                value="on-a-shelf"
                                name="intake_location_type"
                                defaultChecked
                                onChange={ e => setintakeLocation(e.target.value as QuarantineIntakeLocation) }
                            />
                            <label className="cursor-pointer" htmlFor="on-a-shelf">{ 'On a shelf' }</label>
                        </div>
                        <div className="flex items-center gap-1">
                            <input
                                type="radio"
                                id="in-the-bulky-products-area"
                                value="in-the-bulky-products-area"
                                name="intake_location_type"
                                onChange={ e => setintakeLocation(e.target.value as QuarantineIntakeLocation) }
                            />
                            <label className="cursor-pointer" htmlFor="in-the-bulky-products-area">{ 'In the bulky Products area' }</label>
                        </div>
                    </div>
                    { intakeLocation === 'on-a-shelf' && <div className="space-y-4">
                        <IMaskInput
                            type="text"
                            className="input"
                            placeholder={ 'Ex: A-26' }
                            name="intake_location"
                            mask={ 'a-00' }
                            prepare={ (value: string) => value.toUpperCase() }
                        />
                        <div className="flex items-start gap-1">
                            <TriangleAlert size={ 16 } className="text-warning shrink-0" />
                            <p className="text-xs">
                                { 'Specify the Quarantine Intake shelf ID of where this fixture will be placed. Look for a vacant shelf position before entering this information. Tend to use aisles A, B, C, D E and F (in that order) first. Enter one letter for the aisle, and a number for the position on that shelf. A hyphen is added added automatically.' }
                            </p>
                        </div>
                    </div> }
                    { intakeLocation === 'in-the-bulky-products-area' && <div className="flex items-start gap-1">
                        <TriangleAlert size={ 16 } className="text-warning shrink-0" />
                        <p className="text-xs">
                            { 'This Product is to be placed in the Quarantine Intake area for bulky Products. Ensure the OOS sticker is facing outwards, and the Product does not cover OOS stickers on other Products in the area, or prevent access to Repairs Nally bins.' }
                        </p>
                    </div> }
                </div>
            </div>
        </div>
    );
}
