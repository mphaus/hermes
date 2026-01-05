export type QuarantineFormState = {
    technical_supervisor_id: number;
    opportunity: string;
};

export type QuarantineFormAction = {
    type: string;
    payload: {
        technical_supervisor_id: number;
        label: string;
    };
}

export const quarantineFormInitialState: QuarantineFormState = {
    technical_supervisor_id: 0,
    opportunity: '',
};

export function quarantineFormReducer(state: QuarantineFormState, action: QuarantineFormAction): QuarantineFormState {
    switch (action.type) {
        case 'OPPORTUNITY_CHANGE':
            return {
                ...state,
                technical_supervisor_id: action.payload.technical_supervisor_id,
                opportunity: action.payload.label,
            };
        default:
            return state;
    }
}
