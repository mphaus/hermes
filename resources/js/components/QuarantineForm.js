const initialForm = {
    opportunity_type: 'production-lighting-hire',
    opportunity: '',
    technical_supervisor: '',
    serial_number_status: 'serial-number-exists',
    serial_number: '',
    product_id: 0,
    starts_at: '',
    intake_location_type: 'on-a-shelf',
    intake_location: '',
    classification: '',
    description: '',
};

export default function QuarantineForm () {
    return {
        submitting: false,
        form: { ...initialForm },
        errors: { ...initialForm },
        validated: {},
        technicalSupervisorName: '',
        serialNumberRemainingCharacters: 256,
        descriptionRemainingCharacters: 512,
        init () {
            this.form.starts_at = this.$root.dataset.currentDate;
        },
        async send () {
            console.log( this.form );
        },
        clear () {
            this.form = {
                ...initialForm,
                starts_at: this.$root.dataset.currentDate,
            };
            this.errors = { ...initialForm };
            this.validated = {};
            this.$root.reset();
        },
    };
}
