const intialForm = {
    submitted: '',
    quarantine_id: '',
    job: '',
    product: '',
    serial: '',
    ready_for_repairs: '',
    primary_fault_classification: '',
    fault_description: '',
    intake_location: '',
    message: '',
};

export default function QuarantineReportMistakeForm () {
    return {
        message: '',
        submitting: false,
        remainingCharacters: 512,
        form: { ...intialForm },
        errors: { ...intialForm },
        async send () {
            if ( this.submitting ) {
                return;
            }

            this.message = '';
            this.errors = { ...intialForm };
            this.submitting = true;

            try {
                const response = await window.axios.post( route( 'quarantine.report-mistake.store' ), this.form );

                /** @type {{ message: string }} */
                const { message } = response.data;
                this.message = message;

                this.form.message = '';
                this.$root.reset();
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
    };
}
