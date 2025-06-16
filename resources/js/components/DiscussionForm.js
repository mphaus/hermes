const initialForm = {
    short_job_or_project_name: '',
    object_type: 'opportunity',
    object_id: '',
    user_id: '',
};

export default function DiscussionForm () {
    return {
        submitting: false,
        form: { ...initialForm },
        errors: { ...initialForm },
        async send () {
            if ( this.submitting ) {
                return;
            }

            this.erros = { ...initialForm };
            this.submitting = true;

            try {
                const response = await window.axios.post( route( 'discussions.store' ), this.form );

                console.log( response );

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
        }
    };
}
