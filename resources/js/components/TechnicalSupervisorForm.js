const initialForm = {
    first_name: '',
    last_name: '',
};

export default function TechnicalSupervisorForm () {
    return {
        technicalSupervisorId: 0,
        message: '',
        submitting: false,
        form: { ...initialForm },
        errors: { ...initialForm },
        async send () {
            if ( this.submitting ) {
                return;
            }

            this.message = '';
            this.errors = { ...initialForm };
            this.submitting = true;

            try {
                const response = this.technicalSupervisorId > 0
                    ? await window.axios.put( route( 'technical-supervisors.update', this.technicalSupervisorId ), this.form )
                    : await window.axios.post( route( 'technical-supervisors.store' ), this.form );

                /** @type {{ redirect_to: string }} */
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

                /** @type {{ message: string }} */
                const { message } = error.response.data;

                this.message = message;
                console.error( error );
            } finally {
                this.submitting = false;
            }
        },
    };
}
