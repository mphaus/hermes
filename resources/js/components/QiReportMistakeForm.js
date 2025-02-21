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

export default function QiReportMistakeForm () {
    return {
        submitting: false,
        remainingCharacters: 512,
        form: { ...intialForm },
        errors: { ...intialForm },
        async send () {
            if ( this.submitting ) {
                return;
            }

            this.errors = { ...intialForm };
            this.submitting = true;

            try {
                const response = await window.axios.post( this.$root.action, this.form );
                console.log( response.data );
            } catch ( error ) {
                if ( error.status === 422 ) {
                    const { errors } = error.response.data;

                    for ( const key in errors ) {
                        this.errors[ key ] = errors[ key ][ 0 ];
                    }

                    return;
                }

                console.log( error );
            } finally {
                this.submitting = false;
            }
        },
    };
}
