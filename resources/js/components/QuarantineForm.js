const initialForm = {
    opportunity_type: 'production-lighting-hire',
    opportunity: '',
    technical_supervisor_id: '',
    serial_number_status: 'serial-number-exists',
    serial_number: '',
    product_id: '',
    starts_at: '',
    intake_location_type: 'on-a-shelf',
    intake_location: '',
    classification: '',
    description: '',
};

export default function QuarantineForm () {
    return {
        _technicalSupervisorNotYetAssignedId: 0,
        submitting: false,
        form: { ...initialForm },
        errors: { ...initialForm },
        validated: {},
        technicalSupervisorName: '',
        serialNumberRemainingCharacters: 256,
        descriptionRemainingCharacters: 512,
        init () {
            this.form.starts_at = this.$root.dataset.currentDate;
            this._technicalSupervisorNotYetAssignedId = Number( this.$root.dataset.technicalSupervisorNotYetAssignedId );
        },
        async send () {
            if ( this.submitting ) {
                return;
            }

            this.errors = { ...initialForm };
            this.submitting = true;

            try {
                const response = await window.axios.post( route( 'quarantine.store' ), this.form );

                const { redirect_to } = response.data;
                window.location = redirect_to;
            } catch ( error ) {
                if ( error.status === 422 ) {
                    const { errors } = error.response.data;

                    for ( const key in errors ) {
                        this.errors[ key ] = errors[ key ][ 0 ];
                    }

                    return;
                }

                console.error( error );
            } finally {
                this.submitting = false;
            }
        },
        clear () {
            this.form = {
                ...initialForm,
                starts_at: this.$root.dataset.currentDate,
            };
            this.errors = { ...initialForm };
            this.validated = {};
            this.$root.reset();
            this.technicalSupervisorName = '';
            this.serialNumberRemainingCharacters = 256;
            this.descriptionRemainingCharacters = 512;
        },
        handleSelectOpportunityChange ( e ) {
            const data = e.detail;

            if ( data === undefined ) {
                return;
            }

            /** @type {{ technical_supervisor_id: Number }} */
            const { technical_supervisor_id } = data;

            if ( technical_supervisor_id === this._technicalSupervisorNotYetAssignedId ) {
                this.form.technical_supervisor_id = technical_supervisor_id;
                this.technicalSupervisorName = 'Not yet assigned';
                return;
            }

            const technicalSupervisor = this.technicalSupervisors.find( ts => ts.id === technical_supervisor_id );

            if ( technicalSupervisor === undefined ) {
                return;
            }

            this.form.technical_supervisor_id = technicalSupervisor.id;
            this.technicalSupervisorName = technicalSupervisor.name;
        },
        handleOpportunityTypeChange () {
            this.form.opportunity = '';
            this.form.technical_supervisor_id = '';
            this.technicalSupervisorName = '';
        }
    };
}
