import { createContext, useContext, useReducer } from "react";
import { CurrentRMSListValue, CurrentRMSMember } from "@/types";
import { Info, TriangleAlert } from "lucide-react";
import QuarantineOpportunityField from "./QuarantineOpportunityField";
import { quarantineFormInitialState, quarantineFormReducer, QuarantineFormState } from "@/context/QuarantineFormContext";
import QuarantineTechnicalSupervisor from "./QuarantineTechnicalSupervisor";
import QuarantineProductField from "./QuarantineProductField";
import QuarantineOwnerField from "./QuarantineOwnerField";
import QuarantineReferenceField from "./QuarantineReferenceField";

type QuarantineFormContextValue = {
    form: QuarantineFormState;
    opportunityChange: (data: {
        technical_supervisor_id: number;
        label: string;
    }) => void;
};

export const QuarantineFormContext = createContext<QuarantineFormContextValue | null>(null);

export function useQuarantineForm() {
    const context = useContext(QuarantineFormContext);

    if (!context) {
        throw new Error('useQuarantineForm must be used within a QuarantineFormContext.Provider');
    }

    return context;
}

export default function QuarantineForm({ technicalSupervisors, members }: {
    technicalSupervisors: CurrentRMSListValue[];
    members: CurrentRMSMember[]
}) {
    const [ state, dispatch ] = useReducer(quarantineFormReducer, quarantineFormInitialState);

    const opportunityChange = (data: {
        technical_supervisor_id: number;
        label: string;
    }) => {
        dispatch({ type: 'OPPORTUNITY_CHANGE', payload: data });
    }

    const value: QuarantineFormContextValue = {
        form: state,
        opportunityChange,
    };

    return (
        <QuarantineFormContext.Provider value={ value }>
            <div className="card bg-base-100">
                <div className="card-body">
                    <form action="" className="space-y-7">
                        <input type="hidden" name="opportunity" value={ state.opportunity } />
                        <input type="hidden" name="technical_supervisor_id" value={ state.technical_supervisor_id } />
                        <QuarantineOpportunityField />
                        <QuarantineTechnicalSupervisor
                            technicalSupervisors={ technicalSupervisors }
                            currentTechnicalSupervisor={ state.technical_supervisor_id }
                        />
                        <QuarantineProductField />
                        <QuarantineOwnerField members={ members } />
                        <QuarantineReferenceField />
                        <div className="space-y-4">
                            <label className="block font-semibold">{ 'Ready for repairs' }</label>
                            <div className="flex items-start gap-1 mt-2">
                                <Info size={ 16 } className="text-secondary shrink-0" />
                                <p className="text-xs">{ 'Set the date this Product is expected to be in the warehouse, available for Repairs Technicians to work on. If the faulty Product is already in the Warehouse and is about to be placed on Quarantine Intake shelves, leave the date as today\'s.' }</p>
                            </div>
                            <input type="date" name="" id="" className="input" />
                        </div>
                        <div className="space-y-4">
                            <label className="block font-semibold">{ 'Intake location' }</label>
                            <div className="flex items-start gap-1 mt-2">
                                <Info size={ 16 } className="text-secondary shrink-0" />
                                <p className="text-xs ">{ 'Indicate where this Product will be stored in the Quarantine Intake Area.' }</p>
                            </div>
                            <div className="flex flex-col gap-2 sm:flex-row sm:items-center sm:gap-4">
                                <div className="flex items-center gap-1">
                                    <input type="radio" id="on-a-shelf" value="on-a-shelf" />
                                    <label className="cursor-pointer" htmlFor="on-a-shelf">{ 'On a shelf' }</label>
                                </div>
                                <div className="flex items-center gap-1">
                                    <input type="radio" id="in-the-bulky-products-area" value="in-the-bulky-products-area" />
                                    <label className="cursor-pointer" htmlFor="in-the-bulky-products-area">{ 'In the bulky Products area' }</label>
                                </div>
                            </div>
                            <div className="space-y-4">
                                <input type="text" className="input" placeholder={ 'Ex: A-26' } />
                                <div className="flex items-start gap-1">
                                    <TriangleAlert size={ 16 } className="text-warning shrink-0" />
                                    <p className="text-xs">
                                        { 'Specify the Quarantine Intake shelf ID of where this fixture will be placed. Look for a vacant shelf position before entering this information. Tend to use aisles A, B, C, D E and F (in that order) first. Enter one letter for the aisle, and a number for the position on that shelf. A hyphen is added added automatically.' }
                                    </p>
                                </div>
                            </div>
                            <div className="flex items-start gap-1">
                                <TriangleAlert size={ 16 } className="text-warning shrink-0" />
                                <p className="text-xs">
                                    { 'This Product is to be placed in the Quarantine Intake area for bulky Products. Ensure the OOS sticker is facing outwards, and the Product does not cover OOS stickers on other Products in the area, or prevent access to Repairs Nally bins.' }
                                </p>
                            </div>
                            <div className="space-y-4">
                                <label className="block font-semibold">{ 'Primary fault classification' }</label>
                                <div className="flex items-start gap-1 mt-2">
                                    <Info size={ 16 } className="text-secondary shrink-0" />
                                    <p className="text-xs">{ 'Classify the type of primary fault with this Product (that is, if a Product has multiple reasons for submission to Quarantine, which is the most prominent / serious?)' }</p>
                                </div>
                                <select name="" id="" className="select"></select>
                            </div>
                            <div className="space-y-4">
                                <label className="block font-semibold">{ 'Fault description' }</label>
                                <div className="flex items-start gap-1 mt-2">
                                    <Info size={ 16 } className="text-secondary shrink-0" />
                                    <p className="text-xs">{ 'Enter a concise, meaningful and objective fault description.' }</p>
                                </div>
                                <textarea name="" id="" className="textarea"></textarea>
                                <p className="text-xs font-semibold">
                                    <span></span>
                                    { 'character<span>s</span> left' }
                                </p>
                                <div className="space-y-2 text-xs">
                                    <p>{ 'Other considerations' }</p>
                                    <ul>
                                        <li>{ '➡️ Your name will be added to this report automatically, so there\'s no need to add it here.' }</li>
                                        <li>{ '➡️ Mention if the correct Job name could not be assigned, and why' }</li>
                                        <li>{ '➡️ Mention if a serial number collision 💥 was reported, and what you did about it.' }</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div className="flex items-center justify-end gap-2">
                            <button type="button" className="btn btn-primary btn-outline">{ 'Clear form' }</button>
                            <button type="submit" className="btn btn-primary">{ 'Submit' }</button>
                        </div>
                    </form>
                </div>
            </div>
        </QuarantineFormContext.Provider>
    );
}
