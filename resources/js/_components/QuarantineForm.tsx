import { createContext, useContext, useEffect, useReducer } from "react";
import { CurrentRMSListValue, CurrentRMSMember, SharedData } from "@/types";
import { quarantineFormInitialState, quarantineFormReducer, QuarantineFormState } from "@/context/QuarantineFormContext";
import { Form, usePage } from "@inertiajs/react";
import QuarantineOpportunityField from "./QuarantineOpportunityField";
import QuarantineTechnicalSupervisor from "./QuarantineTechnicalSupervisor";
import QuarantineProductField from "./QuarantineProductField";
import QuarantineOwnerField from "./QuarantineOwnerField";
import QuarantineReferenceField from "./QuarantineReferenceField";
import QuarantineReadyForRepairsField from "./QuarantineReadyForRepairsField";
import QuarantineIntakeLocationField from "./QuarantineIntakeLocationField";
import QuarantinePrimaryFaultClassificationField from "./QuarantinePrimaryFaultClassificationField";
import QuarantineFaultDescriptionField from "./QuarantineFaultDescriptionField";
import StoreQuarantineController from "@/actions/App/Http/Controllers/StoreQuarantineController";

type QuarantineFormContextValue = {
    form: QuarantineFormState;
    opportunityChange: (data: {
        technical_supervisor_id: number;
        label: string;
    }) => void;
    readyForRepairsChange: (starts_at: string) => void;
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
    const { min_date } = usePage<SharedData>().props;
    const [ state, dispatch ] = useReducer(quarantineFormReducer, quarantineFormInitialState);

    const opportunityChange = (data: {
        technical_supervisor_id: number;
        label: string;
    }) => {
        dispatch({ type: 'OPPORTUNITY_CHANGE', payload: { ...data } });
    }

    const readyForRepairsChange = (starts_at: string) => {
        dispatch({ type: 'READY_FOR_REPAIRS_CHANGE', payload: { starts_at } });
    }

    const value: QuarantineFormContextValue = {
        form: state,
        opportunityChange,
        readyForRepairsChange,
    };

    useEffect(() => readyForRepairsChange(min_date as string), []);

    return (
        <QuarantineFormContext.Provider value={ value }>
            <Form
                action={ StoreQuarantineController() }
                method="post"
                className="space-y-7"
                validationTimeout={ 1000 }
                transform={ data => ({
                    ...data,
                    serial_number: data.serial_number ?? "",
                    intake_location: data.intake_location ?? "",
                }) }
            >
                { ({
                    errors,
                    processing,
                    validate,
                }) => (
                    <>
                        <input type="hidden" name="opportunity" value={ state.opportunity } />
                        <input type="hidden" name="technical_supervisor_id" value={ state.technical_supervisor_id } />
                        <QuarantineOpportunityField error={ errors.opportunity } />
                        <QuarantineTechnicalSupervisor
                            technicalSupervisors={ technicalSupervisors }
                            currentTechnicalSupervisor={ state.technical_supervisor_id }
                        />
                        <QuarantineProductField error={ errors.product_id } />
                        <QuarantineOwnerField
                            members={ members }
                            error={ errors.owner_id }
                        />
                        <QuarantineReferenceField
                            validate={ validate }
                            error={ errors.serial_number }
                        />
                        <QuarantineReadyForRepairsField error={ errors.starts_at } />
                        { min_date === state.starts_at && <QuarantineIntakeLocationField error={ errors.intake_location } /> }
                        <QuarantinePrimaryFaultClassificationField error={ errors.classification } />
                        <QuarantineFaultDescriptionField error={ errors.description } />
                        <div className="flex items-center justify-end gap-2">
                            <button
                                type="button"
                                className="btn btn-primary btn-outline"
                                disabled={ processing }
                            >{ 'Clear form' }</button>
                            <button
                                type="submit"
                                className="btn btn-primary"
                                disabled={ processing }
                            >
                                { processing ? 'Submitting...' : 'Submit' }
                            </button>
                        </div>
                    </>
                ) }
            </Form>
        </QuarantineFormContext.Provider>
    );
}
