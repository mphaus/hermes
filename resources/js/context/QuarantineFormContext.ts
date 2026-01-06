export type QuarantineFormState = {
    technical_supervisor_id: number;
    opportunity: string;
    starts_at: string;
};

export type QuarantineFormAction =
    | { type: 'OPPORTUNITY_CHANGE'; payload: { technical_supervisor_id: number; label: string } }
    | { type: 'READY_FOR_REPAIRS_CHANGE'; payload: { starts_at: string } };

export const quarantineFormInitialState: QuarantineFormState = {
    technical_supervisor_id: 0,
    opportunity: '',
    starts_at: '',
};

export function quarantineFormReducer(state: QuarantineFormState, action: QuarantineFormAction): QuarantineFormState {
    switch (action.type) {
        case 'OPPORTUNITY_CHANGE':
            return {
                ...state,
                technical_supervisor_id: action.payload.technical_supervisor_id,
                opportunity: action.payload.label,
            };
        case 'READY_FOR_REPAIRS_CHANGE':
            return {
                ...state,
                starts_at: action.payload.starts_at,
            }
        default:
            return state;
    }
}
