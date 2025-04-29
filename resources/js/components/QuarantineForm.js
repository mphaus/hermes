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

const initialSerialNumber = {
    checking: false,
    checked: false,
    exists: false,
};

export default function QuarantineForm () {
    const currentDate = this.$root.dataset.currentDate;
    const technicalSupervisorNotYetAssignedId = Number( this.$root.dataset.technicalSupervisorNotYetAssignedId );

    return {
        errorMessage: '',
        submitting: false,
        form: { ...initialForm },
        errors: { ...initialForm },
        technicalSupervisorName: '',
        serialNumberRemainingCharacters: 256,
        descriptionRemainingCharacters: 512,
        serialNumber: { ...initialSerialNumber },
        init () {
            this.form.starts_at = currentDate;
        },
        async send () {
            if ( this.submitting ) {
                return;
            }

            this.serialNumber.errorMessage = '';
            this.errorMessage = '';
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

                const { message } = error.response.data;
                this.errorMessage = message;

                console.error( error );
            } finally {
                this.submitting = false;
            }
        },
        clear () {
            this.form = {
                ...initialForm,
                starts_at: currentDate,
            };
            this.errors = { ...initialForm };
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

            if ( technical_supervisor_id === technicalSupervisorNotYetAssignedId ) {
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
        },
        get validated () {
            return {
                opportunity:
                    this.form.opportunity_type !== 'not-associated'
                    && this.form.opportunity !== ''
                    && this.errors.opportunity === '',
                serial_number:
                    this.form.serial_number !== ''
                    && this.serialNumber.checked
                    && this.serialNumber.exists === false
                    && this.errors.serial_number === '',
                product_id:
                    this.form.product_id !== ''
                    && this.errors.product_id === '',
                starts_at:
                    this.form.starts_at !== ''
                    && this.errors.starts_at === '',
                intake_location:
                    this.form.starts_at === currentDate
                    && this.form.intake_location_type === 'on-a-shelf'
                    && /^[A-Ia-i]-(?:[1-9]|[1-4][0-9]|5[0-5])$/.test( this.form.intake_location )
                    && this.errors.intake_location === '',
                classification:
                    this.form.classification !== ''
                    && this.errors.classification === '',
                description:
                    this.form.description !== ''
                    && this.form.description.length <= 512
                    && this.errors.description === '',
            };
        },
        async checkSerialNumber () {
            this.serialNumber.checking = true;
            this.serialNumber.checked = false;
            this.serialNumber.exists = false;
            this.errors.serial_number = '';

            try {
                await window.axios.post( route( 'quarantine.check-serial-number' ), {
                    serial_number: this.form.serial_number,
                } );

                this.serialNumber.checked = true;
            }
            catch ( error ) {
                if ( error.status === 422 ) {
                    this.serialNumber.exists = true;
                }

                this.serialNumber.checked = true;

                const { message } = error.response.data;
                this.errors.serial_number = message;

                console.error( error );
            } finally {
                this.serialNumber.checking = false;
            }
        },
        handleSerialNumberStatusChange () {
            this.form.serial_number = '';
            this.errors.serial_number = '';
            this.serialNumber = { ...initialSerialNumber };
            this.serialNumberRemainingCharacters = 256;
        },
    };
}
